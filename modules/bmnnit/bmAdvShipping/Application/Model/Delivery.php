<?php

/**
 * Author: Johannes Baumann <info@bmnnit.com>
 */

namespace Bmnnit\bmAdvShipping\Application\Model;

class Delivery extends Delivery_parent {

    /**
     * 
     * @param type $oBasket
     * @return boolean
     * 
     * Blende Versandarten nur bei best. Artikel einer Kategorie im WK ein.
     * Sind andere Artikel einer anderen Kateogrie im WK  wird die Versandart ausgeblendet.
     * 
     * Wichtig: Die Regeln werden an die Versandkostenregeln angehängt.
     * 
     */
    public function isForBasket2($oBasket) {
        
        //run parent code
        $blForBasket = parent::isForBasket($oBasket);
      
        
        $aaDeliveryLimitCategories = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('aaDeliveryLimitCategories');

        foreach ($aaDeliveryLimitCategories as $deliveryId => $aCatIdArray) {

            if ($deliveryId == $this->_sOXID) {
                
                $oBasketArticleList = $oBasket->getBasketArticles();
                if ($oBasketArticleList && count($oBasketArticleList) > 0) {
                    foreach ($oBasketArticleList as $oBasketArticle) { // gehe alle article durch 
                        $bInCat = false;

                        //artikel kann in mehreren Cats sein, wenn er in einer definierten Cat ist wird die Versandregel aktiviert.
                        foreach ($oBasketArticle->getCategoryIds() as $artcategories) { //hole die categorien für 
                            foreach ($aCatIdArray as $key => $value) {
                                if ($artcategories == $value) {
                                    $bInCat = true; //Versandkostenregel aktivieren (am Ende)
                                }
                            }
                        }

                        //ist artikel in einer definierten kategorie?
                        if ($bInCat != true) {
                            //echo $this->oxdelivery__oxtitle->rawValue . " no <br>";
                            $blForBasket = false;
                            break;
                        }
                    }
                }
            }
        }

        //echo "bmAdvShipping->isForBasket:" . $this->oxdelivery__oxtitle->rawValue . " " . $blForBasket . "<br>";
        return $blForBasket;
    }
    
    //ALTER TABLE `oxdelivery` ADD `OXEXCLRULE` TINYINT(1) NOT NULL COMMENT 'mark rule as exclusive' AFTER `OXFINALIZE`;
    public function isForBasket($oBasket) {
        
        //run parent code
        $blForBasket = parent::isForBasket($oBasket);
      
        $blHasCategories = $this->hasCategories();
        $aDeliveryCategories = $this->getCategories();
 
        //wenn die regel cateogrien hat und exclusive ist..
        //dh. die versandkostenregel ist nur gültig wenn keine anderen artikel
        //aus anderen kategorien im wk sind
        if ( $blHasCategories && $this->isExclusive() ) {
       
                $oBasketArticleList = $oBasket->getBasketArticles();
                if ($oBasketArticleList && count($oBasketArticleList) > 0) {
                    foreach ($oBasketArticleList as $oBasketArticle) { // gehe alle article durch 
                        $bInCat = false;

                        //artikel kann in mehreren Cats sein, wenn er in einer definierten Cat ist wird die Versandregel aktiviert.
                        foreach ($oBasketArticle->getCategoryIds() as $artcategories) { //hole die categorien für 
                            foreach ($aDeliveryCategories as $key => $value) {
                                if ($artcategories == $value) {
                                    $bInCat = true; //Versandkostenregel aktivieren (am Ende)
                                }
                            }
                        }

                        //ist artikel in einer definierten kategorie?
                        if ($bInCat != true) {
                            //echo $this->oxdelivery__oxtitle->rawValue . " no <br>";
                            $blForBasket = false;
                            break;
                        }
                    }
                }
        }

        //echo "bmAdvShipping->isForBasket:" . $this->oxdelivery__oxtitle->rawValue . " " . $blForBasket . "<br>";
        return $blForBasket;
    }
    
    
    public function isExclusive(){
        return $this->oxdelivery__oxexclrule->rawValue;
    }
}
