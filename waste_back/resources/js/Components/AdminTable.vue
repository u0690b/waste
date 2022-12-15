<template>
  <div class="">
    <table class="w-full mt-2 text-gray-500">
      <thead class="border-b uppercase">
        <tr class="font-bold text-left">
          <th class="pl-2">№</th>
          <th
            v-for="(header, i) in Object.values(headers)"
            :key="i"
            class="text-gray-600"
            @click="$emit('orderBy', i)"
          >
            {{ header }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(row, index) in datas.data"
          :key="row.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100"
        >
          <td class="pl-2 border-t">{{ index + 1 }}</td>
          <td
            v-for="(key, i) in Object.keys(headers)"
            :key="i"
            class="px-2 py-2 border-t"
          >
            <inertia-link
              v-if="url"
              :href="route(url, row.id)"
              class="flex items-center focus:text-indigo-500"
            >
              {{ parseVal(row, key) }}
            </inertia-link>
            <span v-else class="items-center">{{ parseVal(row, key) }}</span>
          </td>
          <td class="pl-2 border-t hidden py-2 space-x-2 text-right sm:table-cell">
            <inertia-link
              v-if="url"
              :href="route(url, row.id)"
              class="bg-green-500 hover:bg-green-600"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                />
              </svg>
            </inertia-link>
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
import Icon from "./Icon.vue";
export default {
  components: { Icon },
  props: {
    headers: { type: Object, required: true },
    datas: { type: Object, required: true },
    url: String,
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
};
</script>
