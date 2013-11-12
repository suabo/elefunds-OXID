<?php
/*
 * Elefunds OXID Shop Module
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2012 - 2013, elefunds GmbH <hello@elefunds.de>, suabo <support@suabo.de>
 * All rights reserved.
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *    
 * Author: Marcel Grolms - www.suabo.de
 */ 
class lfndsfinalizeorder extends lfndsfinalizeorder_parent {  

  /*
   * Forward incoming donations to the Elefunds API
   * while order is saved to db   
   */   
  public function finalizeOrder( oxBasket $oBasket, $oUser, $blRecalculatingOrder = false ) {        
    $this->_addLfndsArticle($oBasket);
    parent::finalizeOrder( $oBasket, $oUser, $blRecalculatingOrder);      
    $this->_sendLfndsDonation();
  }
  
  protected function _addLfndsArticle($oBasket) {
    $oLfndsHelper = lfndshelper::getInstance()->getHelper();
    if($oLfndsHelper->isActiveAndValid()) {
      $oBasketItem = $oBasket->addToBasket('lfndsdonation', $oLfndsHelper->getRoundUp());    
      $oBasket->calculateBasket();
    }    
  }
  
  protected function _sendLfndsDonation() {
    $oViewConf = oxNew('oxviewconfig');
    $sModulePath = $oViewConf->getModulePath('suabolfnds');
    require_once($sModulePath.'core/Lfnds/Model/Donation.php');
    require_once($sModulePath.'core/Lfnds/Exception/ElefundsCommunicationException.php');
    $oLfndsHelper = lfndshelper::getInstance()->getHelper();
    if($oLfndsHelper->isActiveAndValid()) {          
      $oLfndsApi = lfndsfacade::getInstance()->getFacade('success');
      $originalTotalInCent = str_replace(array(".", ","), "", round($this->oxorder__oxtotalordersum->value, 2));
      $newTotal = $originalTotalInCent + $oLfndsHelper->getRoundUp();
      $orderID = $this->getId();
      $donation = $oLfndsApi->createDonation()
          ->setForeignId($orderID)
          ->setAmount($oLfndsHelper->getRoundUp())
          ->setSuggestedAmount($oLfndsHelper->getSuggestedRoundUp())
          ->setGrandTotal($newTotal)
          ->setReceiverIds($oLfndsHelper->getReceiverIds())
          ->setAvailableReceiverIds($oLfndsHelper->getAvailableReceiverIds())
          ->setTime(new DateTime());
                
      $oCountry = oxNew('oxcountry');
      $oCountry->load($this->oxorder__oxbillcountryid->value);
      if ($oLfndsHelper->isDonationReceiptRequested()) {
          $donation->setDonator(
              $this->oxorder__oxbillemail->value,         # the customers email address
              $this->oxorder__oxbillfname->value,     # the customers first name
              $this->oxorder__oxbilllname->value,      # the customers last name
              $this->oxorder__oxbillstreet->value." ".$this->oxorder__oxbillstreetnr->value, # the customers street address (with number)
              $this->oxorder__oxbillzip->value,       # the customers zip code (as string or integer)
              $this->oxorder__oxbillcity->value,          # the customers city
              strtolower($oCountry->oxcountry__oxisoalpha2->value)    # the customers country code (e.g. 'de')
          );
      }
            
      try { // Let's add the donation to the API
          $oLfndsApi->addDonation($donation);
          $state = 'pending';
      } catch (Lfnds\Exception\ElefundsCommunicationException $exception) {          
          $state = 'scheduled'; // Something went wrong, we try again later
      }
      
      //log donation to db    
      $oLfnds = oxNew('suabolfnds');
      $oLfnds->suabolfnds__oxorderid->value = $orderID;
      $oLfnds->suabolfnds__lfndsdonation->value = base64_encode(serialize($donation));
      $oLfnds->suabolfnds__lfndsstate->value = $state;
      $oLfnds->suabolfnds__lfndstime->value = date("Y-m-d H:i:s");
      $oLfnds->save();            
    }  
  }
}
?>