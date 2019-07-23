<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CategoryProduct
 * @package Domain\Entities\Shop
 */
class CategoryProduct extends Pivot
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'shop_category_product';

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(new Product());
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(new Category(), 'category_id', 'id');
    }
}
