<?php

use Carbon\Carbon;

if (!function_exists('inputOld')) {
    function inputOld($name, $model = null)
    {
        return old($name, request($name) ?? $model ?? null);
    }
}

if (!function_exists('accessLevelList')) {
    function accessLevelList()
    {
        return [
            '' => 'Public',
            'admin' => 'Admin',
            'user' => 'User',
        ];
    }
}

if (!function_exists('cmsDate')) {
    function cmsDateTime($value, $format = 'j M Y H:i')
    {
        if (isset($value) && !empty($value)) {
            return Carbon::parse($value)->format($format);
        }

        return null;
    }
}

if (!function_exists('recursiveRequireFilesScanDir')) {
    function recursiveRequireFilesScanDir($target)
    {
        if (is_dir($target)) {
            $files = glob($target.'*', GLOB_MARK);
            foreach ($files as $file) {
                if (!is_dir($file)) {
                    include_once __DIR__.'/'.$file;
                } else {
                    recursiveRequireFilesScanDir($file);
                }
            }
        }
    }
}

if (!function_exists('causewayAsset')) {
    function causewayAsset($path)
    {
        return asset('vendor/exdeliver/causeway'.'/'.$path);
    }
}

if (!function_exists('causewayStrDot')) {
    function causewayStrDot($value)
    {
        return str_replace(str_slug($value), '-', '.');
    }
}

if (!function_exists('causewayVatPercentages')) {
    function causewayVatPercentages()
    {
        try {
            $vats = json_decode(config('causeway.vat_percentages'), true);
            if (!is_array($vats)) {
                throw new Exception('Error VATS configuration in .env or config file.');
            } else {
                foreach ($vats as $key => $value) {
                    if (!is_float((float) $key)) {
                        throw new Exception('Error VATS configuration in .env or config file. Key should be float.');
                    }
                }
            }

            return $vats;
        } catch (Exception $e) {
            throw new Exception('Error VATS configuration in .env or config file.');
        }
    }
}

if (!function_exists('orderedArray')) {
    function orderedArray($collection, $parent_id = 0)
    {
        $temp_array = [];
        foreach ($collection as $objectModel) {
            $objectModel->subs = orderedArray($objectModel->children, $objectModel['id']);
            $temp_array[] = $objectModel->toArray();
        }

        return $temp_array;
    }
}

if (!function_exists('causewayDate')) {
    function causewayDate(string $value = null, string $format = 'j M Y')
    {
        return null !== $value ? Carbon::parse($value)->format($format) : '';
    }
}

if (!function_exists('causewayCompanyInformation')) {
    function causewayCompanyInformation()
    {
        return json_decode(config('causeway.shop_company_information'), false);
    }
}

if (!function_exists('generateArrayCombinations')) {
    function generateArrayCombinations($arrays)
    {
        $combination = [[]];
        foreach ($arrays as $property => $property_values) {
            $temporaryResult = [];
            foreach ($combination as $result_item) {
                foreach ($property_values as $property_value) {
                    $temporaryResult[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $combination = $temporaryResult;
        }

        return $combination;
    }
}
