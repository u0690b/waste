<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
            <div class="p-4 bg-white rounded shadow">
                <h1>
                    <BackButton href="/admin/soum_districts" />{{ title }}
                    <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/soum_districts/${data.id}/edit`">
                        Засах</ILink>
                    <DestroyButton :href="'/admin/soum_districts/' + props.data.id" class="float-right">Устгах
                    </DestroyButton>
                </h1>
                <div class="show-grid">
                    <InputLabel v-for="item in fields" :key="item.label" v-bind="item" class="border-b border-dashed" />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Admin.vue';
import InputLabel from '@/Components/InputLabel.vue';
import BackButton from '@/Components/BackButton.vue';
import DestroyButton from '@/Components/DestroyButton.vue';

const props = defineProps({
    data: [Object],
});

const title = 'Сум/дүүрэг дэлгэрэнгүй'

const fields = [
    { label: '', value: props.data.id },
    { label: 'Код', value: props.data.code },
    { label: 'Аймаг нэр', value: props.data.name },
    { label: 'товч', value: props.data.short },
    { label: 'Аймаг/Нийслэл', value: props.data?.aimag_city?.name ?? '' },
    { label: '', value: props.data.created_at },
    { label: '', value: props.data.updated_at }
]

</script>
