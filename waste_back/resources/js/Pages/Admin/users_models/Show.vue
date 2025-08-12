<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
            <div class="p-4 bg-white rounded shadow">
                <h1>
                    <BackButton href="/admin/users" />{{ title }}
                    <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/users/${data.id}/edit`">Засах
                    </ILink>
                    <DestroyButton :href="'/admin/users/' + props.data.id" class="float-right">Устгах
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

const title = 'Хэрэглэгч дэлгэрэнгүй'

const fields = [
    { label: 'дд', value: props.data.id },
    { label: 'Нэр', value: props.data.name },
    { label: 'Нэвтрэх нэр', value: props.data.username },
    { label: 'Нууц үг', value: '*****' },
    { label: 'Айман/нийслэл', value: props.data?.aimag_city?.name ?? '' },
    { label: 'Сум/Дүүрэг', value: props.data?.soum_district?.name ?? '' },
    { label: 'Баг хороо', value: props.data?.bag_horoo?.name ?? '' },
    { label: 'Утас', value: props.data.phone },
    { label: 'Харьялах нэгж', value: props.data?.place?.name ?? '' },
    { label: 'Эхийн түвшин', value: props.data.roles },
    { label: '', value: props.data.created_at },
    { label: '', value: props.data.updated_at },
    { label: '', value: props.data.deleted_at }
]

</script>
