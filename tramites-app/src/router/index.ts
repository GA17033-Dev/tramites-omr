import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router';
import TramitesListView from '@/views/TramitesListView.vue';
import TramiteFormView from '@/views/TramiteFormView.vue';
import InstitucionFormView from '@/views/InstitucionFormView.vue';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/tramites',
  },
  {
    path: '/tramites',
    name: 'tramites.index',
    component: TramitesListView,
    meta: { title: 'Trámites' },
  },
  {
    path: '/tramites/nuevo',
    name: 'tramites.create',
    component: TramiteFormView,
    meta: { title: 'Nuevo trámite' },
  },
  {
    path: '/tramites/:id(\\d+)/editar',
    name: 'tramites.edit',
    component: TramiteFormView,
    meta: { title: 'Editar trámite' },
    props: true,
  },
  {
    path: '/instituciones/nueva',
    name: 'instituciones.create',
    component: InstitucionFormView,
    meta: { title: 'Nueva institución' },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.afterEach((to) => {
  const base = 'OMR — Trámites';
  document.title = to.meta?.title ? `${to.meta.title} · ${base}` : base;
});

export default router;
