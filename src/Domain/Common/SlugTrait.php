<?php

namespace Exdeliver\Causeway\Domain\Common;

use Illuminate\Support\Facades\App;

/**
 * Trait SlugTrait
 * @package Domain\Common
 */
trait SlugTrait
{
    /**
     * Generates an unique iterated name.
     *
     * @param string $column
     * @param string $name
     * @return string
     */
    protected function generateIteratedName(string $column, string $name): string
    {
        $entity = new $this;

        try {
            // Requires soft delete
            $existing = $entity->withTrashed();
        } catch (\Exception $e) {
            $existing = $entity;
        }

        $name = str_slug($name);

        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());

        $result = $existing->where($column, 'LIKE', "{$name}%")
            ->orderBy($column, 'desc');

        if (in_array('locale', $columns, true)) {
            $language = App::getLocale();
            if (isset(request()->language)) {
                $language = request()->language;
            }
            $result->where('locale', $language);
        }

        $result = $result->get();

        if ($result->count() > 0) {
            $sequence = $result->count();
            return $name . '-' . ($sequence + 1);
        } else {
            return $name;
        }
    }
}
