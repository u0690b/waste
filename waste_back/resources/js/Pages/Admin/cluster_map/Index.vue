<template>


  <div class="flex p-4 bg-gray">
    <MySelect v-model="form.soum_district_id" class="w-52" label="Дүүрэг сонгох" :url="`/admin/soum_districts`" />
    <MySelect v-model="form.status_id" class="px-3 w-52" label="Төлөв сонгох" :url="`/admin/statuses`" />
  </div>

  <GoogleMap api-key="AIzaSyBX2h1XKlleDEXJCKTekPVDk2lI2LNDFNc" style="width: 100%; " class="h-[calc(100vh-200px)]" :center="center" :zoom="15">

    <MarkerCluster>
      <Marker v-for="(location, i) in datas" :options="{ position: { lat: parseFloat(location.lat), lng: parseFloat(location.long) }, label: parseState(location.status_id), title: location.name, icon: { fillColor: '#fff', strokeColor: 'white' } }" :key="i" @click="() => onclick(location)" />
    </MarkerCluster>
  </GoogleMap>


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
  import { router as Inertia } from "@inertiajs/vue3";
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
        orange: 'http://maps.google.com/mapfiles/kml/paddle/orange-circle.png',
        yellow: 'http://maps.google.com/mapfiles/kml/paddle/ylw-circle.png',
        blue: 'http://maps.google.com/mapfiles/kml/paddle/blu-circle.png',
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
      parseState(state) {
        if (state == 2) {
          return 'И';
        } else if (state == 3) {
          return 'Ш';
        }
        return 'Ш';
      },
      onclick(location) {
        Inertia.visit(`/admin/registers/${location.id}`);
        console.log(location);
      },
      reset() {
        this.form = mapValues(this.form, () => null);
      },
    },
  };
</script>
