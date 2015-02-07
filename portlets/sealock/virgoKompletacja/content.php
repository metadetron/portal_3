<?php
	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	if (preg_match("/.*.metadetron.com/i", $_SERVER["SERVER_NAME"])) {
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	} 
	ini_set('display_errors', 1);
//	setlocale(LC_ALL, '$messages.LOCALE');
	include_once("controller.php"); 
//	include_once("slk_kompletacja_criteria_class.php"); 
//	include_once($_SERVER[" DOCUMENT_ROOT"] . "/components/com_slk_system_log/slk_system_log_class.php"); 	
	$componentParams = null; //&JComponentHelper::getParams('com_slk_kompletacja');
	$underConstruction = false; //$componentParams->get('under_construction');
	$underConstructionAllowedUser = ''; //$componentParams->get('under_construction_allowed_user');
	$context = array();

	if (false) { //$underConstruction == "1" && (is_null($user) || ($user->username != "metaadmin" && $user->username != $underConstructionAllowedUser))) {
?>
		<div style="color: #FF6666; font-size: 2em; margin: 100px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	} else {
		if (false) { //$underConstruction == "1" && !is_null($user) && ($user->username == "metaadmin" || $user->username == $underConstructionAllowedUser)) {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
		}
?>
<?php
?>
<?php
?>
<?php
	$live_site = "localhost";
	if (false) { //$componentParams->get('css_usage') == "virgo" || $componentParams->get('css_usage') == "") {
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_slk_kompletacja/sealock.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'slk_kmp.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/sealock/virgoKompletacja/slk_kmp.css" type="text/css" /> 
<?php
	}
?>
<style>

td#component {
    background-color: inherit !important;
    border: inherit !important;
    color: inherit !important;
    padding: inherit !important;
    text-shadow: inherit !important;
    font-size: inherit !important;
  }
</style>
<div class="virgo_container_sealock virgo_container_entity_kompletacja" style="border: none;">
	<div class="virgo_scrollable">
<?php
			}
		$tablePrefixes = array();
//		$classNames = array();
		$etityNames = array();		
		$parents = array();
		$tablePrefixes["towar"] = "twr";
//		$classNames["towar"] = "virgoTowar";
		$entityNames["towar"] = "Towar";
		$tmpParents = array();
		$tmpParents[] = "grupa_towaru";
		$tmpParents[] = "jednostka";
		$tmpParents[] = "kompletacja";
		$parents["towar"] = $tmpParents;
		$tablePrefixes["grupa_towaru"] = "gtw";
//		$classNames["grupa_towaru"] = "virgoGrupaTowaru";
		$entityNames["grupa_towaru"] = "GrupaTowaru";
		$tmpParents = array();
		$parents["grupa_towaru"] = $tmpParents;
		$tablePrefixes["zamowienie"] = "zmw";
//		$classNames["zamowienie"] = "virgoZamowienie";
		$entityNames["zamowienie"] = "Zamowienie";
		$tmpParents = array();
		$tmpParents[] = "status_zamowienia";
		$tmpParents[] = "odbiorca";
		$parents["zamowienie"] = $tmpParents;
		$tablePrefixes["status_zamowienia"] = "szm";
//		$classNames["status_zamowienia"] = "virgoStatusZamowienia";
		$entityNames["status_zamowienia"] = "StatusZamowienia";
		$tmpParents = array();
		$parents["status_zamowienia"] = $tmpParents;
		$tablePrefixes["odbiorca"] = "odb";
//		$classNames["odbiorca"] = "virgoOdbiorca";
		$entityNames["odbiorca"] = "Odbiorca";
		$tmpParents = array();
		$parents["odbiorca"] = $tmpParents;
		$tablePrefixes["status_zamowienia_workflow"] = "szw";
//		$classNames["status_zamowienia_workflow"] = "virgoStatusZamowieniaWorkflow";
		$entityNames["status_zamowienia_workflow"] = "StatusZamowieniaWorkflow";
		$tmpParents = array();
		$tmpParents[] = "status_zamowienia";
		$tmpParents[] = "status_zamowienia";
		$parents["status_zamowienia_workflow"] = $tmpParents;
		$tablePrefixes["pozycja_zamowienia"] = "pzm";
//		$classNames["pozycja_zamowienia"] = "virgoPozycjaZamowienia";
		$entityNames["pozycja_zamowienia"] = "PozycjaZamowienia";
		$tmpParents = array();
		$tmpParents[] = "zamowienie";
		$tmpParents[] = "towar";
		$tmpParents[] = "wydanie";
		$parents["pozycja_zamowienia"] = $tmpParents;
		$tablePrefixes["produkt"] = "prd";
//		$classNames["produkt"] = "virgoProdukt";
		$entityNames["produkt"] = "Produkt";
		$tmpParents = array();
		$tmpParents[] = "towar";
		$parents["produkt"] = $tmpParents;
		$tablePrefixes["wydanie"] = "wdn";
//		$classNames["wydanie"] = "virgoWydanie";
		$entityNames["wydanie"] = "Wydanie";
		$tmpParents = array();
		$tmpParents[] = "produkt";
		$parents["wydanie"] = $tmpParents;
		$tablePrefixes["jednostka"] = "jdn";
//		$classNames["jednostka"] = "virgoJednostka";
		$entityNames["jednostka"] = "Jednostka";
		$tmpParents = array();
		$parents["jednostka"] = $tmpParents;
		$tablePrefixes["skladnik"] = "skl";
//		$classNames["skladnik"] = "virgoSkladnik";
		$entityNames["skladnik"] = "Skladnik";
		$tmpParents = array();
		$tmpParents[] = "towar";
		$tmpParents[] = "kompletacja";
		$parents["skladnik"] = $tmpParents;
		$tablePrefixes["kompletacja"] = "kmp";
//		$classNames["kompletacja"] = "virgoKompletacja";
		$entityNames["kompletacja"] = "Kompletacja";
		$tmpParents = array();
		$parents["kompletacja"] = $tmpParents;
		$ancestors = array();
//		$session = &JFactory::getSession();
		$contextId = null;		
			$resultKompletacja = new virgoKompletacja();
			$contextId = $resultKompletacja->getContextId();
			if (isset($contextId)) {
				if (virgoKompletacja::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultKompletacja->load($contextId);
				}
			}
?>
<?php
			if (false) { //$componentParams->get('show_project_name') == "1") {
?>
		<div id="virgo_project">
<?php
  $parentMenu = null; //$menu->getItem($menuItem->parent);
?>
			sealock: <?php echo is_null($parentMenu) ? $mainframe->getPageTitle() : $parentMenu->name . " -> " . $mainframe->getPageTitle() ?>
			<span id="virgo_project_version">
				1.1 
			</span>
<!--

-->
<span 
	title="header=[<?php echo JText::_('VERSIONS') ?>]cssheader=[tooltip_header]cssbody=[tooltip_body]body=
[
0.1.2 -
Minor features added
<br>
0.1.1 -
Binary bool added
<br>
0.1.0 -
<b>
beta
</b>
<br>
]">0.1.2</span>
			<span class="virgo_connected_as">
<?php
				if (is_null($user->username)) {
?>
<?php echo T('NOT_LOGGED_IN') ?><?php
				} else {
?>
<?php echo T('LOGGED_IN_AS') ?>					<span class="virgo_username"><?php echo $user->username ?></span>.
<?php
				}
?>
			</span>
		</div>
<?php
			}
	$masterPobId = P('master_entity_pob_id');
	if (isset($masterPobId)) {
		$portletObject = new virgoPortletObject($masterPobId);
		$className = $portletObject->getPortletDefinition()->getAlias();
		if ($className == "virgoKompletacja") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultKompletacja = new virgoKompletacja($tmpId);
				virgoKompletacja::setDisplayMode("FORM");
			} else {
				$resultKompletacja = new virgoKompletacja();
				virgoKompletacja::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultKompletacja->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultKompletacja->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultKompletacja = new virgoKompletacja($allPrivateRecords[0]['kmp_id']);
						$resultKompletacja->putInContext(false);
					} else {
						$resultKompletacja = new virgoKompletacja();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultKompletacja->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultKompletacja = new virgoKompletacja($records[0]['kmp_id']);
							$resultKompletacja->putInContext(false);
						} else {
							$resultKompletacja = new virgoKompletacja();
						}
					} else {
						$resultKompletacja = new virgoKompletacja();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultKompletacja = new virgoKompletacja(virgoUser::getUserId());
			$resultKompletacja->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultKompletacja = new virgoKompletacja();
		}
?>
<?php
	$kompletacjaDisplayMode = virgoKompletacja::getDisplayMode();
//	if ($kompletacjaDisplayMode == "" || $kompletacjaDisplayMode == "TABLE") {
//		$resultKompletacja = $resultKompletacja->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultKompletacja->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseKompletacja = $whereClauseKompletacja . ' AND ' . $parentContextInfo['condition'];
			if (isset($parentContextInfo['value'])) {
?>		
			<table class="db_context_record">
				<tr>
					<td class="db_context_label">
						<?php echo $parentContextInfo['name'] ?>
					</td>
					<td class="db_context_value">
						<?php echo $parentContextInfo['value'] ?>
					</td>
				</tr>
			</table>
<?php
			}
		}
		if (P('filter_entity_pob_id', '') == '' && P('filter_mode', '0') == '0') {
?>		
<?php
		$criteriaKompletacja = $resultKompletacja->getCriteria();
		$countTmp = 0;
		if (is_null($criteriaKompletacja) || sizeof($criteriaKompletacja) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
?>
			</table>
<?php
		}
?>
<?php
		}
