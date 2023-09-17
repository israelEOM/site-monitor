<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head, usePage } from '@inertiajs/vue3';

defineProps({
    sites: {
        type: Object,
        default: null
    }
});

const flash = usePage().props.flash;

const list = async (page = 1) => {
    await axios.get(`/api/sites?page=${page}`).then(({data})=>{
            this.users = data
        }).catch(({ response })=>{
            console.error(response)
        })
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Sites</h2>
                <a :href="route('sites.create')" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 px-4 ml-4">+ New</a>
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
                                    <th scope="col" class="px-6 py-6">Site</th>
                                    <th scope="col" class="px-6 py-6" width="300px">Ações</th>
                                </tr>
                            </thead>
                            <tbody v-if="sites && sites.data.length > 0">
                                <tr v-for="(site, index) in sites.data" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ site.url }}</td>
                                    <td class="py-4">
                                        <a :href="route('sites.edit', site.id)"><PrimaryButton class="ml-4">Editar</PrimaryButton></a>
                                        <a :href="route('endpoints.index', site.id)"><SecondaryButton class="ml-4">Endpoints</SecondaryButton></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="2" class="px-6 py-4">No record found.</td>
                                </tr>
                            </tbody>
                        </table>

                        <div v-show="sites.links.length > 3" class="pt-6 flex justify-end">
                            <Pagination :links="sites.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
