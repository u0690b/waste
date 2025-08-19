<script setup lang="ts">

import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head,  useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    window.location.href='logindan'
    // router.get('logindan')
};
</script>

<template>
    <AuthLayout title="Log in to your account" description="Enter your email and password below to log in">

        <Head title="Log in" />
        <!-- <FlashMessages></FlashMessages> -->
        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div >
            <h2 class="border mx-4 p-2 rounded-md text-balance border-green-500 text-lg text-center mb-8 font-bold">БОХИРДОЛ БАГАСАХАД БҮГДИЙН ОРОЛЦОО ЧУХАЛ , ОРЧНОО ЦЭВЭРЛЭ, ИРЭЭДҮЙГЭЭ ГЭРЭЛТҮҮЛ, ЦЭВЭР ОРЧИН  ЦЭГЦЭРСЭН
                АМЬДРАЛ</h2>
        </div>
        <form method="POST" @submit.prevent="submit" class="space-y-4 mx-auto max-w-fit text-sm">

            <div class="grid gap-6">
                <!-- <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <UInput id="email" type="email" required autofocus :tabindex="1" autocomplete="email"
                        v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm"
                            :tabindex="5">
                            Forgot password?
                        </TextLink>
                    </div>
                    <UInput id="password" type="password" required :tabindex="2" autocomplete="current-password"
                        v-model="form.password" placeholder="Password" />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" v-model="form.remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div> -->

                <UButton type="submit" :loading="form.processing" class="uppercase">нэврэх</UButton>
                <!-- <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    ДАН Танилт нэвтрэлтийн
                    систем
                </Button> -->
            </div>

            <!-- <div class="text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>
            </div> -->
        </form>
    </AuthLayout>
</template>
