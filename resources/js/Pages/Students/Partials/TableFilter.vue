<script setup>
import { onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import InputError from "@/Components/InputError.vue";
import { Search } from "lucide-vue-next";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    filterMode: {
        type: Boolean,
        default: false,
    },
});

const search = useForm({
    term: "",
    type: "name",
});

const handleSearch = () => {
    search.get(route("app.students.index"), {
        preserveState: false,
    });
};

onMounted(() => {
    if (props.filterMode) {
        let urlParams = new URLSearchParams(window.location.search);

        search.term = urlParams.get("term");
        search.type = urlParams.get("type");
    }
});
</script>

<template>
    <div class="py-3 px-4 grid grid-cols-12 gap-x-4">
        <div class="col-span-6">
            <InputLabel for="search_input">Pesquisa:</InputLabel>
            <TextInput
                id="search_input"
                v-model="search.term"
                class="w-full mt-1"
                placeholder="Digite o termo de pesquisa"
                :icon="Search"
                :loading="search.processing"
            />

            <InputError :message="search.errors.term" />
        </div>

        <div class="col-span-6">
            <InputLabel for="search_type">Pesquisar por:</InputLabel>
            <SelectInput
                id="search_type"
                v-model="search.type"
                class="mt-1"
                :options="[
                    { value: 'name', label: 'Nome' },
                    { value: 'email', label: 'E-mail' },
                ]"
                :loading="search.processing"
            />
            <InputError :message="search.errors.type" />
        </div>

        <div class="col-span-6"></div>

        <div class="col-span-6 w-full mt-2">
            <PrimaryButton
                :disabled="search.processing"
                @click="handleSearch"
                class="float-end"
            >
                {{ search.processing ? "Pesquisando..." : "Pesquisar" }}
            </PrimaryButton>
        </div>
    </div>
</template>
