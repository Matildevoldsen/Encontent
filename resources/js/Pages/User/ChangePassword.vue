<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

const form = useForm({
    old_password: '',
    password: '',
    password_confirmation: ''
});

let messages = {
    success: '',
    error: ''
}

const submit = () => {
    form.post(route('user.change.password.save'), {
        onFinish: function () {
            form.old_password = ''
            form.password = ''
            form.password_confirmation = ''
        },
        onSuccess: () => messages.success = 'Password successfully changed',
        onError: () => messages.error = 'There was an error in changing your password'
    });
};
</script>

<template>
    <Head title="Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Change Password
            </h2>
        </template>

        <form @submit.prevent="submit" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-if="messages.success" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                            <span class="font-medium">Success!</span> {{ messages.success }}
                        </div>

                        <h2 class="text-lg mt-4">Current Password</h2>

                        <div class="mt-2">
                            <BreezeLabel for="old_password" value="Current Password"/>
                            <BreezeInput id="old_password" type="password" class="mt-1 block w-full" v-model="form.old_password"
                                         required autocomplete="old_password"/>
                            <BreezeInputError class="mt-2" :message="form.errors.old_password"/>
                        </div>

                        <h2 class="text-lg mt-4">New Password</h2>

                        <div class="mt-1">
                            <BreezeLabel for="password" value="Password"/>
                            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                                         required autocomplete="new-password"/>
                            <BreezeInputError class="mt-2" :message="form.errors.password"/>
                        </div>

                        <div class="mt-4">
                            <BreezeLabel for="password_confirmation" value="Confirm Password"/>
                            <BreezeInput id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation"
                                         required autocomplete="password_confirmation"/>
                            <BreezeInputError class="mt-2" :message="form.errors.password_confirmation"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Register
                            </BreezeButton>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </BreezeAuthenticatedLayout>
</template>
