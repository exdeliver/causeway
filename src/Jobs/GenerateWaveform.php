<?php

namespace Exdeliver\Causeway\Jobs;

use Exception;
use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Exdeliver\Causeway\Domain\Services\SoundService;
use Exdeliver\Causeway\Domain\Services\WaveformService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class GenerateWaveform.
 */
final class GenerateWaveform implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var WaveformService|Application|mixed */
    protected $waveformService;

    /** @var Sound */
    protected $sound;

    /** @var SoundService|Application|mixed */
    protected $soundService;

    /**
     * Create a new job instance.
     *
     * @param Sound $sound
     */
    public function __construct(Sound $sound)
    {
        /* @var WaveformService waveformService */
        $this->waveformService = app(WaveformService::class);

        /* @var SoundService soundService */
        $this->soundService = app(SoundService::class);

        /* @var Sound sound */
        $this->sound = $sound;
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle()
    {
        $filename = $this->sound->filename;

        $this->waveformService->loadFile($this->sound);

        $this->waveformService->process();

        $this->waveformService->saveImage(storage_path('app/'.$filename)); // Saves image to file
    }
}
