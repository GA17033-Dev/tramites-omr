# tramites-omr

Prueba técnica OMR — sistema de registro y consulta de Trámites Administrativos.

## Estructura del repositorio

tramites-omr/
├── tramites-api/     ← Backend Laravel 10
├── tramites-app/     ← Frontend Vue.js 3
└── README.md

## Arranque rápido

### Backend
cd tramites-api
composer install
cp .env.example .env
php artisan migrate:fresh --seed
php artisan serve
# → http://127.0.0.1:8000

### Frontend
cd tramites-app
npm install
npm run dev
# → http://127.0.0.1:5173

## Decisiones técnicas

- Arquitectura Controller → Service → Repository en el backend
- SQLite por archivo para persistencia 
- Vue 3 + Vite + Axios para el frontend
- Exportación CSV generada en el frontend sin tocar el backend

## Tiempo invertido

| Módulo       | Tiempo |
|--------------|--------|
| Backend      | ~6 h   |
| Frontend     | ~x h   |
| README       | ~0.5 h | 