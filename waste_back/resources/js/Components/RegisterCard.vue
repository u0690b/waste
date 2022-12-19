<script setup>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { ref } from "vue";
import Modal from "./Modal.vue";

const props = defineProps({
  item: { type: Object },
  hideMoreButton: { type: Boolean, default: false },
});
const emit = defineEmits(["select"]);
const isOpen = ref(false);

function setIsOpen(value) {
  isOpen.value = value;
}
</script>

<template>
  <div
    class="relative bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700"
  >
    <Carousel>
      <Slide v-for="slide in item.attached_images" :key="slide">
        <div class="carousel__item">
          <img :src="slide.path" alt="" @click="emit('select', slide.path)" />
        </div>
      </Slide>

      <template #addons>
        <Pagination />
      </template>
    </Carousel>
    <div
      :class="
        item.status_id == 2
          ? ' px-2 py-1 rounded text-xs text-white bg-green-500'
          : 'px-2 py-1 rounded text-xs text-white bg-yellow-500'
      "
      class="inline-flex items-center px-3 rounded-full text-[10px] font-light text-center text-white absolute top-2 left-2"
    >
      {{ item.status.name }}
    </div>

    <div class="p-5">
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        <span class="px-2 py-1 rounded text-xs text-white bg-slate-500">Агуулга:</span>
      </p>
      <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
        {{ item.register }} {{ item.name }} {{ item.chiglel }}
      </h6>
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        <span class="px-2 py-1 rounded text-xs text-white bg-slate-500"
          >Зөрчилийн төрөл:</span
        >
      </p>
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        - {{ item.reason.name }}
      </p>
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        <span class="px-2 py-1 rounded text-xs text-white bg-slate-600">Хаяг:</span>
      </p>

      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        - {{ item.aimag_city.name }}, {{ item.soum_district.name }},
        {{ item.bag_horoo.name }} {{ hideMoreButton ? item.bag_horoo.name : "" }}
      </p>
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">
        <span class="px-2 py-1 rounded text-xs text-white bg-slate-600"
          >Гаргасан зөрчилийн байдал:</span
        >
      </p>
      <p class="mb-3 text-xs text-gray-700 dark:text-gray-400">-{{ item.description }}</p>
      <slot></slot>
      <div v-if="!hideMoreButton" class="flex justify-between items-center">
        <div>
          <inertia-link
            :href="route('admin.registers.show', item.id)"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >
            Дэлгэрэнгүй
            <svg
              aria-hidden="true"
              class="w-4 h-4 ml-2 -mr-1"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </inertia-link>
        </div>
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
