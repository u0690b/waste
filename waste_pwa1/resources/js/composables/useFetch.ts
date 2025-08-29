import axios, { AxiosError } from 'axios';
import { ref } from 'vue';

interface UseFetchOptions {
    transform?: (data: any) => any|null;
    immediate?: boolean;
}

export function useFetch<T = any>(url: string, options: UseFetchOptions = {}) {
    const { transform = (data: any):any|null => data, immediate = true } = options;

    const data = ref<any>(null);
    const error = ref<any>(null);
    const loading = ref(false);

    const execute = async () => {
        loading.value = true;
        error.value = null;
        try {

            const response = await axios.get<T>(url);
            data.value = transform(response.data);
        } catch (err) {
            error.value = err as AxiosError;
        } finally {
            loading.value = false;
        }
    };

    if (immediate) execute();

    return { data, error, loading, execute };
}


