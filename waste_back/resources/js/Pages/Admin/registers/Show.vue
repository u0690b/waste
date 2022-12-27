
<template>
    <div class="flex justify-between px-4 mt-4 sm:px-8">
        <h2 class="text-2xl text-gray-600 underline font-bold">Зөрчлийн бүртгэл</h2>
        <div class="flex items-center space-x-1 text-xs">
            <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 text-sm">Зөрчлийн бүртгэл</span>
        </div>
    </div>
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Үндсэн мэдээлэл</h3>
            <RegisterCard :item="data" hideMoreButton @select="select">
                <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                    <span class="font-bold text-black">#Бүртгэсэн хүн:</span>
                </p>
                <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic"> {{ data.reg_user.name }}</p>
                <h5 v-if="data.resolve_desc" class="mb-3 text-sm text-gray-700 dark:text-gray-400"> <span
                        class="font-bold text-black">#Шийдвэрлэсэн хүн:</span></h5>
                <p v-if="data.resolve_desc" class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    - {{ data.resolve_desc }}
                </p>

            </RegisterCard>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-xl text-gray-600 mb-4">Байрлал /Газрын зураг/</h3>
            <ShowMapPoint :key="'fucing' + data.id" :coordinate="[data.long, data.lat]"></ShowMapPoint>
        </div>
    </div>
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-2 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Нотлох баримт /Зураг/</h3>
            <Carousel>
                <Slide v-for="slide in data.attached_images" :key="slide">
                    <div class="carousel__item">
                        <img :src="slide.path" alt="" @click="() => selected = slide.path">
                    </div>
                </Slide>
                <template #addons>
                    <Pagination />
                </template>
            </Carousel>
            <Modal :show="!!selected" @close="() => (selected = null)">
                <img :src="selected" alt="" />
            </Modal>
        </div>
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-xl text-gray-600 mb-4 tracking-wider">Нотлох баримт /Бичлэг/</h3>
            <video v-if="data.attached_video?.path" class="w-full" controls>
                <source :src="data.attached_video.path" />

                <a :href="data.attached_video.path"> Бичлэг татах</a>
            </video>

        </div>
    </div>

</template>
<style lang="postcss" scoped>
.carousel__item {
    min-height: 200px;
    height: 200px;
    width: 100%;
    background-color: var(--vc-clr-primary);
    color: var(--vc-clr-white);
    font-size: 20px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.carousel__pagination {
    @apply absolute bottom-2 left-1/2 -translate-x-1/2;
}

.carousel__prev,
.carousel__next {
    box-sizing: content-box;
    border: 5px solid white;
}
</style>

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
        Carousel, Slide, Pagination,
    },
    layout: Layout,
    props: {
        errors: Object,
        data: Object,
        host: String,
    },
    setup(props) {


        const isOpen = ref(false);

        function setIsOpen(value) {
            isOpen.value = value;
        }
        return {
            isOpen,
            setIsOpen
        }
    },
    emit: ["select"],
    remember: "form",
    data() {
        return {
            selected: null,
        };
    },
    computed: {},
    methods: {
        select(v) {
            this.selected = v;
        },
    },
};
</script>
