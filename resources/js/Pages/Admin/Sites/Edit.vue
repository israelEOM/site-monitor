<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    site: {
        type: Object,
        default: null
    }
});

const site = usePage().props.site;

const form = useForm({
    url: site.url,
});

const submit = () => {
    form.put(route('sites.update', site.id), {
        onFinish: () => form.reset(),
    });
};

const deleteSite = () => {
    form.delete(route('sites.destroy', site.id), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Site</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- <x-alerts/> -->

                        <form @submit.prevent="submit" method="post">
                            <div>
                                <input 
                                    type="text" 
                                    name="url" 
                                    placeholder="URL" 
                                    v-model="form.url" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                >
                                <InputError class="mt-2" :message="form.errors.url" />
                            </div>

                            <div class="flex justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Edit
                                </PrimaryButton>
                            </div>
                        </form>
                        <form @submit.prevent="deleteSite">
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
