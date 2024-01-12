<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateTeamForm from "@/Pages/Teams/Partials/CreateTeamForm.vue";
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Team
            </h2>
        </template>

        <div>
            <CreateTeamForm />
        </div>
    </AppLayout>
</template>
