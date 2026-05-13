<?php

namespace App\Services;

use App\Http\Resources\TramiteResource;
use App\Repositories\TramiteRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TramiteService
{
    protected TramiteRepository $tramiteRepository;

    public function __construct(TramiteRepository $tramiteRepository)
    {
        $this->tramiteRepository = $tramiteRepository;
    }


    public function paginate(?int $institucionId = null, ?string $nombre = null, int $perPage = 10): AnonymousResourceCollection
    {
        $paginator = $this->tramiteRepository->paginate($institucionId, $nombre, $perPage);

        return TramiteResource::collection($paginator);
    }

    public function create(array $data): TramiteResource
    {
        $data['activo'] = $data['activo'] ?? true;

        $tramite = $this->tramiteRepository->create($data);

        return new TramiteResource($tramite->load('institucion'));
    }

    public function find(int $id): ?TramiteResource
    {
        $tramite = $this->tramiteRepository->findById($id);

        return $tramite ? new TramiteResource($tramite) : null;
    }

    public function update(int $id, array $data): ?TramiteResource
    {
        $tramite = $this->tramiteRepository->update($id, $data);

        return $tramite ? new TramiteResource($tramite->fresh('institucion')) : null;
    }


    public function delete(int $id): bool
    {
        return $this->tramiteRepository->delete($id);
    }
}
