<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    endpoints: {
        type: Array
    },
    site: {
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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Endpoints from: {{ site.url }}</h2>
                <a :href="route('endpoints.create', site.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 px-4 ml-4">+ New</a>
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
                                    <th scope="col" class="px-6 py-6">Endpoint</th>
                                    <th scope="col" class="px-6 py-6">Frequency</th>
                                    <th scope="col" class="px-6 py-6">Status</th>
                                    <th scope="col" class="px-6 py-6">Next check</th>
                                    <th scope="col" class="px-6 py-6" width="190px">Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="endpoints && endpoints.length > 0">
                                <tr v-for="(endpoint, index) in endpoints" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ endpoint.endpoint }}</td>
                                    <td class="px-6 py-4">{{ endpoint.frequency }}</td>
                                    <td class="px-6 py-4">
                                        <svg v-if="endpoint.check.isSuccess" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <svg v-else fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                        </svg>
                                    </td>
                                    <td class="px-6 py-4">{{ endpoint.next_check }}</td>
                                    <td class="py-4">
                                        <a :href="route('endpoints.edit', [site.id, endpoint.id])"><PrimaryButton class="ml-4">Edit</PrimaryButton></a>
                                        <a :href="route('endpoints.checks', endpoint.id)"><SecondaryButton class="ml-4">Logs</SecondaryButton></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="5" class="px-6 py-4">No record found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
