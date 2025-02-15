<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import DrawerLeft from '@/Components/DrawerLeft.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextTarea from '@/Components/TextTarea.vue';
import Select from '@/Components/Select.vue';
import Spinner from '@/Components/Spinner.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';
import DrawerBottom from '@/Components/DrawerBottom.vue';
import FormCreateTask from '@/Components/FormCreateTask.vue';

const props = defineProps({
    tareas: Object,
    materias: Object,
    estatus_pendiente: Object,
    estatus: Object,
})

const opendrawer = ref(false);
const titledrawer = ref('Agregar tarea')
const errors = ref([]);
const loadSpinner = ref(false);
const dificultad_name = ref('');
const showInputEstatus = ref(false);

const openDrawerLeft = (id) => {
    titledrawer.value = id ? 'Editar tarea' : 'Agregar tarea';    
    document.body.style.overflow = 'hidden';
    opendrawer.value = true;
}

function closeDrawerLeft() {  
    form.reset();
    document.body.style.overflow = '';
    showInputEstatus.value  = false;
    opendrawer.value = false;    
    errors.value = [];
}

const form = useForm({
    id: '',
    titulo: '',
    fechaentrega: '',
    descripcion: '',
    materias_id: '',
    dificultad_id: '',
    estatus_id: props.estatus_pendiente.id,
    profesor: '',
});

const submit = async () => {
    try {
        loadSpinner.value = true;
        let response = await axios.post(route('add.tareas'), form);        
        if (response.data.status == 1) {
            form.reset();            
            loadSpinner.value = false;
            router.reload({ only: ['tareas'] });
            closeDrawerLeft();
            errors.value = [];
        } else {
            loadSpinner.value = false;
            errors.value = [];
            alert(response.data.msg);
        }
    } catch (error) {
        loadSpinner.value = false;
        errors.value = error.response.data.errors;
    }
}

const EditTarea = async (id) => {
    try {
        
        let response = await axios.get(route('edit.tarea', id));
        
        if (response.data.status == 0) {
            alert(response.data.msg)
        } else {
            openDrawerLeft(id);
            showInputEstatus.value  = true;
            
            response.data.forEach(element => {
                form.id = element.id;
                form.titulo = element.titulo;
                form.fechaentrega = element.fechaentrega;
                form.descripcion = element.descripcion;
                form.materias_id = element.materia_id;
                form.dificultad_id = element.dificultad_id;
                form.estatus_id = element.estatus_id;
                form.profesor = element.profesor;
                dificultad_name.value = element.dificultad_name;
            });
            
        }
    } catch (error) {
        errors.value = error.response.data.errors;
    }
}

const DeleteTarea = async (id)  => {
    
    if (!confirm('¿Estas seguro de elimnar la tarea?')) {
        return false;
    }
    
    try {
        let response = await axios.delete(route('delete.tarea'), {
            data: {
                'id': id,
            }
        });
        if (response.data.status == 1) {
            router.reload({ only: ['tareas'] });
        } else {
            alert(response.data.msg);
        }
    } catch (error) {
        // console.log(error);
    }
} 

const CompleteInputandStatus = async () => {
    
    try {
        let response = await axios.post(route('get.materia', form.materias_id));
        form.profesor = response.data.materias.name;
        form.dificultad_id = response.data.materias.dificultad_id;
        dificultad_name.value = response.data.dificultad.name;
    } catch (error) {
        // console.log(error);
    }
}

</script>

