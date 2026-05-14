<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import StatusBadge from "@/components/StatusBadge.vue";
import TramiteDetailModal from "@/components/TramiteDetailModal.vue";
import tramitesService from "@/services/tramites.service";
import institucionesService from "@/services/instituciones.service";
import { useConfirm } from "@/composables/useConfirm";
import { downloadCsv, toCsv } from "@/utils/csv";
import type { Tramite } from "@/types/tramite";
import type { Institucion } from "@/types/institucion";
import type { PaginationMeta } from "@/types/api";

const { confirm } = useConfirm();


const tramiteDetalle = ref<Tramite | null>(null);

const tramites = ref<Tramite[]>([]);
const meta = ref<PaginationMeta | null>(null);
const instituciones = ref<Institucion[]>([]);
const filtroInstitucion = ref<number | null>(null);
const busqueda = ref("");
const page = ref(1);
const cargando = ref(false);

async function cargarTramites() {
  cargando.value = true;
  try {
    const res = await tramitesService.getTramites({
      institucion_id: filtroInstitucion.value,
      nombre: busqueda.value.trim() || null,
      page: page.value,
    });
    if (res.success) {
      tramites.value = res.data ?? [];
      meta.value = res.meta ?? null;
    }
  } finally {
    cargando.value = false;
  }
}

onMounted(async () => {
  const res = await institucionesService.getInstituciones();
  if (res.success) instituciones.value = res.data ?? [];
  await cargarTramites();
});

watch(filtroInstitucion, () => {
  page.value = 1;
  cargarTramites();
});

let debounceId: number;
watch(busqueda, () => {
  clearTimeout(debounceId);
  debounceId = setTimeout(() => {
    page.value = 1;
    cargarTramites();
  }, 350);
});

const paginas = computed(() => {
  if (!meta.value) return [];
  const { current_page: actual, last_page: total } = meta.value;
  const start = Math.max(1, actual - 2);
  const end = Math.min(total, start + 4);
  return Array.from({ length: end - start + 1 }, (_, i) => start + i);
});

function irPagina(p: number) {
  if (!meta.value || p < 1 || p > meta.value.last_page) return;
  page.value = p;
  cargarTramites();
}

async function desactivar(t: Tramite) {
  const ok = await confirm({
    title: "Desactivar trámite",
    message: `¿Seguro que querés desactivar "${t.codigo} — ${t.nombre}"?`,
    confirmText: "Sí, desactivar",
    cancelText: "Cancelar",
    variant: "danger",
  });
  if (ok) {
    await tramitesService.deleteTramite(t.id);
    tramiteDetalle.value = null; 
    cargarTramites();
  }
}

function ver(t: Tramite) {
  tramiteDetalle.value = t;
}

function exportarCsv() {
  if (!tramites.value.length) return;
  const csv = toCsv(tramites.value, [
    { key: "codigo", label: "Código" },
    { key: "nombre", label: "Nombre" },
    {
      key: "institucion",
      label: "Institución",
      format: (r) => r.institucion?.nombre ?? "",
    },
    {
      key: "tipo",
      label: "Tipo institución",
      format: (r) => r.institucion?.tipo ?? "",
    },
    { key: "dias_habiles", label: "Días hábiles" },
    {
      key: "activo",
      label: "Estado",
      format: (r) => (r.activo ? "Activo" : "Inactivo"),
    },
    { key: "descripcion", label: "Descripción" },
  ]);
  downloadCsv(`tramites-${new Date().toISOString().slice(0, 10)}.csv`, csv);
}
</script>

