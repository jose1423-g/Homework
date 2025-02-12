<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import DrawerLeft from '@/Components/DrawerLeft.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Select from '@/Components/Select.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';

defineProps({
    dificultad: Object, 
    materias: Object,
})

const errors = ref([]); 
const opendrawer = ref(false);
const titledrawer = ref('Agregar materia')

const openAside = (id) => {
    titledrawer.value = id ? 'Editar materia' : 'Agregar materia';
    document.body.style.overflow = 'hidden';
    opendrawer.value = true;    
}

function closeDrawer() {  
    form.reset('dificultad', 'name', 'profesor');    
    document.body.style.overflow = '';
    opendrawer.value = false
}

const form = useForm({
    id: '',
    name: '',
    profesor: '',
    dificultad: '', 
});

const submit = async () => {
    try {
        let response = await axios.post(route('add.materia'), form);        
        if (response.data.status == 1) {
            form.reset('dificultad', 'name', 'profesor');
            
            router.reload({ only: ['materias'] });
            closeDrawer();
            
        } else {
            alert(response.data.msg);
        }
    } catch (error) {
        errors.value = error.response.data.errors;
    }
    
}

const EditMateria = async (id) => {
    try {
        let response = await axios.get(route('edit.materia', id));
        
        if (response.data.status == 0) {
            alert(response.data.msg)   
        } else {
            openAside(id);
            let materia = response.data;
            form.id = materia.id;
            form.name = materia.name;
            form.profesor = materia.profesor;
            form.dificultad = materia.dificultad_id;
        }
    } catch (error) {
        errors.value = error.response.data.errors;
    }
}

const DeleteMateria = async (id)  => {
    
    if (!confirm('¿Estas seguro de la eliminar la materia?')) {
        return false;
    }

    try {
        let response = await axios.delete(route('delete.materia'), {
            data: {
                'id': id,
            }
        });
        if (response.data.status == 1) {            
            router.reload({ only: ['materias'] });
        } else {
            alert(response.data.msg);
        }
    } catch (error) {
        // console.log(error);
    }
} 

</script>

<template>
    <Head title="Tareas" />

    <AuthenticatedLayout>

        <DrawerLeft :isOpen="opendrawer" @close="closeDrawer" :title="titledrawer">       
            <form @submit.prevent="submit" method="post" class="flex flex-col w-full h-full gap-5">
                <div class="max-h-[400px] sm:max-h-[550px] overflow-y-auto p-5">
                    <TextInput 
                        id="id"
                        type="hidden"
                        v-model="form.id"
                    />
                    <div class="mb-4">
                        <InputLabel for="name" value="Materia *" />
                        <TextInput 
                            id="name"
                            type="text"
                            class="w-full mt-2"
                            v-model="form.name"
                        />
                        <span v-if="errors.name" class="text-red-500">{{ errors.name[0] }}</span>
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
                        <InputLabel for="dificultad" value="Dificultad *"/>
                        <Select
                            id="dificultad"
                            class="w-full mt-2"
                            v-model="form.dificultad"
                        >
                            <option v-for="item in dificultad" :value="item.id">{{ item.name }}</option>
                        </Select>
                        <span v-if="errors.dificultad" class="text-red-500">{{ errors.dificultad[0] }}</span>
                    </div>
                                     
                </div>
                
                <div class="flex justify-end"> 
                    <PrimaryButton>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <p>{{ titledrawer }}</p>
                        </div>
                    </PrimaryButton>
                </div>
            </form>
        </DrawerLeft>
        <div class="py-6">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    
                    <div class="block space-y-3 sm:justify-between sm:flex sm:space-y-0">
                        
                        <h3 class="text-2xl font-bold">Agrega tus Materias</h3>

                        <div class="h-5">
                            <PrimaryButton type="button" @click="openAside(false)">
                                <div class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p>Agregar materia</p>
                                </div>                                
                            </PrimaryButton>
                        </div>
                                                
                    </div>
                    
                    <div class="mt-5">
                        <div class="py-3 mb-10 border-b-2 border-gray-300">
                            <h3 class="mb-1 text-xl font-bold">Materias</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3"><!-- container -->
                            
                            <!-- card -->
                            <div v-for="item in materias" class="w-auto p-3 border border-gray-200 rounded-md shadow-xl sm:max-w-[20rem]"> 
                                
                                <div class="flex items-center justify-center mt-3 mb-5 sm:justify-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <h3 class="text-xl font-semibold text-center">{{ item.materia }}</h3>
                                </div>
                                
                                <div class="flex items-center mb-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-gray-500">{{ item.profesor }}</p>
                                </div>                                
                                
                                <div class="flex items-center mb-5 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                    </svg>
                                    <p>{{ item.dificultad }}</p>
                                </div>

                                <div class="flex items-center justify-center">
                                    <SecondaryButton type="button" class="mr-5 cursor-pointer" @click="EditMateria(item.id)">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <p>Editar</p>
                                        </div>                                        
                                    </SecondaryButton>
                                    <DangerButton type="button" class="cursor-pointer" @click="DeleteMateria(item.id)">
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
