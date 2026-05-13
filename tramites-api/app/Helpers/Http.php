<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;


class Http
{
    public const RET_OK         = 'OK';
    public const RET_CREATED    = 'CREATED';
    public const RET_ERROR      = 'ERROR';
    public const RET_NOT_FOUND  = 'NOT_FOUND';
    public const RET_VALIDATION = 'VALIDATION';
    public const RET_UNAUTH     = 'UNAUTHORIZED';
    public const RET_FORBIDDEN  = 'FORBIDDEN';


    private const STATUS = [
        self::RET_OK         => 200,
        self::RET_CREATED    => 201,
        self::RET_ERROR      => 500,
        self::RET_NOT_FOUND  => 404,
        self::RET_VALIDATION => 422,
        self::RET_UNAUTH     => 401,
        self::RET_FORBIDDEN  => 403,
    ];

   
    private const MENSAJES = [
        self::RET_OK         => 'OK',
        self::RET_CREATED    => 'Recurso creado correctamente',
        self::RET_ERROR      => 'Error interno del servidor',
        self::RET_NOT_FOUND  => 'Recurso no encontrado',
        self::RET_VALIDATION => 'Los datos enviados no son válidos',
        self::RET_UNAUTH     => 'No autenticado',
        self::RET_FORBIDDEN  => 'Acceso prohibido',
    ];

   
    public static function respuesta(string $resultado, $datos = null, $errors = []): JsonResponse
    {
        $status  = self::STATUS[$resultado]   ?? 500;
        $message = is_string($datos) ? $datos : (self::MENSAJES[$resultado] ?? 'OK');

        
        if ($status >= 400) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors'  => empty($errors) ? (object) [] : $errors,
            ], $status);
        }

    
        $payload = ['success' => true, 'message' => $message];

        if ($datos instanceof JsonResource || $datos instanceof ResourceCollection) {
           
            $payload = array_merge($payload, $datos->response()->getData(true));
        } elseif ($datos !== null && ! is_string($datos)) {
            $payload['data'] = $datos;
        }

        return response()->json($payload, $status);
    }
}
