<script setup>
import ThemeToggler from "@/StudentsApp/Components/ThemeToggler.vue";
</script>

<template>
    <div
        class="transition-colors ease-in duration-500 bg-gray-200 dark:bg-gray-900 dark:text-white flex flex-col items-center justify-center content-center text-center h-full min-h-screen w-full px-4"
    >
        <ThemeToggler />

        <slot />
    </div>
</template>
