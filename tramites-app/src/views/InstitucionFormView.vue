<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import institucionesService from '@/services/instituciones.service';
import { useToast } from '@/composables/useToast';
import FieldError from '@/components/FieldError.vue';
import type { InstitucionPayload, TipoInstitucion } from '@/types/institucion';

const router = useRouter();
const { showToast } = useToast();

const enviando = ref(false);
const errores = reactive<Record<string, string[]>>({});

const tipos: TipoInstitucion[] = ['MINISTERIO', 'ALCALDIA', 'AUTONOMA'];

const form = reactive<InstitucionPayload>({
  nombre: '',
  tipo: 'MINISTERIO',
});

function validar(): boolean {
  Object.keys(errores).forEach((k) => delete errores[k]);

  if (!form.nombre.trim()) errores.nombre = ['El nombre es obligatorio'];
  else if (form.nombre.length > 255) errores.nombre = ['Máx 255 caracteres'];

  if (!tipos.includes(form.tipo)) errores.tipo = ['Tipo inválido'];

  return Object.keys(errores).length === 0;
}

async function enviar() {
  if (!validar()) {
    showToast('Revisá los campos marcados', 'warning');
    return;
  }

  enviando.value = true;
  try {
    await institucionesService.createInstitucion(form);
    router.push({ name: 'tramites.index' });
  } catch (e: any) {
    if (e?.fieldErrors) Object.assign(errores, e.fieldErrors);
  } finally {
    enviando.value = false;
  }
}
</script>

<template>
  <section class="max-w-xl mx-auto">
    <header class="mb-5">
      <RouterLink
        to="/tramites"
        class="text-xs text-slate-500 hover:text-slate-800"
      >
        ← Volver al listado
      </RouterLink>
      <h1 class="mt-1 text-2xl font-semibold text-slate-900">Nueva institución</h1>
      <p class="text-sm text-slate-500">
        Una vez creada queda activa y disponible en el selector de trámites.
      </p>
    </header>

    <form
      @submit.prevent="enviar"
      class="bg-white rounded-lg border p-6 space-y-4"
    >
      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          Nombre <span class="text-rose-500">*</span>
        </label>
        <input
          v-model="form.nombre"
          type="text"
          maxlength="255"
          placeholder="Ej. Ministerio de Educación"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
          :class="errores.nombre && 'border-rose-400'"
        />
        <FieldError :message="errores.nombre?.[0]" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          Tipo <span class="text-rose-500">*</span>
        </label>
        <select
          v-model="form.tipo"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
          :class="errores.tipo && 'border-rose-400'"
        >
          <option v-for="t in tipos" :key="t" :value="t">{{ t }}</option>
        </select>
        <FieldError :message="errores.tipo?.[0]" />
      </div>

      <div class="flex justify-end gap-2 pt-2 border-t">
        <RouterLink
          to="/tramites"
          class="px-4 py-2 text-sm rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-50"
        >
          Cancelar
        </RouterLink>
        <button
          type="submit"
          :disabled="enviando"
          class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded bg-brand-500 text-white hover:bg-brand-600 disabled:opacity-60 disabled:cursor-not-allowed"
        >
          <svg
            v-if="enviando"
            class="w-4 h-4 animate-spin"
            viewBox="0 0 24 24"
            fill="none"
          >
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25" />
            <path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="4" class="opacity-75" />
          </svg>
          {{ enviando ? 'Guardando…' : 'Crear institución' }}
        </button>
      </div>
    </form>
  </section>
</template>
