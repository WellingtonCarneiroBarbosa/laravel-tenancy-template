<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateTeamForm from "@/Pages/Teams/Partials/CreateTeamForm.vue";
</script>

<template>
    <AppLayout title="Criar Novo App">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Criar Novo App
            </h2>
        </template>

        <div>
            <CreateTeamForm />
        </div>
    </AppLayout>
</template>
