<script setup>
import { watch, ref } from "vue";
import { UserCheck2, X } from "lucide-vue-next";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
    showingNavigationDropdown: Boolean,
});

const backdrop = ref(null);

const sidebar = ref(null);

const logout = () => {
    router.post(route("logout"));
};

watch(
    () => props.showingNavigationDropdown.value,
    (newValue) => {
        if (newValue) {
            backdrop.value.classList.remove("hidden");
        } else {
            backdrop.value.classList.add("hidden");
        }
    }
);
</script>

<template>
    <div
        id="docs-sidebar"
        ref="sidebar"
        class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-500 transform fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500 dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'translate-x-0 ': showingNavigationDropdown,
            '-translate-x-full ': !showingNavigationDropdown,
        }"
    >
        <div class="right-0 top-0 fixed p-2" v-if="showingNavigationDropdown">
            <button @click="showingNavigationDropdown = false">
                <X class="w-6 h-6 text-gray-500 dark:text-gray-400" />
            </button>
        </div>

        <div class="flex-none text-xl font-semibold dark:text-white px-6">
            <a href="#" aria-label="Brand">
                <Link
                    :href="route('app.dashboard')"
                    class="shrink-0 flex flex-row items-center gap-x-2"
                >
                    <ApplicationMark class="block h-9 w-auto" />
                    Agenda Aí
                </Link>
            </a>
        </div>
        <nav
            class="hs-accordion-group p-6 w-full flex flex-col flex-wrap"
            data-hs-accordion-always-open
        >
            <ul class="space-y-1.5">
                <li>
                    <Link
                        :href="route('app.dashboard')"
                        class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        :class="{
                            'bg-gray-100 dark:bg-gray-900':
                                route().current('app.dashboard'),
                        }"
                    >
                        <svg
                            class="w-4 h-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"
                            />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        Dashboard
                    </Link>
                </li>

                <li
                    class="hs-accordion"
                    id="forms-accordion"
                    :class="{
                        active: route().current('app.users.*'),
                    }"
                >
                    <button
                        type="button"
                        class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    >
                        <UserCheck2 class="w-4 h-4" />
                        Alunos

                        <svg
                            class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="m18 15-6-6-6 6" />
                        </svg>

                        <svg
                            class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            ></path>
                        </svg>
                    </button>

                    <div
                        id="forms-accordion"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                        :class="{
                            hidden: !route().current('app.users.*'),
                        }"
                    >
                        <ul class="pt-2 ps-2">
                            <li>
                                <Link
                                    :href="route('app.users.index')"
                                    :class="{
                                        'bg-gray-100 dark:bg-gray-900':
                                            route().current('app.users.index'),
                                    }"
                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                >
                                    Meus Alunos
                                </Link>
                            </li>
                            <li>
                                <Link
                                    :href="route('app.users.create')"
                                    :class="{
                                        'bg-gray-100 dark:bg-gray-900':
                                            route().current('app.users.create'),
                                    }"
                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                >
                                    Adicionar
                                </Link>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <ul
                class="absolute bottom-0 left-0 px-7 mb-10 space-y-1.5 w-full"
                v-if="showingNavigationDropdown"
            >
                <div
                    class="border-t border-gray-200 dark:border-gray-600 mb-3"
                />
                <li
                    class="hs-accordion"
                    id="account-accordion"
                    :class="{
                        hidden: !showingNavigationDropdown,
                        active:
                            route().current('profile.show') ||
                            route().current('teams.*'),
                    }"
                >
                    <button
                        type="button"
                        class="hs-accordion-toggle bg-gray-100 dark:bg-gray-800 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                    >
                        Configurações

                        <svg
                            class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="m18 15-6-6-6 6" />
                        </svg>

                        <svg
                            class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            ></path>
                        </svg>
                    </button>

                    <div
                        id="account-accordion"
                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                        :class="{
                            hidden:
                                !route().current('profile.show') &&
                                !route().current('teams.*'),
                        }"
                    >
                        <ul class="pt-2 ps-2">
                            <li>
                                <Link
                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                    :href="route('profile.show')"
                                    :class="{
                                        'bg-gray-100 dark:bg-gray-900':
                                            route().current('profile.show'),
                                    }"
                                >
                                    Meu Perfil
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                    :href="
                                        route(
                                            'teams.show',
                                            $page.props.auth.user.current_team
                                        )
                                    "
                                    :class="{
                                        'bg-gray-100 dark:bg-gray-900':
                                            route().current('teams.show'),
                                    }"
                                >
                                    Configurar App Atual
                                </Link>
                            </li>
                            <li>
                                <Link
                                    class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                    v-if="$page.props.jetstream.canCreateTeams"
                                    :href="route('teams.create')"
                                    :class="{
                                        'bg-gray-100 dark:bg-gray-900':
                                            route().current('teams.create'),
                                    }"
                                >
                                    Criar Novo App
                                </Link>
                            </li>
                            <template
                                v-if="
                                    $page.props.auth.user.all_teams.length > 1
                                "
                            >
                                <div
                                    class="border-t border-gray-200 dark:border-gray-600"
                                />

                                <div class="block py-2 text-xs text-gray-400">
                                    Mudar App Atual
                                </div>

                                <template
                                    v-for="team in $page.props.auth.user
                                        .all_teams"
                                    :key="team.id"
                                >
                                    <form @submit.prevent="switchToTeam(team)">
                                        <DropdownLink as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="
                                                        team.id ==
                                                        $page.props.auth.user
                                                            .current_team_id
                                                    "
                                                    class="me-2 h-5 w-5 text-green-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>

                                                <div>
                                                    {{ team.name }}
                                                </div>
                                            </div>
                                        </DropdownLink>
                                    </form>
                                </template>
                            </template>
                        </ul>
                    </div>
                </li>

                <li class="w-full">
                    <button
                        @click="logout"
                        class="bg-gray-100 justify-center text-center dark:bg-gray-800 w-full dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 hover:text-slate-700 focus:outline-none focus:ring-1 focus:ring-gray-600 transition duration-150 ease-in-out"
                    >
                        Sair
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <div
        ref="backdrop"
        id="docs-sidebar-backdrop"
        style="z-index: 59"
        class="transition duration fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 hs-overlay-backdrop hidden"
    ></div>
</template>
