<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import DrawerLeft from '@/Components/DrawerLeft.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextTarea from '@/Components/TextTarea.vue';
import Select from '@/Components/Select.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import axios from 'axios';

const opendrawer = ref(false);
const titledrawer = ref('')

const openAside = () => {
    titledrawer.value = 'Agregar Tarea';
    document.body.style.overflow = 'hidden';
    opendrawer.value = true;
}

function closeDrawer() {  
    document.body.style.overflow = '';
  opendrawer.value = false
}

const form = useForm({
    titulo: '',
    fechaentrega: '',
    descripcion: '',
    materia: '',
    profesor: '',
});

const submit = async () => {
    console.log(form);
    // let response = axios.post(route(''));
}

</script>

<template>
    <Head title="Tareas" />

    <AuthenticatedLayout>

        <DrawerLeft :isOpen="opendrawer" @close="closeDrawer" :title="titledrawer">       
            <form @submit.prevent="submit" method="post" class="flex flex-col w-full h-full gap-5">
                <div class="max-h-[400px] sm:max-h-[550px] overflow-y-auto p-5">
                    
                    <div class="mb-4">
                        <InputLabel for="titulo" value="Titulo de la tarea" />
                        <TextInput 
                            id="titulo"
                            type="text"
                            class="w-full mt-2"
                            v-model="form.titulo"
                        />
                    </div>
                    
                    <div class="mb-4">
                        <InputLabel for="fechaentrega" value="Fecha de entrega" />
                        <TextInput 
                            id="fechaentrega"
                            type="date"
                            class="w-full mt-2"
                            v-model="form.fechaentrega"
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="materia" value="Materia"/>
                        <Select 
                            id="materia"
                            class="w-full mt-2"
                            v-model="form.descripcion"
                        />
                    </div>                    
                    
                    <div class="flex mb-4">
                        <p class="mr-2 font-semibold">Nivel de dificultad:</p>
                        <span class="text-blue-500">Baja Dificultad</span>
                        <!-- 
                            rojo Alta Dificultad
                            amarillo Dificultad media
                            azul Baja Dificultad
                        -->
                    </div>

                    <div class="mb-4">
                        <InputLabel for="profesor" value="Profesor" />
                        <TextInput 
                            readonly
                            id="profesor"
                            type="text"
                            class="w-full mt-2 bg-gray-100"
                            v-model="form.profesor"
                        />
                    </div>

                    <div class="mb-4">
                        <InputLabel for="descripcion" value="Descripción de la tarea" />
                        <TextTarea 
                            id="descripcion"
                            class="w-full mt-2"
                            v-model="form.descripcion"
                        />
                    </div>
                                     
                </div>
                
                <div class="flex justify-end">
                    <PrimaryButton>
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <p>Agregar tarea</p>
                        </div>                                
                    </PrimaryButton>
                </div>
            </form>
        </DrawerLeft>
    
        <div class="py-6">
            <div class="container mx-auto sm:px-6 lg:px-8">
                <div class="p-6 text-gray-900">
                    <div class="block space-y-3 sm:justify-between sm:flex sm:space-y-0">
                        
                        <h3 class="text-2xl font-bold">Bienvenido {{ $page.props.auth.user.name }}</h3>

                        <PrimaryButton type="button" @click="openAside">
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
                            <div v-for="item in 9" class="col-span-2 px-4 py-3 border border-gray-200 rounded-md shadow-xl">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                                    </svg>
                                    <span class="text-gray-500">13/02/25</span>
                                </div>
                                
                                <h3 class="my-3 text-lg font-semibold text-center">Titulo tarea</h3>

                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <p class="text-gray-500">Metodos Emergentes</p>
                                </div>
                                
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 text-gray-600 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <p class="text-gray-500">Vero Morales</p>
                                </div>

                                <div class="flex justify-center mb-4">
                                    <div class="mr-2 min-size-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-600 size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="h-[10rem]  px-3 overflow-y-auto">
                                        <p class="text-gray-500">
                                            aun no has introducido nada :(                                            
                                        </p>
                                    </div>                                            
                                </div>
                                
                                <div class="flex items-center mb-4 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <p>Pendiente</p>
                                </div>

                                <div class="flex items-center justify-center">
                                    <SecondaryButton type="button" class="mr-5 cursor-pointer">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                            <p>Editar</p>
                                        </div>                                        
                                    </SecondaryButton>
                                    <SecondaryButton type="button" class="cursor-pointer">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-2 size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <p>ver</p>
                                        </div>
                                    </SecondaryButton>
                                </div>
                            </div> <!--  card -->                       
                        </div>                        

                    </div>
                </div>                                                    
            </div>
        </div>
    </AuthenticatedLayout>
</template>
