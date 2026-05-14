<script setup lang="ts">
defineProps<{ activo: boolean }>();
</script>

<template>
  <span
    class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-medium"
    :class="
      activo
        ? 'bg-emerald-100 text-emerald-800'
        : 'bg-slate-200 text-slate-600'
    "
  >
    <span
      class="w-1.5 h-1.5 rounded-full"
      :class="activo ? 'bg-emerald-500' : 'bg-slate-400'"
    />
    {{ activo ? 'Activo' : 'Inactivo' }}
  </span>
</template>
