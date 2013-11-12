<?php
/*
 * Cronscript für OXID Backend
 *
 * The MIT License (MIT)
 * 
 * Copyright (c) 2013, suabo <support@suabo.de>
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
$iSleepTime = 5;
$AdminUrl = "http://www.your-shop.de/admin/index.php";
$aLogin   = array( 
              "user" => "", 
              "pwd" => "" 
              );
/* - - - - - - - - - - do not edit below this line - - - - - - - - - - - - - - */
$aData    = array(
  "cl" => "lfndsdonation_list",
  "cron" => "1"
);
$aLogin["cl"] = "login";
$aLogin["fnc"] = "checklogin";
$aLogin["chlanguage"] = "0";
$aLogin["profile"] = "0";
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
curl_setopt($ch, CURLOPT_URL, $AdminUrl);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
if(preg_match(@'/<input type="hidden" name="stoken" value="([^\"]*)"/', $response, $aHits)) $sToken = $aHits[1];
if(preg_match(@'/<input type="hidden" name="force_admin_sid" value="([^\"]*)"/', $response, $aHits)) $sSID = $aHits[1];
echo date("Y-m-d H:i:s")." : OXID Backend Cronjob stoken=$sToken adminSID=$sSID wird ausgeführt.\n";
$aLogin["stoken"] = $sToken; // add stoken
$aLogin["force_admin_sid"] = $sSID; // add adminSID
curl_setopt($ch, CURLOPT_POST, true); // set to post mode
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aLogin) );
$response = curl_exec($ch); // do login
//Now we are logged in
$aData["stoken"] = $sToken; // attach stoken to post request
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData) );
$response = curl_exec($ch);
echo $response;
//close curl connection
curl_close($ch);
echo date("Y-m-d H:i:s")." : OXID Backend Cronjob wurde beendet.\n";
?>