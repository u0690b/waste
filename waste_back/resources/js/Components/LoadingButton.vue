<template>
  <button :disabled="loading" v-bind="$attrs" class="btn btn-primary d-flex flex- justify-content-center " :class="[{'disabled':loading}]" @click="$emit('click',$event)">
    <div v-if="loading" class="animate-spin icon-spin3 mr-2 w-4 h-4 text-black ti-reload" />
    <slot v-else />
  </button>
</template>

<script>
export default {
  props: {
    loading: [Boolean],
  },
}
</script>
