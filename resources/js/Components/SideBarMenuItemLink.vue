<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'block border-l pl-4 -ml-px border-transparent text-purple-400 border-purple-400 dark:border-purple-500  text-purple-500 '
        : 'block border-l pl-4 -ml-px border-transparent hover:border-purple-400 dark:hover:border-purple-500 text-slate-700 hover:text-purple-900 dark:text-slate-400 dark:hover:text-purple-300';
});
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />

    </Link>
</template>
