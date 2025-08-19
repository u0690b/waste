<template>
  <Layout :title="title">
   <div class="p-4 mt-8 sm:px-8 sm:py-4 ">
      <div class="p-4 bg-white rounded shadow">
        <h1>
          <BackButton href="/admin/customers" />{{ title }}
          <ILink class="float-right ml-4 btn btn-warning" :href="`/admin/customers/${data.id}/edit`">Засах</ILink>
          <DestroyButton :href="'/admin/customers/' + props.data.id" class="float-right">Устгах</DestroyButton>
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

const title = 'Customers дэлгэрэнгүй'

const fields = [
  { label: '', value: props.data.id },
  { label: '', value: props.data.regnum },
  { label: '', value: props.data.firstname },
  { label: '', value: props.data.gender },
  { label: '', value: props.data.image },
  { label: '', value: props.data.lastname },
  { label: '', value: props.data.nationality },
  { label: '', value: props.data.passportAddress },
  { label: '', value: props.data.passportExpireDate },
  { label: '', value: props.data.passportIssueDate },
  { label: '', value: props.data.soumDistrictCode },
  { label: '', value: props.data.soumDistrictName },
  { label: '', value: props.data.surname },
  { label: '', value: props.data.token },
  { label: '', value: props.data.remember_token },
  { label: '', value: props.data.push_token },
  { label: '', value: props.data.created_at },
  { label: '', value: props.data.updated_at }
]

</script>