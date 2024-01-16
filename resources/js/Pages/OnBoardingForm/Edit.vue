<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Form from "./Partials/Form.vue";
import { useForm } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
    onBoardingForm: Object,
});

const form = useForm({
    steps: [],
    questions: [],
});

const handleSave = () => {
    form.post(route("app.on-boarding-form.create"));
};

onMounted(() => {
    form.steps = props.onBoardingForm.steps;

    let questions = props.onBoardingForm.questions;

    questions.map((qs) => {
        qs.questions.map((question) => {
            question.showEditInputLabel = false;

            if (
                question.type === "select" ||
                question.type === "radio" ||
                question.type === "checkbox"
            ) {
                question.options.map((option) => {
                    option.showEditInputLabel = false;

                    return option;
                });
            }

            return question;
        });

        return qs;
    });

    form.questions = questions;
});
</script>

<template>
    <AppLayout title="Editar Formulário de OnBoarding">
        <template #header>
            <HeaderTitle>
                Editar Formulário de OnBoarding: Ciclo
                {{ onBoardingForm.cicle }}
            </HeaderTitle>
        </template>

        <Form
            v-if="form.questions.length >= 1 && form.steps.length >= 1"
            :form="form"
            @save="handleSave"
        />
    </AppLayout>
</template>
