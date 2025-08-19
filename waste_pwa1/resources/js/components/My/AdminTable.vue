<template>
    <div class="">
        <table class="w-full mt-2 text-gray-500 table-bordered text-sm">
            <thead class="border-b ">
                <tr class="text-left">
                    <th class="pl-2 w-11">
                        <i class="ti-list" />
                    </th>
                    <th v-for="(header, i) in headers" :key="i" class="text-gray-600"
                        @click="emit('orderBy', header.order)">
                        {{ header.name }}
                    </th>
                    <th class="w-20 pl-2 ">
                        <ILink v-if="url" :href="`${url}/create`" class="btn btn-success ti-plus"></ILink>
                    </th>
                </tr>
            </thead>
            <slot name='filter' />
            <tbody>
                <tr v-for="(row, index) in datas.data" :key="row.id"
                    class="border-t hover:bg-gray-100 dark:hover:bg-gray-600 focus-within:bg-gray-100">
                    <td class="pl-2 ">{{ (index + 1) + (datas.per_page * (datas.current_page - 1)) }}</td>
                    <td v-for="(header, i) in headers" :key="i" class="px-2 py-1 ">
                        <template v-if="header.type == 'img'">
                            <img :src="row[header.key]" :class="header.class" />
                        </template>
                        <template v-else>
                            <ILink v-if="!noadd && url" :href="url + '/' + row.id + '?' + (callback ?? '')"
                                class="items-center ">
                                {{ parseVal(row, header.key) }}
                            </ILink>
                            <span v-else class="items-center">{{ parseVal(row, header.key) }}</span>
                        </template>
                    </td>
                    <td class="py-1 pl-2 text-center">
                        <UButton v-if="!nodelete && url" @click="()=>destroy(row.id)" title="устгах"
                            class="inline-block px-1 py-0">
                            <i class="ti-trash" />
                        </UButton>

                        <ILink v-if="!noedit && url" :href="url + '/' + row.id + '/edit?' + (callback ?? '')"
                            class="inline-block px-2 text-white bg-orange-500 rounded hover:bg-orange-700 "
                            title="Засах">
                            <i class="ti-pencil-alt" />
                        </ILink>
                    </td>
                </tr>
                <tr v-if="datas.data.length === 0">
                    <td class="px-6 py-4 " :colspan="headers.length + 2">Мэдээлэл байхгүй </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { Header, PaginatedData, Row } from "@/types/type";
import { router } from "@inertiajs/vue3"; // adjust if you use another router

// --- Props ---
const props = defineProps<{
    headers: Header[];
    datas: PaginatedData<Row>;
    url?: string;
    showAdd?: boolean;
    nodelete?: boolean;
    noadd?: boolean;
    noedit?: boolean;
}>();

// --- Emits ---
const emit = defineEmits<{
    (e: "orderBy", order?: string): void;
    (e: "showAdd"): void;
    (e: "update:showAdd", value: boolean): void;
}>();

// --- Helpers ---
const parseVal = (row: Row, key: string): unknown => {
    let ret: unknown = "";
    const keys = key.split(".");
    if (keys.length === 1) {
        ret = row[keys[0]];
    } else {
        let r: any = row;
        for (const k of keys) {
            try {
                r = r?.[k];
            } catch (error: any) {
                console.info(keys, error?.message);
            }
        }
        ret = r;
    }
    return ret;
};

// const isShow = computed<boolean>({
//     get: () => !!props.showAdd,
//     set: (value) => emit("update:showAdd", value),
// });

const callback =
    "callback=" +
    (new URLSearchParams(window.location.search).get("callback") ??
        encodeURIComponent(location.pathname + location.search));

// --- Actions ---
const destroy = (rowId: string | number) => {
    if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        if (props.url) {
            router.delete(`${props.url}/${rowId}${callback ?? ""}`);
        }
    }
};

// const show = () => {
//     isShow.value = !isShow.value;
//     emit("showAdd");
// };
</script>
