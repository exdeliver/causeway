<?php

/**
 * EXdeliver presents...
 * Causeway CMS configuration.
 */
return [
    // VAT percentages (Key = value)
    'vat_percentages' => env('CAUSEWAY_VAT_PERCENTAGES', '{"0.00": "0%", "9.00": "9%", "21.00": "21%"}'),
    'shop_company_information' => env('CAUSEWAY_COMPANY_INFORMATION', '{"company": "EXdeliver", "address": "YourCompanyStreet 22", "zipcode": "0000 TT", "city": "Rotterdam", "country": "The Netherlands", "vat_no": "NL6500000", "coc_no": "20000000", "email": "info@mail.nl", "bank_account": "NL00INGB000123456", "bank_name": "ING"}'),
];