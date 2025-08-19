import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function base64ToFile(dataUrl: string, filename: string): File {
    const [meta, base64] = dataUrl.split(',');
    const mime = meta?.match(/:(.*?);/)?.[1] ?? 'image/png';

    const byteChars = atob(base64 == undefined ? meta : base64);
    const byteNumbers = new Array(byteChars.length);

    for (let i = 0; i < byteChars.length; i++) {
        byteNumbers[i] = byteChars.charCodeAt(i);
    }

    const byteArray = new Uint8Array(byteNumbers);
    return new File([byteArray], filename, { type: mime });
}

export function base64ToBlob(dataUrl: string): Blob {
    const [meta, base64] = dataUrl.split(',');
    const mime = meta?.match(/:(.*?);/)?.[1] ?? 'image/png';

    const byteChars = atob(base64 == undefined?meta:base64);
    const byteNumbers = new Array(byteChars.length);

    for (let i = 0; i < byteChars.length; i++) {
        byteNumbers[i] = byteChars.charCodeAt(i);
    }

    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], { type: mime });
}
