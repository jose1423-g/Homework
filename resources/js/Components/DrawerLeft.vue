<script setup> 
import {onMounted, onUnmounted} from 'vue';

const props = defineProps({
    title: {
        type: String,
        default: ''        
    },
    isOpen: {
        type: Boolean,
        required: true
    },
});

const emit = defineEmits(['close'])

const close = () => {
    emit('close');
}

const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        e.preventDefault();
        if (props.isOpen) {
            close();
        }
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = '';
});

</script>
<template>        

    <div class="bg-red-700">
        <!-- Overlay -->
        <div
            v-if="isOpen"
            @click="close"
            class="fixed inset-0 transition-opacity bg-gray-500 opacity-75"
        >
        </div>
        <!-- drawer -->
        <div 
            :class="['fixed top-0 right-0 w-full h-full sm:w-[30rem] rounded-l-xl bg-white shadow-lg transform transition-transform duration-300', { 'translate-x-full': !isOpen }]"        
        >        
            <div class="flex items-center justify-between p-4 border-b-2 border-gray-100">
                <h2 class="text-lg font-semibold">{{ title }}</h2>
                <button type="button" class="cursor-pointer" @click="close">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="px-3 py-5">                
                <!-- content -->
                <div class="px-3 max-h-[400px] sm:max-h-[calc(100vh-140px)] md:max-h-[550px] overflow-y-auto">
                    <slot />
                </div>
                <!-- footer -->
                <div v-if="$slots.footer" class="mt-5">
                    <slot name="footer" />
                </div>
            </div>
        </div> 
    </div>
</template>