<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Exdeliver\Causeway\Domain\Common\Entity;

/**
 * Class MenuItem
 * @package Domain\Entities\Menu
 */
class MenuItem extends Entity
{
    use \Dimsav\Translatable\Translatable;

    /**
     * @var array
     */
    public $translatedAttributes = ['label', 'url'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->orderBy('sequence', 'desc');
    }
}