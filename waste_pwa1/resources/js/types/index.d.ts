import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    new_noti: number;
    auth: Auth;
    flash: { message: string; success: string; warning: string; error: string };
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id:number,
    created_at: string;
    updated_at: string;
    regnum: string;
    firstname: string;
    gender: string;
    image: string;
    lastname: string;
    nationality: string;
    passportAddress: string;
    passportExpireDate: string;
    passportIssueDate: string;
    soumDistrictCode: string;
    soumDistrictName: string;
    surname: string;
    token: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
