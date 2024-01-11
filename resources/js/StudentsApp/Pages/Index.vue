<script setup>
import { nextTick, ref, watch } from "vue";
import axios from "axios";

const props = defineProps(["someProp"]);
const pinInputs = ref(["", "", "", "", ""]);

const invalidPin = ref(false);

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
            let redirectRoute = route("students-app.initialized-app.index", {
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

const handleKeyPress = (event) => {
    const isAllowedKey =
        (event.key >= "0" && event.key <= "9") ||
        (event.key >= "A" && event.key <= "Z") ||
        (event.key >= "a" && event.key <= "z");

    if (!isAllowedKey) {
        return;
    }

    const focusedInput = document.activeElement;

    if (focusedInput) {
        let id = focusedInput.id;

        let index = parseInt(id.split("-")[2]);

        const value = pinInputs.value;

        if (
            event.key === "v" ||
            event.key === "V" ||
            event.metaKey ||
            event.ctrlKey
        ) {
            if (
                (event.metaKey || event.ctrlKey) &&
                (event.key === "v" || event.key === "V")
            ) {
                return;
            }

            if (event.key !== "v" && event.key !== "V") {
                return;
            }
        }

        event.preventDefault();

        if (event.key === "Backspace" || event.key === "Delete") {
            pinInputs.value[index] = "";
            focusOnPreviousInput();
            return;
        }

        if (event.key === "ArrowLeft") {
            focusOnPreviousInput();
            return;
        }

        if (event.key === "ArrowRight") {
            const nextInput = document.getElementById(
                `pin-input-${parseInt(id.split("-")[2]) + 1}`
            );

            if (nextInput) {
                nextInput.focus();
            }

            return;
        }

        pinInputs.value[index] = event.key.toUpperCase();

        if (index === 4) {
            return;
        }

        if (value[index]?.length > 1) {
            pinInputs.value[index] = value[index].slice(0, 1);
        }

        focusOnNextInput();
    }
};

const focusOnNextInput = () => {
    const focusedInput = document.activeElement;

    if (focusedInput) {
        let id = focusedInput.id;

        const nextInput = document.getElementById(
            `pin-input-${parseInt(id.split("-")[2]) + 1}`
        );

        if (nextInput) {
            nextInput.focus();
        }
    }
};

const focusOnPreviousInput = () => {
    nextTick(() => {
        const focusedInput = document.activeElement;

        if (focusedInput) {
            let id = focusedInput.id;

            const previousInput = document.getElementById(
                `pin-input-${parseInt(id.split("-")[2]) - 1}`
            );

            if (previousInput) {
                previousInput.focus();
            }
        }
    });
};

const pasteValue = (event) => {
    event.preventDefault();

    const pastedData = event?.clipboardData || window?.clipboardData;

    if (pastedData) {
        const pastedText = pastedData.getData("text");

        if (pastedText.length > 5) {
            return;
        }

        for (let i = 0; i < pastedText.length; i++) {
            pinInputs.value[i] = pastedText[i];
        }

        const focusedInput = document.activeElement;

        focusedInput?.blur();
    }
};
</script>

<template>
    <div
        class="dark:bg-gray-900 flex items-center justify-center content-center h-screen w-full px-2"
    >
        <section class="lg:px-4 py-20">
            <div
                class="mx-auto container flex justify-center items-center flex-col"
            >
                <div class="mb-4 flex justify-center">
                    <h1
                        class="lg:px-56 md:px-40 leading-10 lg:text-8xl md:text-7xl text-4xl font-black text-center text-gray-800 dark:text-white"
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
                    <div class="mt-10 flex space-x-3">
                        <input
                            id="pin-input-0"
                            v-model="pinInputs[0]"
                            v-on:keydown="handleKeyPress($event)"
                            v-on:paste="pasteValue($event)"
                            autocomplete="off"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            :disabled="loading"
                            class="block w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                            autofocus
                        />
                        <input
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
                            v-on:keydown="handleKeyPress($event)"
                            class="block w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
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
                            v-on:keydown="handleKeyPress($event)"
                            class="block w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
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
                            v-on:keydown="handleKeyPress($event)"
                            class="block w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                        <input
                            id="pin-input-4"
                            v-model="pinInputs[4]"
                            v-on:keydown="handleKeyPress($event)"
                            :class="{
                                'border-red-400 dark:border-red-500':
                                    invalidPin,
                                'border-gray-200 dark:border-gray-700':
                                    !invalidPin,
                            }"
                            type="text"
                            autocomplete="off"
                            class="block w-[38px] text-center rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600"
                        />
                    </div>

                    <p v-if="invalidPin" class="text-red-500 text-sm mt-2">
                        Parece que o código que você inseriu é inválido.
                        <br />
                        Por favor, tente novamente.
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
