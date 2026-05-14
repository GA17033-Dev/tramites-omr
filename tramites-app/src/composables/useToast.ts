import { reactive } from 'vue';

export type ToastVariant = 'success' | 'error' | 'info' | 'warning';

export interface ToastMessage {
  id: number;
  text: string;
  variant: ToastVariant;
}

interface ToastState {
  items: ToastMessage[];
}

const state = reactive<ToastState>({ items: [] });
let nextId = 1;

export function useToast() {
  function showToast(text: string, variant: ToastVariant = 'info', ms = 3500) {
    const id = nextId++;
    state.items.push({ id, text, variant });
    if (ms > 0) {
      setTimeout(() => dismiss(id), ms);
    }
    return id;
  }

  function dismiss(id: number) {
    const idx = state.items.findIndex((t) => t.id === id);
    if (idx !== -1) state.items.splice(idx, 1);
  }

  return { state, showToast, dismiss };
}
