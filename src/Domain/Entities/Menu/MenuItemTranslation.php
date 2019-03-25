<?php

namespace Exdeliver\Causeway\Domain\Entities\Menu;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuItemTranslation
 * @package Domain\Entities\Menu
 */
class MenuItemTranslation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $guarded = [];
}