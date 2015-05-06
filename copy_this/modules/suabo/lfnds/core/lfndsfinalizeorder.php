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
      $oBasketItem = $oBasket->addToBasket('lfndsdonation', "1");
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
  
  public function getLfndsDonation() {
    $sOxId = oxDb::getDb()->getOne("SELECT oxid FROM suabolfnds WHERE oxorderid='".$this->getId()."'");
    $oDonation = oxNew('suabolfnds');
    if($oDonation->load($sOxId)) return $oDonation;   
  }
  
  /* PDF Generation */
  public function exportStandart( $oPdf ) {
      $oDonation = $this->getLfndsDonation();      
      if(!$oDonation || $oDonation->suabolfnds__lfndsstate->value == "cancelled") return parent::exportStandart($oPdf);
      /* This is sutipd, because the h position can't be read so we can't add information here after parent is executed :( */
      // preparing order curency info
      $myConfig = $this->getConfig();
      $oPdfBlock = new PdfBlock();

      $this->_oCur = $myConfig->getCurrencyObject( $this->oxorder__oxcurrency->value );
      if ( !$this->_oCur ) {
          $this->_oCur = $myConfig->getActShopCurrencyObject();
      }

      // loading active shop
      $oShop = $this->_getActShop();

      // shop information
      $oPdf->setFont( $oPdfBlock->getFont(), '', 6 );
      $oPdf->text( 15, 55, $oShop->oxshops__oxname->getRawValue().' - '.$oShop->oxshops__oxstreet->getRawValue().' - '.$oShop->oxshops__oxzip->value.' - '.$oShop->oxshops__oxcity->getRawValue() );

      // billing address
      $this->_setBillingAddressToPdf( $oPdf );

      // delivery address
      if ( $this->oxorder__oxdelsal->value ) {
          $this->_setDeliveryAddressToPdf( $oPdf );
      }

      // loading user
      $oUser = oxNew( 'oxuser' );
      $oUser->load( $this->oxorder__oxuserid->value );

      // user info
      $sText = $this->translate( 'ORDER_OVERVIEW_PDF_FILLONPAYMENT' );
      $oPdf->setFont( $oPdfBlock->getFont(), '', 5 );
      $oPdf->text( 195 - $oPdf->getStringWidth( $sText ), 55, $sText );

      // customer number
      $sCustNr = $this->translate( 'ORDER_OVERVIEW_PDF_CUSTNR').' '.$oUser->oxuser__oxcustnr->value;
      $oPdf->setFont( $oPdfBlock->getFont(), '', 7 );
      $oPdf->text( 195 - $oPdf->getStringWidth( $sCustNr ), 59, $sCustNr );

      // setting position if delivery address is used
      if ( $this->oxorder__oxdelsal->value ) {
          $iTop = 115;
      } else {
          $iTop = 91;
      }

      // shop city
      $sText = $oShop->oxshops__oxcity->getRawValue().', '.date( 'd.m.Y', strtotime($this->oxorder__oxbilldate->value ) );
      $oPdf->setFont( $oPdfBlock->getFont(), '', 10 );
      $oPdf->text( 195 - $oPdf->getStringWidth( $sText ), $iTop + 8, $sText );

      // shop VAT number
      if ( $oShop->oxshops__oxvatnumber->value ) {
          $sText = $this->translate( 'ORDER_OVERVIEW_PDF_TAXIDNR' ).' '.$oShop->oxshops__oxvatnumber->value;
          $oPdf->text( 195 - $oPdf->getStringWidth( $sText ), $iTop + 12, $sText );
          $iTop += 8;
      } else {
          $iTop += 4;
      }

      // invoice number
      $sText = $this->translate( 'ORDER_OVERVIEW_PDF_COUNTNR' ).' '.$this->oxorder__oxbillnr->value;
      $oPdf->text( 195 - $oPdf->getStringWidth( $sText ), $iTop + 8, $sText );

      // marking if order is canceled
      if ( $this->oxorder__oxstorno->value == 1 ) {
          $this->oxorder__oxordernr->setValue( $this->oxorder__oxordernr->getRawValue() . '   '.$this->translate( 'ORDER_OVERVIEW_PDF_STORNO' ), oxField::T_RAW );
      }

      // order number
      $oPdf->setFont( $oPdfBlock->getFont(), '', 12 );
      $oPdf->text( 15, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_PURCHASENR' ).' '.$this->oxorder__oxordernr->value );

      // order date
      $oPdf->setFont( $oPdfBlock->getFont(), '', 10 );
      $aOrderDate = explode( ' ', $this->oxorder__oxorderdate->value );
      $sOrderDate = oxRegistry::get("oxUtilsDate")->formatDBDate( $aOrderDate[0]);
      $oPdf->text( 15, $iTop + 8, $this->translate( 'ORDER_OVERVIEW_PDF_ORDERSFROM' ).$sOrderDate.$this->translate( 'ORDER_OVERVIEW_PDF_ORDERSAT' ).$oShop->oxshops__oxurl->value );
      $iTop += 16;

      // product info header
      $oPdf->setFont( $oPdfBlock->getFont(), '', 8 );
      $oPdf->text( 15, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_AMOUNT' ) );
      $oPdf->text( 30, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_ARTID' ) );
      $oPdf->text( 45, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_DESC' ) );
      $oPdf->text( 135, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_VAT' ) );
      $oPdf->text( 148, $iTop, $this->translate( 'ORDER_OVERVIEW_PDF_UNITPRICE' ) );
      $sText = $this->translate( 'ORDER_OVERVIEW_PDF_ALLPRICE' );
      $oPdf->text( 195 - $oPdf->getStringWidth( $sText ), $iTop, $sText );

      // separator line
      $iTop += 2;
      $oPdf->line( 15, $iTop, 195, $iTop );

      // #345
      $siteH = $iTop;
      $oPdf->setFont( $oPdfBlock->getFont(), '', 10 );

      // order articles
      $this->_setOrderArticlesToPdf( $oPdf, $siteH, true );

      // generating pdf file
      $oArtSumm = new PdfArticleSummary( $this, $oPdf );
      $iHeight = $oArtSumm->generate( $siteH );
      if ( $siteH + $iHeight > 258 ) {
          $this->pdfFooter( $oPdf );
          $iTop = $this->pdfHeader( $oPdf );
          $oArtSumm->ajustHeight( $iTop - $siteH );
          $siteH = $iTop;
      }

      $oArtSumm->run( $oPdf );
      $siteH += $iHeight + 8;
                      
      //insert elefunds disclaimer                          
      $oPdf->text( 15, $siteH, $this->translate( 'MODULE_SUABOLFNDS_INVOICE_INFO' ) );
      $siteH += 4;
      $oPdf->text( 15, $siteH, $this->translate( 'MODULE_SUABOLFNDS_INVOICE_INFO2' ) );
      $siteH += 8;    

      $oPdf->text( 15, $siteH, $this->translate( 'ORDER_OVERVIEW_PDF_GREETINGS' ) );
  }    
}
?>