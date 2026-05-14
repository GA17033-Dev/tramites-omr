<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';
import type { Tramite } from '@/types/tramite';

defineProps<{ tramite: Tramite | null }>();
const emit = defineEmits<{
  (e: 'close'): void;
  (e: 'desactivar', tramite: Tramite): void;
}>();
</script>

<template>
  <transition name="modal">
    <div
      v-if="tramite"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
      role="dialog"
      aria-modal="true"
      @keydown.esc="emit('close')"
      @click.self="emit('close')"
    >
      <div
        class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden"
      >
        <header
          class="px-5 py-4 border-b flex items-start justify-between gap-3"
        >
          <div>
            <p class="font-mono text-xs text-slate-500">{{ tramite.codigo }}</p>
            <h3 class="text-base font-semibold text-slate-900">
              {{ tramite.nombre }}
            </h3>
          </div>
          <div class="flex items-center gap-2">
            <StatusBadge :activo="tramite.activo" />
            <button
              type="button"
              @click="emit('close')"
              class="text-slate-400 hover:text-slate-700"
              aria-label="Cerrar"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </div>
        </header>

        <dl class="divide-y text-sm">
          <div class="grid grid-cols-3 px-5 py-3">
            <dt class="text-slate-500">Institución</dt>
            <dd class="col-span-2 text-slate-800">
              {{ tramite.institucion?.nombre ?? '—' }}
              <span
                v-if="tramite.institucion"
                class="ml-1 text-xs text-slate-400"
              >
                ({{ tramite.institucion.tipo }})
              </span>
            </dd>
          </div>
          <div class="grid grid-cols-3 px-5 py-3">
            <dt class="text-slate-500">Días hábiles</dt>
            <dd class="col-span-2 text-slate-800 tabular-nums">
              {{ tramite.dias_habiles }}
            </dd>
          </div>
          <div class="grid grid-cols-3 px-5 py-3">
            <dt class="text-slate-500">Descripción</dt>
            <dd class="col-span-2 text-slate-800 whitespace-pre-wrap">
              {{ tramite.descripcion }}
            </dd>
          </div>
        </dl>

        <footer
          class="px-5 py-3 border-t bg-slate-50 flex justify-end gap-2"
        >
          <button
            type="button"
            @click="emit('close')"
            class="px-4 py-2 text-sm rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-100"
          >
            Cerrar
          </button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.15s ease;
}
.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
