<script setup> 
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextTarea from '@/Components/TextTarea.vue';
import Select from '@/Components/Select.vue';

import { usePage } from '@inertiajs/vue3';

defineProps({
    form: Object,
    submit: Function,
    errors: Object,
    dificultad_name: String,        
    estatus: Object,
    materias: Object,
    showInputEstatus: Boolean,
    CompleteInputandStatus: Function,
});

</script>

<template>

    <form @submit.prevent="submit" method="post" id="formsubmit" class="flex flex-col w-full h-full gap-5">
        <div>
            <TextInput id="id" type="hidden" v-model="form.id" />

            <TextInput id="dificultad_id" type="hidden" v-model="form.dificultad_id" />
        </div>

        <div class="mb-4">
            <InputLabel for="titulo" value="Titulo de la tarea *" />
            <TextInput id="titulo" type="text" class="w-full mt-2" v-model="form.titulo" />
            <span v-if="errors.titulo" class="text-red-500">{{ errors.titulo[0] }}</span>
        </div>

        <div class="mb-4">
            <InputLabel for="fechaentrega" value="Fecha de entrega *" />
            <TextInput id="fechaentrega" type="date" class="w-full mt-2" v-model="form.fechaentrega" />
            <span v-if="errors.fechaentrega" class="text-red-500">{{ errors.fechaentrega[0] }}</span>
        </div>

        <div class="mb-4">
            <InputLabel for="materias_id" value="Materia *" />
            <Select id="materias_id" class="w-full mt-2" v-model="form.materias_id" @change="CompleteInputandStatus">
                <option v-for="item in materias" :value="item.id">{{ item.name }}</option>
            </Select>
        </div>
        
        <div class="flex mb-4">
            <p class="mr-2 font-semibold">Nivel de dificultad:</p>
            <span :class="{
                'text-red-500': dificultad_name === 'Dificultad alta',
                'text-yellow-500': dificultad_name === 'Dificultad media',
                'text-blue-500': dificultad_name === 'Dificultad baja',

            }">{{ dificultad_name }}</span>
        </div>

        <div class="mb-4">
            <InputLabel for="profesor" value="Profesor" />
            <TextInput readonly id="profesor" type="text" class="w-full mt-2 bg-gray-100" v-model="form.profesor" />
        </div>

        <div class="mb-4" v-if="showInputEstatus">
            <InputLabel for="estatus_id" value="Estatus" />
            <Select id="estatus_id" class="w-full mt-2" v-model="form.estatus_id">
                <option v-for="item in estatus" :value="item.id">{{ item.name }}</option>
            </Select>
        </div>

        <div class="mb-4">
            <InputLabel for="descripcion" value="Descripción de la tarea *" />
            <TextTarea id="descripcion" class="w-full mt-2" v-model="form.descripcion" />
            <span v-if="errors.descripcion" class="text-red-500">{{ errors.descripcion[0] }}</span>
        </div>
    </form>

</template>