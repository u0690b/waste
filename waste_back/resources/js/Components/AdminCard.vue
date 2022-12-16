<template>
  <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <RegisterCard v-for="item in datas.data" :item="item" @select="select"></RegisterCard>
    <Modal :show="!!selected" @close="() => selected = null">
      <RegisterCard :item="selected" @select="select" hideMoreButton>
        <h5 class=" text-xs text-black ">Бүртгэсэн хүн:</h5>
        <p>- {{ selected.reg_user.name }}</p>
        <h5 v-if="selected.resolve_desc" class=" text-xs text-black ">Шийдвэрлэсэн хүн:</h5>
        <p v-if="selected.resolve_desc" class="mb-3  font-normal text-gray-700 dark:text-gray-400">- {{
            selected.resolve_desc
        }}</p>
        <video v-if="selected.attached_video?.path" width="320" height="240" controls>
          <source :src="selected.attached_video.path">

          <a :href="selected.attached_video.path"> Download the video.</a>

        </video>
      </RegisterCard>
    </Modal>
  </div>
</template>

<script>
import { ref } from "vue";
import Icon from "./Icon.vue";
import Modal from "./Modal.vue";
import RegisterCard from "./RegisterCard.vue";
export default {
  components: { Icon, RegisterCard, Modal },
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
    const selected = ref(null)
    const select = (v) => selected.value = v;
    return {
      parseVal,
      selected,
      select
    };
  },
};
</script>
