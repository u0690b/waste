<template>
  <Layout :title="title">
   <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
      <div class="p-4 bg-white rounded shadow">
        <h1>
          <BackButton href="/admin/registers" />{{ title }}
          <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/registers/${data.id}/edit`">Засах</ILink>
          <DestroyButton :href="'/admin/registers/' + props.data.id" class="float-right">Устгах</DestroyButton>
        </h1>
        <div class="show-grid">
          <InputLabel v-for="item in fields" :key="item.label" v-bind="item" class="border-b border-dashed" />
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from '@/Layouts/Admin.vue';
import InputLabel from '@/Components/InputLabel.vue';
import BackButton from '@/Components/BackButton.vue';
import DestroyButton from '@/Components/DestroyButton.vue';

const props = defineProps({
  data: [Object],
});

const title = 'Registers дэлгэрэнгүй'

const fields = [
  { label: '', value: props.data.id },
  { label: 'Иргэн/ААН', value: props.data.whois },
  { label: 'Байгууллага, аж ахуйн нэгжийн нэр, иргэний овог нэр', value: props.data.name },
  { label: 'Регистрийн дугаар', value: props.data.register },
  { label: 'Үйл ажиллагааны чиглэл', value: props.data.chiglel },
  { label: 'Аймаг,Нийслэл', value: props.data?.aimag_city?.name ?? '' },
  { label: 'Сум,Дүүрэг', value: props.data?.soum_district?.name ?? '' },
  { label: 'Баг,Хороо', value: props.data?.bag_horoo?.name ?? '' },
  { label: 'Хаяг, байршилд', value: props.data.address },
  { label: 'Гаргасан зөрчлийн байдал', value: props.data.description },
  { label: 'Зөрчлийн төрөл', value: props.data?.reason?.name ?? '' },
  { label: 'Зөрчсөн хууль тогтоомжийн зүйл, заалт', value: props.data.zuil_zaalt },
  { label: 'Уртраг', value: props.data.long },
  { label: 'Өргөрөг', value: props.data.lat },
  { label: 'Бүртгэсэн хүн', value: props.data?.reg_user?.name ?? '' },
  { label: 'Шийдвэрийн төрөл', value: props.data?.resolve?.name ?? '' },
  { label: 'Шийдвэрлэсэн байдал', value: props.data.resolve_desc },
  { label: 'Шийдвэрлэсэн зураг', value: props.data.resolve_image },
  { label: 'Шийдвэрлэсэн огноо', value: props.data.resolved_at },
  { label: 'Шийдвэрлэсэн хүн', value: props.data?.comf_user?.name ?? '' },
  { label: 'Төлөв', value: props.data?.status?.name ?? '' },
  { label: 'Үүсгэсэн', value: props.data.reg_at },
  { label: 'Хуваарилсан хүн', value: props.data.allocate_by },
  { label: '', value: props.data.created_at },
  { label: '', value: props.data.updated_at }
]

</script>