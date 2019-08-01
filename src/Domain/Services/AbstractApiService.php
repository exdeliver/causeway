<?php

namespace Exdeliver\Causeway\Domain\Services;

use Exception;
use Illuminate\Foundation\Application;

/**
 * Class AbstractApiService.
 */
abstract class AbstractApiService extends AbstractService
{
    /**
     * @param string $serviceClassName
     *
     * @return Application|mixed
     *
     * @throws Exception
     */
    public function getProvider(string $serviceClassName)
    {
        $class = "\\Exdeliver\\Causeway\\Domain\\Services\\{$serviceClassName}";

        if (!class_exists($class)) {
            throw new Exception('PaymentService not found.');
        }

        $service = app($class);

        return $service;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key)
    {
        $this->key = $key;
    }
}
