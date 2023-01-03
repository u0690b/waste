
<template>
    <Show :errors="errors" :data="data" :host="host">
        <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
            <div class="px-4 py-2 bg-white border rounded-md  shadow">
                <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Шийдвэрлэлтийн мэдээлэл оруулах</h3>
                <div>
                    <form @submit.prevent="submit">
                        <MySelect :value="data.resolve_id" :error="errors.resolve_id" class="max-w-xs"
                            label="Шийдвэрийн төрөл" :url="`/admin/resolves`"
                            @changeId="(id) => (form.resolve_id = id)" />

                        <TextareaInput v-model="form.resolve_desc" :error="errors.resolve_desc" class=""
                            label="Шийдвэрлэсэн байдал" />

                        <LoadingButton :loading="form.processing"
                            class="bg-gray-600 p-3 mx-4 text-white rounded text-base hover:bg-gray-500" type="submit">
                            Хадгалах
                        </LoadingButton>
                    </form>
                </div>
            </div>
        </div>
    </Show>
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

import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { ref } from "vue";
import Show from "./Show.vue";
import TextareaInput from "@/Components/TextareaInput.vue";




export default {
    metaInfo: { title: "Edit Registers" },
    components: {
        LoadingButton,
        NumberInput,
        MyInput,
        MySelect,
        ShowMapPoint,
        RegisterCard,
        Modal,
        Carousel,
        Slide,
        Pagination,
        Show,
        TextareaInput,
    },
    layout: Layout,
    props: {
        errors: Object,
        data: Object,
        host: String,
    },
    setup(props) {


    },
    emit: ["select"],
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                id: this.data.id,
                resolve_id: this.data.resolve_id,
                resolve_desc: this.data.resolve_desc,
            }),
        };
    },
    computed: {},
    methods: {
        submit() {
            this.form.put(this.route("admin.registers.resolve", this.data.id));
        },
    },
};
</script>
