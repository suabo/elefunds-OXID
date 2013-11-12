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
    $oLfndsApi = lfndsfacade::getInstance();
    $oLfndsApi->sendDonation($this);  
    //also observe for scheduled donations and try to send API callback again
    if($this->getConfig()->getConfigParam('sLfndsObserveNewDonation')) {       
      $oLfndsApi->observeDonationState(); 
    }  
  }
}
?>