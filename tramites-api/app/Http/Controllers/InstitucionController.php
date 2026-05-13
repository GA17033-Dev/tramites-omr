<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Http\Requests\StoreInstitucionRequest;
use App\Services\InstitucionService;
use Illuminate\Http\JsonResponse;

class InstitucionController extends Controller
{
    protected InstitucionService $institucionService;

    public function __construct(InstitucionService $institucionService)
    {
        $this->institucionService = $institucionService;
    }


    public function index(): JsonResponse
    {
        return Http::respuesta(Http::RET_OK, $this->institucionService->getAllActivas());
    }

    
    public function store(StoreInstitucionRequest $request): JsonResponse
    {
        return Http::respuesta(Http::RET_CREATED, $this->institucionService->create($request->getData()));
    }

    public function update(StoreInstitucionRequest $request, int $id): JsonResponse
    {
        $resource = $this->institucionService->update($id, $request->getData());

        return $resource
            ? Http::respuesta(Http::RET_OK, $resource)
            : Http::respuesta(Http::RET_NOT_FOUND, 'Institución no encontrada');
    }

    public function delete(int $id,): JsonResponse
    {
        $success = $this->institucionService->delete($id);

        return Http::respuesta(
            $success ? Http::RET_OK : Http::RET_NOT_FOUND,
            $success ? 'Institución eliminada' : 'Institución no encontrada'
        );
    }

    public function getById(int $id): JsonResponse
    {
        $resource = $this->institucionService->find($id);

        return $resource
            ? Http::respuesta(Http::RET_OK, $resource)
            : Http::respuesta(Http::RET_NOT_FOUND, 'Institución no encontrada');
    }
}
