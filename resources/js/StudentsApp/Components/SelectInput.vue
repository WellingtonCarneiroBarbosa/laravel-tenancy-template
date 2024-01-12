<script setup>
import { onMounted, ref, useAttrs } from "vue";

const props = defineProps({
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

const attrs = useAttrs();

defineEmits(["update:modelValue"]);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        :class="{
            'border-red-500 focus:border-red-500 focus:ring-red-500': invalid,
            'border-transparent focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-gray-600':
                !invalid && !valid,
            'border-teal-500 focus:border-teal-500 focus:ring-teal-500': valid,
            'pl-9': icon,
        }"
        @change="$emit('update:modelValue', $event.target.value)"
        class="py-2 px-4 bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:text-gray-400 block w-full rounded-lg transition-colors duration-150 ease-in"
        ref="input"
        v-bind="attrs"
        :value="modelValue"
        :disabled="loading"
    >
        <option value="" disabled selected>Por favor, selecione</option>
        <option
            v-for="(option, key) in options"
            :key="`select_option_${key}`"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>
