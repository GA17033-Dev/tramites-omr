# tramites-app — Frontend

Stack: **Vue 3 · TypeScript · Vite · Tailwind CSS  · Vue Router · Axios**

## Arranque

```bash
# 1) Dependencias
npm install

# 2) .env (apunta al backend Laravel)
cp .env.example .env
# VITE_API_URL=http://127.0.0.1:8000/api

# 3) Servidor de desarrollo
npm run dev
# → http://127.0.0.1:5173
```

> El backend (`tramites-api`) debe estar corriendo en `php artisan serve`
> antes de arrancar el frontend.

## Vistas

| Ruta                   | Vista                       | Descripción                                                    |
|------------------------|-----------------------------|----------------------------------------------------------------|
| `/tramites`            | `TramitesListView`          | Tabla paginada · filtro por institución · búsqueda · CSV · modal de detalle |
| `/tramites/nuevo`      | `TramiteFormView` (create)  | Crea un trámite                                                |
| `/tramites/:id/editar` | `TramiteFormView` (edit)    | Edita un trámite                                               |
| `/instituciones/nueva` | `InstitucionFormView`       | Crea una institución                                           |




- **Búsqueda por nombre** (+3) — input con debounce de 350 ms en el listado, encadenable con el filtro por institución.
- **Confirmación antes de desactivar** (+3) — modal Tailwind reusable (`ConfirmDialog` + composable `useConfirm`).
- **Exportar CSV** (+4) — exporta el listado actual  con `;` como separador (compatible con Excel ES).

## Arquitectura

```
src/
├── api/
│   └── http.ts                    # instancia axios + interceptors (loading + toast)
├── services/                      # endpoints por recurso (default export)
│   ├── instituciones.service.ts
│   └── tramites.service.ts
├── components/
│   ├── AppNav.vue                 # navegación superior
│   ├── AppLoader.vue              # barra de carga global (consume isLoading)
│   ├── ToastHost.vue              # contenedor de toasts
│   ├── ConfirmDialog.vue          # modal de confirmación reutilizable
│   ├── TramiteDetailModal.vue     # modal de detalle de trámite
│   ├── FieldError.vue
│   └── StatusBadge.vue
├── composables/
│   ├── useToast.ts                # showToast(text, variant)
│   └── useConfirm.ts              # await confirm({ title, message, … })
├── router/
│   └── index.ts                   # rutas
├── types/
│   ├── api.ts                     # ApiSuccess / ApiError / PaginationMeta
│   ├── institucion.ts
│   └── tramite.ts
├── utils/
│   └── csv.ts                     # toCsv + downloadCsv
├── views/
│   ├── TramitesListView.vue
│   ├── TramiteFormView.vue       # crea o edita según ruta
│   └── InstitucionFormView.vue
├── App.vue
├── main.ts
└── style.css                      # Tailwind 
```

## Decisiones técnicas

- **Vue 3 + Composition API** con `<script setup lang="ts">` en todos los componentes — más limpio y con tipado estricto.
- **Tailwind ** en vez de Vuetify/Bootstrap-Vue: mejor control visual, menos peso, y los pocos componentes interactivos (modal, toasts) están escritos a mano para no traer JS extra del que no se usa.
- **Capa de servicios** (`services/*.service.ts`) con **default export** y nombres explícitos (`getTramites`, `createTramite`, `deleteTramite`, etc.)  Cada service consume el `http` instance compartido y devuelve `Promise<ApiResponse<T>>` ya tipado (sin `any` ni `@ts-ignore`).
- **Cliente axios único** con interceptores que manejan **loading global** (`isLoading` ref) y **toasts** automáticos: éxito en mutaciones (POST/PUT/DELETE), error en cualquier 4xx/5xx. Consume el shape `{ success, message, errors }` del backend.
- **Errores de validación de la API** (`422`) caen al `catch` del formulario; el toast con el mensaje genérico lo dispara el interceptor.
- **Validación cliente** mínima en cada formulario (required + length) antes de pegar al backend; los botones de envío se deshabilitan durante el `submit`.
- **Composables `useToast` y `useConfirm`** con estado reactivo compartido — cualquier vista los usa sin prop drilling y sin libs externas.
- **CSV** se genera en cliente (`utils/csv.ts`) sin tocar el backend, con  `;` como separador para abrir directo en Excel ES.
- **Búsqueda** con debounce 350 ms para no spamear la API mientras el usuario escribe; vuelve siempre a la página 1 al cambiar filtro.
- **Alias `@/`** apuntando a `src/` configurado en `vite.config.ts` y `tsconfig.app.json`.

## Tiempo invertido

| Módulo                                     | Tiempo  |
|--------------------------------------------|---------|
| Setup (Vite + Tailwind  + Router)| ~0.5 h  |
| Cliente API + interceptores + tipados      | ~1 h    |
| Capa services (refactor)                   | ~0.5 h  |
| Composables (toast, confirm) + componentes | ~1 h    |
| Vista listado (paginación, filtros, CSV)   | ~1.5 h  |
| Formulario trámite (crear/editar)          | ~1 h    |
| Formulario institución + detalle           | ~0.5 h  |
| Documentación                              | ~0.5 h  |
| **Total**                                  | **~6.5 h** |
