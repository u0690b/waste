<template>
  <Layout :title="title">
   <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
      <div class="p-4 bg-white rounded shadow">
        <h1>
          <BackButton href="/admin/notifications" />{{ title }}
          <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/notifications/${data.id}/edit`">Засах</ILink>
          <DestroyButton :href="'/admin/notifications/' + props.data.id" class="float-right">Устгах</DestroyButton>
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

const title = 'Notifications дэлгэрэнгүй'

const fields = [
  { label: '', value: props.data.id },
  { label: 'Хэнээс', value: props.data?.user?.name ?? '' },
  { label: 'Төрөл', value: props.data.type },
  { label: 'Гарчиг', value: props.data.title },
  { label: 'Агуулга', value: props.data.content },
  { label: 'Холоотой айди', value: props.data.rid },
  { label: 'Уншсан', value: props.data.read_at },
  { label: '', value: props.data.created_at },
  { label: '', value: props.data.updated_at }
]

</script>