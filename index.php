<?php

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

require_once("./vendor/autoload.php");

$numbers = ["1352120000", "5352120000", "05352120000", "+905352120000", "905352120000", "+395352120000",  "+393275506507", "+495352120000",
    "+49535120000", "+4953512000011", "0-535-212-00-00", "(535) 212 00 00", "535 212 0000", "+1323232323","53521200", ];
$lib = PhoneNumberUtil::getInstance();
foreach ($numbers as $number) {
    $num = $lib->parse($number, "TR");
    $countryRegionCode = $lib->getRegionCodeForCountryCode($num->getCountryCode());
    $regionMetadata  = $lib->getMetadataForRegion($countryRegionCode);
    $mobile_code_pattern = $regionMetadata->getMobile()->getNationalNumberPattern();
    $matchIsMobile = preg_match("/".$mobile_code_pattern."/", $num->getNationalNumber(), $matches);
    echo sprintf("[%s] number country: [%s] with national: %s and int: %s isValid:%b Country: %s isMobile: %b\n",
        $number, $num->getCountryCode(), $num->getNationalNumber(), $lib->format($num, PhoneNumberFormat::E164),
        (bool)$lib->isValidNumber($num), $countryRegionCode , (bool)$matchIsMobile);
    /*
    var_export($num);
    var_export($countryRegionCode);
    var_export($lib->getMetadataForRegion("TR")->hasMobile());
    var_export($lib->getMetadataForRegion($lib->getRegionCodeForCountryCode($num->getCountryCode()))->getMobile());
    var_export($matchIsMobile);
    var_export($matches);


    break;
    */
}

/**
* Sample output
[5352120000] number country: [90] with national: 5352120000 and int: +905352120000
[05352120000] number country: [90] with national: 5352120000 and int: +905352120000
[+905352120000] number country: [90] with national: 5352120000 and int: +905352120000
[905352120000] number country: [90] with national: 5352120000 and int: +905352120000
[+395352120000] number country: [39] with national: 5352120000 and int: +395352120000
[+495352120000] number country: [49] with national: 5352120000 and int: +495352120000
[+49535120000] number country: [49] with national: 535120000 and int: +49535120000
[+4953512000011] number country: [49] with national: 53512000011 and int: +4953512000011
[0-535-212-00-00] number country: [90] with national: 5352120000 and int: +905352120000
[(535) 212 00 00] number country: [90] with national: 5352120000 and int: +905352120000
[535 212 0000] number country: [90] with national: 5352120000 and int: +905352120000
 */