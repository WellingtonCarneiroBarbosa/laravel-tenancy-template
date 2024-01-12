<script setup>
import { HSSelect } from "preline";
import { nextTick, onMounted, ref, watch } from "vue";

const select = ref(null);

watch(
    () => select.value,
    (val) => {
        if (val) {
            nextTick(() => {
                const interval = setInterval(() => {
                    const select = HSSelect.getInstance(`#${props.id}`);

                    if (select) {
                        select.on("change", (val) => {
                            emit("update:modelValue", val);
                        });

                        clearInterval(interval);
                    }
                }, 500);
            });
        }
    },
    { immediate: true }
);

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
    <div class="relative">
        <select
            ref="select"
            data-hs-select='{
                "placeholder": "Por favor, selecione",
                "toggleTag": "<button type=\"button\"></button>",
                "toggleClasses": "disabled:opacity-50 disabled:pointer-events-none hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 transition-colors duration-150 ease-in",
                "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
            }'
            :class="{
                'border-red-500 focus:border-red-500 focus:ring-red-500':
                    invalid,
                'border-transparent focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-gray-600':
                    !invalid && !valid,
                'border-teal-500 focus:border-teal-500 focus:ring-teal-500':
                    valid,
                'pl-9': icon,
            }"
            class="hidden"
            :id="id"
            v-bind="$attrs"
            :value="modelValue"
            :disabled="loading"
        >
            <option
                v-for="(option, key) in options"
                :key="`select_option_${key}`"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>

        <div class="absolute top-6 end-3 -translate-y-1/2">
            <svg
                class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500"
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
                <path d="m7 15 5 5 5-5" />
                <path d="m7 9 5-5 5 5" />
            </svg>
        </div>
    </div>
</template>
