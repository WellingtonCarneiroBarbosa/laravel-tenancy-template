<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Form from "./Partials/Form.vue";
import { useForm, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: "",
    email: "",
    cpf: "",
    access_expires_at: "",
});

const save = () => {
    form.post(route("app.users.create"));
};
</script>

<template>
    <AppLayout title="Adicionar Aluno">
        <template #header>
            <HeaderTitle title="Adicionar Aluno" />

            <Link :href="route('app.users.index')">
                <PrimaryButton> Voltar </PrimaryButton>
            </Link>
        </template>

        <Form :form="form" @submitted="save" />
    </AppLayout>
</template>
