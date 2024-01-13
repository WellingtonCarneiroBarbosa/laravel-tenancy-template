<script setup>
import { computed, ref, onMounted, watch } from "vue";
import AppLayout from "@/StudentsApp/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/StudentsApp/Components/TextInput.vue";
import TextAreaInput from "@/StudentsApp/Components/TextAreaInput.vue";
import SelectInput from "@/StudentsApp/Components/SelectInput.vue";
import RadioInput from "@/StudentsApp/Components/RadioInput.vue";
import CheckboxInput from "@/StudentsApp/Components/CheckboxInput.vue";
import FormSection from "@/StudentsApp/Components/FormSection.vue";
import PrimaryButton from "@/StudentsApp/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import collect from "collect.js";

const props = defineProps({
    onBoardingForm: {
        type: Object,
        required: true,
    },
});

const responses = ref([]);

watch(
    () => responses.value,
    (responses) => {
        console.log(responses);
    },
    { deep: true }
);

const currentStep = ref(null);

const currentQuestions = ref([]);

const steps = computed(() => {
    return collect(props.onBoardingForm.steps);
});

const questions = computed(() => {
    return collect(props.onBoardingForm.questions);
});

const setCurrentQuestions = (currentStepIndex, isPrevious = false) => {
    currentQuestions.value = questions.value
        .where("step", currentStepIndex)
        .sortBy("questions.order")
        .all()[0];

    if (isPrevious) {
        return;
    }

    currentQuestions.value.questions = collect(currentQuestions.value.questions)
        .map((question) => {
            if (
                question.type === "select" ||
                question.type === "radio" ||
                question.type === "checkbox"
            ) {
                let labels = question.input_options_labels;
                let values = question.input_options_values;

                question.options = [];

                for (let i = 0; i < labels.length; i++) {
                    question.options.push({
                        label: labels[i],
                        value: values[i],
                    });
                }
            }

            return question;
        })
        .all();

    responses.value.push({
        step: currentQuestions.value.step,
        questions: [],
    });

    currentQuestions.value.questions.forEach((question, index) => {
        let base = {
            input_id: `step_${currentQuestions.value.step}_question_${index}_input`,
            type: question.type,
            input_value: "",
        };

        if (question.type === "checkbox") {
            base.input_value = [];
        }

        responses.value[currentStepIndex - 1].questions.push(base);
    });
};

const goToNextStep = () => {
    if (currentStep.value.order === steps.value.last().order) {
        return;
    }

    let allQuestionsAnswered = true;

    responses.value[currentStep.value.order - 1].questions.forEach(
        (question) => {
            if (
                question.input_value === "" ||
                question.input_value?.length === 0
            ) {
                allQuestionsAnswered = false;
            }
        }
    );

    if (!allQuestionsAnswered) {
        alert("Por favor, responda todas as perguntas antes de continuar.");
        return;
    }

    currentStep.value = steps.value
        .where("order", currentStep.value.order + 1)
        .all()[0];

    if (
        responses.value.filter(
            (response) => response.step === currentStep.value.order
        ).length === 0
    ) {
        setCurrentQuestions(currentStep.value.order);
    } else {
        setCurrentQuestions(currentStep.value.order, true);
    }
};

const goToPreviousStep = () => {
    if (currentStep.value.order === steps.value.first().order) {
        return;
    }

    currentStep.value = steps.value
        .where("order", currentStep.value.order - 1)
        .all()[0];

    setCurrentQuestions(currentStep.value.order, true);
};

const save = () => {
    let passed = true;

    responses.value.forEach((response) => {
        response.questions.forEach((question) => {
            if (
                question.input_value === "" ||
                question.input_value?.length === 0
            ) {
                alert(
                    "Por favor, responda todas as perguntas antes de continuar."
                );
                passed = false;
                return;
            }
        });
    });

    if (!passed) {
        return;
    }

    alert("Salvo com sucesso!");
};

onMounted(() => {
    currentStep.value = steps.value.first();
    setCurrentQuestions(1);
});
</script>

<template>
    <AppLayout>
        <div
            class="flex flex-col items-start text-left w-full"
            v-if="currentStep !== null"
        >
            <FormSection class="w-full">
                <template #title>{{ currentStep.title }}</template>

                <template #description>{{ currentStep.description }}</template>

                <template #form v-if="currentQuestions.questions.length > 0">
                    <div
                        class="col-span-12"
                        v-for="(question, index) in currentQuestions.questions"
                        :key="`step_${currentQuestions.step}_question_${index}`"
                    >
                        <InputLabel
                            :for="`step_${currentQuestions.step}_question_${index}_input`"
                            :value="question.title"
                            class="pl-1"
                        />

                        <template v-if="question.type === 'text'">
                            <TextInput
                                class="w-full mt-1"
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                                placeholder="Digite aqui"
                                required
                            />
                        </template>

                        <template v-if="question.type === 'select'">
                            <SelectInput
                                class="w-full py-0 mt-1"
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                                :options="question.options"
                                required
                            />
                        </template>

                        <template v-if="question.type === 'textarea'">
                            <TextAreaInput
                                class="w-full mt-1"
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                                placeholder="Digite aqui"
                                required
                            />
                        </template>

                        <template v-if="question.type === 'checkbox'">
                            <CheckboxInput
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                :options="question.options"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                            />
                        </template>

                        <template v-if="question.type === 'radio'">
                            <RadioInput
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                :options="question.options"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                            />
                        </template>

                        <template v-if="question.description">
                            <p
                                class="pl-1 text-xs text-gray-500 dark:text-gray-200 mt-2"
                            >
                                {{ question.description }}
                            </p>
                        </template>

                        <div
                            v-if="
                                index !== currentQuestions.questions.length - 1
                            "
                            class="mt-5 -mb-1 border-t w-full h-full border-gray-400 dark:border-gray-600"
                        ></div>
                    </div>
                </template>

                <template #actions>
                    <div class="flex items-center justify-end">
                        <SecondaryButton
                            class="mt-5"
                            @click="goToPreviousStep"
                            v-if="
                                currentStep.order !== steps.toArray()[0]?.order
                            "
                            type="button"
                        >
                            Voltar
                        </SecondaryButton>

                        <PrimaryButton
                            class="mt-5 ml-2"
                            @click="goToNextStep"
                            v-if="
                                currentStep.order !==
                                steps.toArray()[steps.toArray().length - 1]
                                    ?.order
                            "
                            type="button"
                        >
                            Próximo
                        </PrimaryButton>

                        <PrimaryButton
                            class="mt-5 ml-2"
                            @click="save"
                            v-if="
                                currentStep.order ===
                                steps.toArray()[steps.toArray().length - 1]
                                    ?.order
                            "
                        >
                            Salvar
                        </PrimaryButton>
                    </div>

                    <div class="text-right mt-1 pb-3 pr-1">
                        Passo {{ currentStep.order }} de
                        {{ steps.toArray().length }}
                    </div>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
