<?php

namespace App\Repositories;

use App\Models\Tramite;
use Illuminate\Pagination\LengthAwarePaginator;

class TramiteRepository
{
    protected Tramite $tramite;

    public function __construct(Tramite $tramite)
    {
        $this->tramite = $tramite;
    }

    
    public function paginate(?int $institucionId = null, ?string $nombre = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->tramite
            ->newQuery()
            ->with('institucion')
            ->when($institucionId, fn ($q) => $q->where('institucion_id', $institucionId))
            ->when($nombre, fn ($q, $val) => $q->where('nombre', 'like', '%' . $val . '%'))
            ->orderByDesc('id')
            ->paginate($perPage)
            ->appends(request()->query());
    }

    public function findById(int $id): ?Tramite
    {
        return $this->tramite
            ->newQuery()
            ->with('institucion')
            ->find($id);
    }

    public function create(array $data): Tramite
    {
        return $this->tramite
            ->newQuery()
            ->create($data);
    }

    public function update(int $id, array $data): ?Tramite
    {
        $tramite = $this->findById($id);

        if ($tramite) {
            $tramite->update($data);
        }

        return $tramite;
    }

    public function changeStatus(int $id, bool $estado): bool
    {
        $tramite = $this->findById($id);

        if ($tramite) {
            $tramite->update(['activo' => $estado]);
            return true;
        }

        return false;
    }
}
