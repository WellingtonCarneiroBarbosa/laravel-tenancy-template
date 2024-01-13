<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormSection from "@/Components/FormSection.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import {
    Pencil,
    Check,
    Plus,
    X,
    MoveLeft,
    MoveRight,
    Minus,
} from "lucide-vue-next";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/StudentsApp/Components/TextAreaInput.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["save"]);

const currentStepIndex = ref(0);

const addQuestion = () => {
    props.form.questions[currentStepIndex.value].questions.push({
        type: "",
        question: `Pergunta ${
            props.form.questions[currentStepIndex.value].questions.length + 1
        }`,
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
    props.form.questions[currentStepIndex.value].questions.splice(index, 1);
};

const removeOption = (question, index) => {
    question.options.splice(index, 1);
};

const addStep = () => {
    props.form.steps.push({
        step: props.form.steps.length + 1,
        title: `Passo ${props.form.steps.length + 1}`,
        description: "",
    });

    props.form.questions.push({
        step: props.form.steps.length,
        questions: [
            {
                type: "",
                question: `Pergunta 1`,
                showEditInputLabel: false,
                options: [
                    {
                        label: "Opção 1",
                        showEditInputLabel: false,
                    },
                ],
            },
        ],
    });

    currentStepIndex.value = props.form.steps.length - 1;
};

const removeStep = (index) => {
    props.form.steps.splice(index, 1);
    props.form.questions.splice(index, 1);

    if (currentStepIndex.value === props.form.steps.length) {
        currentStepIndex.value--;
    }
};

const passes = () => {
    let hasError = false;

    props.form.questions.forEach((step) => {
        step.questions.forEach((question) => {
            if (question.type === "") {
                hasError = true;
            }

            if (
                (question.type === "select" ||
                    question.type === "checkbox" ||
                    question.type === "radio") &&
                question.options.length < 2
            ) {
                hasError = true;
            }
        });
    });

    return hasError === false;
};

const save = () => {
    if (!passes()) {
        alert(
            "Você precisa preencher todos os campos antes de salvar o formulário. Verifique se todas as perguntas possuem um tipo e se as perguntas do tipo select, checkbox ou radio possuem pelo menos 2 opções."
        );

        return;
    }

    confirm("Tem certeza que deseja salvar?") && emit("save");
};
</script>

<template>
    <FormSection
        :form-classes="{
            'px-4 py-5 sm:p-6 shadow': true,
            'bg-gray-400 dark:bg-gray-800': currentStepIndex % 2 === 0,
            'bg-gray-200 dark:bg-gray-700': currentStepIndex % 2 !== 0,
        }"
    >
        <template #title> Passo {{ currentStepIndex + 1 }} </template>

        <template #description>
            <p class="text-gray-600 dark:text-gray-400">
                Insira as perguntas que serão feitas no formulário de OnBoarding
                no passo {{ currentStepIndex + 1 }}.

                <br />
                <br />

                Recomendamos uma média de 5 perguntas por passo, não mais que
                isso, para que o aluno não se sinta sobrecarregado.
            </p>
        </template>

        <template #form>
            <div class="col-span-12">
                <InputLabel
                    :class="{
                        'block font-medium text-sm': true,
                        'text-white dark:text-gray-400':
                            currentStepIndex % 2 === 0,
                        'text-gray-700 dark:text-gray-300':
                            currentStepIndex % 2 !== 0,
                    }"
                    :for="`step_${currentStepIndex}_title`"
                    value="Título do Passo:"
                />

                <TextInput
                    :id="`step_${currentStepIndex}_title`"
                    class="mt-1 w-full"
                    v-model="form.steps[currentStepIndex].title"
                    required
                />
            </div>

            <div class="col-span-12 mt-2">
                <InputLabel
                    :class="{
                        'block font-medium text-sm': true,
                        'text-white dark:text-gray-400':
                            currentStepIndex % 2 === 0,
                        'text-gray-700 dark:text-gray-300':
                            currentStepIndex % 2 !== 0,
                    }"
                    :for="`step_${currentStepIndex}_description`"
                    value="Descrição do Passo:"
                />

                <TextAreaInput
                    :id="`step_${currentStepIndex}_description`"
                    class="mt-1 w-full"
                    v-model="form.steps[currentStepIndex].description"
                />

                <hr
                    class="w-full my-3 mt-10"
                    :class="{
                        'border-gray-300 dark:border-gray-700':
                            currentStepIndex % 2 === 0,
                        'border-gray-700 dark:border-gray-300':
                            currentStepIndex % 2 !== 0,
                    }"
                />
            </div>

            <div
                class="col-span-12"
                v-for="(question, key) in form.questions[currentStepIndex]
                    .questions"
            >
                <div class="flex gap-x-2">
                    <InputLabel
                        :class="{
                            'block font-medium text-sm': true,
                            'text-white dark:text-gray-400':
                                currentStepIndex % 2 === 0,
                            'text-gray-700 dark:text-gray-300':
                                currentStepIndex % 2 !== 0,
                        }"
                        :for="`step_${currentStepIndex}_question_${key}`"
                        v-if="!question.showEditInputLabel"
                        :value="question.question"
                    />
                    <input
                        type="text"
                        class="w-full rounded-md h-5 p-4"
                        v-model="question.question"
                        v-if="question.showEditInputLabel"
                        @keypress.enter="question.showEditInputLabel = false"
                    />

                    <button
                        @click="question.showEditInputLabel = true"
                        v-if="!question.showEditInputLabel"
                    >
                        <Pencil
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                    </button>

                    <div class="flex-grow" />

                    <button @click="removeQuestion(key)" v-if="key !== 0">
                        <X
                            class="w-4 h-4 text-gray-800 dark:text-gray-500 mr-1"
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
                            :class="{
                                'block font-medium text-sm': true,
                                'text-white dark:text-gray-400':
                                    currentStepIndex % 2 === 0,
                                'text-gray-700 dark:text-gray-300':
                                    currentStepIndex % 2 !== 0,
                            }"
                            for="question"
                            v-if="!option.showEditInputLabel"
                            :value="option.label"
                        />
                        <input
                            type="text"
                            class="w-full rounded-md h-5 p-4"
                            v-model="option.label"
                            v-if="option.showEditInputLabel"
                            @keypress.enter="option.showEditInputLabel = false"
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
                        v-if="
                            key ===
                            form.questions[currentStepIndex].questions.length -
                                1
                        "
                    >
                        <Plus
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                        Adicionar Pergunta
                    </button>
                </div>

                <hr
                    class="mt-5"
                    :class="{
                        'border-gray-300 dark:border-gray-700':
                            currentStepIndex % 2 === 0,
                        'border-gray-700 dark:border-gray-300':
                            currentStepIndex % 2 !== 0,
                    }"
                    v-if="
                        key !==
                        form.questions[currentStepIndex].questions.length - 1
                    "
                />
            </div>
        </template>

        <template #actions>
            <div class="flex flex-col">
                <div>
                    <button
                        type="button"
                        @click="currentStepIndex--"
                        :disabled="currentStepIndex === 0"
                        v-if="currentStepIndex !== 0"
                    >
                        <MoveLeft
                            class="w-6 h-6 text-gray-800 dark:text-gray-500 mr-3"
                        />
                    </button>

                    <button
                        type="button"
                        @click="currentStepIndex++"
                        :disabled="currentStepIndex === form.steps.length - 1"
                        v-if="
                            currentStepIndex !== form.steps.length - 1 &&
                            form.steps.length > 1
                        "
                    >
                        <MoveRight
                            class="w-6 h-6 text-gray-800 dark:text-gray-500"
                        />
                    </button>
                </div>

                <div class="mt-2">
                    <button
                        class="rounded-md text-gray-800 dark:text-gray-500 text-sm mr-3"
                        type="button"
                        @click="removeStep(currentStepIndex)"
                        v-if="form.steps.length > 1"
                    >
                        <div class="flex items-center justify-center">
                            <Minus class="w-4 h-4" />
                            Remover Etapa
                        </div>
                    </button>

                    <button
                        class="rounded-md text-gray-800 dark:text-gray-500 text-sm mr-2"
                        type="button"
                        @click="addStep"
                    >
                        <div class="flex items-center justify-center">
                            <Plus class="w-4 h-4" />
                            Adicionar Etapa
                        </div>
                    </button>
                    <button
                        class="mt-2 bg-blue-700 p-2 rounded-md text-white text-sm ml-2"
                        type="button"
                        @click="save"
                    >
                        Finalizar e Salvar
                    </button>
                </div>
            </div>
        </template>
    </FormSection>
</template>
