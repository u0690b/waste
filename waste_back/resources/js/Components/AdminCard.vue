<template>
  <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <RegisterCard v-for="item in datas.data" :item="item" @select="select" :showRoute="showRoute"></RegisterCard>
    <Modal :show="!!selected" @close="() => selected = null">
      <img :src="selected" alt="">
    </Modal>
  </div>
</template>

<script>
import { ref } from "vue";
import Icon from "./Icon.vue";
import Modal from "./Modal.vue";
import RegisterCard from "./RegisterCard.vue";
import ShowMapPoint from "./ShowMapPoint.vue";
export default {
  components: { Icon, RegisterCard, Modal, ShowMapPoint },
  props: {
    headers: { type: Object, required: true },
    datas: { type: Object, required: true },
    url: String,
    showRoute: [String]
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
