<script setup lang="ts">

import type { FormError, FormSubmitEvent } from '@nuxt/ui'
definePageMeta({
    // middleware: ['sanctum:guest'],
});

const { login } = useSanctumAuth();


const state = reactive({
  email: '',
  password: '',
  remember: true,
})

// eslint-disable-next-line @typescript-eslint/no-explicit-any
const validate = (state: { email: any; password: any }): FormError[] => {
  const errors = []
  if (!state.email) errors.push({ name: 'email', message: 'Required' })
  if (!state.password) errors.push({ name: 'password', message: 'Required' })
  return errors
}
const toast = useToast()
async function onSubmit(event: FormSubmitEvent<typeof state>) {
  await login(state);
  toast.add({ title: 'Success', description: 'The form has been submitted.', color: 'success' })
  console.log(event.data)
}
</script>

<template>
  <div class=" mt-20  ">
    <div>
      <img src="~/assets/img/logo.png" class="rounded-full w-34 h-34 mx-auto mb-10" alt="Logo">
    </div>
    <UForm :validate="validate" :state="state" class="space-y-4 mx-auto max-w-fit" @submit="onSubmit">
      <UFormField label="Нэвтрэх нэр" name="email">
        <UInput v-model="state.email" />
      </UFormField>

      <UFormField label="Нууц үг" name="password">
        <UInput v-model="state.password" type="password" />
      </UFormField>

      <UButton type="submit">
        Submit
      </UButton>
    </UForm>
  </div>
</template>
<style lang="css"></style>
