<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Form from "./Partials/Form.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    steps: [
        {
            order: 1,
            title: "Passo 1",
            description: "",
        },
    ],
    questions: [
        {
            step: 1,
            questions: [
                {
                    type: "",
                    title: "Pergunta 1",
                    showEditInputLabel: false,
                    options: [
                        {
                            label: "Opção 1",
                            showEditInputLabel: false,
                        },
                    ],
                },
            ],
        },
    ],
});

const handleSave = () => {
    form.post(route("app.on-boarding-form.create"), {
        onError: () => {
            console.log(form.errors);
        },
    });
};
</script>

<template>
    <AppLayout title="Criar Formulário de OnBoarding">
        <template #header>
            <HeaderTitle>Criar Formulário de OnBoarding</HeaderTitle>
        </template>

        <Form :form="form" @save="handleSave" />
    </AppLayout>
</template>
