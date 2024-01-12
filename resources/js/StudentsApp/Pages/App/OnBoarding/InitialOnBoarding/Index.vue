<script setup>
import { computed, ref, onMounted } from "vue";
import AppLayout from "@/StudentsApp/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/StudentsApp/Components/TextInput.vue";
import TextAreaInput from "@/StudentsApp/Components/TextAreaInput.vue";
import SelectInput from "@/StudentsApp/Components/SelectInput.vue";
import RadioInput from "@/StudentsApp/Components/RadioInput.vue";
import CheckboxInput from "@/StudentsApp/Components/CheckboxInput.vue";
import FormSection from "@/StudentsApp/Components/FormSection.vue";
import collect from "collect.js";

const props = defineProps({
    onBoardingForm: {
        type: Object,
        required: true,
    },
});

const responses = ref([]);

const currentStep = ref(null);

const currentQuestions = ref([]);

const steps = computed(() => {
    return collect(props.onBoardingForm.steps);
});

const questions = computed(() => {
    return collect(props.onBoardingForm.questions);
});

const setCurrentQuestions = (currentStepIndex) => {
    currentQuestions.value = questions.value
        .where("step", currentStepIndex + 1)
        .sortBy("questions.order")
        .all()[0];

    currentQuestions.value.questions = collect(currentQuestions.value.questions)
        .map((question) => {
            if (
                question.input_type === "select" ||
                question.input_type === "radio" ||
                question.input_type === "checkbox"
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
        responses.value[currentStepIndex].questions.push(() => {
            let base = {
                input_id: `step_${currentQuestions.value.step}_question_${index}_input`,
                input_type: question.input_type,
                input_value: "",
            };

            if (question.input_type === "checkbox") {
                base.input_value = [];
            }

            return base;
        });
    });
};

onMounted(() => {
    currentStep.value = steps.value.first();
    setCurrentQuestions(0);
});
</script>

<template>
    <AppLayout>
        <div
            class="flex flex-col items-start text-left w-full my-10"
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

                        <template v-if="question.input_type === 'text'">
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

                        <template v-if="question.input_type === 'select'">
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

                        <template v-if="question.input_type === 'textarea'">
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

                        <template v-if="question.input_type === 'checkbox'">
                            <CheckboxInput
                                :id="`step_${currentQuestions.step}_question_${index}_input`"
                                :options="question.options"
                                v-model="
                                    responses[currentQuestions.step - 1]
                                        .questions[index].input_value
                                "
                            />
                        </template>

                        <template v-if="question.input_type === 'radio'">
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

                <template #actions> Ações </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
