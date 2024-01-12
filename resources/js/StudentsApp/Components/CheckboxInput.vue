<script setup>
import { onMounted, ref, useAttrs } from "vue";

const props = defineProps({
    modelValue: Array,
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

const emit = defineEmits(["update:modelValue"]);

defineExpose({ focus: () => input.value.focus() });

const handleCheckboxChange = (event, value) => {
    let values = props.modelValue;

    if (event.target.checked) {
        values.push(value);
    } else {
        values = values.filter((item) => item !== value);
    }

    emit("update:modelValue", values);
};
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
                    :checked="modelValue.includes(option.value)"
                    @change="handleCheckboxChange($event, option.value)"
                    class="shrink-0 h-4 w-4 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                />

                {{ option.label }}
            </label>
        </div>
    </div>
</template>
