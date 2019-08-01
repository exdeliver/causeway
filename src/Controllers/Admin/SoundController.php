<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exception;
use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Exdeliver\Causeway\Domain\Services\SoundService;
use Exdeliver\Causeway\Domain\Services\WaveformService;
use Exdeliver\Causeway\Jobs\GenerateWaveform;
use Exdeliver\Causeway\Requests\PostSoundRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

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
     *
     * @param SoundService    $soundService
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
     * @return Factory|View
     */
    public function index()
    {
        return view('causeway::admin.sound.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('causeway::admin.sound.new');
    }

    /**
     * @param Request $request
     * @param Sound   $sound
     *
     * @return Factory|View
     */
    public function edit(Request $request, Sound $sound)
    {
        return view('causeway::admin.sound.update', [
            'sound' => $sound,
        ]);
    }

    /**
     * @param PostSoundRequest $request
     * @param Sound            $sound
     *
     * @return RedirectResponse
     */
    public function update(PostSoundRequest $request, Sound $sound)
    {
        return $this->store($request, $sound);
    }

    /**
     * @param PostSoundRequest $request
     * @param Sound|null       $sound
     *
     * @return RedirectResponse
     */
    public function store(PostSoundRequest $request, Sound $sound = null)
    {
        $fileName = !empty($request->filename) ? 'filename' : '';

        $soundRecord = $this->soundService->saveSound($request->only([
            'artist', 'name', 'description', $fileName,
        ]), $sound->id ?? null);

        $request->session()->flash('status', 'Sound '.$soundRecord->title.' uploaded.');

        return redirect()
            ->to(route('admin.sound.index'));
    }

    /**
     * @return bool
     *
     * @throws Exception
     */
    public function foobar()
    {
        $this->waveformService->loadFile(public_path().'/test.mp3');

        $this->waveformService->process();

        $this->waveformService->saveImage('waveform_example.png'); // Saves image to file

        GenerateWaveform::dispatch();

        return $this->waveformService->outputImage(); // Outputs image to browser
    }

    /**
     * @return Factory|View
     */
    public function play()
    {
        return view('sound.play');
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function getAjaxSounds()
    {
        $pages = Sound::get();

        return Datatables::of($pages)
            ->addColumn('name', function ($row) {
                return $row->name.' <a href="'.route('causeway.sound.play', ['name' => $row->name]).'" target="_blank"><i class="fa fa-play-circle"></i></a>';
            })
            ->addColumn('artist', function ($row) {
                return $row->artist;
            })
            ->addColumn('manage', function ($row) {
                return '<a href="'.route('admin.sound.update', ['id' => $row->id]).'" class="btn btn-sm btn-warning">Edit</a>
                        <form action="'.route('admin.sound.destroy', ['id' => $row->id]).'" class="delete-inline" method="post">
                            '.method_field('DELETE').csrf_field().'
                            <button class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Remove</button>
                        </form>
                        ';
            })
            ->rawColumns(['name', 'url', 'access_level', 'manage'])
            ->make(true);
    }

    /**
     * @param Request $request
     * @param Sound   $sound
     *
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function destroy(Request $request, Sound $sound)
    {
        $sound->delete();

        return redirect()
            ->back();
    }
}
