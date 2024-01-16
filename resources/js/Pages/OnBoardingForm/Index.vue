<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TableContainer from "@/Components/TableContainer.vue";
import TableHeader from "@/Components/TableHeader.vue";
import TableRow from "@/Components/TableRow.vue";
import TableRowActions from "@/Components/TableRowActions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";

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
                        <button>Deletar</button>
                    </TableRowActions>
                </tr>
            </template>
        </TableContainer>
    </AppLayout>
</template>
