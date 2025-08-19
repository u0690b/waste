import { InertiaForm } from "@inertiajs/vue3";

const useOrderBy = (formData:InertiaForm<any>, fieldName?:string) => {
    formData.model.orderBy = fieldName;
    formData.model.dir = formData.model.dir == 'desc' ? 'asc' : 'desc';
};

export default useOrderBy;
