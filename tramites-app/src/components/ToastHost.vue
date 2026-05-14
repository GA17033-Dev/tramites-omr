<script setup lang="ts">
import { useToast } from '@/composables/useToast';

const { state, dismiss } = useToast();

const variantClasses: Record<string, string> = {
  success: 'border-l-4 border-emerald-500 bg-emerald-50  text-emerald-800',
  error:   'border-l-4 border-rose-500    bg-rose-50     text-rose-800',
  info:    'border-l-4 border-sky-500     bg-sky-50      text-sky-800',
  warning: 'border-l-4 border-amber-500   bg-amber-50    text-amber-800',
};
</script>

<template>
  <div
    class="fixed top-20 right-4 z-50 flex flex-col gap-2 w-[22rem] max-w-[calc(100vw-2rem)]"
  >
    <transition-group name="toast" tag="div" class="flex flex-col gap-2">
      <div
        v-for="t in state.items"
        :key="t.id"
        class="toast-enter rounded-md shadow-md py-3 pl-4 pr-2 flex items-start justify-between gap-3 bg-white"
        :class="variantClasses[t.variant]"
        role="alert"
      >
        <div class="text-sm leading-snug">{{ t.text }}</div>
        <button
          type="button"
          @click="dismiss(t.id)"
          class="text-slate-400 hover:text-slate-700 transition"
          aria-label="Cerrar"
        >
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
    </transition-group>
  </div>
</template>

<style scoped>
.toast-enter-active,
.toast-leave-active {
  transition: all 0.25s ease;
}
.toast-enter-from {
  opacity: 0;
  transform: translateY(-8px);
}
.toast-leave-to {
  opacity: 0;
  transform: translateX(20px);
}
</style>
