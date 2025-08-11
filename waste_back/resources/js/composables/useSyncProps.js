import { computed } from 'vue'

export const useSyncProps = (props,  key)  => {
  const emit = defineEmits([`update:${key}`])
  return computed({
    get() {
      return props[key]
    },
    set(value) {
      emit(`update:${key}`, value)
    },
  })
}