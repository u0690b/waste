<template>
    <form @submit.prevent="emit('save', form)" class="field-form">
        <div class="form-grid">
            <MyInput v-model="form.model.name" :error="form.errors.name" class="" label="Нэр" />
            <MyInput v-model="form.model.username" :error="form.errors.username" class="" label="Нэвтрэх нэр" />
            <MyInput v-model="form.model.password" type="password" autocomplete="new-password"
                :error="form.errors.password" class="" label="Нууц үг" />



            <MySelect v-model="form.model.aimag_city" :error="form.errors.aimag_city_id" :disabled="user.roles == 'da'"
                label="Аймаг/нийслэл" :url="`/admin/aimag_cities`" @changeId="
                    (id) => {
                        if (user.roles != 'da') {
                            form.model.aimag_city_id = id;
                            form.model.soum_district_id = null;
                            form.model.bag_horoo_id = null;
                            form.model.soum_district = null;
                            form.model.bag_horoo = null;
                        }
                    }
                " />

            <MySelect v-if="form.model.aimag_city_id && form.model.aimag_city_id < 23"
                :disabled="user.roles == 'da' && user.aimag_city_id == 7" v-model="form.model.soum_district"
                :error="form.errors.soum_district_id" label="Сум/дүүрэг" :required="form.model.aimag_city_id < 23"
                :url="`/admin/soum_districts?aimag_city_id=${form.model.aimag_city_id}`" @changeId="
                    (id) => ((form.model.soum_district_id = id), (form.model.bag_horoo_id = null))
                " />

            <MySelect v-if="form.model.soum_district_id" v-model="form.model.bag_horoo"
                :error="form.errors.bag_horoo_id" label="Баг/хороо"
                :url="`/admin/bag_horoos?soum_district_id=${form.model.soum_district_id}`"
                @changeId="(id) => (form.model.bag_horoo_id = id)" />



            <MyInput v-model="form.model.phone" :error="form.errors.phone" class="" label="Утас" />
            <MySelect v-model="form.model.place" :error="form.errors.place_id" class="" label="Харьялах нэгж"
                :url="`/admin/places`" @changeId="id => form.model.place_id = id" />

            <MySelect v-model="form.model.roles" :modelKey="true" :storedOptions="roles" :error="form.errors.roles"
                label="Эрх" :filterable="true" />
        </div>
        <div class="flex justify-end pt-4 mt-4 border-t">
            <ButtonPrimary :disabled="!form.isDirty || form.processing">
                Хадгалах
            </ButtonPrimary>
        </div>
    </form>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import ButtonPrimary from "@/Components/ButtonPrimary.vue";
import MyInput from '@/Components/MyInput.vue'
import MySelect from '@/Components/MySelect.vue'
import { onMounted } from 'vue';

const props = defineProps({
    data: { type: Object, default: () => ({}) },
});


const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);
const user = usePage().props.auth.user;
onMounted(() => {
    form.model.aimag_city = user.aimag_city;
    form.model.soum_district = user.soum_district;
    form.model.aimag_city_id = user.aimag_city.id;
    form.model.soum_district_id = user.soum_district.id;
});
const roles = user.roles == 'admin' ?
    [
        { id: "admin", name: "Админ" },
        { id: "da", name: "Аймаг, дүүрэг админ" },
        { id: "mha", name: "БОХУБ" },
    ] :
    user.roles == 'da' ? [
        { id: "mha", name: "БОХУБ" },
    ] : []


/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_username = computed({get:() => props.username,set:(value)=> emit('update:username')})
const v_password = computed({get:() => props.password,set:(value)=> emit('update:password')})
const v_aimag_city_id = computed({get:() => props.aimag_city_id,set:(value)=> emit('update:aimag_city_id')})
const v_soum_district_id = computed({get:() => props.soum_district_id,set:(value)=> emit('update:soum_district_id')})
const v_bag_horoo_id = computed({get:() => props.bag_horoo_id,set:(value)=> emit('update:bag_horoo_id')})
const v_phone = computed({get:() => props.phone,set:(value)=> emit('update:phone')})
const v_place_id = computed({get:() => props.place_id,set:(value)=> emit('update:place_id')})
const v_roles = computed({get:() => props.roles,set:(value)=> emit('update:roles')})
const v_remember_token = computed({get:() => props.remember_token,set:(value)=> emit('update:remember_token')})
const v_push_token = computed({get:() => props.push_token,set:(value)=> emit('update:push_token')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
const v_deleted_at = computed({get:() => props.deleted_at,set:(value)=> emit('update:deleted_at')})
*/
</script>
