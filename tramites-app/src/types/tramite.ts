import type { Institucion } from './institucion';

export interface Tramite {
  id: number;
  codigo: string;
  nombre: string;
  descripcion: string;
  institucion_id: number;
  dias_habiles: number;
  activo: boolean;
  institucion?: Institucion;
}

export interface TramitePayload {
  codigo: string;
  nombre: string;
  descripcion: string;
  institucion_id: number | null;
  dias_habiles: number | null;
}

export interface TramiteFilters {
  institucion_id?: number | null;
  nombre?: string | null;
  page?: number;
}
