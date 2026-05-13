<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Http\Requests\StoreTramiteRequest;
use App\Http\Requests\UpdateTramiteRequest;
use App\Services\TramiteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    protected TramiteService $tramiteService;

    public function __construct(TramiteService $tramiteService)
    {
        $this->tramiteService = $tramiteService;
    }

  
    public function index(Request $request): JsonResponse
    {
        $institucionId = $request->query('institucion_id');
        $institucionId = $institucionId !== null && $institucionId !== '' ? (int) $institucionId : null;

        $nombre = $request->query('nombre');
        $nombre = is_string($nombre) && trim($nombre) !== '' ? trim($nombre) : null;

        return Http::respuesta(
            Http::RET_OK,
            $this->tramiteService->paginate($institucionId, $nombre)
        );
    }


    public function show(int $id): JsonResponse
    {
        $resource = $this->tramiteService->find($id);

        return $resource
            ? Http::respuesta(Http::RET_OK, $resource)
            : Http::respuesta(Http::RET_NOT_FOUND, 'Trámite no encontrado');
    }

    
    public function store(StoreTramiteRequest $request): JsonResponse
    {
        return Http::respuesta(Http::RET_CREATED, $this->tramiteService->create($request->getData()));
    }

   
    public function update(UpdateTramiteRequest $request, int $id): JsonResponse
    {
        $resource = $this->tramiteService->update($id, $request->getData());

        return $resource
            ? Http::respuesta(Http::RET_OK, $resource)
            : Http::respuesta(Http::RET_NOT_FOUND, 'Trámite no encontrado');
    }

   
    public function destroy(int $id): JsonResponse
    {
        $resource = $this->tramiteService->delete($id);

        return $resource
            ? Http::respuesta(Http::RET_OK, $resource)
            : Http::respuesta(Http::RET_NOT_FOUND, 'Trámite no encontrado');
    }
}
