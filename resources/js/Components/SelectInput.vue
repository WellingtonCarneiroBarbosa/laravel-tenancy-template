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
        class="py-2 px-4 w-full text-sm text-gray-800 cursor-pointer bg-gray-200 hover:bg-gray-300 rounded-lg focus:outline-none focus:bg-gray-300 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800"
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
