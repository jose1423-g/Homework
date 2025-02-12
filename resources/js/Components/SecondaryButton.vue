<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-3 py-1 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-gray-100 border border-gray-300 rounded-md shadow-sm hover:bg-white disabled:opacity-25"
    >
        <slot />
    </button>
</template>
