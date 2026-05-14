import http from '@/api/http';
import type { ApiResponse } from '@/types/api';
import type { Tramite, TramiteFilters, TramitePayload } from '@/types/tramite';

export default {
  getTramites(filtros: TramiteFilters = {}): Promise<ApiResponse<Tramite[]>> {
    const params: Record<string, string | number> = {};
    if (filtros.institucion_id) params.institucion_id = filtros.institucion_id;
    if (filtros.nombre)         params.nombre         = filtros.nombre;
    if (filtros.page)           params.page           = filtros.page;

    return http
      .get<ApiResponse<Tramite[]>>('/tramites', { params })
      .then((r) => r.data);
  },

  getTramite(id: number): Promise<ApiResponse<Tramite>> {
    return http
      .get<ApiResponse<Tramite>>(`/tramites/${id}`)
      .then((r) => r.data);
  },

  createTramite(data: TramitePayload): Promise<ApiResponse<Tramite>> {
    return http
      .post<ApiResponse<Tramite>>('/tramites', data)
      .then((r) => r.data);
  },

  updateTramite(id: number, data: TramitePayload): Promise<ApiResponse<Tramite>> {
    return http
      .put<ApiResponse<Tramite>>(`/tramites/${id}`, data)
      .then((r) => r.data);
  },

  deleteTramite(id: number): Promise<ApiResponse<Tramite>> {
    return http
      .delete<ApiResponse<Tramite>>(`/tramites/${id}`)
      .then((r) => r.data);
  },
};