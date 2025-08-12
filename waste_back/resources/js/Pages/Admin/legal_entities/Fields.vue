<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.register"  :error="form.errors.register" class="" label="Хуулийн Этгээдийн Регистр" />
          <MyInput v-model="form.model.name"  :error="form.errors.name" class="" label="Хуулийн Этгээдийн Нэр" />
          <MyInput v-model="form.model.industry"  :error="form.errors.industry" class="" label="Үйл Ажиллагааны Чиглэл" />
    </div>
    <div class="flex justify-end pt-4 mt-4 border-t">
      <ButtonPrimary :disabled="!form.isDirty || form.processing">
        Хадгалах
      </ButtonPrimary>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import ButtonPrimary from "@/Components/ButtonPrimary.vue";
import MyInput from '@/Components/MyInput.vue'

const props = defineProps({
  data: { type: Object, default: () => ({})},
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_register = computed({get:() => props.register,set:(value)=> emit('update:register')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_industry = computed({get:() => props.industry,set:(value)=> emit('update:industry')})
*/
</script>