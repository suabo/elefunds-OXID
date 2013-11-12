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
class suabolfndsevents {
  public static function onActivate {
    if(!(oxDb::getDb()->exec("SHOW TABLES LIKE 'suabolfnds';"))) {
      $oViewConf = oxNew('oxviewconfig');
      $sModulePath  = $oViewConf->getModulePath('suabolfnds');
      $sql  = file_get_contents($sModulePath.'setup/1.0.0/suabolfnds.sql');
      $sql += file_get_contents($sModulePath.'setup/1.0.0/oxarticleslfndsdonationarticle.sql');
      oxDb::getDb()->exec($sql);
    }    
  }
  
  public static function onDeactivate {    
    $sShopId = $this->getConfig()->getShopId();
    oxDb::getDb()->execute("DELETE FROM oxconfig WHERE oxmodule = 'module:suabolfnds' AND oxshopid = '$sShopId'");
    oxDb::getDb()->execute("DELETE FROM oxconfigdisplay WHERE oxcfgmodule = 'suabolfnds'");  
  }
}
?>