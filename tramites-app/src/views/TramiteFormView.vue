<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter, RouterLink } from 'vue-router';
import tramitesService from '@/services/tramites.service';
import institucionesService from '@/services/instituciones.service';
import { useToast } from '@/composables/useToast';
import FieldError from '@/components/FieldError.vue';
import type { Institucion } from '@/types/institucion';
import type { TramitePayload } from '@/types/tramite';

const route = useRoute();
const router = useRouter();
const { showToast } = useToast();

const id = computed<number | null>(() => {
  const raw = route.params.id;
  return raw ? Number(raw) : null;
});
const esEdicion = computed(() => id.value !== null);

const instituciones = ref<Institucion[]>([]);
const enviando = ref(false);
const cargandoDatos = ref(false);
const errores = reactive<Record<string, string[]>>({});

const form = reactive<TramitePayload>({
  codigo: '',
  nombre: '',
  descripcion: '',
  institucion_id: null,
  dias_habiles: null,
});

onMounted(async () => {
  const inst = await institucionesService.getInstituciones();
  if (inst.success && inst.data) instituciones.value = inst.data;

  if (esEdicion.value && id.value) {
    cargandoDatos.value = true;
    try {
      const res = await tramitesService.getTramite(id.value);
      if (res.success && res.data) {
        Object.assign(form, {
          codigo: res.data.codigo,
          nombre: res.data.nombre,
          descripcion: res.data.descripcion,
          institucion_id: res.data.institucion_id,
          dias_habiles: res.data.dias_habiles,
        });
      }
    } finally {
      cargandoDatos.value = false;
    }
  }
});

function validarCliente(): boolean {
  Object.keys(errores).forEach((k) => delete errores[k]);

  if (!form.codigo.trim())              errores.codigo         = ['El código es obligatorio'];
  else if (form.codigo.length > 50)     errores.codigo         = ['Máx 50 caracteres'];
  if (!form.nombre.trim())              errores.nombre         = ['El nombre es obligatorio'];
  else if (form.nombre.length > 255)    errores.nombre         = ['Máx 255 caracteres'];
  if (!form.descripcion.trim())         errores.descripcion    = ['La descripción es obligatoria'];
  if (!form.institucion_id)             errores.institucion_id = ['Seleccioná una institución'];
  if (!form.dias_habiles || form.dias_habiles < 1)
    errores.dias_habiles = ['Debe ser un número entero mayor a 0'];

  return Object.keys(errores).length === 0;
}

async function enviar() {
  if (!validarCliente()) {
    showToast('Revisá los campos marcados', 'warning');
    return;
  }

  enviando.value = true;
  try {
    if (esEdicion.value && id.value) {
      await tramitesService.updateTramite(id.value, form);
    } else {
      await tramitesService.createTramite(form);
    }
    router.push({ name: 'tramites.index' });
  } catch (e: any) {
    if (e?.fieldErrors) {
      Object.assign(errores, e.fieldErrors);
    }
  } finally {
    enviando.value = false;
  }
}
</script>

<template>
  <section class="max-w-2xl mx-auto">
    <header class="mb-5">
      <RouterLink
        to="/tramites"
        class="text-xs text-slate-500 hover:text-slate-800"
      >
        ← Volver al listado
      </RouterLink>
      <h1 class="mt-1 text-2xl font-semibold text-slate-900">
        {{ esEdicion ? 'Editar trámite' : 'Nuevo trámite' }}
      </h1>
    </header>

    <form
      @submit.prevent="enviar"
      class="bg-white rounded-lg border p-6 space-y-4"
    >
      <div v-if="cargandoDatos" class="text-sm text-slate-500">
        Cargando datos del trámite…
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          Código <span class="text-rose-500">*</span>
        </label>
        <input
          v-model="form.codigo"
          type="text"
          maxlength="50"
          placeholder="Ej. TRM-100"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
          :class="errores.codigo && 'border-rose-400'"
        />
        <FieldError :message="errores.codigo?.[0]" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          Nombre <span class="text-rose-500">*</span>
        </label>
        <input
          v-model="form.nombre"
          type="text"
          maxlength="255"
          placeholder="Ej. Inscripción de Centro Escolar"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
          :class="errores.nombre && 'border-rose-400'"
        />
        <FieldError :message="errores.nombre?.[0]" />
      </div>

      <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">
          Descripción <span class="text-rose-500">*</span>
        </label>
        <textarea
          v-model="form.descripcion"
          rows="3"
          placeholder="Descripción breve del trámite"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
          :class="errores.descripcion && 'border-rose-400'"
        />
        <FieldError :message="errores.descripcion?.[0]" />
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">
            Institución <span class="text-rose-500">*</span>
          </label>
          <select
            v-model="form.institucion_id"
            class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            :class="errores.institucion_id && 'border-rose-400'"
          >
            <option :value="null" disabled>Seleccioná una institución</option>
            <option v-for="i in instituciones" :key="i.id" :value="i.id">
              {{ i.nombre }} ({{ i.tipo }})
            </option>
          </select>
          <FieldError :message="errores.institucion_id?.[0]" />
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">
            Días hábiles <span class="text-rose-500">*</span>
          </label>
          <input
            v-model.number="form.dias_habiles"
            type="number"
            min="1"
            placeholder="Ej. 15"
            class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
            :class="errores.dias_habiles && 'border-rose-400'"
          />
          <FieldError :message="errores.dias_habiles?.[0]" />
        </div>
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
          {{ enviando ? 'Guardando…' : esEdicion ? 'Guardar cambios' : 'Crear trámite' }}
        </button>
      </div>
    </form>
  </section>
</template>
