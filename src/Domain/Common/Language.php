<?php

namespace Exdeliver\Causeway\Domain\Common;

/**
 * Class Language.
 */
class Language
{
    /**
     * @return array
     */
    public static function list(): array
    {
        return ['en' => 'English', 'nl' => 'Dutch'];
    }
}
