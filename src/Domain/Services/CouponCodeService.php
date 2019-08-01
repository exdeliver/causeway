<?php

namespace Exdeliver\Causeway\Domain\Services;

use CWCart;
use Exception;
use Exdeliver\Causeway\Domain\Entities\Shop\CouponCode;
use Exdeliver\Causeway\Infrastructure\Repositories\CouponCodeRepository;

/**
 * Class CouponCodeService.
 */
class CouponCodeService extends AbstractService
{
    /**
     * CouponCodeService constructor.
     *
     * @param CouponCodeRepository $couponCodeRepository
     */
    public function __construct(CouponCodeRepository $couponCodeRepository)
    {
        $this->repository = $couponCodeRepository;
    }

    /**
     * @param $couponCode
     *
     * @return mixed
     */
    public function validateCouponCode($couponCode)
    {
        $couponCode = $this->repository->where('coupon_code', '=', $couponCode)->first();

        return $couponCode;
    }

    /**
     * @param CouponCode $couponCode
     *
     * @return array
     *
     * @throws Exception
     */
    public function applyCouponCode(CouponCode $couponCode)
    {
        $findExistingProduct = CWCart::find([
            'product_id' => 'discount-coupon',
        ]);

        if (count($findExistingProduct) > 0) {
            foreach ($findExistingProduct as $product) {
                CWCart::remove((string) $product->id);
            }
        }

        CWCart::add([
            'product_id' => 'discount-coupon',
            'name' => __('Coupon code: ').$couponCode->name,
            'type' => 'discount',
            'discount_type' => $couponCode->discount_type,
            'gross_price' => null,
            'vat_price' => null,
            'discount_amount' => $couponCode->discount_amount,
            'coupon_code' => $couponCode->coupon_code,
            'vat' => null,
            'quantity' => 1,
        ]);

        return ['status' => 'success', 'message' => __('Coupon code applied.')];
    }
}
