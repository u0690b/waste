import { defineStore } from "pinia";
import { ref, watch } from "vue";

export type FormDataConvertible =
    | Array<FormDataConvertible>
    | {
          [key: string]: FormDataConvertible;
      }

    | Blob
    | FormDataEntryValue
    | Date
    | boolean
    | number
    | null
    | undefined;

export interface WasteModel {
    id?: number;
    whois: boolean;
    name: string | undefined | null;
    register: string | undefined | null;
    chiglel: string | undefined;
    aimag_city_id: number | undefined;
    soum_district_id: number | undefined;
    bag_horoo_id: number | undefined;
    address: string | undefined | null;
    description: string | undefined | null;
    reason_id: number | undefined;
    zuil_zaalt: string | undefined | null;
    resolve_id: number | undefined;
    resolve_desc: string | undefined | null;
    resolve_image: string | undefined | null;
    long: number | undefined;
    lat: number | undefined;
    reg_user_id: number | undefined;
    comf_user_id: number | undefined;
    status_id: number | undefined;
    reg_at: string | undefined | null;
    resolved_at: string | undefined | null;
    allocate_by: string | undefined | null;
    imageFileList: File[] | undefined | null;
    imageBase64List?: string[] | undefined ;
}


export interface WasteFormModel extends Record<string, FormDataConvertible> {
    model: WasteModel & { [key: string]: FormDataConvertible };
}



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
