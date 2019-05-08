<?php

namespace Exdeliver\Causeway\Controllers;

use Exdeliver\Causeway\Domain\Entities\Sound\Sound;

class SoundController extends Controller
{
    public function getSound(Sound $soundName)
    {
        return view('causeway::sound.play', [
            'sound' => $soundName
        ]);
    }
}
