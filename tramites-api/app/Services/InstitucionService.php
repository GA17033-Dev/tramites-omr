<?php

namespace App\Services;

use App\Repositories\InstitucionRepository;
use Illuminate\Database\Eloquent\Collection;

class InstitucionService
{
    protected InstitucionRepository $institucionRepository;

    public function __construct(InstitucionRepository $institucionRepository)
    {
        $this->institucionRepository = $institucionRepository;
    }

    public function getAll(): Collection
    {
        return $this->institucionRepository->all();
    }

    public function create(array $data): \App\Models\Institucion
    {
        return $this->institucionRepository->create($data);
    }

    public function find(int $id): ?\App\Models\Institucion
    {
        return $this->institucionRepository->find($id);
    }

    public function update(int $id, array $data): ?\App\Models\Institucion
    {
        return $this->institucionRepository->update($id, $data);
    }



    public function changeStatus(int $id, bool $estado): bool
    {
        return $this->institucionRepository->changeStatus($id, $estado);
    }
}
