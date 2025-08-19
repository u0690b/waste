import { WasteModel } from "@/types/type";
import { defineStore } from "pinia";
import { ref, watch } from "vue";



export const useWasteListStore = defineStore('wasteList', () => {
    const wasteList = ref<WasteModel[]>(JSON.parse(localStorage.getItem('wasteList') || '[]'));

    // whenever wasteList changes, update localStorage
    watch(
        wasteList,
        (newVal) => {

            localStorage.setItem('wasteList', JSON.stringify(newVal));
        },
        { deep: true },
    );
    return { wasteList };
});
