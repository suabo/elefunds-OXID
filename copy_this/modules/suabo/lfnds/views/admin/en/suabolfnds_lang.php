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

$sLangName  = "English";

// -------------------------------
// RESOURCE IDENTIFIER = STRING
// -------------------------------
$aLang = array(
    'charset'                                 => "UTF-8",    
    'SHOP_MODULE_GROUP_lfndsmain'             => 'API Settings',
    'SHOP_MODULE_GROUP_lfndstheme'            => 'Theme',
    'SHOP_MODULE_GROUP_lfndscustom'           => 'Custom Integration',
    'SHOP_MODULE_GROUP_lfndsobserver'         => 'Donationstate Observation',
    'SHOP_MODULE_sLfndsClientID'              => 'ClientID',
    'SHOP_MODULE_sLfndsApiKey'                => 'ApiKey',
    'SHOP_MODULE_sLfndsTheme'                 => 'Theme',
    'SHOP_MODULE_sLfndsThemeColor'            => 'Theme Color',    
    'SHOP_MODULE_sLfndsJQueryInclude'         => 'Load JQuery 1.10.2 from Google',
    'SHOP_MODULE_sLfndsRowContainer'          => 'jQuery-Selector of delivery layer',
    'SHOP_MODULE_sLfndsRowLabel'              => 'jQuery-Selector of delivery label ',
    'SHOP_MODULE_sLfndsRowValue'              => 'jQuery-Selector of delivery price',    
    'SHOP_MODULE_sLfndsFooterSelector'        => 'jQuery-Selector of the form in last checkout step',
    'SHOP_MODULE_sLfndsTotalSelector'         => 'jQuery-Selector of grand total',    
    'SHOP_MODULE_sLfndsTheme_light'           => 'light',
    'SHOP_MODULE_sLfndsTheme_dark'            => 'dark',
    'SHOP_MODULE_sLfndsObserveTrigger'        => 'Auto. trigger donation, which order got following state set.',
    'SHOP_MODULE_sLfndsObserveTrigger_oxpaid' => 'paid (paid date set)',
    'SHOP_MODULE_sLfndsObserveTrigger_oxsenddate' => 'delivery (delivery date set)',
    'SHOP_MODULE_sLfndsObserveNewDonation'    => 'New Donation',
    'SHOP_MODULE_sLfndsObserveDonationList'   => 'Donation Overview',
    'SHOP_MODULE_sLfndsObserveOrderList'      => 'Order Overview',
    'SHOP_MODULE_sLfndsObserveHome'           => 'Home(backend start page)',    
    
    'mxlfndsdonation'                         => 'elefunds Donations',
    'tbclshop_lfndsdonation'                  => 'Donation Details',
    'MODULE_SUABOLFNDS_TITLE'                 => 'elefunds',
    'MODULE_SUABOLFNDS_TITLE_SUBITEM'         => 'Donations',
    'MODULE_SUABOLFNDS_STATE_TITLE'           => 'elefunds State',
    'MODULE_SUABOLFNDS_STATE'                 => 'all',
    'MODULE_SUABOLFNDS_STATE_PENDING'         => 'pending',
    'MODULE_SUABOLFNDS_STATE_CANCELLED'       => 'cancelled',
    'MODULE_SUABOLFNDS_STATE_COMPLETE'        => 'complete',
    'MODULE_SUABOLFNDS_TIME'                  => 'Date',
    'MODULE_SUABOLFNDS_DONATION'              => 'Orderobject',
    'MODULE_SUABOLFNDS_ORDER'                 => 'OrderID',    
    'MODULE_SUABOLFNDS_foreignId'             => 'ID of order',
    'MODULE_SUABOLFNDS_donationTimestamp'     => 'Date of donation',
    'MODULE_SUABOLFNDS_donationAmount'        => 'Donation in cent',
    'MODULE_SUABOLFNDS_receivers'             => 'ID of donation receiver',
    'MODULE_SUABOLFNDS_receiversAvailable'    => 'ID of all possible donation receiver',
    'MODULE_SUABOLFNDS_donator'               => 'Donator',
    'MODULE_SUABOLFNDS_grandTotal'            => 'Grand Total',
    'MODULE_SUABOLFNDS_donationAmountSuggested' => 'Suggested Donation Amount',
    
    'MODULE_SUABOLFNDS_TOTAL_DONATIONS'           => 'elefunds Donation Overview',
    'MODULE_SUABOLFNDS_TOTAL_DONATIONS_TOTAL'     => 'Total',
    'MODULE_SUABOLFNDS_TOTAL_DONATIONS_COMPLETED' => 'Complete',
    'MODULE_SUABOLFNDS_TOTAL_DONATIONS_PENDING'   => 'Payment pending',
    'MODULE_SUABOLFNDS_TOTAL_DONATIONS_CANCELLED' => 'Cancelled',
    
    'MODULE_SUABOLFNDS_BUTTON_PAID'         => 'Set donation paid now',
    'MODULE_SUABOLFNDS_BUTTON_STORNO'       => 'Cancel donation',
    'MODULE_SUABOLFNDS_BUTTON_INFO'         => 'If you cancel an donation here you will have to manually remove the donation article from the order.',
    'MODULE_SUABOLFNDS_INVOICE_INFO'        => 'Your donation is processed by the elefunds Foundation gUG which forwards 100% to your chosen charities.',
    'MODULE_SUABOLFNDS_INVOICE_INFO2'       => '',
);
