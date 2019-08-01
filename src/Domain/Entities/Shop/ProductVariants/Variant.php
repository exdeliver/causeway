<?php

namespace Exdeliver\Causeway\Domain\Entities\Shop\ProductVariants;

use Exdeliver\Causeway\Domain\Common\AggregateRoot;
use Exdeliver\Causeway\Domain\Common\ChildrenTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Variant.
 */
class Variant extends AggregateRoot
{
    use ChildrenTrait;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'shop_product_variants';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function values()
    {
        return $this->hasMany(VariantValue::class);
    }
}