?>
<?php
	if (isset($resultKompletacja)) {
		$tmpId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
?>
<?php
	if ($kompletacjaDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if ($tmpAction == "Store" || $tmpAction == "Apply" || $tmpAction == "StoreAndClear") {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultKompletacja->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultKompletacja->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$kompletacjaDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultKompletacja->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($kompletacjaDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_kompletacja") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('KOMPLETACJA') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul <?php echo $floatingGridFields ? "class='float_grid_fields'" : "" ?>>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$editForm = P('edit_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
									
<?php
	if (class_exists('virgoSkladnik') && P('show_form_skladniki', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_form_towary', '1') == "1") {
?>
<?php
	} else {
	}
?>

<?php
	} elseif ($editForm == "virgo_entity") {
?>
<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_skladniki') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsSkladnik = &JComponentHelper::getParams('com_slk_skladnik');
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_ilosc') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ilość
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_towar') == "1" && ($masterComponentName != "towar" || is_null($contextId))) {
?>
				<td align="center" nowrap>Towar </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpSkladnik = new virgoSkladnik();
				$resultsSkladnik = $tmpSkladnik->selectAll(' skl_kmp_id = ' . $resultKompletacja->kmp_id);
				$idsToCorrect = $tmpSkladnik->getInvalidRecords();
				$index = 0;
				foreach ($resultsSkladnik as $resultSkladnik) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultSkladnik->skl_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSkladnik->skl_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSkladnik->skl_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSkladnik->skl_id) ? 0 : $resultSkladnik->skl_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSkladnik->skl_id;
		$resultSkladnik = new virgoSkladnik;
		$resultSkladnik->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_ilosc') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 0;
?>
<?php
	if (!isset($resultSkladnik)) {
		$resultSkladnik = new virgoSkladnik();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="skl_ilosc_<?php echo $resultSkladnik->skl_id ?>" 
							name="skl_ilosc_<?php echo $resultSkladnik->skl_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultSkladnik->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_SKLADNIK_ILOSC');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#skl_ilosc_<?php echo $resultSkladnik->skl_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ilosc_<?php echo $resultKompletacja->kmp_id ?>" 
							name="ilosc_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_ilosc, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_towar') == "1" && ($masterComponentName != "towar" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSkladnik) * 1;
?>
<?php
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoTowar"])) {
			$tmpId = $parentsInContext["virgoTowar"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_towar', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultSkladnik->skl_twr_id = $tmpId;
			}
			if (isset($resultSkladnik->skl_twr_id)) {
				$parentId = $resultSkladnik->skl_twr_id;
				$parentTowar = new virgoTowar();
				$parentValue = $parentTowar->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="skl_towar_<?php echo $resultSkladnik->skl_id ?>" name="skl_towar_<?php echo $resultSkladnik->skl_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_SKLADNIK_TOWAR');
?>
<?php
	$parentTowar = new virgoTowar();
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = $parentTowar->getVirgoListSize($whereList);
	$showAjaxskl = P('show_form_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxskl) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="skl_towar_<?php echo isset($resultSkladnik->skl_id) ? $resultSkladnik->skl_id : '' ?>" 
							name="skl_towar_<?php echo isset($resultSkladnik->skl_id) ? $resultSkladnik->skl_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_towar) || trim($limit_towar) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTowar = $parentTowar->getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultSkladnik->skl_twr_id) && $id == $resultSkladnik->skl_twr_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSkladnik->skl_twr_id;
				$parentTowar = new virgoTowar();
				$parentValue = $parentTowar->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="skl_towar_<?php echo $resultSkladnik->skl_id ?>" name="skl_towar_<?php echo $resultSkladnik->skl_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Towar",
			virgo_field_name: "towar",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#skl_towar_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.value);
				  	$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.label);
				  	$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#skl_towar_<?php echo $resultSkladnik->skl_id ?>').val('');
				$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
	$resultTowar = new virgoTowar(); 
	$resultTowar->loadFromRequest();
?>
<fieldset
	id="create_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	class="create_skl_towar"
	style="display: none; margin: 0px; <?php echo $floatingFields ? " float: left;" : '' ?>"
>
<input 
	type="hidden" 
	id="check_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	name="create_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	value="0"
> 	
<?php
	if ($formsInTable) {
?>
	<table>
<?php
	}
?>
<?php
	if (class_exists('virgoGrupaTowaru') && ((P('show_create_grupa_towaru', "1") == "1" || P('show_create_grupa_towaru', "1") == "2" || P('show_create_grupa_towaru', "1") == "3") && !isset($context["gtw"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>">
 *
<?php echo T('GRUPA_TOWARU') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_grupa_towaru = $componentParams->get('limit_to_grupa_towaru');
		$limit_grupa_towaru = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoGrupaTowaru"])) {
			$tmpId = $parentsInContext["virgoGrupaTowaru"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_create_grupa_towaru', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_gtw_id = $tmpId;
			}
			if (isset($resultTowar->twr_gtw_id)) {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_GRUPA_TOWARU');
?>
<?php
	$parentGrupaTowaru = new virgoGrupaTowaru();
	$whereList = "";
	if (!is_null($limit_grupa_towaru) && trim($limit_grupa_towaru) != "") {
		$whereList = $whereList . " gtw_id ";
		if (trim($limit_grupa_towaru) == "page_title") {
			$limit_grupa_towaru = "SELECT gtw_id FROM slk_grupy_towarow WHERE gtw_" . $limit_grupa_towaru . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_towaru = \"$limit_grupa_towaru\";");
		$whereList = $whereList . " IN (" . $limit_grupa_towaru . ") ";
	}						
	$parentCount = $parentGrupaTowaru->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_grupa_towaru', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_grupa_towaru) || trim($limit_grupa_towaru) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaTowaru = $parentGrupaTowaru->getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaTowaru)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_gtw_id) && $id == $resultTowar->twr_gtw_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaTowaru",
			virgo_field_name: "grupa_towaru",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_grupa_towaru_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["gtw"])) {
		$parentValue = $context["gtw"];
	} else {
		$parentValue = $resultKompletacja->kmp_gtw_id;
	}
	
?>
				<input type="hidden" id="kmp_grupaTowaru_<?php echo $resultKompletacja->kmp_id ?>" name="kmp_grupaTowaru_<?php echo $resultKompletacja->kmp_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('virgoJednostka') && ((P('show_create_jednostka', "1") == "1" || P('show_create_jednostka', "1") == "2" || P('show_create_jednostka', "1") == "3") && !isset($context["jdn"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>">
 *
<?php echo T('JEDNOSTKA') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_jednostka = $componentParams->get('limit_to_jednostka');
		$limit_jednostka = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoJednostka"])) {
			$tmpId = $parentsInContext["virgoJednostka"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_create_jednostka', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_jdn_id = $tmpId;
			}
			if (isset($resultTowar->twr_jdn_id)) {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_JEDNOSTKA');
?>
<?php
	$parentJednostka = new virgoJednostka();
	$whereList = "";
	if (!is_null($limit_jednostka) && trim($limit_jednostka) != "") {
		$whereList = $whereList . " jdn_id ";
		if (trim($limit_jednostka) == "page_title") {
			$limit_jednostka = "SELECT jdn_id FROM slk_jednostki WHERE jdn_" . $limit_jednostka . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_jednostka = \"$limit_jednostka\";");
		$whereList = $whereList . " IN (" . $limit_jednostka . ") ";
	}						
	$parentCount = $parentJednostka->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_jednostka', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_jednostka) || trim($limit_jednostka) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsJednostka = $parentJednostka->getVirgoList($whereList);
			while(list($id, $label)=each($resultsJednostka)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_jdn_id) && $id == $resultTowar->twr_jdn_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Jednostka",
			virgo_field_name: "jednostka",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_jednostka_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["jdn"])) {
		$parentValue = $context["jdn"];
	} else {
		$parentValue = $resultKompletacja->kmp_jdn_id;
	}
	
?>
				<input type="hidden" id="kmp_jednostka_<?php echo $resultKompletacja->kmp_id ?>" name="kmp_jednostka_<?php echo $resultKompletacja->kmp_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   kod varchar" 
						for="twr_kod_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('KOD') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_kod_<?php echo $resultTowar->twr_id ?>" 
							name="twr_kod_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getKod(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_KOD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_kod_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   nazwa varchar" 
						for="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('NAZWA') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_nazwa_<?php echo $resultTowar->twr_id ?>" 
							name="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_NAZWA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_nazwa_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   stan_aktualny decimal" 
						for="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('STAN_AKTUALNY') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanAktualny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_AKTUALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanAktualny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   stan_minimalny decimal" 
						for="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('STAN_MINIMALNY') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanMinimalny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_MINIMALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
<?php
	if ($formsInTable) {
?>
	</table>
<?php
	}
?>
</fieldset>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input 
	type="button" 
	value="<?php echo T('Wprowadź nowy') ?> <?php echo T('towar') ?>" 
	class="button btn"
	onclick="
			$('#create_skl_towar_<?php echo $resultSkladnik->skl_id ?>').toggle();
			$('label[for=\'skl_towar_<?php echo $resultSkladnik->skl_id ?>\']').toggle();
<?php
	if ($showAjaxskl) {
		$dropdown = "dropdown_";
	} else {
		$dropdown = "";
	}
?> 
			$('#skl_towar_<?php echo $dropdown ?><?php echo $resultSkladnik->skl_id ?>').toggle();
			$('#check_skl_towar_<?php echo $resultSkladnik->skl_id ?>').val($('#create_skl_towar_<?php echo $resultSkladnik->skl_id ?>').css('display') == 'none' ? 0 : 1);
		"
>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_towar_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultSkladnik = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultSkladnik->skl_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSkladnik->skl_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSkladnik->skl_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSkladnik->skl_id) ? 0 : $resultSkladnik->skl_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSkladnik->skl_id;
		$resultSkladnik = new virgoSkladnik;
		$resultSkladnik->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_ilosc') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 0;
?>
<?php
	if (!isset($resultSkladnik)) {
		$resultSkladnik = new virgoSkladnik();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="skl_ilosc_<?php echo $resultSkladnik->skl_id ?>" 
							name="skl_ilosc_<?php echo $resultSkladnik->skl_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultSkladnik->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_SKLADNIK_ILOSC');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#skl_ilosc_<?php echo $resultSkladnik->skl_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ilosc_<?php echo $resultKompletacja->kmp_id ?>" 
							name="ilosc_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_ilosc, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSkladnik->get('show_table_towar') == "1" && ($masterComponentName != "towar" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSkladnik) * 1;
?>
<?php
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoTowar"])) {
			$tmpId = $parentsInContext["virgoTowar"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_towar', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultSkladnik->skl_twr_id = $tmpId;
			}
			if (isset($resultSkladnik->skl_twr_id)) {
				$parentId = $resultSkladnik->skl_twr_id;
				$parentTowar = new virgoTowar();
				$parentValue = $parentTowar->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="skl_towar_<?php echo $resultSkladnik->skl_id ?>" name="skl_towar_<?php echo $resultSkladnik->skl_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_SKLADNIK_TOWAR');
?>
<?php
	$parentTowar = new virgoTowar();
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = $parentTowar->getVirgoListSize($whereList);
	$showAjaxskl = P('show_form_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxskl) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="skl_towar_<?php echo isset($resultSkladnik->skl_id) ? $resultSkladnik->skl_id : '' ?>" 
							name="skl_towar_<?php echo isset($resultSkladnik->skl_id) ? $resultSkladnik->skl_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_towar) || trim($limit_towar) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTowar = $parentTowar->getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultSkladnik->skl_twr_id) && $id == $resultSkladnik->skl_twr_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultSkladnik->skl_twr_id;
				$parentTowar = new virgoTowar();
				$parentValue = $parentTowar->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="skl_towar_<?php echo $resultSkladnik->skl_id ?>" name="skl_towar_<?php echo $resultSkladnik->skl_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Towar",
			virgo_field_name: "towar",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#skl_towar_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.value);
				  	$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.label);
				  	$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#skl_towar_<?php echo $resultSkladnik->skl_id ?>').val('');
				$('#skl_towar_dropdown_<?php echo $resultSkladnik->skl_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
	$resultTowar = new virgoTowar(); 
	$resultTowar->loadFromRequest();
?>
<fieldset
	id="create_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	class="create_skl_towar"
	style="display: none; margin: 0px; <?php echo $floatingFields ? " float: left;" : '' ?>"
>
<input 
	type="hidden" 
	id="check_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	name="create_skl_towar_<?php echo $resultSkladnik->skl_id ?>"
	value="0"
> 	
<?php
	if ($formsInTable) {
?>
	<table>
<?php
	}
?>
<?php
	if (class_exists('virgoGrupaTowaru') && ((P('show_create_grupa_towaru', "1") == "1" || P('show_create_grupa_towaru', "1") == "2" || P('show_create_grupa_towaru', "1") == "3") && !isset($context["gtw"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>">
 *
<?php echo T('GRUPA_TOWARU') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_grupa_towaru = $componentParams->get('limit_to_grupa_towaru');
		$limit_grupa_towaru = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoGrupaTowaru"])) {
			$tmpId = $parentsInContext["virgoGrupaTowaru"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_create_grupa_towaru', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_gtw_id = $tmpId;
			}
			if (isset($resultTowar->twr_gtw_id)) {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_GRUPA_TOWARU');
?>
<?php
	$parentGrupaTowaru = new virgoGrupaTowaru();
	$whereList = "";
	if (!is_null($limit_grupa_towaru) && trim($limit_grupa_towaru) != "") {
		$whereList = $whereList . " gtw_id ";
		if (trim($limit_grupa_towaru) == "page_title") {
			$limit_grupa_towaru = "SELECT gtw_id FROM slk_grupy_towarow WHERE gtw_" . $limit_grupa_towaru . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_towaru = \"$limit_grupa_towaru\";");
		$whereList = $whereList . " IN (" . $limit_grupa_towaru . ") ";
	}						
	$parentCount = $parentGrupaTowaru->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_grupa_towaru', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_grupa_towaru) || trim($limit_grupa_towaru) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaTowaru = $parentGrupaTowaru->getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaTowaru)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_gtw_id) && $id == $resultTowar->twr_gtw_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaTowaru",
			virgo_field_name: "grupa_towaru",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_grupa_towaru_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["gtw"])) {
		$parentValue = $context["gtw"];
	} else {
		$parentValue = $resultKompletacja->kmp_gtw_id;
	}
	
?>
				<input type="hidden" id="kmp_grupaTowaru_<?php echo $resultKompletacja->kmp_id ?>" name="kmp_grupaTowaru_<?php echo $resultKompletacja->kmp_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('virgoJednostka') && ((P('show_create_jednostka', "1") == "1" || P('show_create_jednostka', "1") == "2" || P('show_create_jednostka', "1") == "3") && !isset($context["jdn"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>">
 *
<?php echo T('JEDNOSTKA') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_jednostka = $componentParams->get('limit_to_jednostka');
		$limit_jednostka = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoJednostka"])) {
			$tmpId = $parentsInContext["virgoJednostka"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_create_jednostka', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_jdn_id = $tmpId;
			}
			if (isset($resultTowar->twr_jdn_id)) {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_JEDNOSTKA');
?>
<?php
	$parentJednostka = new virgoJednostka();
	$whereList = "";
	if (!is_null($limit_jednostka) && trim($limit_jednostka) != "") {
		$whereList = $whereList . " jdn_id ";
		if (trim($limit_jednostka) == "page_title") {
			$limit_jednostka = "SELECT jdn_id FROM slk_jednostki WHERE jdn_" . $limit_jednostka . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_jednostka = \"$limit_jednostka\";");
		$whereList = $whereList . " IN (" . $limit_jednostka . ") ";
	}						
	$parentCount = $parentJednostka->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_jednostka', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_jednostka) || trim($limit_jednostka) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsJednostka = $parentJednostka->getVirgoList($whereList);
			while(list($id, $label)=each($resultsJednostka)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_jdn_id) && $id == $resultTowar->twr_jdn_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Jednostka",
			virgo_field_name: "jednostka",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_jednostka_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["jdn"])) {
		$parentValue = $context["jdn"];
	} else {
		$parentValue = $resultKompletacja->kmp_jdn_id;
	}
	
?>
				<input type="hidden" id="kmp_jednostka_<?php echo $resultKompletacja->kmp_id ?>" name="kmp_jednostka_<?php echo $resultKompletacja->kmp_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   kod varchar" 
						for="twr_kod_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('KOD') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_kod_<?php echo $resultTowar->twr_id ?>" 
							name="twr_kod_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getKod(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_KOD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_kod_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   nazwa varchar" 
						for="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('NAZWA') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_nazwa_<?php echo $resultTowar->twr_id ?>" 
							name="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_NAZWA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_nazwa_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   stan_aktualny decimal" 
						for="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('STAN_AKTUALNY') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanAktualny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_AKTUALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanAktualny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
		<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   stan_minimalny decimal" 
						for="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
					>* <?php echo T('STAN_MINIMALNY') ?>
</label>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanMinimalny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_MINIMALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

		</li>
<?php
	if ($formsInTable) {
?>
	</table>
<?php
	}
?>
</fieldset>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input 
	type="button" 
	value="<?php echo T('Wprowadź nowy') ?> <?php echo T('towar') ?>" 
	class="button btn"
	onclick="
			$('#create_skl_towar_<?php echo $resultSkladnik->skl_id ?>').toggle();
			$('label[for=\'skl_towar_<?php echo $resultSkladnik->skl_id ?>\']').toggle();
<?php
	if ($showAjaxskl) {
		$dropdown = "dropdown_";
	} else {
		$dropdown = "";
	}
?> 
			$('#skl_towar_<?php echo $dropdown ?><?php echo $resultSkladnik->skl_id ?>').toggle();
			$('#check_skl_towar_<?php echo $resultSkladnik->skl_id ?>').val($('#create_skl_towar_<?php echo $resultSkladnik->skl_id ?>').css('display') == 'none' ? 0 : 1);
		"
>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_towar_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpSkladnik->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_towary') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsTowar = &JComponentHelper::getParams('com_slk_towar');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_grupa_towaru/slk_grupa_towaru_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_jednostka/slk_jednostka_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_kompletacja/slk_kompletacja_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_grupa_towaru/slk_grupa_towaru_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_jednostka/slk_jednostka_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_kompletacja/slk_kompletacja_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_grupa_towaru/slk_grupa_towaru_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_jednostka/slk_jednostka_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_kompletacja/slk_kompletacja_class.php");
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_kod') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Kod
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_nazwa') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Nazwa
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_aktualny') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Stan aktualny
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_minimalny') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Stan minimalny
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_produkt') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Produkt
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_grupa_towaru') == "1" && ($masterComponentName != "grupa_towaru" || is_null($contextId))) {
?>
				<td align="center" nowrap>Grupa towaru </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_jednostka') == "1" && ($masterComponentName != "jednostka" || is_null($contextId))) {
?>
				<td align="center" nowrap>Jednostka </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpTowar = new virgoTowar();
				$resultsTowar = $tmpTowar->selectAll(' twr_kmp_id = ' . $resultKompletacja->kmp_id);
				$idsToCorrect = $tmpTowar->getInvalidRecords();
				$index = 0;
				foreach ($resultsTowar as $resultTowar) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultTowar->twr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultTowar->twr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultTowar->twr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultTowar->twr_id) ? 0 : $resultTowar->twr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultTowar->twr_id;
		$resultTowar = new virgoTowar;
		$resultTowar->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsTowar->get('show_table_kod') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 0;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_kod_<?php echo $resultTowar->twr_id ?>" 
							name="twr_kod_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getKod(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_KOD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_kod_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="kod_<?php echo $resultKompletacja->kmp_id ?>" 
							name="kod_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_kod, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_nazwa') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 1;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_nazwa_<?php echo $resultTowar->twr_id ?>" 
							name="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_NAZWA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_nazwa_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="nazwa_<?php echo $resultKompletacja->kmp_id ?>" 
							name="nazwa_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_nazwa, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_aktualny') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 2;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanAktualny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_AKTUALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanAktualny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stanAktualny_<?php echo $resultKompletacja->kmp_id ?>" 
							name="stanAktualny_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_stan_aktualny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_minimalny') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 3;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanMinimalny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_MINIMALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stanMinimalny_<?php echo $resultKompletacja->kmp_id ?>" 
							name="stanMinimalny_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_stan_minimalny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_produkt') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 4;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
<select class="inputbox" id="twr_produkt_<?php echo $resultTowar->twr_id ?>" name="twr_produkt_<?php echo $resultTowar->twr_id ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_PRODUKT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultTowar->twr_produkt == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultTowar->twr_produkt === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultTowar->twr_produkt) || $resultTowar->twr_produkt == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_produkt_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="produkt_<?php echo $resultKompletacja->kmp_id ?>" 
							name="produkt_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_produkt, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_grupa_towaru') == "1" && ($masterComponentName != "grupa_towaru" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsTowar) * 5;
?>
<?php
//		$limit_grupa_towaru = $componentParams->get('limit_to_grupa_towaru');
		$limit_grupa_towaru = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoGrupaTowaru"])) {
			$tmpId = $parentsInContext["virgoGrupaTowaru"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_grupa_towaru', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_gtw_id = $tmpId;
			}
			if (isset($resultTowar->twr_gtw_id)) {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_GRUPA_TOWARU');
?>
<?php
	$parentGrupaTowaru = new virgoGrupaTowaru();
	$whereList = "";
	if (!is_null($limit_grupa_towaru) && trim($limit_grupa_towaru) != "") {
		$whereList = $whereList . " gtw_id ";
		if (trim($limit_grupa_towaru) == "page_title") {
			$limit_grupa_towaru = "SELECT gtw_id FROM slk_grupy_towarow WHERE gtw_" . $limit_grupa_towaru . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_towaru = \"$limit_grupa_towaru\";");
		$whereList = $whereList . " IN (" . $limit_grupa_towaru . ") ";
	}						
	$parentCount = $parentGrupaTowaru->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_form_grupa_towaru', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_grupa_towaru) || trim($limit_grupa_towaru) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaTowaru = $parentGrupaTowaru->getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaTowaru)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_gtw_id) && $id == $resultTowar->twr_gtw_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaTowaru",
			virgo_field_name: "grupa_towaru",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_grupa_towaru_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_jednostka') == "1" && ($masterComponentName != "jednostka" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsTowar) * 6;
?>
<?php
//		$limit_jednostka = $componentParams->get('limit_to_jednostka');
		$limit_jednostka = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoJednostka"])) {
			$tmpId = $parentsInContext["virgoJednostka"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_jednostka', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_jdn_id = $tmpId;
			}
			if (isset($resultTowar->twr_jdn_id)) {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_JEDNOSTKA');
?>
<?php
	$parentJednostka = new virgoJednostka();
	$whereList = "";
	if (!is_null($limit_jednostka) && trim($limit_jednostka) != "") {
		$whereList = $whereList . " jdn_id ";
		if (trim($limit_jednostka) == "page_title") {
			$limit_jednostka = "SELECT jdn_id FROM slk_jednostki WHERE jdn_" . $limit_jednostka . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_jednostka = \"$limit_jednostka\";");
		$whereList = $whereList . " IN (" . $limit_jednostka . ") ";
	}						
	$parentCount = $parentJednostka->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_form_jednostka', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_jednostka) || trim($limit_jednostka) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsJednostka = $parentJednostka->getVirgoList($whereList);
			while(list($id, $label)=each($resultsJednostka)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_jdn_id) && $id == $resultTowar->twr_jdn_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Jednostka",
			virgo_field_name: "jednostka",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_jednostka_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultTowar = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultTowar->twr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultTowar->twr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultTowar->twr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultTowar->twr_id) ? 0 : $resultTowar->twr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultTowar->twr_id;
		$resultTowar = new virgoTowar;
		$resultTowar->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsTowar->get('show_table_kod') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 0;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_kod_<?php echo $resultTowar->twr_id ?>" 
							name="twr_kod_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getKod(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_KOD');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_kod_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="kod_<?php echo $resultKompletacja->kmp_id ?>" 
							name="kod_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_kod, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_nazwa') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 1;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_nazwa_<?php echo $resultTowar->twr_id ?>" 
							name="twr_nazwa_<?php echo $resultTowar->twr_id ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTowar->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_NAZWA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_nazwa_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="nazwa_<?php echo $resultKompletacja->kmp_id ?>" 
							name="nazwa_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_nazwa, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_aktualny') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 2;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanAktualny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanAktualny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_AKTUALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanAktualny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stanAktualny_<?php echo $resultKompletacja->kmp_id ?>" 
							name="stanAktualny_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_stan_aktualny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_stan_minimalny') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 3;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>" 
							name="twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultTowar->getStanMinimalny(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_STAN_MINIMALNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_stanMinimalny_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="stanMinimalny_<?php echo $resultKompletacja->kmp_id ?>" 
							name="stanMinimalny_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_stan_minimalny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_produkt') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsKompletacja) * 4;
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new virgoTowar();
	}
?>
<select class="inputbox" id="twr_produkt_<?php echo $resultTowar->twr_id ?>" name="twr_produkt_<?php echo $resultTowar->twr_id ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = virgoTranslation::translateToken('HINT_TOWAR_PRODUKT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultTowar->twr_produkt == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultTowar->twr_produkt === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultTowar->twr_produkt) || $resultTowar->twr_produkt == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_produkt_<?php echo $resultTowar->twr_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="produkt_<?php echo $resultKompletacja->kmp_id ?>" 
							name="produkt_<?php echo $resultKompletacja->kmp_id ?>"
							value="<?php echo htmlentities($resultKompletacja->kmp_produkt, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_grupa_towaru') == "1" && ($masterComponentName != "grupa_towaru" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsTowar) * 5;
?>
<?php
//		$limit_grupa_towaru = $componentParams->get('limit_to_grupa_towaru');
		$limit_grupa_towaru = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoGrupaTowaru"])) {
			$tmpId = $parentsInContext["virgoGrupaTowaru"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_grupa_towaru', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_gtw_id = $tmpId;
			}
			if (isset($resultTowar->twr_gtw_id)) {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_GRUPA_TOWARU');
?>
<?php
	$parentGrupaTowaru = new virgoGrupaTowaru();
	$whereList = "";
	if (!is_null($limit_grupa_towaru) && trim($limit_grupa_towaru) != "") {
		$whereList = $whereList . " gtw_id ";
		if (trim($limit_grupa_towaru) == "page_title") {
			$limit_grupa_towaru = "SELECT gtw_id FROM slk_grupy_towarow WHERE gtw_" . $limit_grupa_towaru . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_towaru = \"$limit_grupa_towaru\";");
		$whereList = $whereList . " IN (" . $limit_grupa_towaru . ") ";
	}						
	$parentCount = $parentGrupaTowaru->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_form_grupa_towaru', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_grupaTowaru_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_grupa_towaru) || trim($limit_grupa_towaru) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaTowaru = $parentGrupaTowaru->getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaTowaru)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_gtw_id) && $id == $resultTowar->twr_gtw_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_gtw_id;
				$parentGrupaTowaru = new virgoGrupaTowaru();
				$parentValue = $parentGrupaTowaru->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>" name="twr_grupaTowaru_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaTowaru",
			virgo_field_name: "grupa_towaru",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_grupa_towaru_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_grupa_towaru_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsTowar->get('show_table_jednostka') == "1" && ($masterComponentName != "jednostka" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsTowar) * 6;
?>
<?php
//		$limit_jednostka = $componentParams->get('limit_to_jednostka');
		$limit_jednostka = null;
		$tmpId = null;
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
		if (isset($parentsInContext["virgoJednostka"])) {
			$tmpId = $parentsInContext["virgoJednostka"];
		}
		$readOnly = "";
		if (isset($tmpId) || P('show_form_jednostka', "1") == "2") {
			if (!is_null($tmpId)) {
						$resultTowar->twr_jdn_id = $tmpId;
			}
			if (isset($resultTowar->twr_jdn_id)) {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = virgoTranslation::translateToken('HINT_TOWAR_JEDNOSTKA');
?>
<?php
	$parentJednostka = new virgoJednostka();
	$whereList = "";
	if (!is_null($limit_jednostka) && trim($limit_jednostka) != "") {
		$whereList = $whereList . " jdn_id ";
		if (trim($limit_jednostka) == "page_title") {
			$limit_jednostka = "SELECT jdn_id FROM slk_jednostki WHERE jdn_" . $limit_jednostka . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_jednostka = \"$limit_jednostka\";");
		$whereList = $whereList . " IN (" . $limit_jednostka . ") ";
	}						
	$parentCount = $parentJednostka->getVirgoListSize($whereList);
	$showAjaxtwr = P('show_form_jednostka', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
							name="twr_jednostka_<?php echo isset($resultTowar->twr_id) ? $resultTowar->twr_id : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_jednostka) || trim($limit_jednostka) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsJednostka = $parentJednostka->getVirgoList($whereList);
			while(list($id, $label)=each($resultsJednostka)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (isset($resultTowar->twr_jdn_id) && $id == $resultTowar->twr_jdn_id ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultTowar->twr_jdn_id;
				$parentJednostka = new virgoJednostka();
				$parentValue = $parentJednostka->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->twr_id ?>" name="twr_jednostka_<?php echo $resultTowar->twr_id ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Jednostka",
			virgo_field_name: "jednostka",
			virgo_matching_labels_namespace: "sealock",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val(ui.item.value);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_jednostka_<?php echo $resultTowar->twr_id ?>').val('');
				$('#twr_jednostka_dropdown_<?php echo $resultTowar->twr_id ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#kmp_jednostka_dropdown_<?php echo $resultKompletacja->kmp_id ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpTowar->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultKompletacja->kmp_date_created) {
		if ($resultKompletacja->kmp_usr_created_id == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultKompletacja->kmp_usr_created_id);
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultKompletacja->kmp_date_created;
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultKompletacja->kmp_usr_created_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultKompletacja->kmp_date_created ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultKompletacja->kmp_date_modified) {
		if ($resultKompletacja->kmp_usr_modified_id == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultKompletacja->kmp_usr_modified_id);
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultKompletacja->kmp_date_modified;
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultKompletacja->kmp_usr_modified_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultKompletacja->kmp_date_modified ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
	if (!isset($masterPobId) && P('form_only', "0") != "1" && P('form_only', "0") != "5" && P('form_only', "0") != "6") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("KOMPLETACJA"), "\\'".rawurlencode($resultKompletacja->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (!isset($masterPobId) && P('form_only') != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['skl_ilosc_<?php echo $resultSkladnik->skl_id ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($kompletacjaDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_kompletacja") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('KOMPLETACJA') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$createForm = P('create_form', "virgo_default");
	if (is_null($createForm) || trim($createForm) == "" || $createForm == "virgo_default") {
?>
<?php
		if (isset($resultKompletacja->kmp_id)) {
			$resultKompletacja->kmp_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear") {

	}
?>
									
<?php
	if (class_exists('virgoSkladnik') && P('show_create_skladniki', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_create_towary', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultKompletacja->kmp_id)) {
			$resultKompletacja->kmp_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear") {

	}
?>
									
<?php
	if (class_exists('virgoSkladnik') && P('show_create_skladniki', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_create_towary', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultKompletacja->kmp_date_created) {
		if ($resultKompletacja->kmp_usr_created_id == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultKompletacja->kmp_usr_created_id);
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultKompletacja->kmp_date_created;
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultKompletacja->kmp_usr_created_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultKompletacja->kmp_date_created ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultKompletacja->kmp_date_modified) {
		if ($resultKompletacja->kmp_usr_modified_id == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultKompletacja->kmp_usr_modified_id);
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultKompletacja->kmp_date_modified;
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultKompletacja->kmp_usr_modified_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultKompletacja->kmp_date_modified ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
<?php
	$actions = virgoRole::getExtraActions('IC');
	if (isset($actions) && count($actions) > 0) {
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	} else {
?>
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
		if (!isset($masterPobId) && P('form_only', "0") != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div><?php 
	if ($this->canExecute("Form")) {
?>
 <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php 
	}
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
		}
		$actions = virgoRole::getExtraActions('EC');
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	}
?>

				</div>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($kompletacjaDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('KOMPLETACJA') ?>:</legend>
				<ul>
<?php
	$criteriaKompletacja = $resultKompletacja->getCriteria();
?>
<?php
	$context = null; //$session->get('GLOBAL-VIRGO_CONTEXT_usuniete');
?>	
<?php
	if (P('show_search_skladniki') == "1") {
?>
<?php
	$record = new virgoKompletacja();
	$recordId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
	$record->load($recordId);
	$subrecordsSkladniki = $record->getSkladniki();
	$sizeSkladniki = count($subrecordsSkladniki);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Składniki
					</label>
<?php
	if ($sizeSkladniki == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSkladniki as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSkladniki) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_towary') == "1") {
?>
<?php
	$record = new virgoKompletacja();
	$recordId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
	$record->load($recordId);
	$subrecordsTowary = $record->getTowary();
	$sizeTowary = count($subrecordsTowary);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Towary
					</label>
<?php
	if ($sizeTowary == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsTowary as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeTowary) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	unset($criteriaKompletacja);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_clear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Clear';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLEAR') ?>"
						/><div class="button_right"></div></div><?php						
	if (P('form_only', "0") != "2") {
?> <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
	</div>
<?php
/* MILESTONE 1.4 View */
	} elseif ($kompletacjaDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('KOMPLETACJA') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<dl class="dl-horizontal">
<?php
	}
?>
									<?php
	if (class_exists('virgoSkladnik') && P('show_view_skladniki', '0') == "1") {
?>
<?php
	$record = new virgoKompletacja();
	$recordId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
	$record->load($recordId);
	$subrecordsSkladniki = $record->getSkladniki();
	$sizeSkladniki = count($subrecordsSkladniki);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="kompletacja"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Składniki 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizeSkladniki == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSkladniki as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSkladniki) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_view_towary', '0') == "1") {
?>
<?php
	$record = new virgoKompletacja();
	$recordId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
	$record->load($recordId);
	$subrecordsTowary = $record->getTowary();
	$sizeTowary = count($subrecordsTowary);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="kompletacja"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Towary 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizeTowary == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsTowary as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeTowary) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>

<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</dl>
<?php
	}
?>
			</fieldset>
<?php
	} elseif ($editForm == "virgo_entity") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('KOMPLETACJA') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultKompletacja->kmp_date_created) {
		if ($resultKompletacja->kmp_usr_created_id == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultKompletacja->kmp_usr_created_id);
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultKompletacja->kmp_date_created;
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultKompletacja->kmp_usr_created_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultKompletacja->kmp_date_created ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultKompletacja->kmp_date_modified) {
		if ($resultKompletacja->kmp_usr_modified_id == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultKompletacja->kmp_usr_modified_id);
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultKompletacja->kmp_date_modified;
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultKompletacja->kmp_usr_modified_id ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultKompletacja->kmp_date_modified ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("KOMPLETACJA"), "\\'".$resultKompletacja->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (P('form_only') != "1" && P('form_only') != "7") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>

				</div>
	</div>
<?php
/* MILESTONE 1.5 Table */
	} elseif ($kompletacjaDisplayMode == "TABLE") {
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "kmp_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultsKompletacja = $resultKompletacja->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsKompletacja as $resultKompletacja) {
		if (isset($resultKompletacja[$eventColumn]) && isset($events[substr($resultKompletacja[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultKompletacja[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoKompletacja($resultKompletacja['kmp_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultKompletacja[$eventColumn], 0, 10)] = $eventsInDay;
	}
?>
<style type="text/css">
table.virgo_calendar_month {
	margin: 10px;
}

tr.virgo_calendar_week {
}

td.virgo_calendar_day, td.virgo_calendar_day:hover {
	border:1px solid #CCCCCC;
	font-size:20px;
	height:120px;
	padding:5px 0px;
	text-align:center;
	vertical-align:top;
	width:150px;
	color: black;
}

td.virgo_calendar_header {
	font-size:22px;
	padding: 0px 0px 10px 0px;
}

td.virgo_calendar_day {
	background-color: #FFFFFF;
}

td.virgo_calendar_day:hover {
	background-color: #FFFACD;
}

td.virgo_calendar_sunday:hover {
	background-color: #FFFACD;
	color: red !important;
}

td.virgo_calendar_day_empty {
	background: inherit;
	border: none;
}

td.virgo_calendar_sunday, td.virgo_calendar_holiday {
	color: red !important;
}
td.virgo_calendar_holiday div.holiday_name {
	font-size: 10px;
}

span.virgo_calendar_event, span.virgo_calendar_event:hover {
	font-size: 9px;
	cursor: pointer;
}

span.virgo_calendar_event_action, span.virgo_calendar_event_action:hover {
	border:1px dotted #999999;
	color:#999999;
	cursor:pointer;
	font-size:7px;
	margin:0 1px;
	padding:0 1px;
}

span.virgo_calendar_event:hover, span.virgo_calendar_event_action:hover {
	color: blue;
}

div.virgo_calendar_day_number {
}

td.virgo_calendar_weekday {
}

td.virgo_calendar_sunday {
	color: red;
}

td.virgo_calendar_today {
	background-color: #FFEEEE;
	border: 2px solid red;
}
td.virgo_calendar_today:hover {
	border: 2px solid grey;
}
td.virgo_calendar_day input.btn {
  background-color: khaki;
  background-image: none;
  border: medium none;
  border-radius: 0 0 0 0;
  color: blue;
  text-shadow: none;
  display: block !important;
  font-family: Comic Sans MS;
  font-size: 10px;
  line-height: 10px;
  margin-top: 1px;
  padding: 3px;
  width: 100%;
}
td.virgo_calendar_day div.inlineBlock {
  display: block !important;
}
td.virgo_calendar_day {
  cursor: default !important;
}
td.virgo_calendar_day div.virgo_calendar_day_number input.btn {
  display: inline;
  width: inherit;
  background-color: transparent;
  font-size: 20px;
  color: inherit;
  font-family: inherit;
  margin: auto;
  padding: 0px;
  box-shadow: none;
}
td.virgo_calendar_day div {
  text-align: center;
}
</style>
		<input
			type="hidden"
			id="<?php echo $eventColumn ?>_0" 
			name="<?php echo $eventColumn ?>_0"
			value=""
		>
		<table class='virgo_calendar_month' cellspacing="0" cellpadding="0">
			<tr>
<?php
	$tmpMonthDateTime = strtotime($selectedYear . "-" . $selectedMonth . "-01");
	$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
				<td colspan="7" align="center" class='virgo_calendar_header'><?php echo $tmpMonthDateString . " " . $selectedYear?></td>
			<tr>
			<tr class='virgo_calendar_weekdays'>
<?php
	$tmpMonthDateTime = strtotime("2010-07-26");
	for ($weekDay = 0; $weekDay <7; $weekDay++) {
		$tmpWeekDateString = strftime("%A", $tmpMonthDateTime + $weekDay * 24 * 60 * 60);
?>
				<td align="center" class='virgo_calendar_weekday <?php echo $weekDay == 6 ? "virgo_calendar_sunday" : "" ?>'><?php echo $tmpWeekDateString ?></td>
<?php
	}
?>			
			</tr>
			<tr class='virgo_calendar_week'>
				<input type='hidden' name='virgo_selected_day' value=''/>
				<input type='hidden' name='kmp_id_<?php echo $this->getId() ?>' value=''/>
<?php
	$tmpWeekDay = 1;
	$safety = 0;
	if ($tmpDay["wday"] > 0) {
		while ($tmpWeekDay != ((int)$tmpDay["wday"]) && $safety < 8) {
			echo "<td class='virgo_calendar_day_empty'></td>";
			$tmpWeekDay = $tmpWeekDay + 1;
			$safety = $safety + 1;
		}
	} else {
		for ($tmp=0; $tmp<6;$tmp++) {
			echo "<td class='virgo_calendar_day_empty'></td>";
		}
	}
	$safety = 0;
	while (((int)$tmpDay["mon"]) == ((int)$selectedMonth) && $safety < 31) {
		$tmpStringDay = $tmpDay["year"] . "-" . (str_pad($tmpDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($tmpDay["mday"], 2, "0", STR_PAD_LEFT));
		echo "<td class='virgo_calendar_day " . (((int)$tmpDay["wday"]) == 0 ? "virgo_calendar_sunday" : "") . " " . ($tmpStringDay == date("Y-m-d") ? "virgo_calendar_today" : "") . "'>";
		echo "<div class='virgo_calendar_day_number' >";		
		if ($this->canExecute("Add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_selected_day.value='<?php echo $tmpStringDay ?>';
 								form.target = '';
							" 
							value="<?php echo T($tmpDay['mday']) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		} else {
		echo $tmpDay["mday"];			
		}
		echo "</div>";
		if (isset($events[$tmpStringDay])) {
			$eventsInDay = $events[$tmpStringDay];
			foreach ($eventsInDay as $resultKompletacja) {
?>
<?php
	if (isset($resultKompletacja)) {
		$tmpId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultKompletacja->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.kmp_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
			}
		}
		echo "</td>";
		if (((int)$tmpDay["wday"]) == 0) {
			echo "</tr><tr class='virgo_calendar_week'>";
		}
		$tmpDay = getdate(strtotime($tmpDay["year"] . "-" .  $tmpDay["mon"] . "-" . (((int)$tmpDay["mday"])+1)));
		$safety = $safety + 1;
	}
?>
			</tr>
			<tr class="data_table_header">
								<td nowrap="nowrap" width="100%" align="center" colspan="7">
									<?php AB('PreviousYear', '&lArr;') ?>
									<?php AB('PreviousMonth', '&larr;') ?>
									<?php AB('CurrentMonth', T('CURRENT_MONTH')) ?>
									<select name="virgo_cal_selected_month" onChange="this.form.portlet_action.value='SetMonth';<?php echo JSFS() ?>" class="inputbox">
<?php
	for ($month = 1; $month <13; $month++) {
		$tmpMonthDateTime = strtotime("1970-" . $month . "-01");
		$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
										<option value="<?php echo $month ?>" <?php echo $month == $selectedMonth ? "selected='selected'" : "" ?>><?php echo $tmpMonthDateString ?></option>
<?php
	}
?>
									</select>
									<select name="virgo_cal_selected_year" onChange="this.form.portlet_action.value='SetYear';<?php echo JSFS() ?>" class="inputbox">
<?php
	/* 
		The last date/time that is working on 32-Bit machines:
		19.01.2038 03:14:07 ( =2147480047 )
	*/
	for ($tmpYear = 1970; $tmpYear < 2037; $tmpYear++) {
?>
										<option value="<?php echo $tmpYear ?>" <?php echo $tmpYear == $selectedYear ? "selected='selected'" : "" ?>><?php echo $tmpYear ?></option>
<?php
	}
?>
									</select>
									<?php AB('NextMonth', '&rarr;') ?>
									<?php AB('NextYear', '&rArr;') ?>
								</td>
			</tr>
		</table>
<?php
?>
<?php
		} else {
?>
		<script type="text/javascript">
			var kompletacjaChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == kompletacjaChildrenDivOpen) {
					div.style.display = 'none';
					kompletacjaChildrenDivOpen = '';
				} else {
					if (kompletacjaChildrenDivOpen != '') {
						document.getElementById(kompletacjaChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					kompletacjaChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				ids.value = '';
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(chcks[i].name.lastIndexOf("_")+1);
						}
					}
				}
			}
			
			function isOurCheckbox(name, pobId) {
				return name.match("^DELETE_" + pobId + "_\d*");
			}
			
			function nothingSelected(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						chcks[i].checked = value;
					}
				}
			}
			
			if (typeof portletCurrentTab === 'undefined') {
				var portletCurrentTab = new Array();
				function showOperations(tab, pobId) {
					var div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					var span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'none';
					span.className = 'operations_tab';
					portletCurrentTab[pobId] = tab;
					div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'block';
					span.className = 'operations_tab_current';
				}
				function changeDisplay(id) {
					var div = document.getElementById(id);
					div.style.display = div.style.display == "none" ? "inline-block" : "none";
				}
			}
			portletCurrentTab[<?php echo $this->getId() ?>] = "basic";
			
		</script>
<?php		
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaTowaru'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaTowaru'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoJednostka'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoJednostka'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultKompletacja->getShowPage(); 
			$showRows = $resultKompletacja->getShowRows(); 
?>
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<input type="hidden" name="virgo_parent_id" id="virgo_parent_id"/>
<?php
			$actionOnRowClick = P('action_on_row_click', 'Select');
			if ($actionOnRowClick == "Custom") {
				$actionOnRowClick = P('action_on_row_click_custom', 'Select');
			}
			$actionOnRowDoubleClick = P('action_on_row_double_click', 'View');
			if ($actionOnRowDoubleClick == "Custom") {
				$actionOnRowDoubleClick = P('action_on_row_click_custom', 'View');
			}
			$hint = virgoTranslation::translateToken('HINT_TOWAR');
			if (isset($hint)) {
?>
				<p><br/><?php echo $hint ?><br/><br/></p>
<?php
			}

?>
<?php echo P('master_mode', "0") == "1" ? "<div class='well sidebar-nav'>" : "" ?>
		<table class="data_table table table-striped table-hover table-condensed <?php echo P('form_only') == "4" ? "chessboard" : "" ?> <?php echo P('master_mode', "0") == "1" ? "nav nav-list" : "" ?>" cellpadding="0" cellspacing="<?php echo P('form_only') == "4"  ? "5" : "0" ?>" border="0">
<?php
			if (P('master_mode', "0") == "1") {
?>			
				<tr><td colspan="99" class="nav-header"><?php echo T('Kompletacje') ?></td></tr>
<?php
			}
?>			
<?php
			$virgoOrderColumn = $resultKompletacja->getOrderColumn();
			$virgoOrderMode = $resultKompletacja->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsKompletacja = $resultKompletacja->getTableData($resultCount, $filterApplied);

			if (P('form_only') != "4") {
?>		
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
			if ($this->canExecute("delete")) {
?>
			<th rowspan="2">
			</th>
<?php
			}
?>
									<?php
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getAlias();
			$masterObject = new $className();
			$tmp2Id = $masterObject->getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
?>
<?php
	if (class_exists('virgoSkladnik') && P('show_table_skladniki', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_table_towary', '0') == "1") {
?>
<?php
	}
?>
				<th rowspan="2"></th>
			</tr>
			<tr class="data_table_header">

			</tr>

<?php
			}
			if ($resultCount != 0) {
				if (((int)$showRows) * (((int)$showPage)-1) == $resultCount ) {
					$showPage = ((int)$showPage)-1;
					$resultKompletacja->setShowPage($showPage);
				}
				$index = 0;
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsKompletacja as $resultKompletacja) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/virgoKompletacja/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultKompletacja['kmp_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoKompletacja::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoKompletacja::setContextId($resultKompletacja['kmp_id'], false);
						$tmpContextId = $resultKompletacja['kmp_id'];
					}
				}
				if (isset($tmpContextId) && $resultKompletacja['kmp_id'] == $tmpContextId) {
					if (P('form_only') != "4") {
						$contextClass = ' contextClass ';
					} else {
						$contextClass = '';
					}
					$contextRowIdInTable = $tmpContextId;
				} else {
					$contextClass = '';
				}
?>
			<tr 
				id="<?php echo $this->getId() ?>_<?php echo isset($resultKompletacja['kmp_id']) ? $resultKompletacja['kmp_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
			" 
			>
<?php
			} 
?>
<?php
			if (P('form_only') == "4") {
				$width = P('chessboard_cell_width');
				$height = P('chessboard_cell_height');
				if ($width != "0") {
					$styleWidth = " width: " . $width . "px; ";
				}
				if ($height != "0") {
					$styleHeight = " height: " . $height . "px; ";
				}
				$style = "";
				if (!is_null($styleWidth) || !is_null($styleHeight)) {
					$style = " style='" . $styleWidth . $styleHeight . "' ";
				}
?>
				<td 
					class="chessboard" 
					valign="top" 
					<?php echo $style ?>
				>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultKompletacja['kmp_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultKompletacja['kmp_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
	if (class_exists('virgoSkladnik') && P('show_table_skladniki', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_table_towary', '0') == "1") {
?>
<?php
	}
?>
<?php
?>
<?php
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>
<?php
	if (isset($resultKompletacja)) {
		$tmpId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("KOMPLETACJA"), "\\'".rawurlencode($resultKompletacja['kmp_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
	if (P('form_only') != "4") {
?>
<?php
		if (isset($tabModeChildrenList["skladnik"])) {
			$tabModeChildrenMenu = $tabModeChildrenList["skladnik"];
			if (!is_null($tabModeChildrenMenu) && $tabModeChildrenMenu != -1) { 
				$menu =& JSite::getMenu();
				$item = $menu->getItem($tabModeChildrenMenu);
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('ShowForKompletacja')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_showforkompletacja inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ShowForKompletacja';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.action='<?php echo $live_site ?>/index.php/<?php echo $item->alias ?>';this.form.virgo_class.value='virgoSkladnik';
 								form.target = '';
							" 
							value="<?php echo T('SKLADNIKI') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
		}
?><?php
		if (isset($tabModeChildrenList["towar"])) {
			$tabModeChildrenMenu = $tabModeChildrenList["towar"];
			if (!is_null($tabModeChildrenMenu) && $tabModeChildrenMenu != -1) { 
				$menu =& JSite::getMenu();
				$item = $menu->getItem($tabModeChildrenMenu);
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('ShowForKompletacja')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_showforkompletacja inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ShowForKompletacja';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.action='<?php echo $live_site ?>/index.php/<?php echo $item->alias ?>';this.form.virgo_class.value='virgoTowar';
 								form.target = '';
							" 
							value="<?php echo T('TOWARY') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
		}
?><?php
	}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

				</td>
<?php
			} else {
?>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultKompletacja['kmp_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultKompletacja['kmp_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
	if (class_exists('virgoSkladnik') && P('show_table_skladniki', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('virgoTowar') && P('show_table_towary', '0') == "1") {
?>
<?php
	}
?>
<?php
?>
<?php
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>
<?php
	if (isset($resultKompletacja)) {
		$tmpId = is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id;
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("KOMPLETACJA"), "\\'".rawurlencode($resultKompletacja['kmp_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
	if (P('form_only') != "4") {
?>
<?php
		if (isset($tabModeChildrenList["skladnik"])) {
			$tabModeChildrenMenu = $tabModeChildrenList["skladnik"];
			if (!is_null($tabModeChildrenMenu) && $tabModeChildrenMenu != -1) { 
				$menu =& JSite::getMenu();
				$item = $menu->getItem($tabModeChildrenMenu);
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('ShowForKompletacja')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_showforkompletacja inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ShowForKompletacja';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.action='<?php echo $live_site ?>/index.php/<?php echo $item->alias ?>';this.form.virgo_class.value='virgoSkladnik';
 								form.target = '';
							" 
							value="<?php echo T('SKLADNIKI') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
		}
?><?php
		if (isset($tabModeChildrenList["towar"])) {
			$tabModeChildrenMenu = $tabModeChildrenList["towar"];
			if (!is_null($tabModeChildrenMenu) && $tabModeChildrenMenu != -1) { 
				$menu =& JSite::getMenu();
				$item = $menu->getItem($tabModeChildrenMenu);
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('ShowForKompletacja')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_showforkompletacja inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ShowForKompletacja';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.action='<?php echo $live_site ?>/index.php/<?php echo $item->alias ?>';this.form.virgo_class.value='virgoTowar';
 								form.target = '';
							" 
							value="<?php echo T('TOWARY') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
		}
?><?php
	}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

<?php
			}
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 0)) {
?>
			</tr>
<?php
			} 
?>

<?php
} else {
	include($fileNameToInclude);
}
?>
<?php
				}
	if (is_null($contextRowIdInTable)) {
		$forceContextOnFirstRow = P('force_context_on_first_row', "1");
		if ($forceContextOnFirstRow == "1") {
			virgoKompletacja::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultKompletacja);
				unset($resultsKompletacja);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpKompletacja = new virgoKompletacja();
						$tmpCount = $tmpKompletacja->getAllRecordCount(' kmp_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoKompletacja::clearRemoteContextId($tabModeEditMenu);
						}
					}
				}
?>			
<?php
				if ($showRows == 'all') {
					$pageCount = 1;
				} else {
					$pageCount = (int)($resultCount / $showRows) + 1;
					if ($resultCount % $showRows == 0) {
						$pageCount = $pageCount - 1;
					}
				}
?>
<?php
	if (P('master_mode', "0") != "1") {
?>
<?php
		if (P('default_page_size', "20") != 'all' || P('available_page_sizes', "5,10,20,50,all") != "all") {
?>
			<tr class="table_footer">
				<td colspan="99" nowrap="nowrap">
						<table cellspacing="0" cellpadding="0" width="100%">
							<tr class="table_footer">
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("form")) {
$showSelectAll = TRUE;
?>
								<td nowrap="nowrap" width="33%" align="left" class="select_all">
<?php echo T('SELECT_ALL') ?>									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php echo T('SELECT_ALL') ?>								<td nowrap="nowrap" width="33%" align="left" class="select_all">
									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
}
?>
								<td nowrap="nowrap" width="34%" align="center" class="select_page">
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-first.png" type="image" value="&#x21E4" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-previous.png" type="image" value="&#x2190" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage - 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
<?php echo T('PAGE') ?><?php
	if ($pageCount > 100) {
?>
		<input class="inputbox" size="5" value="<?php echo $showPage ?>" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
	} else {
?>
									<select class="inputbox" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
				$tmpPageIndex = 1;
				while ($tmpPageIndex <= $pageCount) {
		
?>
										<option value="<?php echo ($tmpPageIndex) ?>" <?php echo ($tmpPageIndex == $showPage ? "selected='selected'" : "") ?>><?php echo ($tmpPageIndex) ?></option>
<?php
					$tmpPageIndex = $tmpPageIndex + 1;
				}
?>
									</select>
<?php
	}
?>
<?php echo T('OF') ?>									<?php echo ($pageCount) ?>
									<input type="hidden" name="virgo_show_page" value="<?php echo ($showPage) ?>">
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-next.png" type="image" value="&#x2192" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage + 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-last.png" type="image" value="&#x21E5" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($pageCount) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
								</td>
								<td width="33%" nowrap="nowrap" align="right" class="show_rows"><?php echo T('SHOW_ROWS') ?> (<?php echo $resultCount ?>):&nbsp;<select class="inputbox" name="virgo_show_rows" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging';
<?php echo JSFS() ?>									
">
<?php
										$paramValue = P('available_page_sizes', "5,10,20,50,all");
										$pageSizes = preg_split("/,/", $paramValue);
										foreach ($pageSizes as $pageSize) {
?>
										<option value="<?php echo $pageSize ?>" <?php echo ($showRows == $pageSize ? "selected='selected'" : "") ?>><?php echo ($pageSize == 'all' ? T('ALL')
 : $pageSize) ?></option>
<?php											
										}
?>
									</select>
								</td>
							</tr>
						</table>
				</td>
			</tr>
<?php
		}
?>
<?php
	}
?>
<?php
			} else {
?>
				<tr>
					<td colspan="99">
						<div class="message"><?php echo ($filterApplied ? T('NO_RESULTS')
 : T('NO_DATA_TO_SHOW')
) ?></div>
					</td>
				</tr>
<?php
			}
?>
		</table>
<?php echo P('master_mode', "0") == "1" ? "</div>" : "" ?>		
<script type='text/javascript'>
	var timer = null;
	var clicks<?php echo $this->getId() ?> = 0;
	var clicked<?php echo $this->getId() ?> = null;
$(document).ready(function() {
    $('form#portlet_form_<?php echo $this->getId() ?> table.data_table td.selectable')
    .on('click', function(e){
    	clicked<?php echo $this->getId() ?> = $(this);
        clicks<?php echo $this->getId() ?> = clicks<?php echo $this->getId() ?> + 1;
        if(clicks<?php echo $this->getId() ?> === 1) {
            var rowId = $(this).parent().attr('id');
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
            timer = setTimeout(function() {
            	clicked<?php echo $this->getId() ?>.css('cursor','progress');
<?php
		$ajax = $this->getAjax();;
		if ($actionOnRowClick == "Select" && isset($ajax) && $ajax) {
			$page = virgoPage::getCurrentPage();
?>
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&kmp_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
<?php
			if (P('form_only') != "4") {
?>
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr.contextClass').removeClass("contextClass");
<?php
			}			
?>			
<?php
		$pobId = $this->getId();
		$ret = "";
		$pobsToSkip[] = $pobId;
		$page = virgoPage::getCurrentPage();
		$query = "
SELECT plc_pob_id AS do_odswiezenia
FROM prt_portlet_locations, prt_portlet_parameters
WHERE plc_pge_id = " . $page->getId() . "
AND plc_pob_id = ppr_pob_id 
AND (ppr_value = '{$pobId}' OR ppr_value LIKE '%,{$pobId}' OR ppr_value LIKE '%,{$pobId}' OR ppr_value LIKE '{$pobId},%' OR ppr_value LIKE '%,{$pobId},%')
AND (ppr_name = 'parent_entity_pob_id' OR ppr_name = 'master_entity_pob_id')
";
		$rows = QR($query);
		if ($rows && count($rows) > 0) {
			foreach ($rows as $row) {
				$ret = $ret . JSFS($row['do_odswiezenia'], "Submit", true, $pobsToSkip);					
			}
		}
$query = "
SELECT CONVERT(ppr_value, SIGNED) AS do_odswiezenia
FROM prt_portlet_parameters
WHERE ppr_pob_id = " . $pobId . " 
AND ppr_name = 'master_entity_pob_id'
";		
		$rows = QR($query);
		if ($rows && count($rows) > 0) {
			foreach ($rows as $row) {
				$ret = $ret . JSFS($row['do_odswiezenia'], "Submit", true, $pobsToSkip);					
			}
		}
		echo $ret;
?>
<?php
		if (P('form_only') != "4") {
?>
		if (data) {
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#' + rowId).addClass("contextClass");
		}
<?php
		}
?>		
		clicked<?php echo $this->getId() ?>.css('cursor','pointer');        
		});
<?php
		} else {
?>
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowClick ?>'; 
		form.kmp_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
			if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
			} else {
?>					
		<?php echo JSFS(null, "Submit", true, array()) ?>
<?php
			}
		}
?>					
                clicks<?php echo $this->getId() ?> = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            var rowId = $(this).parent().attr('id');            
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowDoubleClick ?>'; 
		form.kmp_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
	global $ajax;
	if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
	} else {
?>					
		<?php echo JSFS() ?>
<?php
	}
?>					
            clicks<?php echo $this->getId() ?> = 0;
        }
    })
    .on('dblclick', function(e){
        e.preventDefault();
    });
});
</script>		
<?php
	$showBasic = false;
	$showImport = false;
	$showSelected = false;
	$anythingRendered = false;
?>
		<span class="operations_tabs"><span id="table_operations" style="text-align: center;" class="table_footer_buttons"<?php echo P('form_only') == "4" ? " style='background-color: #FFFFFF;'" : "" ?>>
					<span id="control_basic_<?php echo $this->getId() ?>" class="operations_tab_current" onclick="showOperations('basic', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_BASIC') ?></span>
					<span id="control_import_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('import', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_IMPORT') ?></span>
					<span id="control_selected_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('selected', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_SELECTED') ?></span>
					<div id="operations_basic_<?php echo $this->getId() ?>" class="operations">
		</span>
<?php
			if ($this->canExecute("add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('ADD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			if ($this->canExecute("SearchForm")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('SearchForm')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_searchform inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='SearchForm';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php
			if ($this->canExecute("report")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Report')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_report inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'kmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'kmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('REPORT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			if ($this->canExecute("export")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Export')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_export inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'kmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'kmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('CSV') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			if ($this->canExecute("add")) {
			if ($this->canExecute("form")) {
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Offline')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_offline inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'kmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'kmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('EXCEL') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			}
			}
?>
<?php
	if (true) { //$user->username == "metaadmin" && $user->get( 'gid' ) == 25) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('UpdateTitle')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_updatetitle inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='UpdateTitle';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPDATE_TITLE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
			$actions = virgoRole::getExtraActions('ET');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
?>
					</div>
					<div id="operations_import_<?php echo $this->getId() ?>" style="display: none;" class="operations">
<?php
			if ($this->canExecute("upload")) {
?>
			<input type="file" name="virgo_upload_file">
<?php
				$separatorString = ","; //$componentParams->get('import_separator');
				if ($separatorString == "") {
?>
			<input name="field_separator_in_import" size="1"
<?php
					$sessionSeparator = virgoKompletacja::getImportFieldSeparator();
					if (!is_null($sessionSeparator)) {
?>
						value="<?php $sessionSeparator ?>"
<?php
					}
?>
			>
<?php
				} else {
					$separators = preg_split("/X/", $separatorString);
					if (sizeof($separators) == 1) {
?>
			<input type="hidden" name="field_separator_in_import" value="<?php echo $separators[0] ?>">
<?php
					} else {
?>
			<select name="field_separator_in_import">
<?php
						$sessionSeparator = virgoKompletacja::getImportFieldSeparator();
						foreach ($separators as $separator) {
?>
				<option value="<?php echo $separator ?>" 
<?php
							if ($sessionSeparator == $separator) {
?>
					selected="selected"
<?php
							}
?>
				><?php echo $separator ?></option>
<?php
						}
?>
			</select>
<?php						
					}
				}
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Upload')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_upload inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Upload';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPLOAD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showImport = true;
	}
			}
?>
					</div>
<?php
	if (!$showImport) {
?>
<script type="text/javascript">
	document.getElementById('control_import_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
					<div id="operations_selected_<?php echo $this->getId() ?>" style="display: none;"  class="operations">
			<input type="hidden" name="ids" value="">
<?php
			if ($this->canExecute("edit")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('EditSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_editselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='EditSelected';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('EDIT_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('DeleteSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_deleteselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('KOMPLETACJE'), "") ?>'))) return false;
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='DeleteSelected';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('DELETE_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
?>





					</div>
		</span>
<?php
	if (!$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_selected_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
<?php
	if (!$showImport && !$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
	if (!$anythingRendered) {
?>
<script type="text/javascript">
	document.getElementById('operations_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php		
	}
?>


<?php
		}
/* MILESTONE 1.6 TableForm */
	} elseif ($kompletacjaDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_kompletacja") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var kompletacjaChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == kompletacjaChildrenDivOpen) {
					div.style.display = 'none';
					kompletacjaChildrenDivOpen = '';
				} else {
					if (kompletacjaChildrenDivOpen != '') {
						document.getElementById(kompletacjaChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					kompletacjaChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(7);
						}
					}
				}
				form.submit();
			}
			
			function nothingSelected(form) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

	<form method="post" style="display: inline;" action="" id="virgo_form_kompletacja" name="virgo_form_kompletacja" enctype="multipart/form-data">
						<input type="text" name="kmp_id_<?php echo $this->getId() ?>" id="kmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsKompletacja = $resultKompletacja->getRecordsToEdit();
				$idsToCorrect = $resultKompletacja->getInvalidRecords();
				$index = 0;
				foreach ($resultsKompletacja as $resultKompletacja) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultKompletacja->kmp_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultKompletacja->kmp_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
?>
<?php
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultKompletacja->kmp_id])) {
		$errorMessage = $idsToCorrect[$resultKompletacja->kmp_id];
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">

				</td>
			</tr>

<?php
				}
?>		
				<tr>
					<td colspan="99" align="center">
						<input type="hidden" name="virgo_changed" value="N">
						<input type="hidden" name="virgo_validate_new" value="<?php echo R('virgo_validate_new', "N") ?>">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storeselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreSelected';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
			if ($this->canExecute("add")) {
?>						
						<div id="add_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'inline-block' : 'none' ?>" ><input type="button" class="button" value="<?php echo T('ADD') ?>" onclick="this.form.virgo_validate_new.value='Y'; document.getElementById('virgo_tr_id_0').style.display='table-row'; document.getElementById('remove_button').style.display='inline-block'; document.getElementById('add_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
						<div id="remove_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'none' : 'inline-block' ?>" ><input type="button" class="button" value="<?php echo T('REMOVE') ?>" onclick="this.form.virgo_validate_new.value='N'; document.getElementById('virgo_tr_id_0').style.display='none'; document.getElementById('add_button').style.display='inline-block'; document.getElementById('remove_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
<?php
			}
?>						
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $kompletacjaDisplayMode ?>">
<?php
?>
			<div class="buttons form-actions">
<?php
				if ($virgoShowReturn) {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'kmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultKompletacja) ? (is_array($resultKompletacja) ? $resultKompletacja['kmp_id'] : $resultKompletacja->kmp_id) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
				}
?>
			</div>
		</div>
<?php
	}
} 
?>


		</div>
	</div>
</div>
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_slk_kompletacja" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_slk_kompletacja').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
</table>
</td>
<td valign="top">
<table>
	<tr>
		<td colspan="2">
			<b>Bean:</b>
		</td>
	</tr>
<?php
	$infos = virgoKompletacja::getExtraFilesInfo();
	foreach ($infos as $fileName => $date) {
?>
	<tr>
		<td align="right">
			<?php echo $fileName ?>
		</td>
		<td align="left">
			<?php echo $date ?>
		</td>
	</tr>
<?php
	}
?>
</table>
</td></tr></table>
</div>
<?php 
		if ($underConstruction == "1" && !is_null($user) && $user->username == "admin") {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	}
?>


