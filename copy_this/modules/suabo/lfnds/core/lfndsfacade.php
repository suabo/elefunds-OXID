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
use Lfnds\Facade;
use Lfnds\Template\Shop\CheckoutConfiguration;
use Lfnds\Template\Shop\CheckoutSuccessConfiguration;
class lfndsfacade {

  protected $_oLfndsApi = null;
  protected static $instance = null;
  public function __construct($sMode = '') { $this->instance = $this; }
  public static function getInstance($sMode = '') {
    if($instance === null) $instance = new lfndsfacade($sMode);
    return $instance;
  }
  
  public function getFacade($sMode = '', $sForeignId = '') {
    if($this->_oLfndsApi !== null) return $this->_oLfndsApi;
    $myconfig = oxConfig::getInstance();
    $oViewConf = oxNew('oxviewconfig');
    $sModulePath = $oViewConf->getModulePath('suabolfnds');    
    $oUser = oxSession::getInstance()->getUser();
    ($oUser->getLanguage() == 0 || $oUser->getLanguage() == -1) ? $sCountryCode = 'de' : $sCountryCode = 'en';  
    $sClientId = $myconfig->getConfigParam("sLfndsClientID");
    $sApiKey = $myconfig->getConfigParam("sLfndsApiKey");
    $sTheme = $myconfig->getConfigParam("sLfndsTheme");
    $sThemeColor = $myconfig->getConfigParam("sLfndsThemeColor");
    $sRowContainer = $myconfig->getConfigParam("sLfndsRowContainer");
    $sRowLabel = $myconfig->getConfigParam("sLfndsRowLabel");
    $sRowValue = $myconfig->getConfigParam("sLfndsRowValue");
    $sFooterSelector = $myconfig->getConfigParam("sLfndsFooterSelector");
    $sTotalSelector = $myconfig->getConfigParam("sLfndsTotalSelector");
    require_once($sModulePath.'core/Lfnds/Template/Shop/CheckoutConfiguration.php');
    require_once($sModulePath.'core/Lfnds/Template/Shop/CheckoutSuccessConfiguration.php');    
    require_once($sModulePath.'core/Lfnds/Facade.php');
    if($sMode == 'success' || $sMode == 'social-share') {
      $oCheckoutConfig = new CheckoutSuccessConfiguration();
      $this->_oLfndsApi = new Facade($oCheckoutConfig);
      $this->_oLfndsApi->getConfiguration()
          ->setClientId($sClientId)
          ->setApiKey($sApiKey);      
      if($sMode == 'social-share' && $sForeignId != '') {      
        $this->_oLfndsApi->getConfiguration()
            ->setCountrycode($sCountryCode)
            ->getView()
            ->assign('foreignId', $sForeignId);
      }                
    } else {
      $oBasket = oxSession::getInstance()->getBasket();
      $oCheckoutConfig = new CheckoutConfiguration();
      $oCheckoutConfig->setClientId($sClientId)
          ->setCountrycode($sCountryCode);
      $this->_oLfndsApi = new Facade($oCheckoutConfig);    
      $this->_oLfndsApi->getConfiguration()
          ->getView()        
          ->assign('skin',
              array(
                  'theme' => $sTheme,
                  'color' => $sThemeColor,
                  'orientation' => 'horizontal',
              ) )
          ->assign('sumExcludingDonation', $oBasket->getPrice()->getBruttoPrice() * 100)
          ->assign('rowContainer', $sRowContainer)
          ->assign('rowLabel', $sRowLabel)
          ->assign('rowValue', $sRowValue)
          ->assign('formSelector', $sFooterSelector)        
          ->assign('totalSelector', $sTotalSelector);
    }
    return $this->_oLfndsApi;
  }
  
