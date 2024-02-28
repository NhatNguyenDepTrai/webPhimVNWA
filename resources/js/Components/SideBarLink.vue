<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'flex items-center justify-start cursor-pointer relative w-100 bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:from-purple-700 hover:via-purple-800 hover:to-purple-900 text-white font-bold py-2 px-4 rounded'
        : 'flex items-center justify-start cursor-pointer relative w-100  bg-gradient-to-r hover:from-purple-700 hover:via-purple-800 hover:to-purple-900 hover:text-white hover:font-bold py-2 px-4 rounded';
});
</script>

<template>
    <Link :href="href">
    <div :class="classes">
        <slot />
    </div>
    </Link>
</template>
