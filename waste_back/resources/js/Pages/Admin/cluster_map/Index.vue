<template>
  <div>
    <div>
      <MySelect :value="form.soum_district_id" type="text" class="" label="Сум,Дүүрэг" :url="`/admin/soum_districts`"
        @changeId="(id) => (form.soum_district_id = id)" />
    </div>
    <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" style="width: 100%; height: 600px" :center="center"
      :zoom="15">

      <MarkerCluster>
        <Marker v-for="(location, i) in datas"
          :options="{ position: { lat: parseFloat(location.lat), lng: parseFloat(location.long) }, title: location.name }"
          :key="i" @click="() => onclick(location)" />
      </MarkerCluster>
    </GoogleMap>
  </div>
</template>

<script>
import Layout from "@/Layouts/Admin.vue";
import mapValues from "lodash/mapValues";
import Pagination from "@/Components/Pagination.vue";
import pickBy from "lodash/pickBy";
import SearchFilter from "@/Components/SearchFilter.vue";
import debounce from "lodash/debounce";
import AdminTable from "@/Components/AdminTable.vue";
import { ref } from "vue";
import { GoogleMap, Marker, MarkerCluster } from "vue3-google-map";
import { Inertia } from "@inertiajs/inertia";
import MySelect from "@/Components/MySelect.vue";
export default {
  metaInfo: { title: "Places" },
  components: {
    Pagination,
    SearchFilter,
    AdminTable,
    GoogleMap,
    Marker,
    MarkerCluster,
    MySelect
  },
  setup(props) {
    const center = { lat: parseFloat(47.9173283), lng: parseFloat(106.9247419) };
    const markerOptions = { position: center, label: "L", title: "LADY LIBERTY" };

    return { center, markerOptions };
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
        ...(this.filters ? this.filters : {}),
      },
    };
  },
  computed: {
    myFeatures() {
      return this.datas.data.map((v) => ({ lat: parseFloat(v.lat), lng: parseFloat(v.long) }));
    },
  },
  watch: {
    form: {
      handler: debounce(function () {
        this.$inertia.get(this.route("register.map"), pickBy(this.form), {
          preserveState: true,
        });
      }, 150),
      deep: true,
    },
  },
  methods: {
    onclick(e, v) {
      // Inertia.visit('')
    },
    reset() {
      this.form = mapValues(this.form, () => null);
    },
  },
};
</script>
