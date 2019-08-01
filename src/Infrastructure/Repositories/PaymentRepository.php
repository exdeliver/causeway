<?php

namespace Exdeliver\Causeway\Infrastructure\Repositories;

use Exdeliver\Causeway\Domain\Entities\Shop\Invoices\Payment;

/**
 * Class PaymentRepository.
 */
class PaymentRepository extends AbstractRepository
{
    /**
     * PaymentRepository constructor.
     *
     * @param Payment $model
     */
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }
}
