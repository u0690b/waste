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
          <th class="pl-2">Үйлдэл</th>
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
              class="items-center focus:text-indigo-500"
            >
              {{ parseVal(row, key) }}
            </inertia-link>
            <!--span v-else class="items-center">{{ parseVal(row, key) }}</span-->
          </td>
          <td class="pl-2 py-2 border-t">
            <div class="row flex">
              <div class="col-sm-2">
                <inertia-link
                  v-if="url"
                  :href="route(url, row.id)"
                  class="flex px-2 mr-4 bg-green-500 p-2 text-white rounded-md hover:bg-green-600"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
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
              </div>
              <div class="col-sm-2">
                <inertia-link
                  v-if="url"
                  :href="route(url, row.id)"
                  class="flex px-2 mr-4 bg-red-500 p-2 text-white rounded-md hover:bg-red-600"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </inertia-link>
              </div>
              <div class="col-sm-2">
                <inertia-link
                  v-if="url"
                  :href="route(url, row.id)"
                  class="flex px-2 mr-4 bg-blue-500 p-2 text-white rounded-md hover:bg-blue-600"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"
                    />
                  </svg>
                </inertia-link>
              </div>
              <div class="col-sm-2">
                <inertia-link
                  v-if="url"
                  :href="route(url, row.id)"
                  class="flex px-2 mr-4 bg-orange-500 p-2 text-white rounded-md hover:bg-orange-600"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"
                    />
                  </svg>
                </inertia-link>
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
