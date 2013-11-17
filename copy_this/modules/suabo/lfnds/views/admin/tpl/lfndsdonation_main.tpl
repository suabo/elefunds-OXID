[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="lfndsdonation_main">
</form>
 
<table cellspacing="0" cellpadding="0" border="0">
[{block name="admin_lfnds_main"}]  
    [{if $edit}]
    <tr>
        <td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE_TITLE" }]:</td>
        <td class="edittext">[{$edit->suabolfnds__lfndsstate->value}]</td>
    </tr>
    [{foreach from=$aDonation key=sKey item=sValue}]
      [{if !is_array($sValue)}]
        <tr><td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_"|cat:$sKey }]: </td><td class="edittext">[{$sValue}] </td></tr>
      [{/if}]
      [{if is_array($sValue)}]
        <tr>
          <td class="edittext" valign="top">[{ oxmultilang ident="MODULE_SUABOLFNDS_"|cat:$sKey }]: </td>
          <td class="edittext">
            <table cellspacing="0" cellpadding="0" border="0">
            [{foreach from=$sValue key=sValueKey item=sValueValue}]
              <tr><td class="edittext">[{$sValueKey}]: </td><td class="edittext">[{$sValueValue}] </td></tr> 
            [{/foreach}]
            </table>
          </td>
        </tr>
      [{/if}]
    [{/foreach}]
    [{else if $aTotal}]
    <tr>
        <td class="edittext" colspan="2">[{ oxmultilang ident="MODULE_SUABOLFNDS_TOTAL_DONATIONS" }]:<br><br></td>
    </tr>
    <tr>
        <td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_TOTAL_DONATIONS_TOTAL" }]:</td>
        <td class="edittext">[{$aTotal.totalDonations}]</td>
    </tr>
    <tr>
        <td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_TOTAL_DONATIONS_COMPLETED" }]:</td>
        <td class="edittext">[{$aTotal.totalCompleted}]</td>
    </tr>
    <tr>
        <td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_TOTAL_DONATIONS_PENDING" }]:</td>
        <td class="edittext">[{$aTotal.totalPending}]</td>
    </tr>
    <tr>
        <td class="edittext">[{ oxmultilang ident="MODULE_SUABOLFNDS_TOTAL_DONATIONS_CANCELLED" }]:</td>
        <td class="edittext">[{$aTotal.totalCancelled}]</td>
    </tr>        
    [{/if}]
</table>
[{/block}]
[{include file="bottomitem.tpl"}]