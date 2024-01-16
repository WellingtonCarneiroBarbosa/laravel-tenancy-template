<script setup>
import Modal from "@/Components/Modal.vue";
import HeaderTitle from "@/Components/HeaderTitle.vue";
import dateFormatter from "@/Helpers/dateFormatter";
import { computed, onMounted } from "vue";
import collect from "collect.js";

const props = defineProps({
    student: {
        type: Object,
        required: true,
    },
    notes: {
        type: Object,
        required: true,
    },
    show: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(["close"]);

const dates = computed(() => {
    return props.notes.data.map((note) => {
        return {
            original: note.date,
            formatted: dateFormatter(note.date, "medium"),
        };
    });
});

const computedNotes = computed(() => {
    let myNotes = collect(props.notes.data);

    myNotes = myNotes.groupBy("date");

    return myNotes.all();
});

const handleClose = () => {
    emit("close");
    show.value = false;
};
</script>

<template>
    <Modal :show="show" :closeable="true" @close="handleClose">
        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <HeaderTitle>Prontuário de {{ student.name }}</HeaderTitle>

            <!-- Timeline -->
            <div class="mt-5" v-if="dates.length >= 1">
                <template v-for="notesByDate in computedNotes">
                    <template v-for="(note, noteKey) in notesByDate">
                        <div class="p2 my-2 first:mt-0" v-if="noteKey === 0">
                            <h3
                                class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400"
                            >
                                {{ dateFormatter(note.date, "medium") }}
                            </h3>
                        </div>

                        <div
                            class="flex gap-x-3 relative group rounded-lg hover:bg-gray-100 dark:hover:bg-white/10"
                        >
                            <a class="absolute inset-0 z-[1]"></a>

                            <!-- Icon -->
                            <div
                                class="relative last:after:hidden after:absolute after:top-0 after:bottom-0 after:start-3.5 after:w-px after:-translate-x-[0.5px] after:bg-gray-200 dark:after:bg-gray-700 dark:group-hover:after:bg-gray-600"
                            >
                                <div
                                    class="relative z-10 w-7 h-7 flex justify-center items-center"
                                >
                                    <div
                                        class="w-2 h-2 rounded-full bg-white border-2 border-gray-300 group-hover:border-gray-600 dark:bg-gray-800 dark:border-gray-600"
                                    ></div>
                                </div>
                            </div>
                            <!-- End Icon -->

                            <!-- Right Content -->
                            <div class="grow p-2 pb-8">
                                <h3
                                    class="flex gap-x-1.5 font-semibold text-gray-800 dark:text-white"
                                >
                                    <svg
                                        class="flex-shrink-0 w-4 h-4 mt-1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"
                                        />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" x2="8" y1="13" y2="13" />
                                        <line x1="16" x2="8" y1="17" y2="17" />
                                        <line x1="10" x2="8" y1="9" y2="9" />
                                    </svg>
                                    {{ note.title }}
                                </h3>
                                <p
                                    class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                                >
                                    {{ note.description }}
                                </p>
                                <button
                                    type="button"
                                    class="mt-1 -ms-1 p-1 relative z-10 inline-flex items-center gap-x-2 text-xs rounded-lg border border-transparent text-gray-500 hover:bg-white hover:shadow-sm disabled:opacity-50 disabled:pointer-events-none dark:text-gray-400 dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                >
                                    <img
                                        class="flex-shrink-0 w-7 h-7 rounded-full"
                                        v-if="note.created_by"
                                        :src="
                                            note.created_by?.profile_photo_url
                                        "
                                        alt="Image Description"
                                    />
                                    {{
                                        note.created_by?.name ??
                                        "Usuário não identificado"
                                    }}
                                </button>
                            </div>
                            <!-- End Right Content -->
                        </div>
                    </template>
                </template>
            </div>

            <div class="mt-2" v-else>
                Esse aluno ainda não possui nenhum prontuário registrado.
            </div>
            <!-- End Timeline -->
        </div>
    </Modal>
</template>
