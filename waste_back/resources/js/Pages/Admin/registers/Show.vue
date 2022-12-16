<template>
    <div class="p-8">
        <div class=" bg-white rounded shadow overflow-hidden max-w-3xl p-6">
            <h1 class="mb-8 font-bold text-3xl">
                <inertia-link class="text-indigo-400 hover:text-indigo-600"
                    :href="route('admin.registers.index')">Зөрчлийн бүртгэл</inertia-link>
                <span class="text-indigo-400 font-medium">/</span>
                Дэлгэрэнгүй
            </h1>
            <div>
                <RegisterCard :item="data" hideMoreButton @select="select">
                    <h5 class=" text-xs text-black ">Бүртгэсэн хүн:</h5>
                    <p>- {{ data.reg_user.name }}</p>
                    <h5 v-if="data.resolve_desc" class=" text-xs text-black ">Шийдвэрлэсэн хүн:</h5>
                    <p v-if="data.resolve_desc" class="mb-3  font-normal text-gray-700 dark:text-gray-400">- {{
                            data.resolve_desc
                    }}</p>
                    <video v-if="data.attached_video?.path" width="320" height="240" controls>
                        <source :src="data.attached_video.path">

                        <a :href="data.attached_video.path"> Download the video.</a>

                    </video>
                    <ShowMapPoint :key="'fucing' + data.id" :coordinate="[data.long, data.lat]"></ShowMapPoint>
                </RegisterCard>
                <Modal :show="!!selected" @close="() => selected = null">
                    <img :src="selected" alt="">
                </Modal>
            </div>
        </div>
    </div>
</template>
  
<script>
import Layout from "@/Layouts/Admin.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
import NumberInput from "@/Components/MyInput.vue";
import MyInput from "@/Components/MyInput.vue";
import MySelect from "@/Components/MySelect.vue";
import ShowMapPoint from "@/Components/ShowMapPoint.vue";
import RegisterCard from "@/Components/RegisterCard.vue";
import Modal from "@/Components/Modal.vue";

export default {
    metaInfo: { title: "Edit Registers" },
    components: {
        LoadingButton,
        NumberInput,
        MyInput,
        MySelect,
        ShowMapPoint,
        RegisterCard,
        Modal
    },
    layout: Layout,
    props: {
        errors: Object,
        data: Object,
        host: String,
    },
    remember: "form",
    data() {
        return {
            selected: null
        };
    },
    computed: {

    },
    methods: {
        select(v) { this.selected = v }
    },
};
</script>
  