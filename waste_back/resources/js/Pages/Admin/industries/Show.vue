<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
            <div class="p-4 bg-white rounded shadow">
                <h1>
                    <BackButton href="/admin/industries" />{{ title }}
                    <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/industries/${data.id}/edit`">Засах
                    </ILink>
                    <DestroyButton :href="'/admin/industries/' + props.data.id" class="float-right">Устгах
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

const title = '	Үйл ажиллагааны чиглэл дэлгэрэнгүй'

const fields = [
    { label: '', value: props.data.id },
    { label: 'Үйл ажиллагааны чиглэл', value: props.data.name }
]

</script>
