<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Pencil, Check, Plus, X } from "lucide-vue-next";

const form = useForm({
    steps: [
        {
            step: 1,
            title: "",
            description: "",
        },
    ],
    questions: [
        {
            step: 1,
            questions: [
                {
                    type: "",
                    question: "Pergunta 1",
                    showEditInputLabel: false,
                    options: [
                        {
                            label: "Opção 1",
                            showEditInputLabel: false,
                        },
                    ],
                },
            ],
        },
    ],
});

const currentStepIndex = ref(0);

const addQuestion = () => {
    form.questions[0].questions.push({
        type: "",
        question: `Pergunta ${form.questions[0].questions.length + 1}`,
        showEditInputLabel: false,
        options: [
            {
                label: "Opção 1",
                showEditInputLabel: false,
            },
        ],
    });
};

const addOption = (question) => {
    question.options.push({
        label: `Opção ${question.options.length + 1}`,
        showEditInputLabel: false,
    });
};

const removeQuestion = (index) => {
    form.questions[0].questions.splice(index, 1);
};

const removeOption = (question, index) => {
    question.options.splice(index, 1);
};
</script>

<template>
    <FormSection>
        <template #title> Passo 1 </template>

        <template #description>
            <p class="text-gray-500 dark:text-gray-400">
                Insira as perguntas que serão feitas no formulário de OnBoarding
                no passo 1.

                <br />
                <br />

                Recomendamos uma média de 5 perguntas por passo, não mais que
                isso, para que o aluno não se sinta sobrecarregado.
            </p>
        </template>

        <template #form>
            <div
                class="col-span-12"
                v-for="(question, key) in form.questions[0].questions"
            >
                <div class="flex gap-x-2">
                    <InputLabel
                        :for="`step_${currentStepIndex}_question_${key}`"
                        v-if="!question.showEditInputLabel"
                        :value="question.question"
                    />
                    <input
                        type="text"
                        class="w-full rounded-md h-5 p-4"
                        v-model="question.question"
                        v-if="question.showEditInputLabel"
                    />

                    <button
                        @click="question.showEditInputLabel = true"
                        v-if="!question.showEditInputLabel"
                    >
                        <Pencil
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                    </button>

                    <button
                        @click="question.showEditInputLabel = false"
                        v-if="question.showEditInputLabel"
                    >
                        <Check
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                    </button>
                </div>

                <SelectInput
                    :id="`step_${currentStepIndex}_question_${key}`"
                    class="mt-1"
                    v-model="question.type"
                    :options="[
                        { value: 'text', label: 'Input de Texto' },
                        { value: 'textarea', label: 'Input de Texto Grande' },
                        { value: 'select', label: 'Input de Seleção (select)' },
                        {
                            value: 'checkbox',
                            label: 'Input de Multiplas Seleções (checkbox)',
                        },
                        { value: 'radio', label: 'Input de Seleção (radio)' },
                    ]"
                />

                <template
                    v-if="
                        question.type === 'select' ||
                        question.type === 'checkbox' ||
                        question.type === 'radio'
                    "
                >
                    <div
                        class="flex flex-row gap-x-2 w-full mt-2"
                        v-for="(option, key) in question.options"
                    >
                        <InputLabel
                            for="question"
                            v-if="!option.showEditInputLabel"
                            :value="option.label"
                        />
                        <input
                            type="text"
                            class="w-full rounded-md h-5 p-4"
                            v-model="option.label"
                            v-if="option.showEditInputLabel"
                        />

                        <button
                            @click="option.showEditInputLabel = true"
                            v-if="!option.showEditInputLabel"
                        >
                            <Pencil
                                class="w-4 h-4 text-gray-800 dark:text-gray-500"
                            />
                        </button>

                        <button @click="removeOption(question, key)">
                            <X
                                class="w-4 h-4 text-gray-800 dark:text-gray-500"
                                v-if="key !== 0"
                            />
                        </button>

                        <button
                            @click="option.showEditInputLabel = false"
                            v-if="option.showEditInputLabel"
                        >
                            <Check
                                class="w-4 h-4 text-gray-800 dark:text-gray-500"
                            />
                        </button>

                        <div class="flex-grow" />

                        <button
                            @click="addOption(question)"
                            v-if="key === question.options.length - 1"
                        >
                            <Plus
                                class="w-5 h-5 text-gray-800 dark:text-gray-500"
                            />
                        </button>
                    </div>
                </template>

                <div class="flex w-full justify-end mt-2">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary bg-gray-200 p-2 rounded-md text-sm flex items-center justify-center"
                        @click="addQuestion"
                        v-if="key === form.questions[0].questions.length - 1"
                    >
                        <Plus
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                        Adicionar Pergunta
                    </button>
                </div>

                <hr
                    class="mt-5"
                    v-if="key !== form.questions[0].questions.length - 1"
                />
            </div>
        </template>

        <template #actions> </template>
    </FormSection>
</template>
