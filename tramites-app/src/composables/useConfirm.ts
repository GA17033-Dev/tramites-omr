import { reactive } from 'vue';

interface ConfirmOptions {
  title?: string;
  message: string;
  confirmText?: string;
  cancelText?: string;
  variant?: 'danger' | 'primary';
}

interface ConfirmState extends Required<ConfirmOptions> {
  visible: boolean;
  resolver: ((value: boolean) => void) | null;
}

const state = reactive<ConfirmState>({
  visible: false,
  title: 'Confirmar acción',
  message: '',
  confirmText: 'Aceptar',
  cancelText: 'Cancelar',
  variant: 'danger',
  resolver: null,
});

export function useConfirm() {
  function confirm(opts: ConfirmOptions): Promise<boolean> {
    state.title       = opts.title ?? 'Confirmar acción';
    state.message     = opts.message;
    state.confirmText = opts.confirmText ?? 'Aceptar';
    state.cancelText  = opts.cancelText  ?? 'Cancelar';
    state.variant     = opts.variant     ?? 'danger';
    state.visible     = true;

    return new Promise<boolean>((resolve) => {
      state.resolver = resolve;
    });
  }

  function accept() {
    state.resolver?.(true);
    state.resolver = null;
    state.visible = false;
  }

  function cancel() {
    state.resolver?.(false);
    state.resolver = null;
    state.visible = false;
  }

  return { state, confirm, accept, cancel };
}
