<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;

/**
 * Class CouponCodeRepository.
 */
class CouponCodeRepository extends AbstractRepository
{
    /**
     * CouponCodeRepository constructor.
     *
     * @param CouponCode $model
     */
    public function __construct(CouponCode $model)
    {
        parent::__construct($model);
    }
}
