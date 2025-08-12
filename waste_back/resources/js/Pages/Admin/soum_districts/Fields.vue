<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.code"  :error="form.errors.code" class="" label="Код" />
          <MyInput v-model="form.model.name"  :error="form.errors.name" class="" label="Аймаг Нэр" />
          <MyInput v-model="form.model.short"  :error="form.errors.short" class="" label="Товч" />
          <MySelect :value="form.model.aimag_city"  :error="form.errors.aimag_city_id" class="" label="Аймаг/Нийслэл" :url="`/admin/aimag_cities`" @changeId="id=>form.model.aimag_city_id=id" />
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
import MySelect from '@/Components/MySelect.vue'

const props = defineProps({
  data: { type: Object, default: () => ({})},
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_code = computed({get:() => props.code,set:(value)=> emit('update:code')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_short = computed({get:() => props.short,set:(value)=> emit('update:short')})
const v_aimag_city_id = computed({get:() => props.aimag_city_id,set:(value)=> emit('update:aimag_city_id')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>