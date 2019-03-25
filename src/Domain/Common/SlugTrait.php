<?php

namespace Exdeliver\Causeway\Domain\Common;

/**
 * Trait SlugTrait
 * @package Domain\Common
 */
trait SlugTrait
{
    /**
     * Generates an unique iterated name.
     *
     * @param $column
     * @param $name
     * @return string
     */
    protected function generateIteratedName($column, $name): string
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
            $result->where('locale', 'en');
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