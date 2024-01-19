<script setup>
import { computed, nextTick, onMounted, ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TableContainer from "@/Components/TableContainer.vue";
import TableHeader from "@/Components/TableHeader.vue";
import TableRow from "@/Components/TableRow.vue";
import TableRowActions from "@/Components/TableRowActions.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import dateFormatter from "@/Helpers/dateFormatter.js";
import Notes from "./Partials/Notes.vue";
import TableFilter from "./Partials/TableFilter.vue";

const props = defineProps({
    users: {
        type: Object,
        required: true,
    },
    notes: {
        type: Object,
        required: false,
    },
    filterMode: {
        type: Boolean,
        default: false,
    },
});

const selectedUser = ref(null);

const showUserNotes = ref(false);

const gettingUserNotes = ref(false);

const getUserNotes = async (user) => {
    if (gettingUserNotes.value) {
        return;
    }

    selectedUser.value = user;
    gettingUserNotes.value = true;

    router.visit(
        route("app.users.index", {
            userId: user.id,
        }),
        {
            preserveState: true,
            only: ["notes"],
            onSuccess: () => {
                setTimeout(() => {
                    nextTick(() => {
                        gettingUserNotes.value = false;
                        showUserNotes.value = true;
                    });
                }, 200);
            },
        }
    );
};

const handleNoteClosed = () => {
    showUserNotes.value = false;
    selectedUser.value = null;
};

const getFirstLastName = (name) => {
    const names = name.split(" ");
    return names[0] + " " + names[names.length - 1];
};

const destroyForm = useForm({
    id: "",
});

const anyResultsMessage = computed(() => {
    if (props.filterMode) {
        let url = new URL(window.location.href);

        let term = url.searchParams.get("term");

        let type = url.searchParams.get("type");

        type = type === "name" ? "Nome" : "E-mail";

        return `Nenhum resultado encontrado com o ${type} <b>${term}</b>`;
    }

    return "Você ainda não tem alunos cadastrados. Cadastre um para acessar o aplicativo ;)";
});

const destroy = (user) => {
    Swal.fire({
        title: "Você tem certeza? O aluno " + user.name + " será deletado!",
        text: "Ele perderá totalmente o acesso ao aplicativo! Você não poderá desfazer essa ação!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim, delete o aluno!",
        cancelButtonText: "Não, cancele!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            destroyForm.delete(route("app.users.delete", user.id), {
                preserveState: false,
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                "Cancelado",
                `O acesso do aluno ${user.name} está seguro :)`,
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

            <template v-if="filterMode">
                <Link :href="route('app.users.index')"> Limpar Filtros </Link>
            </template>
        </template>

        <Notes
            :show="showUserNotes"
            :user="selectedUser ?? {}"
            :notes="notes ?? {}"
            @close="handleNoteClosed"
        />

        <div class="w-full flex justify-end mb-2">
            <Link :href="route('app.users.create')">
                <PrimaryButton>Adicionar Aluno</PrimaryButton>
            </Link>
        </div>

        <TableContainer v-if="users.data.length >= 1">
            <template #table-filters>
                <TableFilter :filter-mode="props.filterMode" />
            </template>

            <template #table-header>
                <TableHeader>Nome</TableHeader>
                <TableHeader>Prontuário</TableHeader>
                <TableHeader>Próximo Feedback Em</TableHeader>
                <TableHeader>Data de Expiração de Acesso</TableHeader>
                <TableHeader class="text-end">Ações</TableHeader>
            </template>

            <template #table-body>
                <tr v-for="(user, key) in users.data" :key="key">
                    <TableRow>
                        <div class="flex flex-row items-center mr-6 w-24">
                            <img
                                :src="user.profile_photo_url"
                                class="w-12 h-12 rounded-full mr-2"
                            />
                            <p class="font-bold text-wrap">
                                {{ getFirstLastName(user.name) }}
                            </p>
                        </div>
                    </TableRow>
                    <TableRow>
                        <button
                            @click="getUserNotes(user)"
                            :disabled="gettingUserNotes"
                            class="hover:bg-gray-100 border p-2 rounded-md font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500"
                            :class="{
                                'bg-gray-100 bg-opacity-70 cursor-not-allowed':
                                    gettingUserNotes,
                                'bg-white': !gettingUserNotes,
                            }"
                        >
                            {{
                                gettingUserNotes && selectedUser.id === user.id
                                    ? "Carregando..."
                                    : "Visualizar Prontuário"
                            }}
                        </button>
                    </TableRow>
                    <TableRow>
                        {{ user.next_cycle_at ?? "Ainda não iniciado" }}
                    </TableRow>
                    <TableRow>
                        {{
                            user.access_expires_at
                                ? dateFormatter(user.access_expires_at)
                                : "Sem data de expiração"
                        }}
                    </TableRow>
                    <TableRowActions>
                        <Link :href="route('app.users.edit', user.id)">
                            <button
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500"
                            >
                                Editar
                            </button>
                        </Link>

                        <button
                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-500"
                            @click="destroy(user)"
                        >
                            Deletar
                        </button>
                    </TableRowActions>
                </tr>
            </template>
        </TableContainer>

        <template v-else>
            <TableFilter :filter-mode="props.filterMode" />
            <p v-html="anyResultsMessage"></p>
        </template>
    </AppLayout>
</template>
