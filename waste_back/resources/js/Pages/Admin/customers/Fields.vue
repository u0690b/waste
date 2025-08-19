<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.regnum"  :error="form.errors.regnum" class="" label="" />
          <MyInput v-model="form.model.firstname"  :error="form.errors.firstname" class="" label="" />
          <MyInput v-model="form.model.gender"  :error="form.errors.gender" class="" label="" />
          <textarea-input v-model="form.image"  :error="form.errors.image" class="" label="" />
          <MyInput v-model="form.model.lastname"  :error="form.errors.lastname" class="" label="" />
          <MyInput v-model="form.model.nationality"  :error="form.errors.nationality" class="" label="" />
          <MyInput v-model="form.model.passportAddress"  :error="form.errors.passportAddress" class="" label="" />
          <MyInput v-model="form.model.passportExpireDate"  :error="form.errors.passportExpireDate" class="" label="" />
          <MyInput v-model="form.model.passportIssueDate"  :error="form.errors.passportIssueDate" class="" label="" />
          <MyInput v-model="form.model.soumDistrictCode"  :error="form.errors.soumDistrictCode" class="" label="" />
          <MyInput v-model="form.model.soumDistrictName"  :error="form.errors.soumDistrictName" class="" label="" />
          <MyInput v-model="form.model.surname"  :error="form.errors.surname" class="" label="" />
          <MyInput v-model="form.model.token"  :error="form.errors.token" class="" label="" />
          <MyInput v-model="form.model.remember_token"  :error="form.errors.remember_token" class="" label="" />
          <MyInput v-model="form.model.push_token"  :error="form.errors.push_token" class="" label="" />
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
import TextareaInput from '@/Components/TextareaInput.vue'

const props = defineProps({
  data: { type: Object, default: () => ({})},
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_regnum = computed({get:() => props.regnum,set:(value)=> emit('update:regnum')})
const v_firstname = computed({get:() => props.firstname,set:(value)=> emit('update:firstname')})
const v_gender = computed({get:() => props.gender,set:(value)=> emit('update:gender')})
const v_image = computed({get:() => props.image,set:(value)=> emit('update:image')})
const v_lastname = computed({get:() => props.lastname,set:(value)=> emit('update:lastname')})
const v_nationality = computed({get:() => props.nationality,set:(value)=> emit('update:nationality')})
const v_passportAddress = computed({get:() => props.passportAddress,set:(value)=> emit('update:passportAddress')})
const v_passportExpireDate = computed({get:() => props.passportExpireDate,set:(value)=> emit('update:passportExpireDate')})
const v_passportIssueDate = computed({get:() => props.passportIssueDate,set:(value)=> emit('update:passportIssueDate')})
const v_soumDistrictCode = computed({get:() => props.soumDistrictCode,set:(value)=> emit('update:soumDistrictCode')})
const v_soumDistrictName = computed({get:() => props.soumDistrictName,set:(value)=> emit('update:soumDistrictName')})
const v_surname = computed({get:() => props.surname,set:(value)=> emit('update:surname')})
const v_token = computed({get:() => props.token,set:(value)=> emit('update:token')})
const v_remember_token = computed({get:() => props.remember_token,set:(value)=> emit('update:remember_token')})
const v_push_token = computed({get:() => props.push_token,set:(value)=> emit('update:push_token')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>