  public function sendDonation($oOrder) {
    $oViewConf = oxNew('oxviewconfig');
    $sModulePath = $oViewConf->getModulePath('suabolfnds');
    require_once($sModulePath.'core/Lfnds/Model/Donation.php');
    require_once($sModulePath.'core/Lfnds/Exception/ElefundsCommunicationException.php');
    $oLfndsHelper = lfndshelper::getInstance()->getHelper();
    if($oLfndsHelper->isActiveAndValid()) {          
      $oLfndsApi = $this->getFacade('success');
      $originalTotalInCent = str_replace(array(".", ","), "", round($oOrder->oxorder__oxtotalordersum->value, 2));
      $newTotal = $originalTotalInCent + $oLfndsHelper->getRoundUp();
      $orderID = $oOrder->getId();
      $donation = $oLfndsApi->createDonation()
          ->setForeignId($orderID)
          ->setAmount($oLfndsHelper->getRoundUp())
          ->setSuggestedAmount($oLfndsHelper->getSuggestedRoundUp())
          ->setGrandTotal($newTotal)
          ->setReceiverIds($oLfndsHelper->getReceiverIds())
          ->setAvailableReceiverIds($oLfndsHelper->getAvailableReceiverIds())
          ->setTime(new DateTime());
                
      $oCountry = oxNew('oxcountry');
      $oCountry->load($oOrder->oxorder__oxbillcountryid->value);
      if ($oLfndsHelper->isDonationReceiptRequested()) {
          $donation->setDonator(
              $oOrder->oxorder__oxbillemail->value,         # the customers email address
              $oOrder->oxorder__oxbillfname->value,     # the customers first name
              $oOrder->oxorder__oxbilllname->value,      # the customers last name
              $oOrder->oxorder__oxbillstreet->value." ".$oOrder->oxorder__oxbillstreetnr->value, # the customers street address (with number)
              $oOrder->oxorder__oxbillzip->value,       # the customers zip code (as string or integer)
              $oOrder->oxorder__oxbillcity->value,          # the customers city
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
  
  public function observeDonationState() {
    $oViewConf = oxNew('oxviewconfig');
    $sModulePath = $oViewConf->getModulePath('suabolfnds');
    require_once($sModulePath.'core/Lfnds/Model/Donation.php');
    require_once($sModulePath.'core/Lfnds/Exception/ElefundsCommunicationException.php');
    $pendingDonations = array();
    $cancelledDonations = array();
    $completedDonations = array();
    $oList = oxNew('oxlist');
    $oList->init('suabolfnds');
    $oList->selectString("SELECT * FROM suabolfnds WHERE lfndsstate!='completed' AND lfndsstate!='cancelled';");
    foreach($oList as $oLfndDonation) {
      $oDonation = unserialize(base64_decode($oLfndDonation->suabolfnds__lfndsdonation->value));
      $sOxId = $oLfndDonation->getId();        
      switch ($oLfndDonation->suabolfnds__lfndsstate->value) {            
        case 'pending':
          $sObserveTrigger = oxConfig::getInstance()->getConfigParam('sLfndsObserveTrigger');
          $sOrderId = $oLfndDonation->suabolfnds__oxorderid->value;
          $sOTV = oxDb::getDb()->getOne("SELECT $sObserveTrigger FROM oxorder WHERE oxid='$sOrderId';");
          if(isset($sOTV) && !empty($sOTV) && $sOTV != '0000-00-00 00:00:00') { $completedDonations[$sOxId] = $oDonation; }
        break;
        case 'scheduled':
          $pendingDonations[$sOxId] = $oDonation;
        break;
        case 'scheduled_for_cancellation':
          $cancelledDonations[$sOxId] = $oDonation;
        break;
        case 'scheduled_for_completion':
          $completedDonations[$sOxId] = $oDonation;
        break;
      }
    }    
    $failedPending = array();
    $failedCancelled = array();
    $failedCompleted = array();
    
    // Add scheduled donations
    $oLfndsApi = $this->getFacade('success');
    try {      
      $oLfndsApi->addDonations($pendingDonations);
      $blSuccess = true;
    } catch (\Lfnds\Exception\ElefundsCommunicationException $exception) {
      $blSuccess = false;
    }
    foreach($pendingDonations as $sDonationId => $oDonation ) {
      $oLfndDonation = oxNew('suabolfnds');
      $oLfndDonation->load($sDonationId);
      if($blSuccess) $aParam['suabolfnds__lfndsstate'] = 'pending';
      else $aParam['suabolfnds__lfndsstate'] = 'scheduled';
      $oLfndDonation->assign($aParam);        
      $oLfndDonation->save();
    }
    
    // Cancel donations
    try {
      $oLfndsApi->cancelDonations($cancelledDonations);
      $blSuccess = true;
    } catch (\Lfnds\Exception\ElefundsCommunicationException $exception) {
      $blSuccess = false;
    }
    foreach($cancelledDonations as $sDonationId => $oDonation ) {
      $oLfndDonation = oxNew('suabolfnds');
      $oLfndDonation->load($sDonationId);
      if($blSuccess) $aParam['suabolfnds__lfndsstate'] = 'cancelled';
      else $aParam['suabolfnds__lfndsstate'] = 'scheduled_for_cancellation';
      $oLfndDonation->assign($aParam);        
      $oLfndDonation->save();
    }
    
    // Verify donation
    try {
      $oLfndsApi->completeDonations($completedDonations);
      $blSuccess = true;
    } catch (\Lfnds\Exception\ElefundsCommunicationException $exception) {
      $blSuccess = false;
    }
    foreach($completedDonations as $sDonationId => $oDonation ) {
      $oLfndDonation = oxNew('suabolfnds');
      $oLfndDonation->load($sDonationId);
      if($blSuccess) $aParam['suabolfnds__lfndsstate'] = 'completed';
      else $aParam['suabolfnds__lfndsstate'] = 'scheduled_for_completion';
      $oLfndDonation->assign($aParam);
      $oLfndDonation->save();
    }
    if(oxConfig::getParameter('cron')) { echo "Finished sync of Elefunds donation state.\n";exit(); }
  }    
}
?>