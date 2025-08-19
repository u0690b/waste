<script setup lang="ts">
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {  Home, LaptopMinimalCheck,  MailCheck,  PlusCircle,  WifiOff } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import MobileMenu from './My/MobileMenu.vue';
const { isMobile } = useSidebar()
const mainNavItems: NavItem[] = [
    {
        title: 'Дашбоард',
        href: '/#home',
        icon: Home,
    },
    {
        title: 'Зөрчил бүртгэх',
        href: '/create',
        icon: PlusCircle,
    },
    {
        title: 'Илгээгээгүй',
        href: '/draft',
        icon: WifiOff,
    },
    {
        title: 'Илгээсэн',
        href: '/send',
        icon: MailCheck,
    },
    {
        title: 'Шийдвэрлэсэн',
        href: '/solved',
        icon: LaptopMinimalCheck,
    },
];

</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>

            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
    <MobileMenu v-if="isMobile" :menus="mainNavItems" />
</template>
