<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentEndpoint = ref(null);
const currentFrequency = ref(null);

defineProps({
    site: {
        type: Object
    },
    endpoint: {
        type: Object
    }
});

const endpoint = usePage().props.endpoint;

const form = useForm({
    endpoint: endpoint.endpoint,
    frequency: endpoint.frequency
});

const submit = (siteId) => {
    form.put(route('endpoints.update', [siteId, endpoint.id]), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.endpoint) {
                currentEndpoint.value.focus();
            }
            if (form.errors.frequency) {
                currentFrequency.value.focus();
            }
        },
    });
};

const deleteEndpoint = (siteId) => {
    form.delete(route('endpoints.destroy', [siteId, endpoint.id]), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Endpoint from {{ site.url }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit(site.id)" method="post" class="grid gap-4">
                            <div>
                                <input 
                                    type="text" 
                                    ref="currentEndpoint"
                                    name="endpoint" 
                                    placeholder="Endpoint" 
                                    v-model="form.endpoint" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                                <InputError class="mt-2" :message="form.errors.endpoint" />
                            </div>
                            <div>
                                <input 
                                    type="text" 
                                    ref="currentFrequency"
                                    name="frequency" 
                                    placeholder="Frequency" 
                                    v-model="form.frequency" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                                <InputError class="mt-2" :message="form.errors.frequency" />
                            </div>

                            <div class="flex justify-end">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Edit
                                </PrimaryButton>
                            </div>
                        </form>
                        <form @submit.prevent="deleteEndpoint(site.id)">
                            <div class="flex justify-end mt-4">
                                <DangerButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Delete
                                </DangerButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
