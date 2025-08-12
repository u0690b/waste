<template>
    <form @submit.prevent="emit('save', form)" class="field-form">
        <div class="form-grid">
            <MyInput v-model="form.model.code" :error="form.errors.code" class="" label="Шалтгаан Код" />
            <MyInput v-model="form.model.name" :error="form.errors.name" class="" label="Шалтгаан" />
            <MyInput v-model="form.model.sub_group" :error="form.errors.sub_group" class="" label="Дэд Бүлэг" />
            <MyInput v-model="form.model.stype" :error="form.errors.stype" class="" label="Төрөл" />
            <MySelect :value="form.model.place" :error="form.errors.place_id" class="" label="Хариуцах нэгж"
                :url="`/admin/places`" @changeId="id => form.model.place_id = id" />
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
    data: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_code = computed({get:() => props.code,set:(value)=> emit('update:code')})
const v_name = computed({get:() => props.name,set:(value)=> emit('update:name')})
const v_sub_group = computed({get:() => props.sub_group,set:(value)=> emit('update:sub_group')})
const v_stype = computed({get:() => props.stype,set:(value)=> emit('update:stype')})
const v_place_id = computed({get:() => props.place_id,set:(value)=> emit('update:place_id')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>
