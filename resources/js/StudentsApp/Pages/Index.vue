<script setup>
import { nextTick, ref, watch, onMounted } from "vue";
import axios from "axios";
import ThemeToggler from "@/StudentsApp/Components/ThemeToggler.vue";
import { router, usePage } from "@inertiajs/vue3";

const props = defineProps(["someProp"]);
const pinInputs = ref(["", "", "", "", ""]);

const invalidPin = ref(false);

const hiddenPage = ref(true);

const loading = ref(false);

watch(
    pinInputs,
    (values) => {
        const pin = values.join("");

        if (pin !== "" && invalidPin.value) {
            invalidPin.value = false;
        }

        if (pin.length === 5) {
            getTenant(pin);
        }

        for (let i = 0; i < values.length; i++) {
            if (values[i]?.length > 1) {
                pinInputs.value[i] = values[i].slice(0, 1);
            }
        }
    },
    {
        deep: true,
    }
);

const getTenant = (pin) => {
    loading.value = true;

    axios
        .get(
            route("api.coach-app.find-tenant-by-share-code", { shareCode: pin })
        )
        .then((response) => {
            let redirectRoute = route("students-app.app.home", {
                tenant: response.data.id,
            });

            window.location.href = redirectRoute;
        })
        .catch((error) => {
            loading.value = false;

            if (error?.response?.status === 404) {
                invalidPin.value = true;
                pinInputs.value = ["", "", "", "", ""];

                nextTick(() => {
                    nextTick(() => {
                        const firstInput =
                            document.getElementById("pin-input-0");

                        firstInput?.focus();
                    });
                });

                return;
            }

            console.log(error);
        });
};

onMounted(() => {
    // check if url has shouldRedirect
    const urlParams = new URLSearchParams(window.location.search);

    const shouldRedirect = urlParams.get("shouldRedirect");

    if (shouldRedirect === null || shouldRedirect === undefined) {
        let coach_app_id = localStorage.getItem("coach_app_id");

        if (
            coach_app_id !== null &&
            coach_app_id !== undefined &&
            coach_app_id !== ""
        ) {
            window.location.href = route("students-app.app.home", {
                tenant: coach_app_id,
            });

            return;
        }
    } else if (shouldRedirect === 0) {
        localStorage.removeItem("coach_app_id");
    }

    hiddenPage.value = false;
});
</script>

<template>
    <div
        class="bg-gray-200 dark:bg-gray-900 flex items-center justify-center content-center h-full min-h-screen w-full px-2"
        v-if="!hiddenPage"
    >
        <ThemeToggler />
        <section class="lg:px-4 py-20">
            <div
                class="mx-auto container flex justify-center items-center flex-col"
            >
                <div class="mb-4 flex justify-center">
                    <h1
                        class="lg:px-56 md:px-40 leading-10 lg:text-8xl md:text-7xl text-4xl font-extrabold text-center text-gray-800 dark:text-white"
                    >
                        SEJA BEM-VINDO AO APP DO TREINADOR.
                    </h1>
                </div>
                <div
                    class="w-full flex flex-col text-center justify-center items-center"
                >
                    <p
                        class="text-xl mt-2 leading-6 text-center text-gray-600 dark:text-gray-300 w-4/6"
                    >
                        Para começar, insira o código que você recebeu em seu
                        e-mail.
                    </p>
                    <div class="mt-10 flex space-x-3" data-hs-pin-input>
                        <input
                            data-hs-pin-input-item
                            id="pin-input-0"
                            v-model="pinInputs[0]"
                            autocomplete="off"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            :disabled="loading"
                            class="block bg-gray-100 w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                            autofocus
                        />
                        <input
                            data-hs-pin-input-item
                            id="pin-input-1"
                            v-model="pinInputs[1]"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            autocomplete="off"
                            :disabled="loading"
                            class="block bg-gray-100 w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
                            data-hs-pin-input-item
                            id="pin-input-2"
                            v-model="pinInputs[2]"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            autocomplete="off"
                            :disabled="loading"
                            class="block bg-gray-100 w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
                            data-hs-pin-input-item
                            id="pin-input-3"
                            v-model="pinInputs[3]"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            autocomplete="off"
                            :disabled="loading"
                            class="block bg-gray-100 w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
                            data-hs-pin-input-item
                            id="pin-input-4"
                            v-model="pinInputs[4]"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            autocomplete="off"
                            class="block bg-gray-100 w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                    </div>

                    <p v-if="invalidPin" class="text-red-500 text-sm mt-2">
                        Parece que o código que você inseriu é inválido.
                        <br />
                        Por favor, tente novamente.
                    </p>

                    <p class="mt-2 dark:text-gray-300">
                        Não recebeu nenhum código?
                        <a class="text-blue-600 font-bold" href="#"
                            >Clique aqui.</a
                        >
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
