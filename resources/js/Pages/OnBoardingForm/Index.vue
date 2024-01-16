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

defineProps({
    onBoardings: {
        type: Array,
        required: true,
    },
});

const destroyForm = useForm({
    id: "",
});

const destroy = (onBoardingForm) => {
    Swal.fire({
        title:
            "Você tem certeza? O formulário do ciclo " +
            onBoardingForm.cicle +
            " será deletado!",
        text: "Você não poderá reverter isso!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Não, cancele!",
        confirmButtonText: "Sim, delete isso!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            destroyForm.delete(
                route("app.on-boarding-form.delete", onBoardingForm.id),
                {
                    preserveState: false,
                }
            );
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                "Cancelado",
                `Seu formulário de OnBoarding do ciclo ${onBoardingForm.cicle} está seguro :)`,
                "error"
            );
        }
    });
};
</script>

<template>
    <AppLayout title="Formulários de OnBoarding">
        <template #header>
            <HeaderTitle>Seus Formulários de OnBoarding</HeaderTitle>
        </template>

        <div class="w-full flex justify-end mb-2">
            <Link :href="route('app.on-boarding-form.create')">
                <PrimaryButton>Novo Formulário</PrimaryButton>
            </Link>
        </div>

        <TableContainer>
            <template #table-header>
                <TableHeader>Ciclo</TableHeader>
                <TableHeader class="text-end">Ações</TableHeader>
            </template>

            <template #table-body>
                <tr v-for="(onBoarding, key) in onBoardings" :key="key">
                    <TableRow>
                        {{
                            onBoarding.cicle === 1
                                ? "On Boarding Inicial"
                                : "Ciclo " + onBoarding.cicle
                        }}
                    </TableRow>
                    <TableRowActions>
                        <Link
                            :href="
                                route(
                                    'app.on-boarding-form.edit',
                                    onBoarding.id
                                )
                            "
                        >
                            <button
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500"
                            >
                                Editar
                            </button>
                        </Link>

                        <button
                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500"
                            @click="destroy(onBoarding)"
                            v-if="
                                onBoarding.cicle !== 1 && onBoarding.cicle !== 2
                            "
                        >
                            Deletar
                        </button>
                    </TableRowActions>
                </tr>
            </template>
        </TableContainer>
    </AppLayout>
</template>
