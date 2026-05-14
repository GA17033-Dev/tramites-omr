<script setup lang="ts">
defineProps<{ message?: string | null }>();
</script>

<template>
  <p v-if="message" class="mt-1 text-xs text-rose-600">{{ message }}</p>
</template>
