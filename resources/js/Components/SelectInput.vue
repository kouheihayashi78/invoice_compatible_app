<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    required: true,
});

const SelectInput = ref(null);
// セレクトボックスは値を受け取るので、下記の記述で受け取ったoptionsをvueで使える
defineProps({
    options: {
        type: Array,
        required: true
    }
});

onMounted(() => {
    if (SelectInput.value) {
        SelectInput.value.focus();
    }
});

defineExpose({ focus: () => SelectInput.value.focus() });
</script>

<template>
    <select
        class="bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
        id="grid-state"
        v-model="model"
        ref="SelectInput"
    >
        <option value="">選択してください</option>
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</option>
    </select>
</template>
