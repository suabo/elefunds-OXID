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
class lfndsdonation_main extends oxAdminDetails {

  protected $_sThisTemplate = 'lfndsdonation_main.tpl';
  
  public function render() {    
    $oConfig = $this->getConfig();
    $oViewConf = oxNew('oxviewconfig');
    $sModulePath = $oViewConf->getModulePath('suabolfnds');
    require_once($sModulePath.'core/Lfnds/Model/Donation.php');
    $sOxId = $oConfig->getRequestParameter('oxid');
    $oLfndsDonation = oxNew('suabolfnds');
    if($oLfndsDonation->load($sOxId)) {
      $this->_aViewData['edit'] = $oLfndsDonation;
      $this->_aViewData['aDonation'] = unserialize(base64_decode($oLfndsDonation->suabolfnds__lfndsdonation->value))->toArray();
    } else {
      $this->_aViewData['aTotal'] = $this->_getDonationTotal();
    }
    return parent::render();
  }
  
  public function setPaid() {
    $sOxID = $this->getConfig()->getRequestParameter('oxid');
    oxDb::getDb()->execute("UPDATE suabolfnds SET lfndsstate='scheduled_for_completion' WHERE oxid='$sOxID'");
    lfndsfacade::getInstance()->observeDonationState();
  }
  
  public function storno() {
    $sOxID = $this->getConfig()->getRequestParameter('oxid');
    oxDb::getDb()->execute("UPDATE suabolfnds SET lfndsstate='scheduled_for_cancellation' WHERE oxid='$sOxID'");
    lfndsfacade::getInstance()->observeDonationState();
  }  
  
  protected function _getDonationTotal() {
    $aTotal = array();
    $aTotal['totalDonations'] = oxDb::getDb()->getOne("SELECT count(oxid) FROM suabolfnds;");
    $aTotal['totalCompleted'] = oxDb::getDb()->getOne("SELECT count(oxid) FROM suabolfnds WHERE lfndsstate='completed';");
    $aTotal['totalPending']   = oxDb::getDb()->getOne("SELECT count(oxid) FROM suabolfnds WHERE lfndsstate='pending';");
    $aTotal['totalCancelled'] = oxDb::getDb()->getOne("SELECT count(oxid) FROM suabolfnds WHERE lfndsstate='cancelled';"); 
    return $aTotal;
  }
}
?>