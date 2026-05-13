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
            ->when($soloActivas, fn($q) => $q->where('activo', true))
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
    public function findWithCondition(int $id, array $condition): ?Institucion
    {
        return $this->institucion
            ->newQuery()
            ->where($condition)
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

    public function delete(int $id): bool
    {
        $institucion = $this->findWithCondition($id, ['activo' => true]);

        if ($institucion) {
            $institucion->update(['activo' => false]);
            return true;
        }

        return false;
    }
}
