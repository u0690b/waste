import { useFetch } from '@/composables/useFetch';
import { defineStore } from 'pinia';

export interface Place {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface Reason {
    id: number;
    code: string;
    name: string;
    sub_group: string;
    stype: string;
    place_id: number;
    created_at: string;
    updated_at: string;
}

export interface Status {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface AimagCity {
    id: number;
    code: string;
    name: string;
    created_at: string;
    updated_at: string;
}
export interface SoumDistrict {
    id: number;
    code: string;
    name: string;
    short: string | null;
    aimag_city_id: number;
    created_at: string;
    updated_at: string;
}

export interface BagHoroo {
    id: number;
    code: string;
    name: string;
    soum_district_id: number;
    created_at: string;
    updated_at: string;
}

export interface Industry {
    id: number;
    name: string;
}

export interface Resolve {
    id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface NamedRow {
    value: string;
    label: string;
    parent_id: number | null;
    code: string | null;
}

export interface CommonRootData {
    places: Place[];
    reasons: Reason[];
    statuses: Status[];
    aimag_cities: AimagCity[];
    soum_districts: SoumDistrict[];
    bag_horoos: BagHoroo[];
    resolves: Resolve[];
    industry: Industry[];
}
export interface CommonNamedData {
    places: NamedRow[];
    reasons: NamedRow[];
    statuses: NamedRow[];
    aimag_cities: NamedRow[];
    soum_districts: NamedRow[];
    bag_horoos: NamedRow[];
    resolves: NamedRow[];
    industry: NamedRow[];
}

export const useCommonStore = defineStore('commons', () => {
    const {
        data: commons,
        loading,
        error,
        execute,
    } = useFetch<CommonRootData>('/api/common', {
        immediate: false,
        // transform: (data: CommonRootData): CommonNamedData | null => {
        //     return data
        //         ? {
        //               places: data.places.map<NamedRow>((row) => ({ label: row.name, value: String(row.id), parent_id: null, code: null })),
        //               reasons: data.reasons.map<NamedRow>((row) => ({ label: row.name, value: String(row.id), parent_id: null, code: null })),
        //               statuses: data.statuses.map<NamedRow>((row) => ({ label: row.name, value: String(row.id), parent_id: null, code: null })),
        //               aimag_cities: data.aimag_cities.map<NamedRow>((row) => ({
        //                   label: row.name,
        //                   value: String(row.id),
        //                   parent_id: null,
        //                   code: row.code,
        //               })),
        //               soum_districts: data.soum_districts.map<NamedRow>((row) => ({
        //                   label: row.name,
        //                   value: String(row.id),
        //                   parent_id: row.aimag_city_id,
        //                   code: row.code,
        //               })),
        //               bag_horoos: data.bag_horoos.map<NamedRow>((row) => ({
        //                   label: row.name,
        //                   value: String(row.id),
        //                   parent_id: row.soum_district_id,
        //                   code: row.code,
        //               })),
        //               resolves: data.resolves.map<NamedRow>((row) => ({ label: row.name, value: String(row.id), parent_id: null, code: null })),
        //               industry: data.industry.map<NamedRow>((row) => ({ label: row.name, value: String(row.id), parent_id: null, code: null })),
        //           }
        //         : null;
        // },
    });

    const fetchData = () => {
        if (commons.value==null) {
        execute().then(() => {
            console.log(commons.value);
        });
        }
    };

    return { commons, loading, error, fetchData };
});

