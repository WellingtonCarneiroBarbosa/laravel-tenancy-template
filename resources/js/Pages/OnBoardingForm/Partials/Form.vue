<script setup>
import { computed, ref } from "vue";
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
import TextAreaInput from "@/Components/TextAreaInput.vue";
import Swal from "sweetalert2";

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["save"]);

const formClasses = computed(() => {
    let classes = "px-4 py-5 sm:p-6 shadow";

    if (currentStepIndex.value % 2 === 0) {
        classes +=
            " bg-gray-200 dark:bg-gray-900 dark:text-gray-100 text-gray-800";
    } else {
        classes +=
            " bg-gray-300 dark:bg-gray-800 dark:text-gray-400 text-gray-700";
    }

    return classes;
});

const labelClasses = computed(() => {
    let classes = "block font-medium text-sm";

    if (currentStepIndex % 2 === 0) {
        classes += "text-white dark:text-gray-400";
    } else {
        classes += "text-gray-700 dark:text-gray-300";
    }

    return classes;
});

const currentStepIndex = ref(0);

const addQuestion = () => {
    props.form.questions[currentStepIndex.value].questions.push({
        type: "",
        title: `Pergunta ${
            props.form.questions[currentStepIndex.value].questions.length + 1
        }`,
        description: "",
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
        order: props.form.steps.length + 1,
        title: `Passo ${props.form.steps.length + 1}`,
        description: "",
    });

    props.form.questions.push({
        step: props.form.steps.length,
        questions: [
            {
                type: "",
                title: `Pergunta 1`,
                description: "",
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
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Você precisa preencher todos os campos antes de salvar o formulário. Verifique se todas as perguntas possuem um tipo e se as perguntas do tipo select, checkbox ou radio possuem pelo menos 2 opções.",
        });

        return;
    }

    Swal.fire({
        title: "Deseja prosseguir?",
        text: "Tem certeza que deseja salvar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, salvar!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            emit("save");
        }
    });
};
</script>

<template>
    <FormSection :form-classes="formClasses">
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
                    :class="labelClasses"
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
                    :class="labelClasses"
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
                        :class="labelClasses"
                        :for="`step_${currentStepIndex}_question_${key}`"
                        v-if="!question.showEditInputLabel"
                        :value="question.title"
                    />
                    <input
                        type="text"
                        class="w-full rounded-md h-5 p-4"
                        v-model="question.title"
                        v-if="question.showEditInputLabel"
                        @keypress.enter="question.showEditInputLabel = false"
                    />

                    <button
                        type="button"
                        @click="removeQuestion(key)"
                        v-if="key !== 0"
                    >
                        <X class="w-4 h-4 text-gray-800 dark:text-gray-500" />
                    </button>

                    <button
                        type="button"
                        @click="question.showEditInputLabel = true"
                        v-if="!question.showEditInputLabel"
                    >
                        <Pencil
                            class="w-4 h-4 text-gray-800 dark:text-gray-500"
                        />
                    </button>

                    <button
                        type="button"
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
                    <div class="flex flex-wrap justify-start gap-x-4 w-full">
                        <div
                            class="flex flex-row items-center justify-center gap-x-1 mt-2"
                            v-for="(option, key) in question.options"
                        >
                            <InputLabel
                                :class="labelClasses"
                                for="question"
                                v-if="!option.showEditInputLabel"
                                :value="option.label"
                            />
                            <input
                                type="text"
                                class="w-full rounded-md h-5 p-4"
                                v-model="option.label"
                                v-if="option.showEditInputLabel"
                                @keypress.enter="
                                    option.showEditInputLabel = false
                                "
                            />

                            <button
                                type="button"
                                @click="removeOption(question, key)"
                            >
                                <X
                                    class="w-4 h-4 text-gray-800 dark:text-gray-500"
                                    v-if="key !== 0"
                                />
                            </button>

                            <button
                                type="button"
                                @click="option.showEditInputLabel = true"
                                v-if="!option.showEditInputLabel"
                            >
                                <Pencil
                                    class="w-4 h-4 text-gray-800 dark:text-gray-500"
                                />
                            </button>

                            <button
                                type="button"
                                @click="option.showEditInputLabel = false"
                                v-if="option.showEditInputLabel"
                            >
                                <Check
                                    class="w-4 h-4 text-gray-800 dark:text-gray-500"
                                />
                            </button>

                            <button
                                type="button"
                                @click="addOption(question)"
                                v-if="key === question.options.length - 1"
                                class="flex flex-row items-center justify-center ml-2 font-medium"
                            >
                                <Plus
                                    class="w-5 h-5 text-gray-800 dark:text-gray-500"
                                />
                                adicionar opção
                            </button>
                        </div>
                    </div>
                </template>

                <InputLabel
                    :class="labelClasses + ' mt-2'"
                    :for="`step_${currentStepIndex}_question_${key}_description`"
                    value="Descrição da Pergunta:"
                />

                <TextAreaInput
                    :id="`step_${currentStepIndex}_question_${key}_description`"
                    class="mt-1 w-full"
                    v-model="question.description"
                />

                <div class="flex w-full justify-end mt-2">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-primary p-2 rounded-md text-sm flex items-center justify-center"
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
                        type="button"
                        class="rounded-md text-gray-800 dark:text-gray-500 text-sm mr-3"
                        @click="removeStep(currentStepIndex)"
                        v-if="form.steps.length > 1"
                    >
                        <div class="flex items-center justify-center">
                            <Minus class="w-4 h-4" />
                            Remover Etapa
                        </div>
                    </button>

                    <button
                        type="button"
                        class="rounded-md text-gray-800 dark:text-gray-500 text-sm mr-2"
                        @click="addStep"
                    >
                        <div class="flex items-center justify-center">
                            <Plus class="w-4 h-4" />
                            Adicionar Etapa
                        </div>
                    </button>
                    <button
                        type="button"
                        class="mt-2 bg-blue-700 p-2 rounded-md text-white text-sm ml-2"
                        @click="save"
                    >
                        Finalizar e Salvar
                    </button>
                </div>
            </div>
        </template>
    </FormSection>
</template>
