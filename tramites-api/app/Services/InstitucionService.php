<?php

namespace App\Services;

use App\Http\Resources\InstitucionResource;
use App\Repositories\InstitucionRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InstitucionService
{
    protected InstitucionRepository $institucionRepository;

    public function __construct(InstitucionRepository $institucionRepository)
    {
        $this->institucionRepository = $institucionRepository;
    }

    
    public function getAllActivas(): AnonymousResourceCollection
    {
        $instituciones = $this->institucionRepository->all(true);

        return InstitucionResource::collection($instituciones);
    }

    public function getAll(): AnonymousResourceCollection
    {
        $instituciones = $this->institucionRepository->all(false);

        return InstitucionResource::collection($instituciones);
    }

    public function create(array $data): InstitucionResource
    {
        $data['activo'] = $data['activo'] ?? true;

        $institucion = $this->institucionRepository->create($data);

        return new InstitucionResource($institucion);
    }

    public function find(int $id): ?InstitucionResource
    {
        $institucion = $this->institucionRepository->find($id);

        return $institucion ? new InstitucionResource($institucion) : null;
    }

    public function update(int $id, array $data): ?InstitucionResource
    {
        $institucion = $this->institucionRepository->update($id, $data);

        return $institucion ? new InstitucionResource($institucion) : null;
    }

    public function changeStatus(int $id, bool $estado): bool
    {
        return $this->institucionRepository->changeStatus($id, $estado);
    }
}
