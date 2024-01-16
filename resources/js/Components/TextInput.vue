<script setup>
import { onMounted, ref, useAttrs } from "vue";
import { vMaska } from "maska";

defineProps({
    modelValue: String,
    icon: Object | null | undefined,
    invalid: {
        type: Boolean,
        default: false,
    },
    valid: {
        type: Boolean,
        default: false,
    },
    mask: Object | null | undefined,
    loading: Boolean,
    message: String | null | undefined,
});

defineOptions({
    inheritAttrs: false,
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
    <div class="relative w-full">
        <input
            ref="input"
            v-bind="attrs"
            class="border-gray-300 w-full dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            :value="modelValue"
            :disabled="loading"
            :class="{
                'border-red-500 focus:border-red-500 focus:ring-red-500':
                    invalid,
                ' focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-gray-600':
                    !invalid && !valid,
                'border-teal-500 focus:border-teal-500 focus:ring-teal-500':
                    valid,
                'pl-9': icon,
            }"
            @input="$emit('update:modelValue', $event.target.value)"
            v-maska:[mask]
            autocomplete="off"
        />
        <div
            v-if="icon"
            class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4 peer-disabled:opacity-50 peer-disabled:pointer-events-none"
        >
            <component
                :is="icon"
                class="h-4 w-4 text-gray-500 dark:text-gray-400"
            />
        </div>
        <div
            class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3"
            v-if="invalid"
        >
            <svg
                class="flex-shrink-0 h-4 w-4 text-red-500"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
        </div>
        <div
            v-if="valid"
            class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3"
        >
            <svg
                class="flex-shrink-0 h-4 w-4 text-teal-500"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </div>
    </div>
</template>
