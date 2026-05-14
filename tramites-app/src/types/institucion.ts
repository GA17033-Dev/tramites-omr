export type TipoInstitucion = 'MINISTERIO' | 'ALCALDIA' | 'AUTONOMA';

export interface Institucion {
  id: number;
  nombre: string;
  tipo: TipoInstitucion;
  activo: boolean;
}

export interface InstitucionPayload {
  nombre: string;
  tipo: TipoInstitucion;
}
