<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Sound\Sound;

/**
 * Class SoundController
 * @package Exdeliver\Causeway\Controllers
 */
class SoundController extends Controller
{
    /**
     * @param Sound $soundName
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSound(Sound $soundName)
    {
        return view('site::sound.play', [
            'sound' => $soundName,
        ]);
    }
}
