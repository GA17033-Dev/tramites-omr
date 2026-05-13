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
}
