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
$sMetadataVersion = '1.1';
$aModule = array(
    'id'           => 'suabolfnds',
    'title'        => 'Elefunds',
    'description'  => array(
        'de' => 'Runde deinen zu zahlenden Betrag auf und bestimme somit die Höhe deiner Spende. Verteile diese Differenz an eine oder mehrere gemeinnützige Organisationen deiner Wahl. Begeistere deine Freunde auf Facebook & Twitter und werde so selbst zum Fundraiser.<br><br> OXID Modul entwickelt von:<br><a href="mailto:grolms@suabo.de">Marcel Grolms - suabo</a><br><a href="http://www.suabo.de">www.suabo.de</a>',
        'en' => '<br><br> OXID Modul development by:<br><a href="mailto:grolms@suabo.de">Marcel Grolms - suabo</a><br><a href="http://www.suabo.de">www.suabo.de</a>',
    ),
    'thumbnail'    => 'out/src/img/elefunds_Logo.png',
    'version'      => '1.0.0',
    'author'       => 'Marcel Grolms - suabo',
    'url'          => 'http://www.elefunds.de',
    'email'        => 'hello@elefunds.de',
    'extend'       => array(
        'order'     => 'suabo/lfnds/controllers/lfndsorder',
        'oxorder'   => 'suabo/lfnds/core/lfndsfinalizeorder',
        'thankyou'  => 'suabo/lfnds/controllers/lfndsthankyou',
        'oxorderarticle' => 'suabo/lfnds/core/lfndsorderarticle',
        'order_list' => 'suabo/lfnds/controllers/admin/lfndsdonationobserver',
        'navigation' => 'suabo/lfnds/controllers/admin/lfndsdonationobserver',
    ),
    'files' => array(
        'suabolfnds'    => 'suabo/lfnds/core/suabolfnds.php',
        'lfndsfacade'   => 'suabo/lfnds/core/lfndsfacade.php',
        'lfndshelper'   => 'suabo/lfnds/core/lfndshelper.php',
        'lfndssetup'    => 'suabo/lfnds/setup/lfndssetup.php',
        'lfndsdonation' => 'suabo/lfnds/controllers/admin/lfndsdonation.php',
        'lfndsdonation_main' => 'suabo/lfnds/controllers/admin/lfndsdonation_main.php',
        'lfndsdonation_list' => 'suabo/lfnds/controllers/admin/lfndsdonation_list.php',
    ),
    'templates' => array(
      'lfndsdonation.tpl' => 'suabo/lfnds/views/admin/tpl/lfndsdonation.tpl',
      'lfndsdonation_main.tpl' => 'suabo/lfnds/views/admin/tpl/lfndsdonation_main.tpl',
      'lfndsdonation_list.tpl' => 'suabo/lfnds/views/admin/tpl/lfndsdonation_list.tpl',
    ),
    'blocks' => array(
        array('template' => 'widget/sidebar/partners.tpl',  'block' => 'partner_logos',           'file' => '/views/blocks/lfndspartnerbox.tpl'),
        array('template' => 'page/checkout/order.tpl',      'block' => 'shippingAndPayment',      'file' => '/views/blocks/lfndsdonation.tpl'),        
        array('template' => 'layout/base.tpl',              'block' => 'base_style',              'file' => '/views/blocks/lfndsbasecss.tpl'),
        array('template' => 'layout/base.tpl',              'block' => 'base_js',                 'file' => '/views/blocks/lfndsbasejs.tpl'),
        array('template' => 'page/checkout/thankyou.tpl',   'block' => 'checkout_thankyou_info',  'file' => '/views/blocks/lfndscheckoutthankyouinfo.tpl'),        
    ),
   'settings' => array(
        array('group' => 'lfndsmain',   'name' => 'sLfndsClientID',       'type' => 'str',    'value' => ''),
        array('group' => 'lfndsmain',   'name' => 'sLfndsApiKey',         'type' => 'str',    'value' => ''),        
        array('group' => 'lfndstheme',  'name' => 'sLfndsTheme',          'type' => 'select', 'value' => 'light', 'constraints' => 'light|dark' ),
        array('group' => 'lfndstheme',  'name' => 'sLfndsThemeColor',     'type' => 'str',    'value' => '#FFFFFF'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsJQueryInclude',  'type' => 'bool',   'value' => 'false'),        
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowContainer',   'type' => 'str',    'value' => '#basketSummary tr:nth-child(4)'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowLabel',       'type' => 'str',    'value' => 'th'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowValue',       'type' => 'str',    'value' => 'td'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsFooterSelector', 'type' => 'str',    'value' => '#orderConfirmAgbBottom'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsTotalSelector',  'type' => 'str',    'value' => '#basketGrandTotal'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObservrDonationList',  'type' => 'bool', 'value' => 'false'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveOrderList',     'type' => 'bool', 'value' => 'true'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveHome',          'type' => 'bool', 'value' => 'false'),        
    ),
    'events'       => array(
        'onActivate'   => 'lfndssetup::onActivate',
        'onDeactivate' => 'lfndssetup::onDeactivate'
    ),    
);