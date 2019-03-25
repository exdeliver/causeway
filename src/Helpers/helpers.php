<?php

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
            return \Carbon\Carbon::parse($value)->format($format);
        }
        return null;
    }
}

if (!function_exists('recursiveRequireFilesScanDir')) {
    function recursiveRequireFilesScanDir($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (!is_dir($file)) {
                    include_once(__DIR__ . '/' . $file);
                } else {
                    recursiveRequireFilesScanDir($file);
                }
            }
        }
    }
}