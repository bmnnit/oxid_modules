<?php
namespace Bmnnit\bmAdvShipping\Core;

use oxDb;

class Events {

    public static function onActivate() {
        
        $sExclRule = "ALTER TABLE `oxdelivery` ADD `OXEXCLRULE` TINYINT(1) NOT NULL COMMENT 'mark rule as exclusive' AFTER `OXFINALIZE`;";

        oxDb::getDb()->execute($sExclRule);
    }
}