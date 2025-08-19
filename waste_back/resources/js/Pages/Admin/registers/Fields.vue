<template>
  <form @submit.prevent="emit('save', form)" class="field-form">
    <div class="form-grid">
      <MyInput v-model="form.model.whois"  :error="form.errors.whois" class="" label="Иргэн/Аан" />
          <MyInput v-model="form.model.name"  :error="form.errors.name" class="" label="Байгууллага, Аж Ахуйн Нэгжийн Нэр, Иргэний Овог Нэр" />
          <MyInput v-model="form.model.register"  :error="form.errors.register" class="" label="Регистрийн Дугаар" />
          <MyInput v-model="form.model.chiglel"  :error="form.errors.chiglel" class="" label="Үйл Ажиллагааны Чиглэл" />
          <MySelect :value="form.model.aimag_city"  :error="form.errors.aimag_city_id" class="" label="Аймаг,Нийслэл" :url="`/admin/aimag_cities`" @changeId="id=>form.model.aimag_city_id=id" />
          <MySelect :value="form.model.soum_district"  :error="form.errors.soum_district_id" class="" label="Сум,Дүүрэг" :url="`/admin/soum_districts`" @changeId="id=>form.model.soum_district_id=id" />
          <MySelect :value="form.model.bag_horoo"  :error="form.errors.bag_horoo_id" class="" label="Баг,Хороо" :url="`/admin/bag_horoos`" @changeId="id=>form.model.bag_horoo_id=id" />
          <MyInput v-model="form.model.address"  :error="form.errors.address" class="" label="Хаяг, Байршилд" />
          <MyInput v-model="form.model.description"  :error="form.errors.description" class="" label="Гаргасан Зөрчлийн Байдал" />
          <MySelect :value="form.model.reason"  :error="form.errors.reason_id" class="" label="Зөрчлийн Төрөл" :url="`/admin/reasons`" @changeId="id=>form.model.reason_id=id" />
          <MyInput v-model="form.model.zuil_zaalt"  :error="form.errors.zuil_zaalt" class="" label="Зөрчсөн Хууль Тогтоомжийн Зүйл, Заалт" />
          <MyInput v-model="form.model.long"  :error="form.errors.long" class="" label="Уртраг" />
          <MyInput v-model="form.model.lat"  :error="form.errors.lat" class="" label="Өргөрөг" />
          <MySelect :value="form.model.reg_user"  :error="form.errors.reg_user_id" class="" label="Бүртгэсэн Хүн" :url="`/admin/reg_users`" @changeId="id=>form.model.reg_user_id=id" />
          <MySelect :value="form.model.resolve"  :error="form.errors.resolve_id" class="" label="Шийдвэрийн Төрөл" :url="`/admin/resolves`" @changeId="id=>form.model.resolve_id=id" />
          <MyInput v-model="form.model.resolve_desc"  :error="form.errors.resolve_desc" class="" label="Шийдвэрлэсэн Байдал" />
          <MyInput v-model="form.model.resolve_image"  :error="form.errors.resolve_image" class="" label="Шийдвэрлэсэн Зураг" />
          <MyInput v-model="form.model.resolved_at"  :error="form.errors.resolved_at" class="" label="Шийдвэрлэсэн Огноо" />
          <MySelect :value="form.model.comf_user"  :error="form.errors.comf_user_id" class="" label="Шийдвэрлэсэн Хүн" :url="`/admin/comf_users`" @changeId="id=>form.model.comf_user_id=id" />
          <MySelect :value="form.model.status"  :error="form.errors.status_id" class="" label="Төлөв" :url="`/admin/statuses`" @changeId="id=>form.model.status_id=id" />
          <MyInput v-model="form.model.reg_at"  :error="form.errors.reg_at" class="" label="Үүсгэсэн" />
          <MyInput v-model="form.allocate_by" type="number" :error="form.errors.allocate_by" class="" label="Хуваарилсан Хүн" />
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
const v_whois = computed({get:() => props.whois,set:(value)=> emit('update:whois')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_register = computed({get:() => props.register,set:(value)=> emit('update:register')})
const v_chiglel = computed({get:() => props.chiglel,set:(value)=> emit('update:chiglel')})
const v_aimag_city_id = computed({get:() => props.aimag_city_id,set:(value)=> emit('update:aimag_city_id')})
const v_soum_district_id = computed({get:() => props.soum_district_id,set:(value)=> emit('update:soum_district_id')})
const v_bag_horoo_id = computed({get:() => props.bag_horoo_id,set:(value)=> emit('update:bag_horoo_id')})
const v_address = computed({get:() => props.address,set:(value)=> emit('update:address')})
const v_description = computed({get:() => props.description,set:(value)=> emit('update:description')})
const v_reason_id = computed({get:() => props.reason_id,set:(value)=> emit('update:reason_id')})
const v_zuil_zaalt = computed({get:() => props.zuil_zaalt,set:(value)=> emit('update:zuil_zaalt')})
const v_long = computed({get:() => props.long,set:(value)=> emit('update:long')})
const v_lat = computed({get:() => props.lat,set:(value)=> emit('update:lat')})
const v_reg_user_id = computed({get:() => props.reg_user_id,set:(value)=> emit('update:reg_user_id')})
const v_resolve_id = computed({get:() => props.resolve_id,set:(value)=> emit('update:resolve_id')})
const v_resolve_desc = computed({get:() => props.resolve_desc,set:(value)=> emit('update:resolve_desc')})
const v_resolve_image = computed({get:() => props.resolve_image,set:(value)=> emit('update:resolve_image')})
const v_resolved_at = computed({get:() => props.resolved_at,set:(value)=> emit('update:resolved_at')})
const v_comf_user_id = computed({get:() => props.comf_user_id,set:(value)=> emit('update:comf_user_id')})
const v_status_id = computed({get:() => props.status_id,set:(value)=> emit('update:status_id')})
const v_reg_at = computed({get:() => props.reg_at,set:(value)=> emit('update:reg_at')})
const v_allocate_by = computed({get:() => props.allocate_by,set:(value)=> emit('update:allocate_by')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>