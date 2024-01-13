<script setup>
defineProps({
    value: String,
    class: {
        type: String,
        default: "block font-medium text-sm text-gray-700 dark:text-gray-300",
    },
});
</script>

<template>
    <label :class="class" v-bind="$attrs">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
