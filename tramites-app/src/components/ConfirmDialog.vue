<script setup lang="ts">
import { useConfirm } from '@/composables/useConfirm';

const { state, accept, cancel } = useConfirm();
</script>

<template>
  <transition name="modal">
    <div
      v-if="state.visible"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm px-4"
      role="dialog"
      aria-modal="true"
      @keydown.esc="cancel"
    >
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
        <div class="px-5 py-4 border-b">
          <h3 class="text-base font-semibold text-slate-900">
            {{ state.title }}
          </h3>
        </div>
        <div class="px-5 py-4 text-sm text-slate-600">
          {{ state.message }}
        </div>
        <div class="px-5 py-3 flex justify-end gap-2 bg-slate-50">
          <button
            type="button"
            @click="cancel"
            class="px-4 py-2 text-sm rounded border border-slate-300 text-slate-700 bg-white hover:bg-slate-100"
          >
            {{ state.cancelText }}
          </button>
          <button
            type="button"
            @click="accept"
            class="px-4 py-2 text-sm rounded text-white"
            :class="
              state.variant === 'danger'
                ? 'bg-rose-600 hover:bg-rose-700'
                : 'bg-brand-500 hover:bg-brand-600'
            "
          >
            {{ state.confirmText }}
          </button>
        </div>
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