<template>
  <section>
    <header class="flex flex-wrap items-center justify-between gap-3 mb-5">
      <div class="flex gap-2">
        <button
          type="button"
          @click="exportarCsv"
          :disabled="!tramites.length"
          class="inline-flex items-center gap-1.5 px-3 py-2 text-sm rounded border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"
            />
          </svg>
          Exportar CSV
        </button>
        <RouterLink
          to="/tramites/nuevo"
          class="inline-flex items-center gap-1 px-3 py-2 text-sm rounded bg-brand-500 text-white hover:bg-brand-600"
        >
          + Nuevo trámite
        </RouterLink>
      </div>
    </header>

    <div class="bg-white rounded-lg border p-4 mb-4 grid gap-3 md:grid-cols-3">
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">
          Institución
        </label>
        <select
          v-model="filtroInstitucion"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
        >
          <option :value="null">Todas las instituciones</option>
          <option v-for="i in instituciones" :key="i.id" :value="i.id">
            {{ i.nombre }}
          </option>
        </select>
      </div>

      <div class="md:col-span-2">
        <label class="block text-xs font-medium text-slate-600 mb-1">
          Buscar por nombre
        </label>
        <input
          v-model="busqueda"
          type="text"
          placeholder="Ej. solvencia, permiso, registro…"
          class="w-full rounded-md border-slate-300 text-sm focus:border-brand-500 focus:ring-brand-500"
        />
      </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white rounded-lg border overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
          <thead class="bg-slate-50 text-slate-600">
            <tr>
              <th class="px-4 py-3 text-left font-semibold">Código</th>
              <th class="px-4 py-3 text-left font-semibold">Nombre</th>
              <th class="px-4 py-3 text-left font-semibold">Institución</th>
              <th class="px-4 py-3 text-right font-semibold">Días hábiles</th>
              <th class="px-4 py-3 text-left font-semibold">Estado</th>
              <th class="px-4 py-3 text-right font-semibold">Acciones</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            <tr v-if="cargando && !tramites.length">
              <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                Cargando trámites…
              </td>
            </tr>
            <tr v-else-if="!tramites.length">
              <td colspan="6" class="px-4 py-10 text-center text-slate-400">
                No hay trámites que coincidan con los filtros.
              </td>
            </tr>
            <tr
              v-for="t in tramites"
              :key="t.id"
              class="hover:bg-slate-50 transition"
            >
              <td class="px-4 py-3 font-mono text-xs text-slate-700">
                {{ t.codigo }}
              </td>
              <td class="px-4 py-3 text-slate-900">{{ t.nombre }}</td>
              <td class="px-4 py-3 text-slate-600">
                {{ t.institucion?.nombre ?? "—" }}
                <span
                  v-if="t.institucion"
                  class="ml-1 text-[10px] uppercase tracking-wide text-slate-400"
                >
                  ({{ t.institucion.tipo }})
                </span>
              </td>
              <td class="px-4 py-3 text-right tabular-nums">
                {{ t.dias_habiles }}
              </td>
              <td class="px-4 py-3">
                <StatusBadge :activo="t.activo" />
              </td>
              <td class="px-4 py-3">
                <div class="flex justify-end gap-1">
                  <button
                    type="button"
                    @click="ver(t)"
                    class="px-2.5 py-1 rounded text-xs border border-slate-300 bg-white hover:bg-slate-50 text-slate-700"
                  >
                    Ver
                  </button>
                  <RouterLink
                    :to="{ name: 'tramites.edit', params: { id: t.id } }"
                    class="px-2.5 py-1 rounded text-xs border border-slate-300 bg-white hover:bg-slate-50 text-slate-700"
                  >
                    Editar
                  </RouterLink>
                  <button
                    type="button"
                    :disabled="!t.activo"
                    @click="desactivar(t)"
                    class="px-2.5 py-1 rounded text-xs border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100 disabled:opacity-40 disabled:cursor-not-allowed"
                  >
                    Desactivar
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div
        v-if="meta && meta.last_page > 1"
        class="flex items-center justify-between px-4 py-3 border-t bg-slate-50 text-sm"
      >
        <span class="text-slate-500">
          Mostrando {{ meta.from ?? 0 }}–{{ meta.to ?? 0 }} de {{ meta.total }}
        </span>
        <div class="flex items-center gap-1">
          <button
            type="button"
            @click="irPagina(meta.current_page - 1)"
            :disabled="meta.current_page <= 1"
            class="px-2 py-1 rounded border border-slate-300 bg-white disabled:opacity-40"
          >
            ‹
          </button>
          <button
            v-for="p in paginas"
            :key="p"
            type="button"
            @click="irPagina(p)"
            :class="
              p === meta.current_page
                ? 'bg-brand-500 text-white border-brand-500'
                : 'bg-white text-slate-700 border-slate-300 hover:bg-slate-50'
            "
            class="px-3 py-1 rounded border text-xs"
          >
            {{ p }}
          </button>
          <button
            type="button"
            @click="irPagina(meta.current_page + 1)"
            :disabled="meta.current_page >= meta.last_page"
            class="px-2 py-1 rounded border border-slate-300 bg-white disabled:opacity-40"
          >
            ›
          </button>
        </div>
      </div>
    </div>

    <!-- Modal de detalle (bonus: detalle sin cambiar de ruta) -->
    <TramiteDetailModal
      :tramite="tramiteDetalle"
      @close="tramiteDetalle = null"
      @desactivar="desactivar"
    />
  </section>
</template>
