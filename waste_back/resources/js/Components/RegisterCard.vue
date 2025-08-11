<script setup>
    import "vue3-carousel/dist/carousel.css";

    // import { ref } from "vue";


     defineProps({
        item: { type: Object, required: true },
        hideMoreButton: { type: Boolean, default: false },
        showRoute: { type: String, default: 'admin.registers.show' }
    });
    // const emit = defineEmits(["select"]);
    // const isOpen = ref(false);

    // function setIsOpen(value) {
    //     isOpen.value = value;
    // }
</script>

<template>
    <div class="relative bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
        <!-- <Carousel>
                    <Slide v-for="slide in item.attached_images" :key="slide">
                        <div class="carousel__item">
                            <img :src="slide.path" alt="" @click="emit('select', slide.path)">
                        </div>
                    </Slide>

                    <template #addons>
                        <Pagination />
                    </template>
</Carousel> -->
        <div :class="item.status_id == 2 ? 'bg-green-500' : 'bg-yellow-500'" class=" inline-flex items-center px-3 rounded-full text-[10px] font-light text-center  text-white absolute top-1 left-1">
            {{ item.status.name }}</div>
        <div class="p-5">
            <p class="mb-3 text-sm py-2">
                <span class="font-bold text-black">#Товч агуулга:</span>
            </p>
            <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic">
                {{ item.register }}/ {{ item.name }}/ {{ item.chiglel }}
            </p>
            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                <span class="font-bold text-black">#Бүртгэсэн огноо:</span>
            </p>
            <p class="mb-3 text-xs text-gray-900 dark:text-gray-400 italic">
                {{ item.created_at }}
            </p>
            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                <span class="font-bold text-black">#Зөрчлийн төрөл:</span>
            </p>
            <p class="mb-3 text-xs text-gray-900 dark:text-gray-400 italic">
                {{ item.reason.name }}
            </p>
            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                <span class="font-bold text-black">#Хаяг:</span>
            </p>

            <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic">
                {{ item.aimag_city.name }}, {{ item.soum_district.name }},
                {{ item.bag_horoo.name }} {{ hideMoreButton ? item.bag_horoo.name : "" }}
            </p>
            <p class="mb-3 text-sm text-gray-700 dark:text-gray-400">
                <span class="font-bold text-black">
                    #Гаргасан зөрчлийн байдал:</span>
            </p>
            <p class="mb-3 text-xs text-gray-700 dark:text-gray-400 italic">{{ item.description }}</p>
            <slot></slot>
            <div v-if="!hideMoreButton" class="flex justify-between items-center">

                <ILink :href="route(showRoute, item.id)" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-900 dark:focus:ring-blue-800">
                    Дэлгэрэнгүй
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </ILink>

            </div>
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
