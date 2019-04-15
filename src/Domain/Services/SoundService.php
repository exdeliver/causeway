<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\SoundRepository;
use Exdeliver\Causeway\Jobs\GenerateWaveform;

/**
 * Class SoundService
 * @package Domain\Services
 */
class SoundService extends AbstractService
{
    /**
     * @var string
     */
    public $path = 'sounds';

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * SoundService constructor.
     * @param SoundRepository $soundRepository
     * @param UploadService $uploadService
     */
    public function __construct(SoundRepository $soundRepository, UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->repository = $soundRepository;
    }

    /**
     * @param array $params
     * @param int|null $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function saveSound(array $params, int $id = null)
    {
        $params['user_id'] = auth()->user()->id;

        $sound = $this->repository->updateOrCreate([
            'id' => $id ?? null,
        ], $params);

        if (isset($params['filename'])) {
            $this->uploadService->upload($params['filename'], storage_path($this->path));

            GenerateWaveform::dispatch($sound);
        }

        return $sound;
    }
}