<?php

namespace Exdeliver\Causeway\Domain\Services;

final class SanitzeService
{
    /**
     * Strip inline javascript tags.
     *
     * @param string $string
     *
     * @return string|string[]|null
     */
    public function stripInlineJavascript(string $string)
    {
        return preg_replace('\bon\w+=\S+(?=.*>)', '', $string);
    }
}
