<template>
    <form @submit.prevent="emit('save', form)" class="field-form">
        <div class="form-grid">
            <MySelect :value="form.model.user" :error="form.errors.user_id" class="" label="Хэнээс"
                :url="`/admin/users`" @changeId="id => form.model.user_id = id" />
            <MyInput v-model="form.model.type" :error="form.errors.type" class="" label="Төрөл" />
            <MyInput v-model="form.model.title" :error="form.errors.title" class="" label="Гарчиг" />
            <textarea-input v-model="form.content" :error="form.errors.content" class="" label="Агуулга" />
            <MyInput v-model="form.rid" type="number" :error="form.errors.rid" class="" label="Холоотой Айди" />
            <MyInput v-model="form.model.read_at" type="date" :error="form.errors.read_at" class="" label="Уншсан" />
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
import TextareaInput from '@/Components/TextareaInput.vue'

const props = defineProps({
    data: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['save'])
const form = useForm({ model: { ...props.data } }).transform((data) => data.model);

/*
const v_id = computed({get:() => props.id,set:(value)=> emit('update:id')})
const v_user_id = computed({get:() => props.user_id,set:(value)=> emit('update:user_id')})
const v_type = computed({get:() => props.type,set:(value)=> emit('update:type')})
const v_title = computed({get:() => props.title,set:(value)=> emit('update:title')})
const v_content = computed({get:() => props.content,set:(value)=> emit('update:content')})
const v_rid = computed({get:() => props.rid,set:(value)=> emit('update:rid')})
const v_read_at = computed({get:() => props.read_at,set:(value)=> emit('update:read_at')})
const v_created_at = computed({get:() => props.created_at,set:(value)=> emit('update:created_at')})
const v_updated_at = computed({get:() => props.updated_at,set:(value)=> emit('update:updated_at')})
*/
</script>
