import axios, { AxiosError } from 'axios';
import { ref, Ref } from 'vue';

interface UseFetchOptions<T, R> {
    transform?: (data: T) => R|null;
    immediate?: boolean;
}

export function useFetch<T = any, R = T>(url: string, options: UseFetchOptions<T, R> = {}) {
    const { transform = (data: any):any|null => data, immediate = true } = options;

    const data: Ref<R | null> = ref(null);
    const error: Ref<AxiosError | null> = ref(null);
    const loading: Ref<boolean> = ref(false);

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


