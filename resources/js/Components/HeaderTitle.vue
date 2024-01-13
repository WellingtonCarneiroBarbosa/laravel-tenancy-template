<script setup>
defineProps({
    title: {
        type: String,
        required: false,
        default: null,
    },
});
</script>

<template>
    <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
    >
        <slot v-if="$slots.default" />

        <template v-else>
            {{ title }}
        </template>
    </h2>
</template>
