<script setup lang="ts">
import { LegalEntity } from '@/types/type';
import { watchDebounced } from '@vueuse/core';
import axios, { AxiosError } from 'axios';
import { ref } from 'vue';
const props = defineProps<{
    modelValue: string | null |undefined;
}>();
const emit = defineEmits<{
    (e: 'update:modelValue', value: string | null): void;
    (e: 'onSelected', value: LegalEntity | null): void;
}>();

const searchTerm = ref(props.modelValue??'');
const selected = ref<LegalEntity>();
const results = ref<LegalEntity[]>([]);
const loading = ref(false);
let cancelTokenSource: any = null;
const open = ref(false);
const mouseOnEntered = ref(false);
watchDebounced(
    searchTerm,
    (newVal) => {
        emit('update:modelValue', newVal);

        if (newVal === selected.value?.name) {
            return;
        }

        if (newVal.length < 3) {
            open.value = false;
            results.value = [];
        } else {
            search(newVal);
        }
    },
    { debounce: 300 },
);
const selectOption = (item: any) => {
    mouseOnEntered.value = false;
    searchTerm.value = item.name;
    selected.value = item;
    open.value = false;
    emit('onSelected', item);
};
// Debounced search function
const search = async (search: string) => {
    // Cancel previous request if still pending
    if (cancelTokenSource) {
        cancelTokenSource.cancel('Cancelled due to new request');
    }
    cancelTokenSource = axios.CancelToken.source();
    if (!loading.value) loading.value = true;

    try {
        const res = await axios.get(route('legal'), {
            params: { search: search },
            cancelToken: cancelTokenSource.token,
        });

        results.value = res.data;
        open.value = true;
    } catch (err) {
        if (axios.isCancel(err as AxiosError)) {
            console.log('Request canceled:', (err as AxiosError).message);
        } else {
            console.error('Error:', err as AxiosError);
        }
    } finally {
        if (loading.value) loading.value = false;
    }
};


</script>
<template>
    <div class="relative w-64">
        <UInput v-model.trim="searchTerm"   v-bind="{ ...$attrs }" :items="results" :loading="loading" trailing @blur="() => { if (!mouseOnEntered) open = false; }"/>

        <!-- Dropdown -->
        <ul v-if="open" class="absolute right-0 left-0 mt-1 max-h-48 overflow-y-auto rounded border bg-white dark:bg-gray-200 shadow z-10"  @mouseenter="mouseOnEntered = true" @mouseleave="mouseOnEntered = false" >
            <li v-if="loading" class="p-2 ">Уншиж байна...</li>

            <li v-for="item in results" :key="item.id" class="cursor-pointer p-2 hover:bg-gray-100" @click="selectOption(item)">
                {{ item.name }} <span class="text-sx text-muted">{{ item.register}}</span>
            </li>

            <li v-if="!loading && results.length === 0" class="p-2 text-gray-500">Мэдээлэл алга</li>
        </ul>
    </div>
</template>
