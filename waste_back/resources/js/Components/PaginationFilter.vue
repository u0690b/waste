<template>
    <div class="flex flex-wrap justify-between gap-4 mb-2">
        <div class="relative text-gray-400 w-[300px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input id="search" name="search" type="search" :value="search" @input="updateSearch($event.target.value)"
                class="w-full py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:z-10"
                placeholder="Шалтгаан хайх" />
        </div>

        <select :value="modelValue" @change="updateModelValue($event.target.value)"
            class="text-sm text-gray-900 border border-gray-300 rounded-md focus:outline-none focus:ring-gray-500 focus:z-10">
            <option value="10">10/{{ total }}</option>
            <option value="30">30/{{ total }}</option>
            <option value="50">50/{{ total }}</option>
            <option value="100">100/{{ total }}</option>
            <!-- <option value="500">500/{{ total }}</option>
      <option value="1000">1000/{{ total }}</option> -->
        </select>
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: [Number, String],
        default: 10,
    },
    search: {
        type: [String, Number],
        default: '',
    },
    total: {
        type: Number,
        required: true,
    },
});
const emit = defineEmits(['update:modelValue', 'update:search', 'update']);
const update = () => {
    emit('update');
};
const updateModelValue = (value) => {
    emit('update:modelValue', value);
    update();
};
const updateSearch = (value) => {
    emit('update:search', value);
    update();
};

</script>
