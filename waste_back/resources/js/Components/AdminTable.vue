<template>
  <div class="">
    <table class="w-full mt-2 text-gray-500">
      <thead class="uppercase border-b">
        <tr class="font-bold text-left">
          <th class="pl-2 w-11"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
          </th>
          <th v-for="(header, i) in Object.values(headers)" :key="i" class="text-gray-600" @click="$emit('orderBy', i)">
            {{ header }}
          </th>
          <th v-if="url" class="pl-2">
            <span class="flex"> Үйлдэл
              <div v-if="insertUrl" class="ml-2 col-sm-2">
                <ILink :href="insertUrl"
                  class="flex p-2 px-2 mr-4 text-white bg-green-500 rounded-md hover:bg-green-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>

                </ILink>
              </div>
            </span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in datas.data" :key="row.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="pl-2 border-t ">{{ index + 1 }}</td>
          <td v-for="(key, i) in Object.keys(headers)" :key="i" class="px-2 py-2 border-t">
            <ILink v-if="url" :href="route(url, row.id)" class="items-center focus:text-indigo-500">
              {{ parseVal(row, key) }}
            </ILink>
            <span v-else class="items-center">{{ parseVal(row, key) }}</span>
          </td>
          <td class="py-2 pl-2 border-t">
            <div v-if="url" class="flex row">
              <div class="col-sm-2">
                <ILink v-if="url" :href="route(url, row.id)"
                  class="flex p-2 px-2 mr-4 text-white bg-orange-500 rounded-md hover:bg-orange-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </ILink>
              </div>
              <div v-if="deleteUrl" class="col-sm-2">
                <ILink v-if="url" @click="() => destroy(row.id)" as="buttom"
                  class="flex p-2 px-2 mr-4 text-white bg-red-500 rounded-md hover:bg-red-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </ILink>
              </div>
              <div v-if="insertUrl" class="col-sm-2">
                <ILink v-if="url" :href="insertUrl"
                  class="flex p-2 px-2 mr-4 text-white bg-green-500 rounded-md hover:bg-green-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                  </svg>

                </ILink>
              </div>
              <div v-if="showUrl" class="col-sm-2">
                <ILink v-if="url" :href="route(showUrl, row.id)"
                  class="flex p-2 px-2 mr-4 text-white bg-orange-500 rounded-md hover:bg-orange-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                  </svg>
                </ILink>
              </div>
            </div>
          </td>
        </tr>
        <tr v-if="datas.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">Мэдээлэл байхгүй</td>
        </tr>
      </tbody>

    </table>
  </div>
</template>

<script>
import { router as Inertia } from "@inertiajs/vue3";
import Icon from "./Icon.vue";

export default {
  components: { Icon },
  props: {
    headers: { type: Object, required: true },
    datas: { type: Object, required: true },
    url: String,
    insertUrl: [String],
    deleteUrl: [String],
    showUrl: [String],
  },
  emits: ["orderBy"],
  setup(props) {
    const parseVal = (row, key) => {
      let ret = "";
      let keys = key.split(".");
      if (keys.length == 1) {
        ret = row[keys[0]];
      } else {
        if (row[keys[0]] && row[keys[0]][keys[1]]) ret = row[keys[0]][keys[1]] ?? "";
        else ret = "";
      }

      return ret;
    };

    return {
      parseVal,
    };
  },
  methods: {
    destroy(rowId) {
      if (confirm("Та устгахдаа итгэлтэй байна уу?")) {
        Inertia.delete(this.route(this.deleteUrl, rowId));
      }
    },
  },
};
</script>
