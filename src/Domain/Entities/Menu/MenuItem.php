<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;


use Astrotomic\Translatable\Translatable;
use Exdeliver\Causeway\Domain\Common\Entity;
use Exdeliver\Causeway\Domain\Common\Interfaces\MenuItemInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MenuItem.
 */
class MenuItem extends Entity implements MenuItemInterface
{
    use Translatable;

    /**
     * @var array
     */
    public $translatedAttributes = ['label', 'url'];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->orderBy('sequence', 'desc');
    }

    /**
     * @return BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * @return bool
     */
    public function isSubmenu()
    {
        return null !== $this->parent_id;
    }
}
