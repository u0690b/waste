<template>
  <div>
    <div class="m-auto mb-6">
      <div class="bg-white rounded shadow p-6 ">
        <h1 class="mb-8 text-3xl font-bold">Тайлан</h1>
        <div class="flex gap-4 mb-8 border-b">
          <MyInput v-model="form.start_at" type="date" class="w-40" label="Эхлэх огноо" />
          <MyInput v-model="form.end_at" type="date" class="w-40" label="Дуусах огноо" />
          <div class="grid grid-cols-2 gap-x-4 justify-between">
            <label v-for="ty, key in types" :key="key">
              <input v-model="form.sh_type" type="checkbox" :value="key" /> {{ ty }}
            </label>
          </div>
          <button @click="save" class="rounded bg-orange-500 h-8 px-4 text-white">CSV файл татах</button>
        </div>
        <div class=" ">
          <div class=" bg-white">
            <table class="table table-bordered border min-w-fit">
              <thead class="font-bold">
                <tr>
                  <td v-for="row, key in form.sh_type" :key="key" class="px-1 border py-2">{{ types[row] }}</td>
                  <td class="px-1 py-2 border">Нийт</td>
                </tr>
              </thead>
              <tbody class="align-text-top">
                <tr v-for="row in tableData" :key="row">
                  <template v-for="value in form.sh_type">
                    <td v-if="!row[value + 'dis']" :key="value" :rowspan="row[value + 'span']" class="border">
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
                  <td v-if="form.sh_type.length > 1" :colspan="form.sh_type.length - 1"></td>
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

<script>
import Layout from '@/Layouts/Admin.vue'
import MyInput from '@/Components/MyInput.vue'
import debounce from 'lodash/debounce'
import pickBy from 'lodash/pickBy'
import fileSaver from "https://cdn.skypack.dev/file-saver@2.0.5";
export default {
  metaInfo: { title: 'Documents' },
  components: {
    MyInput,
  },
  layout: Layout,
  props: {
    datas: Object,
    filters: [Object, Array],
    host: String,
  },
  data() {
    return {
      form: {
        sh_type: [],
        ...(this.filters ?? {}),
      },

      types: {
        reason_name: 'Зөрчлийн төрөл',
        ac_name: 'Аймаг нийслэл',
        sd_name: 'Сум дүүрэг',
        bh_name: 'Баг хороо',
        whois: 'Хэлбэр',
        org: 'Байгууллага',
        status_name: 'Төлөв',
        reg_user: 'Бүртгэсэн хүн',
        comf_user: 'Шийдвэрлэсэн, Хуваарилагдсан',
        resolve_name: 'Шийдвэрийн төрөл',
      },
    }
  },
  computed: {
    grantTotal() {
      return this.datas.map((v) => +v.niit).reduce((a, c) => a + c, 0)
    },
    tableData() {
      return this.combineCell(this.datas)
    },
  },
  watch: {

    form: {
      handler: debounce(function () {
        this.$inertia.get(this.route('admin.tailan'), pickBy(this.form), { preserveState: true })
      }, 150),
      deep: true,
    },

  },
  methods: {
    getSpan(idxRow, idxCol) {
      let count = 0, tmp = this.datas[idxRow][idxCol]
      // debugger
      for (let index = idxRow; index < this.datas.length; index++) {


        if (tmp == this.datas[index][idxCol]) {
          count++
        } else {
          return count
        }
      }

    },
    combineCell(list) {
      for (let field in list[0]) {
        var k = 0
        while (k < list.length) {
          list[k][field + 'span'] = 1
          list[k][field + 'dis'] = false
          for (var i = k + 1; i <= list.length - 1; i++) {
            if (list[k][field] == list[i][field] && list[k][field] != '') {
              list[k][field + 'span']++
              list[k][field + 'dis'] = false
              list[i][field + 'span'] = 1
              list[i][field + 'dis'] = true
            } else { break }
          }
          k = i
        }
      }
      return list
    },
    save() {
      let csv = [];
      let rowText = [];
      const rows = this.datas;
      for (const field of this.filters.sh_type) {
        rowText.push(this.types[field]);
      }
      rowText.push('niit');
      csv.push(rowText.join(","));
      for (const row of rows) {
        let rowText = [];
        for (const field of this.filters.sh_type) {
          rowText.push('"' + (row[field] ?? ' ') + '"');
        }
        rowText.push(row['niit']);
        csv.push(rowText.join(","));
      }
      const csvFile = new Blob(['\uFEFF' + csv.join("\n")], {
        encoding: "UTF-8",
        type: "text/csv;charset=utf-8;"
      });
      saveAs(csvFile, "data.csv");

    }
  },
}
</script>

<style scoped>
table th,
td {
  padding: 0 0.6rem;
  border: 1px solid #ccc;
}
</style>