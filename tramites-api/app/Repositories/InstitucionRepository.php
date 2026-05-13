<?php

namespace App\Repositories;

use App\Models\Institucion;
use Illuminate\Database\Eloquent\Collection;

class InstitucionRepository
{
    protected Institucion $institucion;

    public function __construct(Institucion $institucion)
    {
        $this->institucion = $institucion;
    }

    public function all(bool $soloActivas = false): Collection
    {
        return $this->institucion
            ->newQuery()
            ->when($soloActivas, fn ($q) => $q->where('activo', true))
            ->orderBy('nombre')
            ->get();
    }

    public function create(array $data): Institucion
    {
        return $this->institucion
            ->newQuery()
            ->create($data);
    }

    public function find(int $id): ?Institucion
    {
        return $this->institucion
            ->newQuery()
            ->find($id);
    }

    public function update(int $id, array $data): ?Institucion
    {
        $institucion = $this->find($id);

        if ($institucion) {
            $institucion->update($data);
        }

        return $institucion;
    }

    public function changeStatus(int $id, bool $estado): bool
    {
        $institucion = $this->find($id);

        if ($institucion) {
            $institucion->update(['activo' => $estado]);
            return true;
        }

        return false;
    }
}
