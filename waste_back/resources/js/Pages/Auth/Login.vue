<script setup>
    import Checkbox from '@/Components/Checkbox.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    defineProps({
        canResetPassword: Boolean,
        status: String,
    });

    const form = useForm({
        username: '',
        password: '',
        remember: false
    });

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <GuestLayout>

        <Head title="Нэвтрэх" />
        <div class="max-w-xs m-auto mt-60 border rounded-xl border-indigo-300 p-5">
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="username" value="Нэвтрэх нэр" />
                    <TextInput id="username" type="text" class="mt-1 block w-full" v-model="form.username" required autofocus autocomplete="username" />
                    <InputError class="mt-2" :message="form.errors.username" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Нууц үг" />
                    <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ml-2 text-sm text-gray-600">Сануулах</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">

                    <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Нэвтрэх
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
