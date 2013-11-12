<?php
class suabolfnds extends oxI18n {
  protected $_sClassName = 'suabolfnds';
  public function __construct($aParams = null) {
    if ( $aParams && is_array($aParams)) {
      foreach ( $aParams as $sParam => $mValue) { $this->$sParam = $mValue; }
    }
    parent::__construct();
    $this->init('suabolfnds');    
  }
}
?>