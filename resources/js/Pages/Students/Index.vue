<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableContainer from "@/Components/TableContainer.vue";
import TableHeader from "@/Components/TableHeader.vue";
import TableRow from "@/Components/TableRow.vue";
import TableRowActions from "@/Components/TableRowActions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import dateFormatter from "@/Helpers/dateFormatter.js";

const props = defineProps({
    students: {
        type: Object,
        required: true,
    },
});

const getFirstLastName = (name) => {
    const names = name.split(" ");
    return names[0] + " " + names[names.length - 1];
};

const destroyForm = useForm({
    id: "",
});

const destroy = (student) => {
    Swal.fire({
        title: "Você tem certeza? O aluno " + student.name + " será deletado!",
        text: "Ele perderá totalmente o acesso ao aplicativo! Você não poderá desfazer essa ação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, delete o aluno!",
        cancelButtonText: "Não, cancele!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            destroyForm.delete(route("app.students.delete", student.id), {
                preserveState: false,
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                "Cancelado",
                `O acesso do aluno ${student.name} está seguro :)`,
                "error"
            );
        }
    });
};
</script>

<template>
    <AppLayout title="Alunos">
        <template #header>
            <HeaderTitle>Alunos</HeaderTitle>
        </template>

        <div class="w-full flex justify-end mb-2">
            <Link :href="route('app.students.create')">
                <PrimaryButton>Adicionar Aluno</PrimaryButton>
            </Link>
        </div>

        <TableContainer>
            <template #table-header>
                <TableHeader>Nome</TableHeader>
                <TableHeader>Prontuário</TableHeader>
                <TableHeader>Próximo Feedback Em</TableHeader>
                <TableHeader>Data de Expiração de Acesso</TableHeader>
                <TableHeader class="text-end">Ações</TableHeader>
            </template>

            <template #table-body>
                <tr v-for="(student, key) in students.data" :key="key">
                    <TableRow>
                        <div class="flex flex-row items-center mr-6 w-24">
                            <img
                                :src="student.profile_photo_url"
                                class="w-12 h-12 rounded-full mr-2"
                            />
                            <p class="font-bold text-wrap">
                                {{ getFirstLastName(student.name) }}
                            </p>
                        </div>
                    </TableRow>
                    <TableRow> Notas </TableRow>
                    <TableRow>
                        {{ student.next_cycle_at ?? "Ainda não iniciado" }}
                    </TableRow>
                    <TableRow>
                        {{
                            student.access_expires_at
                                ? dateFormatter(student.access_expires_at)
                                : "Sem data de expiração"
                        }}
                    </TableRow>
                    <TableRowActions>
                        <Link :href="route('app.students.edit', student.id)">
                            <button
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500"
                            >
                                Editar
                            </button>
                        </Link>

                        <button
                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500"
                            @click="destroy(student)"
                        >
                            Deletar
                        </button>
                    </TableRowActions>
                </tr>
            </template>
        </TableContainer>
    </AppLayout>
</template>
