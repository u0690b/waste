export type FormDataConvertible =
    | Array<FormDataConvertible>
    | {
          [key: string]: FormDataConvertible;
      }
    | Blob
    | FormDataEntryValue
    | Date
    | boolean
    | number
    | null
    | undefined;

export interface WasteModel {
    id?: number;
    whois: boolean;
    name?: string | null;
    register?: string | null;
    chiglel?: string;
    aimag_city_id?: number;
    soum_district_id?: number;
    bag_horoo_id?: number;
    address?: string | null;
    description?: string | null;
    reason_id?: number;
    zuil_zaalt?: string | null;

    long?: number;
    lat?: number;
    reg_user_id?: number;
    reg_at?: string | null;
    images?: File[] | null;
    attached_images?: any[];
    imageBase64List?: string[];
    status_id?: number;
    comf_user_id?: number;
    comf_user_name?: string;
    resolve_id?: number | null;
    resolve_desc?: string | null;
    resolve_image?: string | null;
    resolved_at?: string | null;
    allocate_user_id?: string | null;

    created_at?: string;
    updated_at?: string;
}

export interface WasteFormModel extends Record<string, FormDataConvertible> {
    model: WasteModel & { [key: string]: FormDataConvertible };
}

// export interface User {
//     id: number;
//     regnum: string;
//     lastname?: string;
//     firstname?: string;
//     surname?: string;
//     gender?: string;
//     image?: string;
//     nationality?: string;
//     passportAddress?: string;
//     passportExpireDate?: string;
//     passportIssueDate?: string;
//     push_token?: string;
//     soumDistrictCode?: string;
//     soumDistrictName?: string;
//     updated_at?: string;
//     created_at?: string;
// }

// export interface Auth{
//     user?:User
// }

export interface LegalEntity {
    id: number;
    register: string;
    name: string;
    industry: string;
}
export interface Header {
    name: string;
    key: string;
    type?: string;
    url?: string;
    order?: string;
    class?: string;
}
export interface Row {
    id: number | string;
    [key: string]: any;
}

export interface PaginatedData<T> {
    data: T[];
    current_page: number;
    per_page: number;
    total: number;
    links:any[];
}

export interface NotificationModel extends Row {
    id: number;
    user_id: number;
    type?: string | null;
    title?: string | null;
    content?: string;
    rid?: number;
    read_at?: string;

    created_at?: string;
    updated_at?: string;
}
