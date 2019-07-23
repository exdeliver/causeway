<?php

namespace Exdeliver\Causeway\Validators;

use Illuminate\Validation\Validator;

/**
 * Class CausewayValidators
 * @package Exdeliver\Causeway\Validators
 */
class CausewayValidators extends Validator
{
    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateCausewayShopProductStock($attribute, $value, $parameters, $messages): bool
    {
        return true;
    }
}