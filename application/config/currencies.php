<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CURRENCIES
| -------------------------------------------------------------------
| This file contains an array of currencies.  It is used for
| the product prices
|
*/
$config['currencies_array'] = array(
    'NIG' => array('name' => 'Nigerian Naira', 'symbol' => '₦', 'hex' => '&#x20a6;'),
    'USD' => array('name' => 'US Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'EUR' => array('name' => 'Euro', 'symbol' => '€', 'hex' => '&#x20ac;'),
    'CAD' => array('name' => 'Canadian Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'AUD' => array('name' => 'Australian Dollar', 'symbol' => 'A$', 'hex' => '&#x41;&#x24;'),
    'AED' => array('name' => 'United Arab Emirates Dirham', 'symbol' => 'د.إ', 'hex' => '&#x62f;&#x2e;&#x625;'),
    'ANG' => array('name' => 'NL Antillian Guilder', 'symbol' => 'ƒ', 'hex' => '&#x192;'),
    'ARS' => array('name' => 'Argentine Peso', 'symbol' => '$', 'hex' => '&#x24;'),
    'BRL' => array('name' => 'Brazilian Real', 'symbol' => 'R$', 'hex' => '&#x52;&#x24;'),
    'BSD' => array('name' => 'Bahamian Dollar', 'symbol' => 'B$', 'hex' => '&#x42;&#x24;'),
    'CHF' => array('name' => 'Swiss Franc', 'symbol' => 'CHF', 'hex' => '&#x43;&#x48;&#x46;'),
    'CLP' => array('name' => 'Chilean Peso', 'symbol' => '$', 'hex' => '&#x24;'),
    'CNY' => array('name' => 'Chinese Yuan Renminbi', 'symbol' => '¥', 'hex' => '&#xa5;'),
    'COP' => array('name' => 'Colombian Peso', 'symbol' => '$', 'hex' => '&#x24;'),
    'CZK' => array('name' => 'Czech Koruna', 'symbol' => 'Kč', 'hex' => '&#x4b;&#x10d;'),
    'DKK' => array('name' => 'Danish Krone', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;'),
    'FJD' => array('name' => 'Fiji Dollar', 'symbol' => 'FJ$', 'hex' => '&#x46;&#x4a;&#x24;'),
    'GBP' => array('name' => 'British Pound', 'symbol' => '£', 'hex' => '&#xa3;'),
    'GHS' => array('name' => 'Ghanaian New Cedi', 'symbol' => 'GH₵', 'hex' => '&#x47;&#x48;&#x20b5;'),
    'GTQ' => array('name' => 'Guatemalan Quetzal', 'symbol' => 'Q', 'hex' => '&#x51;'),
    'HKD' => array('name' => 'Hong Kong Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'HNL' => array('name' => 'Honduran Lempira', 'symbol' => 'L', 'hex' => '&#x4c;'),
    'HRK' => array('name' => 'Croatian Kuna', 'symbol' => 'kn', 'hex' => '&#x6b;&#x6e;'),
    'HUF' => array('name' => 'Hungarian Forint', 'symbol' => 'Ft', 'hex' => '&#x46;&#x74;'),
    'IDR' => array('name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'hex' => '&#x52;&#x70;'),
    'ILS' => array('name' => 'Israeli New Shekel', 'symbol' => '₪', 'hex' => '&#x20aa;'),
    'INR' => array('name' => 'Indian Rupee', 'symbol' => '₹', 'hex' => '&#x20b9;'),
    'ISK' => array('name' => 'Iceland Krona', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;'),
    'JMD' => array('name' => 'Jamaican Dollar', 'symbol' => 'J$', 'hex' => '&#x4a;&#x24;'),
    'JPY' => array('name' => 'Japanese Yen', 'symbol' => '¥', 'hex' => '&#xa5;'),
    'KRW' => array('name' => 'South-Korean Won', 'symbol' => '₩', 'hex' => '&#x20a9;'),
    'LKR' => array('name' => 'Sri Lanka Rupee', 'symbol' => '₨', 'hex' => '&#x20a8;'),
    'MAD' => array('name' => 'Moroccan Dirham', 'symbol' => '.د.م', 'hex' => '&#x2e;&#x62f;&#x2e;&#x645;'),
    'MMK' => array('name' => 'Myanmar Kyat', 'symbol' => 'K', 'hex' => '&#x4b;'),
    'MXN' => array('name' => 'Mexican Peso', 'symbol' => '$', 'hex' => '&#x24;'),
    'MYR' => array('name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'hex' => '&#x52;&#x4d;'),
    'NOK' => array('name' => 'Norwegian Kroner', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;'),
    'NZD' => array('name' => 'New Zealand Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'PAB' => array('name' => 'Panamanian Balboa', 'symbol' => 'B/.', 'hex' => '&#x42;&#x2f;&#x2e;'),
    'PEN' => array('name' => 'Peruvian Nuevo Sol', 'symbol' => 'S/.', 'hex' => '&#x53;&#x2f;&#x2e;'),
    'PHP' => array('name' => 'Philippine Peso', 'symbol' => '₱', 'hex' => '&#x20b1;'),
    'PKR' => array('name' => 'Pakistan Rupee', 'symbol' => '₨', 'hex' => '&#x20a8;'),
    'PLN' => array('name' => 'Polish Zloty', 'symbol' => 'zł', 'hex' => '&#x7a;&#x142;'),
    'RON' => array('name' => 'Romanian New Lei', 'symbol' => 'lei', 'hex' => '&#x6c;&#x65;&#x69;'),
    'RSD' => array('name' => 'Serbian Dinar', 'symbol' => 'RSD', 'hex' => '&#x52;&#x53;&#x44;'),
    'RUB' => array('name' => 'Russian Rouble', 'symbol' => 'руб', 'hex' => '&#x440;&#x443;&#x431;'),
    'SEK' => array('name' => 'Swedish Krona', 'symbol' => 'kr', 'hex' => '&#x6b;&#x72;'),
    'SGD' => array('name' => 'Singapore Dollar', 'symbol' => 'S$', 'hex' => '&#x53;&#x24;'),
    'THB' => array('name' => 'Thai Baht', 'symbol' => '฿', 'hex' => '&#xe3f;'),
    'TND' => array('name' => 'Tunisian Dinar', 'symbol' => 'DT', 'hex' => '&#x44;&#x54;'),
    'TRY' => array('name' => 'Turkish Lira', 'symbol' => 'TL', 'hex' => '&#8378;'),
    'TTD' => array('name' => 'Trinidad/Tobago Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'TWD' => array('name' => 'Taiwan Dollar', 'symbol' => 'NT$', 'hex' => '&#x4e;&#x54;&#x24;'),
    'VEF' => array('name' => 'Venezuelan Bolivar Fuerte', 'symbol' => 'Bs', 'hex' => '&#x42;&#x73;'),
    'VND' => array('name' => 'Vietnamese Dong', 'symbol' => '₫', 'hex' => '&#x20ab;'),
    'XAF' => array('name' => 'CFA Franc BEAC', 'symbol' => 'FCFA', 'hex' => '&#x46;&#x43;&#x46;&#x41;'),
    'XCD' => array('name' => 'East Caribbean Dollar', 'symbol' => '$', 'hex' => '&#x24;'),
    'XPF' => array('name' => 'CFP Franc', 'symbol' => 'F', 'hex' => '&#x46;'),
    'ZAR' => array('name' => 'South African Rand', 'symbol' => 'R', 'hex' => '&#x52;')
);