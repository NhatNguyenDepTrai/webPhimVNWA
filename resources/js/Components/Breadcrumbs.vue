<template>
    <div>
        <ul v-if="splittedUrl.length > 0">
            <li v-for="(part, index) in splittedUrl" :key="index">{{ part }}</li>
        </ul>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

export default {
    setup() {
        const { url } = usePage();

        const splittedUrl = url.split('/');


        return {

            splittedUrl,
        };
    },
};
</script>
