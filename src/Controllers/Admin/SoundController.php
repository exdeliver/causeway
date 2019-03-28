<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use App\Jobs\GenerateWaveform;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Exdeliver\Causeway\Domain\Services\SoundService;
use Exdeliver\Causeway\Domain\Services\WaveformService;
use Exdeliver\Causeway\Requests\PostSoundRequest;
use Illuminate\Http\Request;

class SoundController extends Controller
{
    /**
     * @var WaveformService
     */
    protected $waveformService;

    /**
     * @var SoundService
     */
    protected $soundService;

    /**
     * SoundController constructor.
     * @param SoundService $soundService
     * @param WaveformService $waveformService
     */
    public function __construct(SoundService $soundService, WaveformService $waveformService)
    {
        $this->soundService = $soundService;

        $this->waveformService = $waveformService;

        $this->waveformService->setHeight(100);

        $this->waveformService->setWidth(508);

        $this->waveformService->setBackground('');

        $this->waveformService->setForeground('#ffffff');

        $this->waveformService->setDetail(100);

        $this->waveformService->setType('waveform');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('causeway::admin.sound.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('causeway::admin.sound.new');
    }

    /**
     * @param Request $request
     * @param Sound $sound
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, Sound $sound)
    {
        return view('causeway::admin.sound.edit', [
            'page' => $sound,
        ]);
    }

    /**
     * @param PostSoundRequest $request
     * @param Sound $sound
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostSoundRequest $request, Sound $sound)
    {
        return $this->store($request, $sound);
    }

    /**
     * @param PostSoundRequest $request
     * @param Sound|null $sound
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostSoundRequest $request, Sound $sound = null)
    {
        $soundRecord = $this->soundService->saveSound($request->only([
            'artist', 'title', 'description', 'filename',
        ]), $sound->id ?? null);

        $request->session()->flash('status', 'Sound ' . $soundRecord->title . ' uploaded.');

        return redirect()
            ->to(route('admin.sounds.index'));
    }

    public function foobar()
    {
        $this->waveformService->loadFile(public_path() . "/test.mp3");

        $this->waveformService->process();

        $this->waveformService->saveImage('waveform_example.png'); // Saves image to file

        GenerateWaveform::dispatch();

        return $this->waveformService->outputImage(); // Outputs image to browser
    }

    public function play()
    {
        return view('sound.play');
    }
}