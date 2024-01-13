<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Form from "./Partials/Form.vue";
</script>

<template>
    <AppLayout title="Criar Formulário de OnBoarding">
        <template #header>
            <HeaderTitle>Criar Formulário de OnBoarding</HeaderTitle>
        </template>

        <Form />
    </AppLayout>
</template>
