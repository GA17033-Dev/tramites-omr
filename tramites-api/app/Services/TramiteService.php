<?php

namespace App\Services;

use App\Models\Tramite;
use App\Repositories\TramiteRepository;
use Illuminate\Database\Eloquent\Collection;

class TramiteService
{
    protected TramiteRepository $tramiteRepository;

    public function __construct(TramiteRepository $tramiteRepository)
    {
        $this->tramiteRepository = $tramiteRepository;
    }

    public function getAll(int $institucionId = null): Collection
    {
        return $this->tramiteRepository->paginate($institucionId)->getCollection();
    }

    public function create(array $data): Tramite
    {
        return $this->tramiteRepository->create($data);
    }

    public function find(int $id): ?Tramite
    {
        return $this->tramiteRepository->findById($id);
    }

    public function update(int $id, array $data): ?Tramite
    {
        return $this->tramiteRepository->update($id, $data);
    }

    public function changeStatus(int $id, bool $estado): bool
    {
        return $this->tramiteRepository->changeStatus($id, $estado);
    }

}

