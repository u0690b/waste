<template>
    <div class="flex justify-between px-4 mt-4 sm:px-8">
        <h2 class="text-xl text-gray-600  font-bold">Зөрчлийн бүртгэл дэлгэрэнгүй</h2>
        <div class="flex items-center space-x-1 text-xs">
            <inertia-link href="/" class="font-bold text-indigo-700 text-sm">Нүүр хуудас</inertia-link>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-gray-600 text-sm">Зөрчлийн бүртгэл</span>
        </div>
    </div>
    <slot></slot>
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-3 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow sm:col-span-2">
            <h3 class="text-lg text-gray-600 mb-4 tracking-wider">Илгээгдсэн мэдээлэл</h3>
            <div class="row">
                <div class="col-md-5">

                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="who_is">Иргэн/Аж
                        ахуй
                        нэгж</label>
                    <input v-model="data.whois" type="text" :error="errors.name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="register">Регистрийн
                        дугаар</label>
                    <input v-model="data.register" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Иргэн/Аж ахуй
                        нэгжийн нэр</label>
                    <input v-model="data.name" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 py-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Зөрчлийн
                        төрөл</label>
                    <input v-model="data.reason.name" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="address">Хаяг</label>
                    <input v-model="data.address" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 py-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Гаргасан
                        зөрчлийн тайлбар
                    </label>
                    <input v-model="data.description" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="address">Зөрчлийн
                        хуваарилалт</label>
                    <input v-model="data.chiglel" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 py-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="address">Уртраг</label>
                    <input v-model="data.long" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        for="address">Өргөрөг</label>
                    <input v-model="data.lat" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 py-2">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="address">Бүртгэсэн
                        хэрэглэгч</label>
                    <input v-model="data.reg_user.name" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="address">Бүртгэсэн
                        огноо</label>
                    <input v-model="data.created_at" type="text" :error="errors.name" class="bg-gray-50 border
                        border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block
                        w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
            <!-- <RegisterCard :item="data" hideMoreButton @select="select">
                <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                    <span class="font-bold text-black">#Бүртгэсэн хүн:</span>
                </p>
                <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic"> {{ data.reg_user.name }}</p>
                <h5 v-if="data.resolve_desc" class="mb-3 text-sm text-gray-700 dark:text-gray-400"> <span
                        class="font-bold text-black">#Шийдвэрлэсэн хүн:</span></h5>
                <p v-if="data.resolve_desc" class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                    - {{ data.resolve_desc }}
                </p>

            </RegisterCard> -->
        </div>
        <div class="px-4 py-2 bg-white  rounded-md overflow-hidden shadow">
            <!-- <h3 class="text-lg text-gray-600 mb-4 tracking-wider"></h3> -->
            <TabGroup>
                <div class="bg-white  rounded-lg shadow sm:col-span-2">
                    <div
                        class="flex flex-col space-y-2 items-center px-4 mb-2 py-2  text-gray-600 sm:flex-row sm:justify-between">
                        <h3 class="tracking-wider">Нотлох баримт</h3>
                        <TabList class="flex space-x-1">
                            <Tab v-slot="{ selected }" key="tab_1">
                                <button class="px-4 py-2 text-xs rounded-md hover:bg-blue-400 hover:text-white"
                                    :class="selected ? 'bg-blue-400 text-white' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>

                                </button>
                            </Tab>
                            <Tab v-slot="{ selected }" key="tab_2">
                                <button class="px-4 py-2 text-xs rounded-md hover:bg-blue-400 hover:text-white"
                                    :class="selected ? 'bg-blue-400 text-white' : ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round"
                                            d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                    </svg>

                                </button>
                            </Tab>

                        </TabList>
                    </div>

                    <TabPanels class="px-4 py-2">
                        <TabPanel key="tab_1">
                            asdasd
                            <!-- <Carousel>
                                <Slide v-for="slide in data.attached_images" :key="slide">
                                    <div class="carousel__item">
                                        <img :src="slide.path" alt="" @click="() => selected = slide.path">
                                    </div>
                                </Slide>
                                <template #addons>
                                    <Pagination />
                                </template>
                            </Carousel>
                            <video v-if="data.attached_video?.path" class="w-full" controls>
                                <source :src="data.attached_video.path" />
                                <a :href="data.attached_video.path"> Бичлэг татах</a>
                            </video>
                            <Modal :show="!!selected" @close="() => (selected = null)">
                                <img :src="selected" alt="" />
                            </Modal> -->
                        </TabPanel>
                        <TabPanel key="tab_2">
                            asdasd1
                            <!-- <Carousel>
                                <Slide v-for="slide in data.attached_images" :key="slide">
                                    <div class="carousel__item">
                                        <img :src="slide.path" alt="" @click="() => selected = slide.path">
                                    </div>
                                </Slide>
                                <template #addons>
                                    <Pagination />
                                </template>
                            </Carousel>
                            <video v-if="data.attached_video?.path" class="w-full" controls>
                                <source :src="data.attached_video.path" />
                                <a :href="data.attached_video.path"> Бичлэг татах</a>
                            </video>
                            <Modal :show="!!selected" @close="() => (selected = null)">
                                <img :src="selected" alt="" />
                            </Modal> -->
                        </TabPanel>
                    </TabPanels>
                </div>
            </TabGroup>
        </div>


    </div>
    <div class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-1 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-lg text-gray-600 mb-4">Байрлал /Газрын зураг/</h3>
            <ShowMapPoint :key="'fucing' + data.id" :coordinate="[data.long, data.lat]"></ShowMapPoint>
        </div>
    </div>

    <div v-if="data.comf_user" class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-1 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-lg text-gray-600 mb-4">Хуваарилагдсан мэдээлэл</h3>
            {{ data.comf_user?.name }}
        </div>
    </div>
    <div v-if="data.status_id == 4" class="grid grid-cols-1 px-4 gap-4 mt-8 sm:grid-cols-1 sm:px-8">
        <div class="px-4 py-2 bg-white border rounded-md overflow-hidden shadow">
            <h3 class="text-lg text-gray-600 mb-4">Шийдвэрлэгдсэн мэдээлэл</h3>
            {{ data.resolve_id }}
            {{ data.resolve_desc }}
            {{ data.resolve_image }}
            {{ data.resolved_at }}
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
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
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
        TabGroup,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
    },
    layout: Layout,
    props: {
        errors: Object,
        data: Object,
        host: String,
        auth: Object,
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
    computed: {
        ss() {
            return sss + this.selected;
        }
    },
    methods: {
        select(v) {
            this.selected = v;
        },
    },
};
</script>
