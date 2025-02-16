<script setup>
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Select from "@/Components/Select.vue";

    defineProps({
        form: Object,
        submit: Function,
        dificultad: Object,
        errors: Object,
    })

</script>

<template>
    <form
        @submit.prevent="submit"
        method="post"
        class="flex flex-col w-full h-full gap-4"
    >
        <TextInput id="id" type="hidden" v-model="form.id" />
        <div class="mb-4">
            <InputLabel for="name" value="Materia *" />
            <TextInput
                id="name"
                type="text"
                class="w-full mt-2"
                v-model="form.name"
            />
            <span v-if="errors.name" class="text-red-500">
                {{errors.name[0]}}
            </span>
        </div>

        <div class="mb-4">
            <InputLabel for="profesor" value="Profesor" />
            <TextInput
                id="profesor"
                type="text"
                class="w-full mt-2"
                v-model="form.profesor"
            />
        </div>

        <div class="">
            <InputLabel for="dificultad" value="Dificultad *" />
            <Select
                id="dificultad"
                class="w-full mt-2"
                v-model="form.dificultad"
            >
                <option v-for="item in dificultad" :value="item.id">
                    {{ item.name }}
                </option>
            </Select>
            <span v-if="errors.dificultad" class="text-red-500">
                {{ errors.dificultad[0] }}
            </span>
        </div>
    </form>
</template>
