<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
const data = usePage();
const dataError = ref([]);
dataError.value = data.props.data;
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">
                        <div class="w-full p-2 text-red-500/80 text-xl font-bold">Danh sách tập phim lỗi</div>
                        <div class="mt-3">
                            <div v-for="item in dataError" class="w-full mt-2 py-3">
                                {{ item.category }} - {{ item.product }} - {{ item.episode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
