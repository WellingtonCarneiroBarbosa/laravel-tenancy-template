<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import ActionSection from "@/Components/ActionSection.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    team: Object,
});

const confirmingTeamDeletion = ref(false);
const form = useForm({});

const confirmTeamDeletion = () => {
    confirmingTeamDeletion.value = true;
};

const deleteTeam = () => {
    form.delete(route("teams.destroy", props.team), {
        errorBag: "deleteTeam",
    });
};
</script>

<template>
    <ActionSection>
        <template #title> Desativar App </template>

        <template #description> Permanentemente desativar esse app. </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Uma vez desativado, todos os dados desse app, bem como o acesso
                dos alunos, serão permanentemente desativados. Antes de
                desativar esse app, por favor, faça o download de todos os dados
                que deseja manter.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmTeamDeletion">
                    Desativar App
                </DangerButton>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <ConfirmationModal
                :show="confirmingTeamDeletion"
                @close="confirmingTeamDeletion = false"
            >
                <template #title> Desativar App </template>

                <template #content>
                    Você tem certeza que deseja desativar esse app? Uma vez
                    desativado, todos os dados desse app, bem como o acesso dos
                    alunos, serão permanentemente desativados.
                </template>

                <template #footer>
                    <SecondaryButton @click="confirmingTeamDeletion = false">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteTeam"
                    >
                        Desativar App
                    </DangerButton>
                </template>
            </ConfirmationModal>
        </template>
    </ActionSection>
</template>
