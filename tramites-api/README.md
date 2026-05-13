# tramites-api — Backend

Stack: PHP 8.1+ · Laravel 10 · SQLite

## Arranque

```bash
# 1) Dependencias
composer install

# 2) .env
cp .env.example .env

# 3) Migraciones + seeds
php artisan migrate:fresh --seed

# 4) Servidor
php artisan serve
# → http://127.0.0.1:8000
```

## Endpoints

| Método | Endpoint               | Descripción                              |
|--------|------------------------|------------------------------------------|
| GET    | `/api/instituciones`   | Lista instituciones activas              |
| POST   | `/api/instituciones`   | Crea una institución                     |
| GET    | `/api/tramites`        | Lista paginada. Filtros: `?institucion_id=` `?nombre=` |
| GET    | `/api/tramites/{id}`   | Detalle de un trámite                    |
| POST   | `/api/tramites`        | Crea un trámite                          |
| PUT    | `/api/tramites/{id}`   | Actualiza un trámite                     |
| DELETE | `/api/tramites/{id}`   | Soft delete — marca `activo=false`       |

## Arquitectura

- **Controller** — solo orquesta request/response
- **Service** — lógica de negocio, devuelve Resources
- **Repository** — acceso a datos
- **Helper Http** — único punto de salida JSON

## Decisiones técnicas

- **SQLite por archivo** — persiste entre requests durante la defensa
- **Soft delete manual** — columna `activo=false`, sin trait SoftDeletes
- **Helper único `Http::respuesta()`** — toda respuesta JSON sale de aquí
- **Resources en Services** — el controller solo llama `Http::respuesta()`
- **Form Requests separados** — Store y Update con reglas distintas
- **Institución activa** — validada al crear/actualizar trámites
- **`with('institucion')`** precargado — evita N+1 en listados
- **CORS abierto** sobre `api/*`

## Tiempo invertido

| Módulo                              | Tiempo  |
|-------------------------------------|---------|
| Setup inicial + migraciones + seeds | ~1 h    |
| Modelos, relaciones y Repositories  | ~1 h    |
| Services + Resources + Requests     | ~1.5 h  |
| Helper Http + flujo de respuesta    | ~1 h    |
| Exception Handler                   | ~0.5 h  |
| Validaciones extra                  | ~0.5 h  |
| Documentación                       | ~0.5 h  |
| **Total**                           | **~6 h**|