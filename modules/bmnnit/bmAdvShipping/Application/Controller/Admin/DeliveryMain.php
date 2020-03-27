<?php

/**
 * Author: Johannes Baumann <info@bmnnit.com>
 */

namespace Bmnnit\bmAdvShipping\Application\Controller\Admin;

class DeliveryMain extends DeliveryMain_parent {

    
   /**
     * Das suckt, der ganze nur weil OXID extra params (checkbox) nicht sauber handeln kann 
     *
     * @return mixed
     */
    public function save()
    {
        parent::save();
        
        $oDelivery = oxNew(\OxidEsales\Eshop\Application\Model\Delivery::class);
        
        if ($soxId != "-1") {
            $oDelivery->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['oxdelivery__oxid'] = null;
        }
        
        $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");
        
        if (!isset($aParams['oxdelivery__oxexclrule'])) {
            $aParams['oxdelivery__oxexclrule'] = 0; // --> WTF?
        }
        
        $oDelivery->setLanguage(0);
        $oDelivery->assign($aParams);
        $oDelivery->setLanguage($this->_iEditLang);
        $oDelivery = \OxidEsales\Eshop\Core\Registry::getUtilsFile()->processFiles($oDelivery);
        $oDelivery->save();
    }
}