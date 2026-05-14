import axios from 'axios';
import { ref } from 'vue';
import { useToast } from '@/composables/useToast';


export const isLoading = ref(false);


const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL ?? 'http://127.0.0.1:8000/api',
  headers: { 'Content-Type': 'application/json' },
  timeout: 15_000,
});


instance.interceptors.request.use((config) => {
  isLoading.value = true;
  return config;
});


instance.interceptors.response.use(
  (response) => {
    isLoading.value = false;
    const esMutacion = ['post', 'put', 'patch', 'delete'].includes(
      response.config.method ?? ''
    );

    if (esMutacion && response.data?.success) {
      useToast().showToast(response.data.message ?? 'Operación exitosa', 'success');
    }

    return response;
  },

  (error) => {
    isLoading.value = false;

    const message =
      error.code === 'ERR_NETWORK'
        ? 'Sin conexión con el servidor'
        : error.response?.data?.message ?? error.message ?? 'Algo salió mal';

    useToast().showToast(message, 'error');

    return Promise.reject(error);
  }
);

export default instance;