<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label text-capitalize grid">
      <span>{{ label }}:</span>
      <input
        ref="input"
        v-bind="{ ...$attrs, class: null }"
        class="form-input"
        :class="{ error: error }"
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      />
    </label>
    <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
  </div>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "text",
    },
    modelValue: String,
    label: [String],
    error: [String],
  },
  emits: ["update:modelValue"],
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end);
    },
  },
};
</script>