<template>
    <Head title="Tareas" />

    <AuthenticatedLayout>
                
        <DrawerLeft class="hidden md:block" :isOpen="opendrawer" @close="closeDrawerLeft" :title="titledrawer">  
            
            <FormCreateTask
                :form="form"
                :submit="submit"
                :errors="errors" 
                :dificultad_name="dificultad_name"
                :materias="materias"
                :estatus="estatus"
                :CompleteInputandStatus="CompleteInputandStatus"
                :showInputEstatus="showInputEstatus"
            />
                
            <template #footer>
                <div class="flex justify-end">
                    <PrimaryButton :disabled="loadSpinner" @click="submit">
                        <div v-if="loadSpinner">
                            <Spinner />
                        </div>
                        <div v-else class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <p>{{ titledrawer }}</p>
                        </div>                                
                    </PrimaryButton>
                </div>
            </template>
                        
        </DrawerLeft>

        <DrawerBottom class="md:hidden" :isOpen="opendrawer" @close="closeDrawerLeft" :title="titledrawer">
            
            <FormCreateTask
                :form="form"
                :submit="submit"
                :errors="errors" 
                :dificultad_name="dificultad_name"
                :materias="materias"
                :estatus="estatus"
                :CompleteInputandStatus="CompleteInputandStatus"
                :showInputEstatus="showInputEstatus"
            />
            
            <template #footer>
                <div class="flex justify-end px-3">
                    <PrimaryButton :disabled="loadSpinner" @click="submit" class="flex justify-center w-full md:block">
                        <div v-if="loadSpinner">
                            <Spinner />
                        </div>
                        <div v-else class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <p>{{ titledrawer }}</p>
                        </div>                                
                    </PrimaryButton>
                </div>        
                
            </template>
            
        </DrawerBottom>
        
        <div class="py-6">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <div class="block space-y-3 sm:justify-between sm:flex sm:space-y-0">
                        
                        <h3 class="text-2xl font-bold">Bienvenido {{ $page.props.auth.user.name }}</h3>

                        <PrimaryButton type="button" @click="openDrawerLeft(false)">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <p>Agregar tarea</p>
                            </div>                                
                        </PrimaryButton>
                        
                    </div>
                    
                    <div class="mt-5">
                        <div class="py-3 mb-10 border-b-2 border-gray-300">
                            <h3 class="mb-1 text-xl font-bold">Tareas</h3>
                            <p class="text-sm text-gray-500">¡Es el momento perfecto para avanzar con tus tareas!</p>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3 md:grid-cols-4"><!-- container -->
                            
                            <!-- card -->
                            <div v-for="item in tareas" class="col-span-2 px-4 py-3 border border-gray-200 rounded-md shadow-xl">
                                <div class="items-center justify-between block space-y-3 sm:space-y-0 sm:flex">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                                        </svg>
                                        <span class="text-gray-500">{{ item.fechaentrega }}</span>
                                    </div>
                                    <div class="flex items-center" :class="{
                                        'text-red-500': item.dificultad === 'Dificultad alta',
                                        'text-yellow-500': item.dificultad === 'Dificultad media',
                                        'text-blue-500': item.dificultad === 'Dificultad baja',
                                    }">                                        
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                        <span>{{ item.dificultad }}</span>
                                    </div>
                                </div>
                                
                                <h3 class="my-3 text-lg font-semibold text-center">{{ item.titulo }}</h3>

                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <p class="text-gray-500">{{ item.materia }}</p>
                                </div>
                                
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-gray-500">{{ item.profesor }}</p>
                                </div>

                                <div class="flex justify-center mb-4">
                                    <div class="mr-2 min-size-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-600 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="h-[10rem]  px-3 overflow-y-auto">
                                        <p class="text-gray-500">
                                            {{ item.descripcion }}                                            
                                        </p>
                                    </div>                                            
                                </div>
                                
                                <div 
                                    class="flex items-center mb-4"
                                    :class="{
                                        'text-red-500': item.estatus === 'Pendiente',
                                        'text-orange-500': item.estatus === 'En proceso',
                                        'text-green-500': item.estatus === 'Finalizado',
                                    }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p>{{ item.estatus }}</p>
                                </div>                                

                                <div class="flex items-center justify-center">
                                    <SecondaryButton type="button" class="mr-5 cursor-pointer" @click="EditTarea(item.id)">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <p>Editar</p>
                                        </div>                                        
                                    </SecondaryButton>
                                    <DangerButton type="button" class="cursor-pointer" @click="DeleteTarea(item.id)">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                            <p>Eliminar</p>
                                        </div>
                                    </DangerButton>
                                </div>
                            </div> <!--  card -->                       
                        </div>                        

                    </div>
                </div>                                                    
            </div>
        </div>
    </AuthenticatedLayout>
</template>
