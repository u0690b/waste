<script setup lang="ts">
import { ref, useTemplateRef } from 'vue';


 defineProps<{ items: string[] }>();


const carousel = useTemplateRef('carousel')
const activeIndex = ref(0)

function onClickPrev() {
    activeIndex.value--
}
function onClickNext() {
    activeIndex.value++
}
function onSelect(index: number) {
    activeIndex.value = index
}

function select(index: number) {
    activeIndex.value = index

    carousel.value?.emblaApi?.scrollTo(index)
}
</script>

<template>
    <div class="flex-1 w-full">
        <UCarousel ref="carousel" v-slot="{ item }" :items="items" :prev="{ onClick: onClickPrev }"
            :next="{ onClick: onClickNext }" class="w-full " @select="onSelect">
            <img :src="item" class="rounded-lg h-72 object-contain  mx-auto">
        </UCarousel>

        <div class="flex gap-1 justify-center pt-4 max-w-xs mx-auto">
            <div v-for="(item, index) in items" :key="index"
                class="size-11 opacity-25 hover:opacity-100 transition-opacity"
                :class="{ 'opacity-100': activeIndex === index }" @click="select(index)">
                <img :src="item" class="rounded-lg h-10 w-10 object-cover">
            </div>
        </div>
    </div>
</template>
