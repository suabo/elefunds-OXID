<?php
/*
 * elefunds OXID Shop Module
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
    'title'        => 'elefunds',
    'description'  => array(
        'de' => '
Runde deinen zu zahlenden Betrag auf und bestimme somit die Höhe deiner Spende. 
Verteile diese Differenz an eine oder mehrere gemeinnützige Organisationen deiner Wahl. 
Begeistere deine Freunde auf Facebook & Twitter und werde so selbst zum Fundraiser.<br><br> 
<a href="https://elefunds.de/produkt/anmeldung/" target="_blank">Zugangsdaten bei elefunds anfordern</a>
<br><br>
<strong>Hinweis für eigene Themes:</strong><br>
Die Voreinstellungen unter Angepasste Integration in den Einstellungen ist für das Standard OXID Theme azure.
Wenn Sie ein anderes Theme nutzen müssen Sie diese Einstellung anpassen. Weitere Informationen hierzu finden Sie
<a href="https://github.com/elefunds/elefunds-SDK/blob/master/Documentation/Shops/JavaScriptFrontend.md" target="_blank">hier</a>.
<br><br>
OXID Modul entwickelt von:<br>
<a href="mailto:grolms@suabo.de">Marcel Grolms - suabo</a><br>
<a href="http://www.suabo.de" target="_blank">www.suabo.de</a>',
        'en' => '
<strong>Benefits for shopowners are:</strong><br>
<ul>
<li>High Brand Values of charity partners establishes trust</li>
<li>Highly positive awareness effects for social engagement</li>
<li>Positive emotional Marketing and Brand exposure</li>
<li>Referral marketing and new customer acquisition via social media</li>
<li>Increase in customer lifetime value due to referrals & returning customers</li>
<li>Sustainable and efficient marketing tool with no follow up costs</li>
</ul><br><br>
<a href="https://elefunds.de/produkt/anmeldung/" target="_blank">Register for elefunds API here</a>
<br><br>
<strong>Notice for own themes:</strong><br>
The default Settings for are for the OXID theme azure.
If you use an other theme you might need to change these values. 
More information about the <a href="https://github.com/elefunds/elefunds-SDK/blob/master/Documentation/Shops/JavaScriptFrontend.md" target="_blank">setting parameter</a>.
<br><br> OXID Modul development by:<br><a href="mailto:grolms@suabo.de">Marcel Grolms - suabo</a><br><a href="http://www.suabo.de" target="_blank">www.suabo.de</a>',
    ),
    'thumbnail'    => 'out/src/img/elefunds_Logo.png',
    'version'      => '1.0.1',
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
        array('template' => 'email/html/order_cust.tpl',    'block' => 'email_html_order_cust_paymentinfo', 'file' => '/views/blocks/lfndsdisclaimer.tpl'),        
    ),
   'settings' => array(
        array('group' => 'lfndsmain',   'name' => 'sLfndsClientID',       'type' => 'str',    'value' => '1001'),
        array('group' => 'lfndsmain',   'name' => 'sLfndsApiKey',         'type' => 'str',    'value' => 'ay3456789gg234561234'),        
        array('group' => 'lfndstheme',  'name' => 'sLfndsTheme',          'type' => 'select', 'value' => 'light', 'constraints' => 'light|dark' ),
        array('group' => 'lfndstheme',  'name' => 'sLfndsThemeColor',     'type' => 'str',    'value' => '#FFFFFF'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsJQueryInclude',  'type' => 'bool',   'value' => 'false'),        
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowContainer',   'type' => 'str',    'value' => '#basketSummary tr:nth-child(4)'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowLabel',       'type' => 'str',    'value' => 'th'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsRowValue',       'type' => 'str',    'value' => 'td'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsFooterSelector', 'type' => 'str',    'value' => '#orderConfirmAgbBottom'),
        array('group' => 'lfndscustom', 'name' => 'sLfndsTotalSelector',  'type' => 'str',    'value' => '#basketGrandTotal'),        
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveNewDonation',   'type' => 'bool', 'value' => 'true'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveDonationList',  'type' => 'bool', 'value' => 'false'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveOrderList',     'type' => 'bool', 'value' => 'true'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveHome',          'type' => 'bool', 'value' => 'false'),
        array('group' => 'lfndsobserver', 'name' => 'sLfndsObserveTrigger',       'type' => 'select', 'value' => 'oxpaid', 'constraints' => 'oxpaid|oxsenddate' ),
    ),
    'events'       => array(
        'onActivate'   => 'lfndssetup::onActivate',
        'onDeactivate' => 'lfndssetup::onDeactivate'
    ),    
);
