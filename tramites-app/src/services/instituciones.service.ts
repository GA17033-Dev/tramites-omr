import http from '@/api/http';
import type { ApiResponse } from '@/types/api';
import type { Institucion, InstitucionPayload } from '@/types/institucion';

export default {
  getInstituciones(): Promise<ApiResponse<Institucion[]>> {
    return http
      .get<ApiResponse<Institucion[]>>('/instituciones')
      .then((r) => r.data);
  },

  createInstitucion(data: InstitucionPayload): Promise<ApiResponse<Institucion>> {
    return http
      .post<ApiResponse<Institucion>>('/instituciones', data)
      .then((r) => r.data);
  },
};