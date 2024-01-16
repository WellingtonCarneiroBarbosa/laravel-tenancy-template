<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableContainer from "@/Components/TableContainer.vue";
import TableHeader from "@/Components/TableHeader.vue";
import TableRow from "@/Components/TableRow.vue";
import TableRowActions from "@/Components/TableRowActions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    onBoardings: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <AppLayout title="Formulários de OnBoarding">
        <template #header>
            <HeaderTitle>Seus Formulários de OnBoarding</HeaderTitle>
        </template>

        <div class="w-full flex justify-end mb-2">
            <PrimaryButton>Novo Formulário</PrimaryButton>
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
                    </TableRowActions>
                </tr>
            </template>
        </TableContainer>
    </AppLayout>
</template>
