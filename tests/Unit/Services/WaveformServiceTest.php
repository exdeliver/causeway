<?php

namespace Exdeliver\Causeway\Tests\Unit\Services;

use Exdeliver\Causeway\Domain\Services\WaveformService;
use Exdeliver\Causeway\Tests\TestCase;

class WaveformServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        /** @var WaveformService $waveformService */
        $waveformService = app(WaveformService::class);

        $this->assertTrue(true);
    }
}
