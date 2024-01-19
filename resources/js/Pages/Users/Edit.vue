<script setup>
import { onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import Form from "./Partials/Form.vue";
import { useForm, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: "",
    email: "",
    cpf: "",
    access_expires_at: "",
});

const save = () => {
    form.put(
        route("app.users.edit", {
            user: props.user.id,
        })
    );
};

onMounted(() => {
    form.name = props.user.name;
    form.email = props.user.email;
    form.cpf = props.user.cpf;

    if (props.user.access_expires_at !== null) {
        let date = new Date(props.user.access_expires_at);

        form.access_expires_at =
            date.getFullYear() +
            "-" +
            ("0" + (date.getMonth() + 1)).slice(-2) +
            "-" +
            ("0" + date.getDate()).slice(-2);
    } else {
        form.access_expires_at = "";
    }
});
</script>

<template>
    <AppLayout title="Editar Aluno">
        <template #header>
            <HeaderTitle title="Editar Aluno" />

            <Link :href="route('app.users.index')">
                <PrimaryButton> Voltar </PrimaryButton>
            </Link>
        </template>

        <Form :form="form" mode="edit" @submitted="save" />
    </AppLayout>
</template>
