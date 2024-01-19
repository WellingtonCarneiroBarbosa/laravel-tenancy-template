<script setup>
import { ref, onMounted } from "vue";

const isDark = ref(false);

const toggleTheme = () => {
    isDark.value = !isDark.value;

    if (isDark.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("dark", true);
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.removeItem("dark");
    }
};

onMounted(() => {
    if (document.documentElement.classList.contains("dark")) {
        isDark.value = true;
        return;
    }

    if (localStorage.getItem("dark")) {
        isDark.value = true;
        document.documentElement.classList.add("dark");
    }
});
</script>

<template>
    <div class="absolute top-0 right-0 p-3">
        <div class="flex items-center justify-center">
            <button
                class="flex items-center justify-center w-14 h-10 rounded-full bg-gray-300 dark:bg-gray-700 focus:outline-none"
                @click="toggleTheme"
            >
                <svg
                    class="w-4 h-4 text-gray-800 dark:text-gray-200"
                    :class="{
                        'text-gray-200': isDark,
                        'text-gray-800': !isDark,
                    }"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 4v.01M18 6l.01-.011M6 6l-.01-.011M12 8a4 4 0 100 8 4 4 0 000-8z"
                    ></path>
                </svg>
            </button>
        </div>
    </div>
</template>
