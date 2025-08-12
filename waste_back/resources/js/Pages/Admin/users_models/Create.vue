<template>
    <Layout :title="title">
        <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
            <div class="p-4 bg-white rounded shadow">
                <h1>
                    <BackButton href="/admin/users" />{{ title }}
                </h1>
                <Fields :data="data" @save="submit"></Fields>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "@/Layouts/Admin.vue";
import BackButton from '@/Components/BackButton.vue';
import Fields from "./Fields.vue";

const title = 'Хэрэглэгч Үүсгэх'


defineProps({
    data: [Object],
})

const submit = (form) => {
    form.post('/admin/users', {
        headers: { back: new URLSearchParams(window.location.search).get("callback") },
        preserveScroll: true,
        replace: true,
        onSuccess: () => form.reset(),
        onError: () => ({}),
        onFinish: () => ({}),
    });
};
</script>
