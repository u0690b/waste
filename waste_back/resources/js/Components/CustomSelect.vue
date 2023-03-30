<template>
  <div class="w-full mb-4 " :class="$attrs.class">
    <label class="text-capitalize">
      <span v-if="label" :class="[labelClass]">{{ label }}:</span>
      <select :value="modelValue" v-bind="$attrs" class="w-full py-0 text-sm leading-3 whitespace-pre-wrap min-h-[23px] " :class="selectClass" @input="v=>$emit('update:modelValue',v.target.value)">
        <option v-if="clearable" :value="''">Сонгох</option>
        <option v-for="item in options" :key="item" :value="item[valueKey]" :selected="modelValue==item[valueKey]">
          {{ item[nameKey] }}
        </option>
      </select>
    </label>
    <div v-if="error" class="text-sm text-red-500">{{ error }}</div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue:[String,Number,Object],
  options:[Array],
  label: [String],
  valueKey:{type:String,default:'id'},
  nameKey:{type:String,default:'name'},
  labelClass:String,
  error: [String],
  selectClass:[String],
  clearable:{type:Boolean,default:false},
},
  
)
const $emit = defineEmits(['update:modelValue'])
</script>

<style lang="scss" scoped>

</style>