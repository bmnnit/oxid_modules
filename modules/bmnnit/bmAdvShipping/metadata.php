<?php

$sMetadataVersion = '2.0';

define("BMADVSHIPPING_PLUGIN_VERSION", "0.0.1");

/**
 * Module information
 */
$aModule = array(
    'id' => 'bmadvshipping',
    'title' => '[BM] Advanced Shipping',
    'description' => 'Blende Versandarten nur bei best. Artikel im WK ein',
    'thumbnail' => '_BmnnIT_3_65px_high.png',
    'version' => BMADVSHIPPING_PLUGIN_VERSION,
    'author' => 'Johannes Baumann',
    'email' => 'info@bmmnit.com',
    'url' => 'https://www.bmnnit.com',
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\Delivery::class => Bmnnit\bmAdvShipping\Application\Model\Delivery::class
    )

);
