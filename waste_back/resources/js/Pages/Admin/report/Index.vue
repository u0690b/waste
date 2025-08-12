<template>
    <div>
        <div class="m-auto mb-6">
            <div class="p-6 bg-white rounded shadow ">
                <h1 class="mb-8 text-3xl font-bold">Тайлан</h1>
                <div class="flex gap-4 mb-8 border-b">
                    <MyInput v-model="form.model.start_at" type="date" class="w-40" label="Эхлэх огноо" />
                    <MyInput v-model="form.model.end_at" type="date" class="w-40" label="Дуусах огноо" />
                    <div class="grid justify-between grid-cols-3 gap-x-4">
                        <label v-for="ty, key in types" :key="key">
                            <input type="checkbox" v-model="form.model.sh_type" :value="key" />{{ ty }}
                        </label>
                    </div>
                    <button @click="save" class="h-8 px-4 text-white bg-orange-500 rounded">CSV файл татах</button>
                </div>
                <div class="">
                    <div class="bg-white ">
                        <table class="table border table-bordered min-w-fit">
                            <thead class="font-bold">
                                <tr>
                                    <td v-for="row, key in typesList" :key="key" class="px-1 py-2 border">{{
                                        types[row] }}</td>
                                    <td class="px-1 py-2 border">Нийт</td>
                                </tr>
                            </thead>
                            <tbody class="align-text-top">
                                <tr v-for="row in tableData" :key="row">
                                    <template v-for="value in typesList">
                                        <td v-if="!row[value + 'dis']" :key="value" :rowspan="row[value + 'span']"
                                            class="border">
                                            {{ row[value] }}
                                        </td>
                                    </template>
                                    <td class="border">
                                        {{ row['niit'] }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="font-bold">
                                    <td v-if="typesList.length > 1" :colspan="typesList.length - 1"></td>
                                    <td>Нийт</td>
                                    <td>{{ grantTotal }}</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, onUpdated } from 'vue'
import { usePage, useForm, router } from '@inertiajs/vue3'
import Layout from '@/Layouts/Admin.vue'
import MyInput from '@/Components/MyInput.vue'
import debounce from 'lodash/debounce'
import pickBy from 'lodash/pickBy'
import fileSaver from "https://cdn.skypack.dev/file-saver@2.0.5";

defineOptions({ layout: Layout })

const props = defineProps({
    datas: Object,
    filters: [Object, Array],
    host: String,
})

const types = {
    reason_name: 'Зөрчлийн төрөл',
    ac_name: 'Аймаг нийслэл',
    sd_name: 'Сум дүүрэг',
    bh_name: 'Баг хороо',
    whois: 'Хэлбэр',
    org: 'Байгууллага',
    status_name: 'Төлөв',
    reg_user: 'Бүртгэсэн хүн',
    comf_user: 'Шийдвэрлэсэн',
    resolve_name: 'Шийдвэрийн төрөл',
}
const form = useForm({ model: { ...props.filters, per_page: props.datas.per_page } })
    .transform(data => data.model)
onUpdated(() => {

})

const typesList = computed(() => {
    return [...(props.filters.sh_type || [])]
})


const grantTotal = computed(() => {
    return props.datas.map((v) => +v.niit).reduce((a, c) => a + c, 0)
})

const tableData = computed(() => {
    return combineCell([...props.datas])
})

function combineCell(data) {
    if (!data.length) return []
    // Deep clone to avoid mutating props.datas
    const list = data.map(row => ({ ...row }))
    const fields = typesList.value

    for (const field of fields) {
        let k = 0
        while (k < list.length) {
            list[k][field + 'span'] = 1
            list[k][field + 'dis'] = false
            let i = k + 1
            while (
                i < list.length &&
                list[k][field] === list[i][field] &&
                list[k][field] !== undefined &&
                list[k][field] !== ''
            ) {
                list[k][field + 'span']++
                list[i][field + 'span'] = 1
                list[i][field + 'dis'] = true
                i++
            }
            k = i
        }
    }
    return list
}




function save() {
    let csv = [];
    let rowText = [];
    const rows = props.datas;
    for (const field of typesList) {
        rowText.push(types[field]);
    }
    rowText.push('niit');
    csv.push(rowText.join(","));
    for (const row of rows) {
        let rowText = [];
        for (const field of typesList) {
            rowText.push('"' + (row[field] ?? ' ') + '"');
        }
        rowText.push(row['niit']);
        csv.push(rowText.join(","));
    }
    const csvFile = new Blob(['\uFEFF' + csv.join("\n")], {
        encoding: "UTF-8",
        type: "text/csv;charset=utf-8;"
    });
    fileSaver.saveAs(csvFile, "data.csv");
}
watch(() => form.model, debounce(() => form.get('', { preserveState: true }), 150), { deep: true })

</script>

<style scoped>
table th,
td {
    padding: 0 0.6rem;
    border: 1px solid #ccc;
}
</style>
