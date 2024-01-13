<script setup>
import { ref } from "vue";

const select = ref(null);

const props = defineProps({
    id: String,
    modelValue: String,
    loading: Boolean,
    options: Array,
    icon: Object | null | undefined,
    invalid: {
        type: Boolean,
        default: false,
    },
    valid: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <select
        ref="select"
        :class="{
            'border-red-500 focus:border-red-500 focus:ring-red-500': invalid,
            'border-transparent focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-gray-600':
                !invalid && !valid,
            'border-teal-500 focus:border-teal-500 focus:ring-teal-500': valid,
            'pl-9': icon,
        }"
        class="py-2 px-4 w-full text-sm rounded-lg focus:outline-none border-gray-300 dark:border-gray-700 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
        @change="$emit('update:modelValue', $event.target.value)"
        :id="id"
        v-bind="$attrs"
        :value="modelValue"
        :disabled="loading"
    >
        <option value="">Por favor, selecione</option>
        <option
            v-for="(option, key) in options"
            :key="`select_option_${key}`"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>
