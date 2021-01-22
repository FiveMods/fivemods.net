<?php

require_once('geo.class.php');

$geoplugin = new geoPlugin();
// If we wanted to change the base currency, we would uncomment the following line
// $geoplugin->currency = 'EUR';

$geoplugin->locate();

$ip = $geoplugin->ip;
$city = $geoplugin->city;
$region = $geoplugin->region;
$regionCode = $geoplugin->regionCode;
$regionName = $geoplugin->regionName;
$dmaCode = $geoplugin->dmaCode;
$countryName = $geoplugin->countryName;
$countryCode = $geoplugin->countryCode;
$inEU = $geoplugin->inEU;
$euVATrate = $geoplugin->euVATrate;
$latitude = $geoplugin->latitude;
$longitude = $geoplugin->longitude;
$locationAccuracyRadius = $geoplugin->locationAccuracyRadius;
$timezone = $geoplugin->timezone;
$currencyCode = $geoplugin->currencyCode;
$currencySymbol = $geoplugin->currencySymbol;
$currencyConverter = $geoplugin->currencyConverter;

?>