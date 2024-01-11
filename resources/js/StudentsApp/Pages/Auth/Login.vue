<script setup>
import { nextTick, watch, ref, reactive } from "vue";
import TextInput from "@/StudentsApp/Components/TextInput.vue";
import PrimaryButton from "@/StudentsApp/Components/PrimaryButton.vue";
import ThemeToggler from "@/StudentsApp/Components/ThemeToggler.vue";
import { User, Lock, ArrowRight } from "lucide-vue-next";
import { useForm, usePage } from "@inertiajs/vue3";

const form = useForm({
    cpf: "",
    password: "",
});

const validCpf = ref(false);
const validPassword = ref(false);

const cpfMask = reactive({
    mask: "###.###.###-##",
    tokens: {
        "#": {
            pattern: /[0-9]/,
            fallback: "0",
        },
    },
});

watch(
    () => form.cpf,
    (value) => {
        if (value?.length === 14) {
            validCpf.value = true;

            nextTick(() => {
                document.getElementById("password").focus();
            });
        } else {
            validCpf.value = false;
        }
    },
    {
        immediate: true,
    }
);

const authenticate = () => {
    form.post(
        route("students-app.initialized-app.auth.login", {
            tenant: localStorage.getItem("coach_app_id"),
        })
    );
};
</script>

<template>
    <div
        class="transition-colors ease-in duration-500 bg-gray-200 dark:bg-gray-900 flex flex-col items-center justify-center content-center text-center h-full min-h-screen w-full px-4"
    >
        <ThemeToggler />
        <h1
            class="text-xl mt-2 leading-6 text-center text-gray-600 dark:text-gray-300 font-bold w-4/6"
        >
            Agora, insira seu CPF e sua senha.
        </h1>

        <div
            class="mt-2 flex-col items-center justify-center text-center w-[80%] md:w-[40%] h-full bg-gray-300 dark:bg-gray-700 rounded-md p-4"
        >
            <div class="relative w-full">
                <TextInput
                    type="text"
                    placeholder="Digite seu CPF"
                    v-model="form.cpf"
                    :loading="form.processing"
                    :valid="validCpf && !form.hasErrors"
                    :invalid="form.errors.cpf !== undefined"
                    :message="form.errors.cpf"
                    :mask="cpfMask"
                    :icon="User"
                />
            </div>

            <div class="relative w-full mt-2">
                <TextInput
                    id="password"
                    :loading="form.processing"
                    :invalid="form.errors.password !== undefined"
                    :valid="validPassword && !form.hasErrors"
                    v-model="form.password"
                    :message="form.errors.password"
                    :icon="Lock"
                    v-on:keydown="validPassword = false"
                    v-on:focusout="
                        form.password.length > 7
                            ? (validPassword = true)
                            : (validPassword = false)
                    "
                    @keydown.enter="authenticate"
                    type="password"
                    placeholder="Digite sua senha"
                />
            </div>

            <div class="w-full mt-3">
                <PrimaryButton
                    @click="authenticate"
                    :loading="form.processing"
                    class="rounded-full px-4 float-end"
                >
                    COMEÇAR
                    <ArrowRight v-if="!form.processing" class="ml-2 w-5 h-5" />
                </PrimaryButton>
            </div>
        </div>

        <p class="mt-1 dark:text-gray-300">
            Se esse é seu primeiro acesso, insira a senha que recebeu em seu
            e-mail.
        </p>
    </div>
</template>
