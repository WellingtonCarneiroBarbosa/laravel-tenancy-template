<script setup>
import { reactive } from "vue";
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["submitted"]);

const cpfMask = reactive({
    mask: "###.###.###-##",
    tokens: {
        "#": {
            pattern: /[0-9]/,
            fallback: "0",
        },
    },
});
</script>

<template>
    <FormSection>
        <template #title> Dados Pessoais </template>

        <template #description>
            <p class="text-gray-600 dark:text-gray-400">
                Insira as informações do aluno para cadastrá-lo.
                <br />
                As informações obrigatórias estão marcadas com um *.
            </p>
        </template>

        <template #form>
            <div class="col-span-12 md:col-span-6">
                <InputLabel for="student_name_form" value="Nome Completo*" />

                <TextInput
                    id="student_name_form"
                    class="mt-1 w-full"
                    v-model="form.name"
                    :invalid="form.errors.name"
                    :disabled="form.processing"
                    required
                />

                <InputError :message="form.errors.name" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel for="student_email_form" value="E-mail*" />

                <TextInput
                    id="student_email_form"
                    class="mt-1 w-full"
                    v-model="form.email"
                    :invalid="form.errors.email"
                    :disabled="form.processing"
                    type="email"
                    required
                />

                <InputError :message="form.errors.email" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel for="student_cpf_form" value="CPF" />

                <TextInput
                    id="student_cpf_form"
                    class="mt-1 w-full"
                    v-model="form.cpf"
                    :invalid="form.errors.cpf"
                    :disabled="form.processing"
                    :mask="cpfMask"
                />

                <InputError :message="form.errors.cpf" />
            </div>

            <div class="col-span-12 md:col-span-6">
                <InputLabel
                    for="student_access_expires_at_form"
                    value="Data de Expiração de Acesso*"
                />

                <SelectInput
                    id="student_access_expires_at_form"
                    class="mt-1 w-full"
                    v-model="form.access_expires_at"
                    :invalid="form.errors.access_expires_at"
                    :disabled="form.processing"
                    :options="[
                        {
                            label: '7 dias',
                            value: '7',
                        },
                        {
                            label: '15 dias',
                            value: '15',
                        },
                        {
                            label: '1 mês',
                            value: '30',
                        },
                        {
                            label: '2 meses',
                            value: '60',
                        },
                        {
                            label: '3 meses',
                            value: '90',
                        },
                        {
                            label: '6 meses',
                            value: '180',
                        },
                        {
                            label: '1 ano',
                            value: '360',
                        },
                        {
                            label: '2 anos',
                            value: '720',
                        },
                        {
                            label: 'Não expira',
                            value: '0',
                        },
                    ]"
                    required
                />

                <InputError :message="form.errors.access_expires_at" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton
                type="submit"
                class="mt-4"
                :disabled="form.processing"
                @click="emit('submitted')"
            >
                Adicionar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
