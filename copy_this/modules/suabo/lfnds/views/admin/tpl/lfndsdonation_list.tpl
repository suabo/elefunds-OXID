[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box="list"}]
[{assign var="where" value=$oView->getListFilter()}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<script type="text/javascript">
<!--
window.onload = function ()
{
    top.reloadEditFrame();
    [{ if $updatelist == 1}]
        top.oxid.admin.updateList('[{ $oxid }]');
    [{ /if}]
}
//-->
</script>

<div id="liste">

<form name="search" id="search" action="[{ $oViewConf->getSelfLink() }]" method="post">
[{include file="_formparams.tpl" cl="lfndsdonation_list" lstrt=$lstrt actedit=$actedit oxid=$oxid fnc="" language=$actlang editlanguage=$actlang}]
<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <colgroup>        
        <col width="10%">
        <col width="10%">
        <col width="50%">
        <col width="30%">        
    </colgroup>
<tr class="listitem">
    <td valign="top" class="listfilter first" height="20">
        <div class="r1">
            <div class="b1">              
              <select name="displaytype" class="folderselect" onChange="document.search.submit();">
                <option value="">[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE" }]</option>
                <option value="pending" [{ if $displaytype == "pending" }]SELECTED[{/if}]>[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE_PENDING" }]</option>
                <option value="cancelled" [{ if $displaytype == "cancelled" }]SELECTED[{/if}]>[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE_CANCELLED" }]</option>
                <option value="completed" [{ if $displaytype == "completed" }]SELECTED[{/if}]>[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE_COMPLETE" }]</option>
              </select>
            </div>
        </div>
    </td>
    <td class="listfilter">
      <div class="r1">
        <div class="b1">
          <input class="listedit" type="text" size="50" maxlength="128" name="where[suabolfnds][lfndstime]" value="[{ $where.suabolfnds.lfndstime }]">
        </div>
      </div>
    </td>
    <td class="listfilter"><div class="r1"><div class="b1"></div></div></td>
    <td class="listfilter">
      <div class="r1">
        <div class="b1">
          <div class="find">
            <select name="changelang" class="editinput" onChange="Javascript:top.oxid.admin.changeLanguage();">
              [{foreach from=$languages item=lang}]
              <option value="[{ $lang->id }]" [{ if $lang->selected}]SELECTED[{/if}]>[{ $lang->name }]</option>
              [{/foreach}]
            </select>
            <input class="listedit" type="submit" name="submitit" value="[{ oxmultilang ident="GENERAL_SEARCH" }]">
          </div>
        </div>
      </div>
    </td>    
</tr>
<tr>
    <td class="listheader"><a href="Javascript:top.oxid.admin.setSorting( document.search, 'suabolfnds', 'lfndsstate', 'asc');document.search.submit();" class="listheader">[{ oxmultilang ident="MODULE_SUABOLFNDS_STATE_TITLE" }]</a></td>
    <td class="listheader"><a href="Javascript:top.oxid.admin.setSorting( document.search, 'suabolfnds', 'lfndstime', 'asc');document.search.submit();" class="listheader">[{ oxmultilang ident="MODULE_SUABOLFNDS_TIME" }]</a></td>
    <td class="listheader"><a href="Javascript:top.oxid.admin.setSorting( document.search, 'suabolfnds', 'lfndsdonation', 'asc');document.search.submit();" class="listheader">[{ oxmultilang ident="MODULE_SUABOLFNDS_DONATION" }]</a></td>
    <td class="listheader"><a href="Javascript:top.oxid.admin.setSorting( document.search, 'suabolfnds', 'oxorderid', 'asc');document.search.submit();" class="listheader">[{ oxmultilang ident="MODULE_SUABOLFNDS_ORDER" }]</a></td>    
</tr>

[{assign var="blWhite" value=""}]
[{assign var="_cnt" value=0}]
[{foreach from=$mylist item=listitem}]
    [{assign var="_cnt" value=$_cnt+1}]
    <tr id="row.[{$_cnt}]">
    [{ if $listitem->blacklist == 1}]
        [{assign var="listclass" value=listitem3 }]
    [{ else}]
        [{assign var="listclass" value=listitem$blWhite }]
    [{ /if}]
    [{ if $listitem->getId() == $oxid }]
        [{assign var="listclass" value=listitem4 }]
    [{ /if}]    
    <td valign="top" class="[{ $listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{ $listitem->suabolfnds__oxid->value}]');" class="[{ $listclass}]">[{ $listitem->suabolfnds__lfndsstate->value }]</a></div></td>
    <td valign="top" class="[{ $listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{ $listitem->suabolfnds__oxid->value}]');" class="[{ $listclass}]">[{ $listitem->suabolfnds__lfndstime->value }]</a></div></td>
    <td valign="top" class="[{ $listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{ $listitem->suabolfnds__oxid->value}]');" class="[{ $listclass}]">[{ $listitem->suabolfnds__lfndsdonation->value|substr:0:100 }]...</a></div></td>
    <td valign="top" class="[{ $listclass}]" height="15"><div class="listitemfloating"><a href="Javascript:top.oxid.admin.editThis('[{ $listitem->suabolfnds__oxid->value}]');" class="[{ $listclass}]">[{ $listitem->suabolfnds__oxorderid->value }]</a></div></td>    
</tr>
[{if $blWhite == "2"}]
[{assign var="blWhite" value=""}]
[{else}]
[{assign var="blWhite" value="2"}]
[{/if}]
[{/foreach}]
[{include file="pagenavisnippet.tpl" colspan="4"}]
</table>
</form>
</div>

[{include file="pagetabsnippet.tpl"}]


<script type="text/javascript">
if (parent.parent)
{   parent.parent.sShopTitle   = "[{$actshopobj->oxshops__oxname->getRawValue()|oxaddslashes}]";
    parent.parent.sMenuItem    = "[{ oxmultilang ident="MODULE_SUABOLFNDS_TITLE" }]";
    parent.parent.sMenuSubItem = "[{ oxmultilang ident="MODULE_SUABOLFNDS_TITLE_SUBITEM" }]";
    parent.parent.sWorkArea    = "[{$_act}]";
    parent.parent.setTitle();
}
</script>
</body>
</html>

