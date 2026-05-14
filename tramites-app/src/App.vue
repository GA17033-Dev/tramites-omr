<script setup lang="ts">
import AppNav from '@/components/AppNav.vue';
import AppLoader from '@/components/AppLoader.vue';
import ToastHost from '@/components/ToastHost.vue';
import ConfirmDialog from '@/components/ConfirmDialog.vue';
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppNav />
    <AppLoader />
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-6">
      <RouterView v-slot="{ Component, route }">
        <transition name="fade" mode="out-in">
          <component :is="Component" :key="route.fullPath" />
        </transition>
      </RouterView>
    </main>
    <ToastHost />
    <ConfirmDialog />
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
