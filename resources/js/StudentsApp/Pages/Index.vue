<script setup>
import { nextTick, ref, watch } from "vue";
import axios from "axios";

const pinInputs = ref(["", "", "", "", ""]);

const invalidPin = ref(true);

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
            if (response.data) {
                console.log(data);
            }
        })
        .catch((error) => {
            if (error.response.status === 404) {
                invalidPin.value = true;
                pinInputs.value = ["", "", "", "", ""];

                nextTick(() => {
                    nextTick(() => {
                        const firstInput =
                            document.getElementById("pin-input-0");

                        firstInput?.focus();
                    });
                });
            }
        })
        .finally(() => {
            loading.value = false;
        });
};

const handleKeyPress = (event) => {
    event.preventDefault();

    const focusedInput = document.activeElement;

    if (focusedInput) {
        let id = focusedInput.id;

        let index = parseInt(id.split("-")[2]);

        const value = pinInputs.value;

        if (event.keyCode === 8 || event.keyCode === 46) {
            pinInputs.value[index] = "";
            focusOnPreviousInput();
            return;
        }

        if (event.keyCode === 37) {
            focusOnPreviousInput();
            return;
        }

        if (event.keyCode === 39) {
            const nextInput = document.getElementById(
                `pin-input-${parseInt(id.split("-")[2]) + 1}`
            );

            if (nextInput) {
                nextInput.focus();
            }

            return;
        }

        if (event.key.length === 1) {
            pinInputs.value[index] = event.key.toUpperCase();
        }

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

    const pastedData = event.clipboardData.getData("text");

    if (pastedData.length > 5) {
        return;
    }

    for (let i = 0; i < pastedData.length; i++) {
        pinInputs.value[i] = pastedData[i];
    }

    const focusedInput = document.activeElement;

    focusedInput?.blur();
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
