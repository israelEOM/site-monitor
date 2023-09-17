<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    checks: {
        type: Object
    },
    endpoint: {
        type: Object
    }
});

const flash = usePage().props.flash;

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Logs from endpoint: {{ endpoint.endpoint }}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div v-show="flash.message" class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            {{ flash.message }}
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-6">Status</th>
                                    <th scope="col" class="px-6 py-6">Set date</th>
                                    <th scope="col" class="px-6 py-6">Response</th>
                                </tr>
                            </thead>
                            <tbody v-if="checks && checks.data.length > 0">
                                <tr v-for="(check, index) in checks.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td :class="`px-6 py-4 text-${check.status_code === 200 ? 'green-400' : 'red-600'}`">{{ check.status_code }}</td>
                                    <td class="px-6 py-4">{{ check.created_at }}</td>
                                    <td class="px-6 py-4"><p class="truncate">{{ check.response_body ?? '-' }}</p></td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="5" class="px-6 py-4">No logs found.</td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-show="checks.links.length > 3" class="pt-6 flex justify-end">
                            <Pagination :links="checks.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
