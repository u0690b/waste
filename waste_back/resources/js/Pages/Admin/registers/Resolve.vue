<template>
    <Layout>
        <Show :errors="errors" :data="data" :host="host">
            <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-1 sm:px-8">
                <div class="px-4 py-2 bg-white border rounded-md shadow">
                    <h3 class="text-lg text-gray-600 mb-4">Шийдвэрлэлтийн мэдээлэл оруулах</h3>
                    <div class="grid grid-cols-2">
                        <form @submit.prevent="submit">
                            <MySelect :value="data.resolve_id" :error="errors.resolve_id"
                                class=" text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-80 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                label="Шийдвэрийн төрөл" :url="`/admin/resolves`"
                                @changeId="(id) => (form.resolve_id = id)" />
                            <MyInput v-model="form.comf_user_name"
                                label="Шийдвэрлэж байгаа /Байцаагч, Мэргэжилтэн.../ нэр" class="mb-4" required
                                :error="errors.comf_user_name" />
                            <div
                                class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                <div class="flex items-center justify-between px-3 py-2 border-b dark:border-gray-600">
                                    <div
                                        class="flex flex-wrap items-center divide-gray-200 sm:divide-x dark:divide-gray-600">
                                        <div class="flex items-center space-x-1 sm:pr-4">
                                            <FileInput v-model="form.image" :error="errors.image" class=""
                                                accept="image/*" label="Зураг">

                                            </FileInput>

                                        </div>
                                    </div>
                                    <button type="button" data-tooltip-target="tooltip-fullscreen"
                                        class="p-2 text-gray-500 rounded cursor-pointer sm:ml-auto hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Full screen</span>
                                    </button>
                                    <div id="tooltip-fullscreen" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        Show full screen
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-white rounded-b-lg dark:bg-gray-800">
                                    <label v-if="errors.resolve_desc" for="editor">{{ errors.resolve_desc }}</label>
                                    <textarea id="editor" rows="4" v-model="form.resolve_desc"
                                        :error="errors.resolve_desc"
                                        class="block w-full px-0 text-sm text-gray-800 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Тайлбар бичих..." required></textarea>

                                </div>
                            </div>
                            <!-- <TextareaInput v-model="form.resolve_desc" :error="errors.resolve_desc" class="bg-gray-50
                         text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" label="Шийдвэрлэсэн байдал" /> -->
                            <div class="flex">
                                <button :loading="form.processing"
                                    class="flex bg-gray-600 p-2 my-3 text-white rounded text-base hover:bg-gray-500"
                                    type="submit">
                                    Хадгалах
                                </button>
                                <button :loading="form.processing"
                                    class="flex bg-gray-600  p-2 mx-4 my-3 text-white rounded text-base hover:bg-gray-500">
                                    <ILink class="text-white hover:text-white" :href="route('admin.registers.index')">
                                        Буцах</ILink>
                                </button>
                            </div>
                            <!-- <LoadingButton :loading="form.processing"
                            class="bg-gray-600 p-3 mx-4 text-white rounded text-base hover:bg-gray-500" type="submit">
                            Хадгалах
                        </LoadingButton> -->
                        </form>
                    </div>
                </div>
            </div>
        </Show>
    </Layout>
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
import FileInput from "@/Components/FileInput.vue";

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
        FileInput
    },
    layout: Layout,
    props: {
        errors: Object,
        data: Object,
        host: String,
    },
    setup(props) { },
    emit: ["select"],
    remember: "form",
    data() {
        return {
            form: this.$inertia.form({
                id: this.data.id,
                resolve_id: this.data.resolve_id,
                comf_user_name: null,
                image: null,
                resolve_desc: this.data.resolve_desc,
            }),
        };
    },
    computed: {},
    methods: {
        submit() {
            this.form.post(this.route("admin.registers.resolve", this.data.id));
        },
    },
};
</script>
