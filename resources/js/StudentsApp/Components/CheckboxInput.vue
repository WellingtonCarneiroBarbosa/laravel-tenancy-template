<script setup>
import { onMounted, ref, useAttrs } from "vue";

const props = defineProps({
    modelValue: String,
    loading: Boolean,
    id: String,
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
    <div class="grid grid-cols-12 gap-4 w-full">
        <div
            class="col-span-4"
            v-for="(option, optionKey) in options"
            :key="`checkbox_option_${optionKey}`"
        >
            <label
                class="ml-1 text-gray-700 dark:text-gray-300"
                :for="`${id}_option_${optionKey}`"
            >
                <input
                    type="checkbox"
                    :id="`${id}_option_${optionKey}`"
                    :name="id"
                    v-bind="attrs"
                    :value="option.value"
                    @change="$emit('update:modelValue', $event.target.value)"
                    class="shrink-0 h-4 w-4 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                />

                {{ option.label }}
            </label>
        </div>
    </div>
</template>
