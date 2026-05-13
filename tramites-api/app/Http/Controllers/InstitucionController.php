<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TramiteService;


class InstitucionController extends Controller
{
    protected $tramiteService;

    public function __construct(TramiteService $tramiteService)
    {
        $this->tramiteService = $tramiteService;
    }

    public function index()
    {

        return response()->json($this->tramiteService->getAll());
    }
}
