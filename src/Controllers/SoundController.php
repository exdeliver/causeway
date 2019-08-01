<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Sound\Sound;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class SoundController.
 */
class SoundController extends Controller
{
    /**
     * @param Sound $soundName
     *
     * @return Factory|View
     */
    public function getSound(Sound $soundName)
    {
        return view('site::sound.play', [
            'sound' => $soundName,
        ]);
    }
}
