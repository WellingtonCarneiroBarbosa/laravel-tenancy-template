<script setup>
import ThemeToggler from "@/StudentsApp/Components/ThemeToggler.vue";
import { onMounted } from "vue";

onMounted(() => {
    setTimeout(() => {
        window.HSStaticMethods.autoInit();
    }, 100);
});
</script>

<template>
    <div
        class="transition-colors ease-in duration-500 bg-gray-200 dark:bg-gray-900 dark:text-white flex flex-col items-center justify-center content-center text-center h-full min-h-screen w-full px-4"
    >
        <ThemeToggler />

        <div class="my-10 sm:my-14">
            <slot />
        </div>
    </div>
</template>
