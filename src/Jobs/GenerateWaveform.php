<?php

namespace Exdeliver\Causeway\Jobs;

use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Exdeliver\Causeway\Domain\Services\SoundService;
use Exdeliver\Causeway\Domain\Services\WaveformService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

/**
 * Class GenerateWaveform
 * @package App\Jobs
 */
class GenerateWaveform implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var WaveformService|\Illuminate\Foundation\Application|mixed */
    protected $waveformService;

    /** @var Sound */
    protected $sound;

    /** @var SoundService|\Illuminate\Foundation\Application|mixed */
    protected $soundService;

    /**
     * Create a new job instance.
     *
     * @param Sound $sound
     */
    public function __construct(Sound $sound)
    {
        /** @var WaveformService waveformService */
        $this->waveformService = app(WaveformService::class);

        /** @var SoundService soundService */
        $this->soundService = app(SoundService::class);

        /** @var Sound sound */
        $this->sound = $sound;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $filename = $this->sound->filename;

        $this->waveformService->loadFile($this->sound);

        $this->waveformService->process();

        $this->waveformService->saveImage(storage_path('app/' . $filename)); // Saves image to file
    }
}
