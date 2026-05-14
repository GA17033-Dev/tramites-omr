<script setup lang="ts">
import { isLoading } from '@/api/http';
</script>

<template>
  <div
    v-show="isLoading"
    class="fixed top-14 left-0 right-0 z-30 h-1 overflow-hidden"
    role="progressbar"
    aria-label="Cargando"
  >
    <div class="loader-bar h-full bg-brand-500"></div>
  </div>
</template>

<style scoped>
.loader-bar {
  width: 30%;
  animation: loader 1.1s linear infinite;
}

@keyframes loader {
  0%   { transform: translateX(-100%); width: 30%; }
  50%  { width: 50%; }
  100% { transform: translateX(400%); width: 30%; }
}
</style>
