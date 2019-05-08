<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exdeliver\Causeway\Infrastructure\Repositories\SoundRepository;
use Exdeliver\Causeway\Jobs\GenerateWaveform;
use Illuminate\Support\Facades\File;

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
     * @throws \Exception
     */
    public function saveSound(array $params, int $id = null)
    {
        $params['user_id'] = auth()->user()->id;

        if (!isset($params['filename'])) {
            throw new \Exception('File is required');
        }

        $storageWaveformDir = storage_path('app/public/uploads/sounds/');
        if (!is_dir($storageWaveformDir)) {
            File::makeDirectory($storageWaveformDir, 0777, true);
        }

        $file = $this->uploadService->upload($params['filename'], 'public/uploads/' . $this->path);

        if (!file_exists(storage_path('app/' . $file->file_path))) {
            throw new \Exception('Missing');
        }

        $params['filename'] = $file->file_path;

        $sound = $this->repository->updateOrCreate([
            'id' => $id ?? null,
        ], $params);

        GenerateWaveform::dispatch($sound);

        return $sound;
    }
}
