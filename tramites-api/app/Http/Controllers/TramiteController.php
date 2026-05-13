<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TramiteService;


class TramiteController extends Controller
{
    protected $tramiteService;

    public function __construct(TramiteService $tramiteService)
    {
        $this->tramiteService = $tramiteService;
    }

    public function index(Request $request)
    {
        $institucionId = $request->query('institucion_id');
        return response()->json($this->tramiteService->getAll($institucionId));
    }

   




}
