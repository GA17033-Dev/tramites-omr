<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
  <header class="bg-white border-b sticky top-0 z-40">
    <nav class="max-w-6xl mx-auto px-4 h-14 flex items-center justify-between">
      <RouterLink to="/tramites" class="flex items-center gap-2">
        <span
          class="inline-flex items-center justify-center w-8 h-8 rounded bg-brand-500 text-white font-bold"
          >O</span
        >
        <span class="font-semibold text-slate-800">OMR · Trámites</span>
      </RouterLink>

      <div class="flex items-center gap-1">
        <RouterLink
          to="/tramites"
          class="px-3 py-2 rounded text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100"
          active-class="!text-brand-600 !bg-brand-50"
        >
          Trámites
        </RouterLink>
        <RouterLink
          to="/instituciones/nueva"
          class="px-3 py-2 rounded text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100"
          active-class="!text-brand-600 !bg-brand-50"
        >
          Nueva institución
        </RouterLink>
        <RouterLink
          to="/tramites/nuevo"
          class="ml-2 px-3 py-2 rounded text-sm font-medium bg-brand-500 text-white hover:bg-brand-600"
        >
          + Nuevo trámite
        </RouterLink>
      </div>
    </nav>
  </header>
</template>
