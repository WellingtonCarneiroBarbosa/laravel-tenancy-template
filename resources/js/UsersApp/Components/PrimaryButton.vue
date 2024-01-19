<script setup>
import Spinner from "@/Components/Spinner.vue";
defineProps({
    type: {
        type: String,
        default: "submit",
    },
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-800 focus:bg-blue-700 dark:focus:bg-blue-800 active:bg-blue-800 dark:active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-blue-800 transition ease-in-out duration-150"
        :class="{ 'opacity-50 cursor-not-allowed': loading }"
        :disabled="loading"
    >
        <slot />

        <Spinner v-if="loading" class="ml-2" />
    </button>
</template>
