<?php
	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	if (preg_match("/.*.metadetron.com/i", $_SERVER["SERVER_NAME"])) {
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	} 
	ini_set('display_errors', 1);

	use portal\virgoRole;
	use portal\virgoPage;
	use portal\virgoUser;
	use portal\virgoPortletObject;
	use sealock\virgoPozycjaZamowienia;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_slk_pozycja_zamowienia');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_slk_pozycja_zamowienia/sealock.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'slk_pzm.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/sealock/virgoPozycjaZamowienia/slk_pzm.css" type="text/css" /> 
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
<div class="virgo_container_sealock virgo_container_entity_pozycja_zamowienia" style="border: none;">
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
		$tmpParents[] = "towar";
		$parents["skladnik"] = $tmpParents;
		$tablePrefixes["bilans_otwarcia"] = "bot";
//		$classNames["bilans_otwarcia"] = "virgoBilansOtwarcia";
		$entityNames["bilans_otwarcia"] = "BilansOtwarcia";
		$tmpParents = array();
		$tmpParents[] = "status_bilans_otwarcia";
		$tmpParents[] = "magazyn";
		$parents["bilans_otwarcia"] = $tmpParents;
		$tablePrefixes["status_bilans_otwarcia"] = "sbo";
//		$classNames["status_bilans_otwarcia"] = "virgoStatusBilansOtwarcia";
		$entityNames["status_bilans_otwarcia"] = "StatusBilansOtwarcia";
		$tmpParents = array();
		$parents["status_bilans_otwarcia"] = $tmpParents;
		$tablePrefixes["status_bilans_otwarcia_workflow"] = "sbw";
//		$classNames["status_bilans_otwarcia_workflow"] = "virgoStatusBilansOtwarciaWorkflow";
		$entityNames["status_bilans_otwarcia_workflow"] = "StatusBilansOtwarciaWorkflow";
		$tmpParents = array();
		$tmpParents[] = "status_bilans_otwarcia";
		$tmpParents[] = "status_bilans_otwarcia";
		$parents["status_bilans_otwarcia_workflow"] = $tmpParents;
		$tablePrefixes["magazyn"] = "mgz";
//		$classNames["magazyn"] = "virgoMagazyn";
		$entityNames["magazyn"] = "Magazyn";
		$tmpParents = array();
		$parents["magazyn"] = $tmpParents;
		$tablePrefixes["pozycja_bilansu"] = "pbl";
//		$classNames["pozycja_bilansu"] = "virgoPozycjaBilansu";
		$entityNames["pozycja_bilansu"] = "PozycjaBilansu";
		$tmpParents = array();
		$tmpParents[] = "towar";
		$tmpParents[] = "bilans_otwarcia";
		$parents["pozycja_bilansu"] = $tmpParents;
		$tablePrefixes["informacja"] = "inf";
//		$classNames["informacja"] = "virgoInformacja";
		$entityNames["informacja"] = "Informacja";
		$tmpParents = array();
		$parents["informacja"] = $tmpParents;
		$tablePrefixes["grupa_dokumentow"] = "gdk";
//		$classNames["grupa_dokumentow"] = "virgoGrupaDokumentow";
		$entityNames["grupa_dokumentow"] = "GrupaDokumentow";
		$tmpParents = array();
		$parents["grupa_dokumentow"] = $tmpParents;
		$tablePrefixes["rodzaj_dokumentu"] = "rdk";
//		$classNames["rodzaj_dokumentu"] = "virgoRodzajDokumentu";
		$entityNames["rodzaj_dokumentu"] = "RodzajDokumentu";
		$tmpParents = array();
		$tmpParents[] = "grupa_dokumentow";
		$parents["rodzaj_dokumentu"] = $tmpParents;
		$tablePrefixes["dokument_ksiegowy"] = "dks";
//		$classNames["dokument_ksiegowy"] = "virgoDokumentKsiegowy";
		$entityNames["dokument_ksiegowy"] = "DokumentKsiegowy";
		$tmpParents = array();
		$tmpParents[] = "rodzaj_dokumentu";
		$parents["dokument_ksiegowy"] = $tmpParents;
		$tablePrefixes["pozycja_dokumentu"] = "pdk";
//		$classNames["pozycja_dokumentu"] = "virgoPozycjaDokumentu";
		$entityNames["pozycja_dokumentu"] = "PozycjaDokumentu";
		$tmpParents = array();
		$tmpParents[] = "produkt";
		$tmpParents[] = "dokument_ksiegowy";
		$parents["pozycja_dokumentu"] = $tmpParents;
		$ancestors = array();
		$ancestors["zamowienie"] = "TRUE";
		$ancestors["wydanie"] = "TRUE";
		$ancestors["produkt"] = "TRUE";
		$ancestors["odbiorca"] = "TRUE";
		$ancestors["towar"] = "TRUE";
		$contextId = null;		
			$resultPozycjaZamowienia = virgoPozycjaZamowienia::createGuiAware();
			$contextId = $resultPozycjaZamowienia->getContextId();
			if (isset($contextId)) {
				if (virgoPozycjaZamowienia::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultPozycjaZamowienia->load($contextId);
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
				1.4 
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
		if ($className == "virgoPozycjaZamowienia") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultPozycjaZamowienia = new virgoPozycjaZamowienia($tmpId);
				virgoPozycjaZamowienia::setDisplayMode("FORM");
			} else {
				$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
				virgoPozycjaZamowienia::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultPozycjaZamowienia->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultPozycjaZamowienia->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultPozycjaZamowienia = new virgoPozycjaZamowienia($allPrivateRecords[0]['pzm_id']);
						$resultPozycjaZamowienia->putInContext(false);
					} else {
						$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultPozycjaZamowienia->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultPozycjaZamowienia = new virgoPozycjaZamowienia($records[0]['pzm_id']);
							$resultPozycjaZamowienia->putInContext(false);
						} else {
							$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
						}
					} else {
						$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia(virgoUser::getUserId());
			$resultPozycjaZamowienia->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultPozycjaZamowienia = new virgoPozycjaZamowienia();
		}
?>
<?php
	$pozycjaZamowieniaDisplayMode = virgoPozycjaZamowienia::getDisplayMode();
//	if ($pozycjaZamowieniaDisplayMode == "" || $pozycjaZamowieniaDisplayMode == "TABLE") {
//		$resultPozycjaZamowienia = $resultPozycjaZamowienia->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultPozycjaZamowienia->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClausePozycjaZamowienia = $whereClausePozycjaZamowienia . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaPozycjaZamowienia = $resultPozycjaZamowienia->getCriteria();
		$countTmp = 0;
		if (isset($criteriaPozycjaZamowienia["ilosc"])) {
			$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
			if ($fieldCriteriaIlosc["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaIlosc["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPozycjaZamowienia["cena_netto"])) {
			$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
			if ($fieldCriteriaCenaNetto["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPozycjaZamowienia["cena_brutto"])) {
			$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
			if ($fieldCriteriaCenaBrutto["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
				$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPozycjaZamowienia["zamowienie"])) {
			$parentCriteria = $criteriaPozycjaZamowienia["zamowienie"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPozycjaZamowienia["towar"])) {
			$parentCriteria = $criteriaPozycjaZamowienia["towar"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPozycjaZamowienia["wydanie"])) {
			$parentCriteria = $criteriaPozycjaZamowienia["wydanie"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (is_null($criteriaPozycjaZamowienia) || sizeof($criteriaPozycjaZamowienia) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaPozycjaZamowienia["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ilość') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaIlosc["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ilosc';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
					$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ilość') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ilosc';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_netto"])) {
				$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
				if ($fieldCriteriaCenaNetto["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Cena netto') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaCenaNetto["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaCenaNetto["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='cena_netto';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
					$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Cena netto') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='cena_netto';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["cena_brutto"])) {
				$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
				if ($fieldCriteriaCenaBrutto["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Cena brutto') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaCenaBrutto["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaCenaBrutto["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='cena_brutto';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
					$renderCriteria = "";
			$conditionFrom = $dataTypeCriteria["from"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$renderCriteria = $renderCriteria . " >= " . $conditionFrom;
			}
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$renderCriteria = $renderCriteria . " =< " . $conditionTo;
			}			
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Cena brutto') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='cena_brutto';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["zamowienie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["zamowienie"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Zamówienie') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zamowienie';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('zamowienie') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zamowienie';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["towar"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["towar"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Towar') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='towar';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('towar') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='towar';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPozycjaZamowienia["wydanie"])) {
				$parentCriteria = $criteriaPozycjaZamowienia["wydanie"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Wydanie') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wydanie';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('wydanie') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wydanie';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
?>
			</table>
<?php
		}
?>
<?php
		}
?>
<?php
PROFILE('token');
	if (isset($resultPozycjaZamowienia)) {
		$tmpId = is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($pozycjaZamowieniaDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
			|| $tmpAction == "StoreNewZamowienie"
			|| $tmpAction == "StoreNewTowar"
			|| $tmpAction == "StoreNewWydanie"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultPozycjaZamowienia->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultPozycjaZamowienia->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$pozycjaZamowieniaDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultPozycjaZamowienia->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($pozycjaZamowieniaDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_pozycja_zamowienia") {
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
<?php echo T('POZYCJA_ZAMOWIENIA') ?>:</legend>
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
	if (P('show_form_ilosc', "1") == "1" || P('show_form_ilosc', "1") == "2") {
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
					<label 
						nowrap="nowrap"
						class="fieldlabel  obligatory   ilosc decimal" 
						for="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>"
					>* <?php echo T('ILOSC') ?>
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
					<span align="left" nowrap>
<?php
	if (P('show_form_ilosc', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getIlosc(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="ilosc" name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ILOSC');
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
$('#pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_form_cena_netto', "1") == "1" || P('show_form_cena_netto', "1") == "2") {
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
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?>   cena_netto decimal" 
						for="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>"
					> <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_NETTO') ?>
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
					<span align="left" nowrap>
<?php
	if (P('show_form_cena_netto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaNetto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaNetto" name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_NETTO');
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
$('#pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_form_cena_brutto', "1") == "1" || P('show_form_cena_brutto', "1") == "2") {
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
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?>   cena_brutto decimal" 
						for="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>"
					> <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_BRUTTO') ?>
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
					<span align="left" nowrap>
<?php
	if (P('show_form_cena_brutto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaBrutto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaBrutto" name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_BRUTTO');
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
$('#pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (class_exists('sealock\virgoZamowienie') && ((P('show_form_zamowienie', "1") == "1" || P('show_form_zamowienie', "1") == "2" || P('show_form_zamowienie', "1") == "3") && !isset($context["zmw"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_zamowienie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('ZAMOWIENIE_'); echo !is_null($customLabel) ? $customLabel : T('ZAMOWIENIE') . ' ' . T('') ?> 
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
//		$limit_zamowienie = $componentParams->get('limit_to_zamowienie');
		$limit_zamowienie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoZamowienie");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_zamowienie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_zmw__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getZmwId())) {
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentValue = sealock\virgoZamowienie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ZAMOWIENIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_zamowienie) && trim($limit_zamowienie) != "") {
		$whereList = $whereList . " zmw_id ";
		if (trim($limit_zamowienie) == "page_title") {
			$limit_zamowienie = "SELECT zmw_id FROM slk_zamowienia WHERE zmw_" . $limit_zamowienie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_zamowienie = \"$limit_zamowienie\";");
		$whereList = $whereList . " IN (" . $limit_zamowienie . ") ";
	}						
	$parentCount = sealock\virgoZamowienie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_zamowienie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_zamowienie) || trim($limit_zamowienie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsZamowienie = sealock\virgoZamowienie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsZamowienie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getZmwId()) && $id == $resultPozycjaZamowienia->getZmwId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentZamowienie = new sealock\virgoZamowienie();
				$parentValue = $parentZamowienie->lookup($parentId);
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
	<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Zamowienie",
			virgo_field_name: "zamowienie",
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
					$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddZamowienie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addzamowienie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["zmw"])) {
		$parentValue = $context["zmw"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_zmw_id;
	}
	
?>
				<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoTowar') && ((P('show_form_towar', "1") == "1" || P('show_form_towar', "1") == "2" || P('show_form_towar', "1") == "3") && !isset($context["twr"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_towar_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('TOWAR_'); echo !is_null($customLabel) ? $customLabel : T('TOWAR') . ' ' . T('') ?> 
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
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoTowar");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_towar', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_twr__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getTwrId())) {
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentValue = sealock\virgoTowar::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_TOWAR');
?>
<?php
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = sealock\virgoTowar::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			$resultsTowar = sealock\virgoTowar::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getTwrId()) && $id == $resultPozycjaZamowienia->getTwrId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentTowar = new sealock\virgoTowar();
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
	<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
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
					$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddTowar')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addtowar inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["twr"])) {
		$parentValue = $context["twr"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_twr_id;
	}
	
?>
				<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoWydanie') && ((P('show_form_wydanie', "1") == "1" || P('show_form_wydanie', "1") == "2" || P('show_form_wydanie', "1") == "3") && !isset($context["wdn"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_wydanie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('WYDANIE_'); echo !is_null($customLabel) ? $customLabel : T('WYDANIE') . ' ' . T('') ?> 
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
//		$limit_wydanie = $componentParams->get('limit_to_wydanie');
		$limit_wydanie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoWydanie");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_wydanie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_wdn__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getWdnId())) {
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentValue = sealock\virgoWydanie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_WYDANIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_wydanie) && trim($limit_wydanie) != "") {
		$whereList = $whereList . " wdn_id ";
		if (trim($limit_wydanie) == "page_title") {
			$limit_wydanie = "SELECT wdn_id FROM slk_wydania WHERE wdn_" . $limit_wydanie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_wydanie = \"$limit_wydanie\";");
		$whereList = $whereList . " IN (" . $limit_wydanie . ") ";
	}						
	$parentCount = sealock\virgoWydanie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_wydanie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_wydanie) || trim($limit_wydanie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsWydanie = sealock\virgoWydanie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsWydanie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getWdnId()) && $id == $resultPozycjaZamowienia->getWdnId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentWydanie = new sealock\virgoWydanie();
				$parentValue = $parentWydanie->lookup($parentId);
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
	<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Wydanie",
			virgo_field_name: "wydanie",
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
					$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddWydanie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addwydanie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["wdn"])) {
		$parentValue = $context["wdn"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_wdn_id;
	}
	
?>
				<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
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
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPozycjaZamowienia->getDateCreated()) {
		if ($resultPozycjaZamowienia->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPozycjaZamowienia->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPozycjaZamowienia->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPozycjaZamowienia->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPozycjaZamowienia->getDateModified()) {
		if ($resultPozycjaZamowienia->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPozycjaZamowienia->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPozycjaZamowienia->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPozycjaZamowienia->getDateModified() ?>"	>
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
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("POZYCJA_ZAMOWIENIA"), "\\'".rawurlencode($resultPozycjaZamowienia->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($pozycjaZamowieniaDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_pozycja_zamowienia") {
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
<?php echo T('POZYCJA_ZAMOWIENIA') ?>:</legend>
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
		if (isset($resultPozycjaZamowienia->pzm_id)) {
			$resultPozycjaZamowienia->pzm_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_zamowienie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoZamowienie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoZamowienie::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setZmwId($defaultValue);
}
$defaultValue = P('create_default_value_towar');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTowar::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTowar::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setTwrId($defaultValue);
}
$defaultValue = P('create_default_value_wydanie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoWydanie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoWydanie::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setWdnId($defaultValue);
}
	}
?>
																																																						<?php
	if (P('show_create_ilosc', "1") == "1" || P('show_create_ilosc', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>">
* <?php echo T('ILOSC') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ilosc") {
				$resultPozycjaZamowienia->setIlosc($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ilosc', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getIlosc(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="ilosc" name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ILOSC');
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
$('#pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_cena_netto', "1") == "1" || P('show_create_cena_netto', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>">
 <?php echo P('show_create_cena_netto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_NETTO') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "cena_netto") {
				$resultPozycjaZamowienia->setCenaNetto($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_cena_netto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaNetto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaNetto" name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_NETTO');
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
$('#pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_cena_brutto', "1") == "1" || P('show_create_cena_brutto', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>">
 <?php echo P('show_create_cena_brutto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_BRUTTO') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "cena_brutto") {
				$resultPozycjaZamowienia->setCenaBrutto($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_cena_brutto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaBrutto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaBrutto" name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_BRUTTO');
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
$('#pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (class_exists('sealock\virgoZamowienie') && ((P('show_create_zamowienie', "1") == "1" || P('show_create_zamowienie', "1") == "2" || P('show_create_zamowienie', "1") == "3") && !isset($context["zmw"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_zamowienie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('ZAMOWIENIE_'); echo !is_null($customLabel) ? $customLabel : T('ZAMOWIENIE') . ' ' . T('') ?> 
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
//		$limit_zamowienie = $componentParams->get('limit_to_zamowienie');
		$limit_zamowienie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoZamowienie");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_zamowienie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_zmw__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getZmwId())) {
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentValue = sealock\virgoZamowienie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ZAMOWIENIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_zamowienie) && trim($limit_zamowienie) != "") {
		$whereList = $whereList . " zmw_id ";
		if (trim($limit_zamowienie) == "page_title") {
			$limit_zamowienie = "SELECT zmw_id FROM slk_zamowienia WHERE zmw_" . $limit_zamowienie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_zamowienie = \"$limit_zamowienie\";");
		$whereList = $whereList . " IN (" . $limit_zamowienie . ") ";
	}						
	$parentCount = sealock\virgoZamowienie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_zamowienie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_zamowienie) || trim($limit_zamowienie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsZamowienie = sealock\virgoZamowienie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsZamowienie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getZmwId()) && $id == $resultPozycjaZamowienia->getZmwId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentZamowienie = new sealock\virgoZamowienie();
				$parentValue = $parentZamowienie->lookup($parentId);
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
	<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Zamowienie",
			virgo_field_name: "zamowienie",
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
					$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddZamowienie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addzamowienie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["zmw"])) {
		$parentValue = $context["zmw"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_zmw_id;
	}
	
?>
				<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoTowar') && ((P('show_create_towar', "1") == "1" || P('show_create_towar', "1") == "2" || P('show_create_towar', "1") == "3") && !isset($context["twr"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_towar_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('TOWAR_'); echo !is_null($customLabel) ? $customLabel : T('TOWAR') . ' ' . T('') ?> 
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
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoTowar");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_towar', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_twr__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getTwrId())) {
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentValue = sealock\virgoTowar::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_TOWAR');
?>
<?php
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = sealock\virgoTowar::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			$resultsTowar = sealock\virgoTowar::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getTwrId()) && $id == $resultPozycjaZamowienia->getTwrId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentTowar = new sealock\virgoTowar();
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
	<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
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
					$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddTowar')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addtowar inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["twr"])) {
		$parentValue = $context["twr"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_twr_id;
	}
	
?>
				<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoWydanie') && ((P('show_create_wydanie', "1") == "1" || P('show_create_wydanie', "1") == "2" || P('show_create_wydanie', "1") == "3") && !isset($context["wdn"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_wydanie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('WYDANIE_'); echo !is_null($customLabel) ? $customLabel : T('WYDANIE') . ' ' . T('') ?> 
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
//		$limit_wydanie = $componentParams->get('limit_to_wydanie');
		$limit_wydanie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoWydanie");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_wydanie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_wdn__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getWdnId())) {
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentValue = sealock\virgoWydanie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_WYDANIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_wydanie) && trim($limit_wydanie) != "") {
		$whereList = $whereList . " wdn_id ";
		if (trim($limit_wydanie) == "page_title") {
			$limit_wydanie = "SELECT wdn_id FROM slk_wydania WHERE wdn_" . $limit_wydanie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_wydanie = \"$limit_wydanie\";");
		$whereList = $whereList . " IN (" . $limit_wydanie . ") ";
	}						
	$parentCount = sealock\virgoWydanie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_wydanie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_wydanie) || trim($limit_wydanie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsWydanie = sealock\virgoWydanie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsWydanie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getWdnId()) && $id == $resultPozycjaZamowienia->getWdnId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentWydanie = new sealock\virgoWydanie();
				$parentValue = $parentWydanie->lookup($parentId);
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
	<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Wydanie",
			virgo_field_name: "wydanie",
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
					$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddWydanie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addwydanie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["wdn"])) {
		$parentValue = $context["wdn"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_wdn_id;
	}
	
?>
				<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>



<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultPozycjaZamowienia->pzm_id)) {
			$resultPozycjaZamowienia->pzm_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_zamowienie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoZamowienie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoZamowienie::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setZmwId($defaultValue);
}
$defaultValue = P('create_default_value_towar');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTowar::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTowar::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setTwrId($defaultValue);
}
$defaultValue = P('create_default_value_wydanie');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoWydanie::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoWydanie::token2Id($tmpToken);
	}
	$resultPozycjaZamowienia->setWdnId($defaultValue);
}
	}
?>
																																																						<?php
	if (P('show_create_ilosc', "1") == "1" || P('show_create_ilosc', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>">
* <?php echo T('ILOSC') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ilosc") {
				$resultPozycjaZamowienia->setIlosc($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ilosc', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getIlosc(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="ilosc" name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ILOSC');
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
$('#pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_cena_netto', "1") == "1" || P('show_create_cena_netto', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>">
 <?php echo P('show_create_cena_netto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_NETTO') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "cena_netto") {
				$resultPozycjaZamowienia->setCenaNetto($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_cena_netto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaNetto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaNetto" name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_NETTO');
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
$('#pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_cena_brutto', "1") == "1" || P('show_create_cena_brutto', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>">
 <?php echo P('show_create_cena_brutto_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CENA_BRUTTO') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "cena_brutto") {
				$resultPozycjaZamowienia->setCenaBrutto($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_cena_brutto', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaBrutto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaBrutto" name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_BRUTTO');
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
$('#pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (class_exists('sealock\virgoZamowienie') && ((P('show_create_zamowienie', "1") == "1" || P('show_create_zamowienie', "1") == "2" || P('show_create_zamowienie', "1") == "3") && !isset($context["zmw"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_zamowienie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('ZAMOWIENIE_'); echo !is_null($customLabel) ? $customLabel : T('ZAMOWIENIE') . ' ' . T('') ?> 
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
//		$limit_zamowienie = $componentParams->get('limit_to_zamowienie');
		$limit_zamowienie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoZamowienie");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_zamowienie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_zmw__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getZmwId())) {
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentValue = sealock\virgoZamowienie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ZAMOWIENIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_zamowienie) && trim($limit_zamowienie) != "") {
		$whereList = $whereList . " zmw_id ";
		if (trim($limit_zamowienie) == "page_title") {
			$limit_zamowienie = "SELECT zmw_id FROM slk_zamowienia WHERE zmw_" . $limit_zamowienie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_zamowienie = \"$limit_zamowienie\";");
		$whereList = $whereList . " IN (" . $limit_zamowienie . ") ";
	}						
	$parentCount = sealock\virgoZamowienie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_zamowienie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_zamowienie) || trim($limit_zamowienie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsZamowienie = sealock\virgoZamowienie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsZamowienie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getZmwId()) && $id == $resultPozycjaZamowienia->getZmwId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentZamowienie = new sealock\virgoZamowienie();
				$parentValue = $parentZamowienie->lookup($parentId);
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
	<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Zamowienie",
			virgo_field_name: "zamowienie",
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
					$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddZamowienie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addzamowienie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["zmw"])) {
		$parentValue = $context["zmw"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_zmw_id;
	}
	
?>
				<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoTowar') && ((P('show_create_towar', "1") == "1" || P('show_create_towar', "1") == "2" || P('show_create_towar', "1") == "3") && !isset($context["twr"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_towar_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('TOWAR_'); echo !is_null($customLabel) ? $customLabel : T('TOWAR') . ' ' . T('') ?> 
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
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoTowar");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_towar', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_twr__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getTwrId())) {
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentValue = sealock\virgoTowar::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_TOWAR');
?>
<?php
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = sealock\virgoTowar::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			$resultsTowar = sealock\virgoTowar::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getTwrId()) && $id == $resultPozycjaZamowienia->getTwrId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentTowar = new sealock\virgoTowar();
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
	<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
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
					$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddTowar')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addtowar inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["twr"])) {
		$parentValue = $context["twr"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_twr_id;
	}
	
?>
				<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoWydanie') && ((P('show_create_wydanie', "1") == "1" || P('show_create_wydanie', "1") == "2" || P('show_create_wydanie', "1") == "3") && !isset($context["wdn"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="pzm_wydanie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>">
 *
<?php $customLabel = TE('WYDANIE_'); echo !is_null($customLabel) ? $customLabel : T('WYDANIE') . ' ' . T('') ?> 
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
//		$limit_wydanie = $componentParams->get('limit_to_wydanie');
		$limit_wydanie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoWydanie");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_wydanie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_wdn__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getWdnId())) {
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentValue = sealock\virgoWydanie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_WYDANIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_wydanie) && trim($limit_wydanie) != "") {
		$whereList = $whereList . " wdn_id ";
		if (trim($limit_wydanie) == "page_title") {
			$limit_wydanie = "SELECT wdn_id FROM slk_wydania WHERE wdn_" . $limit_wydanie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_wydanie = \"$limit_wydanie\";");
		$whereList = $whereList . " IN (" . $limit_wydanie . ") ";
	}						
	$parentCount = sealock\virgoWydanie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_create_wydanie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_wydanie) || trim($limit_wydanie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsWydanie = sealock\virgoWydanie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsWydanie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getWdnId()) && $id == $resultPozycjaZamowienia->getWdnId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentWydanie = new sealock\virgoWydanie();
				$parentValue = $parentWydanie->lookup($parentId);
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
	<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Wydanie",
			virgo_field_name: "wydanie",
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
					$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddWydanie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addwydanie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["wdn"])) {
		$parentValue = $context["wdn"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_wdn_id;
	}
	
?>
				<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
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
				</table>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPozycjaZamowienia->getDateCreated()) {
		if ($resultPozycjaZamowienia->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPozycjaZamowienia->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPozycjaZamowienia->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPozycjaZamowienia->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPozycjaZamowienia->getDateModified()) {
		if ($resultPozycjaZamowienia->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPozycjaZamowienia->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPozycjaZamowienia->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPozycjaZamowienia->getDateModified() ?>"	>
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
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
		if ((!isset($masterPobId) || trim($masterPobId) == "") && P('form_only', "0") != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($pozycjaZamowieniaDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('POZYCJA_ZAMOWIENIA') ?>:</legend>
				<ul>
<?php
	$criteriaPozycjaZamowienia = $resultPozycjaZamowienia->getCriteria();
?>
<?php
	if (P('show_search_ilosc', "1") == "1") {

		if (isset($criteriaPozycjaZamowienia["ilosc"])) {
			$fieldCriteriaIlosc = $criteriaPozycjaZamowienia["ilosc"];
			$dataTypeCriteria = $fieldCriteriaIlosc["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ILOSC') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_ilosc_from" 
							name="virgo_search_ilosc_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_ilosc_to" 
							name="virgo_search_ilosc_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_ilosc_is_null" 
				name="virgo_search_ilosc_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaIlosc) && $fieldCriteriaIlosc["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaIlosc) && $fieldCriteriaIlosc["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaIlosc) && $fieldCriteriaIlosc["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_cena_netto', "1") == "1") {

		if (isset($criteriaPozycjaZamowienia["cena_netto"])) {
			$fieldCriteriaCenaNetto = $criteriaPozycjaZamowienia["cena_netto"];
			$dataTypeCriteria = $fieldCriteriaCenaNetto["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CENA_NETTO') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_cenaNetto_from" 
							name="virgo_search_cenaNetto_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_cenaNetto_to" 
							name="virgo_search_cenaNetto_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_cenaNetto_is_null" 
				name="virgo_search_cenaNetto_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaCenaNetto) && $fieldCriteriaCenaNetto["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaCenaNetto) && $fieldCriteriaCenaNetto["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaCenaNetto) && $fieldCriteriaCenaNetto["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_cena_brutto', "1") == "1") {

		if (isset($criteriaPozycjaZamowienia["cena_brutto"])) {
			$fieldCriteriaCenaBrutto = $criteriaPozycjaZamowienia["cena_brutto"];
			$dataTypeCriteria = $fieldCriteriaCenaBrutto["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CENA_BRUTTO') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_cenaBrutto_from" 
							name="virgo_search_cenaBrutto_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_cenaBrutto_to" 
							name="virgo_search_cenaBrutto_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo htmlentities(isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "", ENT_QUOTES, "UTF-8") ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_cenaBrutto_is_null" 
				name="virgo_search_cenaBrutto_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaCenaBrutto) && $fieldCriteriaCenaBrutto["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaCenaBrutto) && $fieldCriteriaCenaBrutto["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaCenaBrutto) && $fieldCriteriaCenaBrutto["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	$context = null; //$session->get('GLOBAL-VIRGO_CONTEXT_usuniete');
?>	
<?php
	if (P('show_search_zamowienie', '1') == "1") {
		if (isset($criteriaPozycjaZamowienia["zamowienie"])) {
			$fieldCriteriaZamowienie = $criteriaPozycjaZamowienia["zamowienie"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('ZAMOWIENIE') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaZamowienie["value"]) ? $fieldCriteriaZamowienie["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_zamowienie" name="virgo_search_zamowienie" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_produkt_is_null" 
				name="virgo_search_produkt_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaZamowienie) && $fieldCriteriaZamowienie["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaZamowienie) && $fieldCriteriaZamowienie["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaZamowienie) && $fieldCriteriaZamowienie["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_towar', '1') == "1") {
		if (isset($criteriaPozycjaZamowienia["towar"])) {
			$fieldCriteriaTowar = $criteriaPozycjaZamowienia["towar"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('TOWAR') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaTowar["value"]) ? $fieldCriteriaTowar["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_towar" name="virgo_search_towar" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_produkt_is_null" 
				name="virgo_search_produkt_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaTowar) && $fieldCriteriaTowar["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaTowar) && $fieldCriteriaTowar["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaTowar) && $fieldCriteriaTowar["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_wydanie', '1') == "1") {
		if (isset($criteriaPozycjaZamowienia["wydanie"])) {
			$fieldCriteriaWydanie = $criteriaPozycjaZamowienia["wydanie"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('WYDANIE') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaWydanie["value"]) ? $fieldCriteriaWydanie["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_wydanie" name="virgo_search_wydanie" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_produkt_is_null" 
				name="virgo_search_produkt_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaWydanie) && $fieldCriteriaWydanie["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaWydanie) && $fieldCriteriaWydanie["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaWydanie) && $fieldCriteriaWydanie["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	unset($criteriaPozycjaZamowienia);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	} elseif ($pozycjaZamowieniaDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('POZYCJA_ZAMOWIENIA') ?>:</legend>
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
	if (P('show_view_ilosc', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="ilosc"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('ILOSC') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getIlosc(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="ilosc" name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_cena_netto', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="cena_netto"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('CENA_NETTO') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaNetto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaNetto" name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_cena_brutto', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="cena_brutto"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('CENA_BRUTTO') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getCenaBrutto(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="cenaBrutto" name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoZamowienie') && P('show_view_zamowienie', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "zamowienie" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="zamowienie"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Zamówienie </span>
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
			$tmpId = null;
			if (!is_null($context) && isset($context['zmw_id'])) {
				$tmpId = $context['zmw_id'];
			}
			$readOnly = "";
			if ($resultPozycjaZamowienia->getId() == 0) {
// przesuac do createforgui				$resultPozycjaZamowienia->pzm_zmw__id = $tmpId;
			}
			$parentId = $resultPozycjaZamowienia->getZamowienieId();
			$parentValue = sealock\virgoZamowienie::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pzm_zamowienie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 
						name="pzm_zamowienie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
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
	if (class_exists('sealock\virgoTowar') && P('show_view_towar', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "towar" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="towar"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Towar </span>
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
			$tmpId = null;
			if (!is_null($context) && isset($context['twr_id'])) {
				$tmpId = $context['twr_id'];
			}
			$readOnly = "";
			if ($resultPozycjaZamowienia->getId() == 0) {
// przesuac do createforgui				$resultPozycjaZamowienia->pzm_twr__id = $tmpId;
			}
			$parentId = $resultPozycjaZamowienia->getTowarId();
			$parentValue = sealock\virgoTowar::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pzm_towar_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 
						name="pzm_towar_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
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
	if (class_exists('sealock\virgoWydanie') && P('show_view_wydanie', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "wydanie" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="wydanie"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Wydanie </span>
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
			$tmpId = null;
			if (!is_null($context) && isset($context['wdn_id'])) {
				$tmpId = $context['wdn_id'];
			}
			$readOnly = "";
			if ($resultPozycjaZamowienia->getId() == 0) {
// przesuac do createforgui				$resultPozycjaZamowienia->pzm_wdn__id = $tmpId;
			}
			$parentId = $resultPozycjaZamowienia->getWydanieId();
			$parentValue = sealock\virgoWydanie::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pzm_wydanie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 
						name="pzm_wydanie_<?php echo isset($resultPozycjaZamowienia->pzm_id) ? $resultPozycjaZamowienia->pzm_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
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
<?php echo T('POZYCJA_ZAMOWIENIA') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPozycjaZamowienia->getDateCreated()) {
		if ($resultPozycjaZamowienia->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPozycjaZamowienia->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPozycjaZamowienia->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPozycjaZamowienia->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPozycjaZamowienia->getDateModified()) {
		if ($resultPozycjaZamowienia->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPozycjaZamowienia->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPozycjaZamowienia->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPozycjaZamowienia->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPozycjaZamowienia->getDateModified() ?>"	>
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
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("POZYCJA_ZAMOWIENIA"), "\\'".$resultPozycjaZamowienia->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	} elseif ($pozycjaZamowieniaDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "pzm_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultPozycjaZamowienia->setShowPage(1); 
	$resultPozycjaZamowienia->setShowRows('all'); 	
	$resultsPozycjaZamowienia = $resultPozycjaZamowienia->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
		if (isset($resultPozycjaZamowienia[$eventColumn]) && isset($events[substr($resultPozycjaZamowienia[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultPozycjaZamowienia[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoPozycjaZamowienia($resultPozycjaZamowienia['pzm_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultPozycjaZamowienia[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='pzm_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultPozycjaZamowienia) {
?>
<?php
PROFILE('token');
	if (isset($resultPozycjaZamowienia)) {
		$tmpId = is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultPozycjaZamowienia->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.pzm_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
<?php
PROFILE('table_01');
?>
		<script type="text/javascript">
			var pozycjaZamowieniaChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == pozycjaZamowieniaChildrenDivOpen) {
					div.style.display = 'none';
					pozycjaZamowieniaChildrenDivOpen = '';
				} else {
					if (pozycjaZamowieniaChildrenDivOpen != '') {
						document.getElementById(pozycjaZamowieniaChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					pozycjaZamowieniaChildrenDivOpen = clickedDivId;
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
PROFILE('table_01');
PROFILE('table_02');
			$showPage = $resultPozycjaZamowienia->getShowPage(); 
			$showRows = $resultPozycjaZamowienia->getShowRows(); 
?>
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
			$hint = TE('HINT_TOWAR');
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Pozycje zamówień') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultPozycjaZamowienia->getOrderColumn();
			$virgoOrderMode = $resultPozycjaZamowienia->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsPozycjaZamowienia = $resultPozycjaZamowienia->getTableData($resultCount, $filterApplied);
PROFILE('main select');
PROFILE('table_03');

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
			$portletObject = new portal\virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getNamespace().'\\'.$portletObject->getPortletDefinition()->getAlias();
			$tmp2Id = $className::getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
?>
<?php
	if (P('show_table_ilosc', "1") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pzm_ilosc');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ILOSC') ?>							<?php echo ($oc == "pzm_ilosc" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterIlosc', null);
?>
						<input
							name="virgo_filter_ilosc"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_cena_netto', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pzm_cena_netto');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CENA_NETTO') ?>							<?php echo ($oc == "pzm_cena_netto" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterCenaNetto', null);
?>
						<input
							name="virgo_filter_cena_netto"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_cena_brutto', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pzm_cena_brutto');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CENA_BRUTTO') ?>							<?php echo ($oc == "pzm_cena_brutto" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterCenaBrutto', null);
?>
						<input
							name="virgo_filter_cena_brutto"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_zamowienie', "1") != "0"  && !isset($parentsInContext['sealock\\virgoZamowienie'])  ) {
	if (P('show_table_zamowienie', "1") == "2") {
		$tmpLookupZamowienie = virgoZamowienie::getVirgoListStatic();
?>
<input name='pzm_Zamowienie_id_<?php echo $this->getId() ?>' id='pzm_Zamowienie_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'zamowienie');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php
	$customLabel = TE('ZAMOWIENIE_'); 
	echo !is_null($customLabel) ? $customLabel : T('ZAMOWIENIE') . '&nbsp;' . T('')
?>
							<?php echo ($oc == "zamowienie" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoZamowienie::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoZamowienie::getVirgoListStatic();
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterZamowienie', null);
?>
						<select 
							name="virgo_filter_zamowienie"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterTitleZamowienie', null);
?>
						<input
							name="virgo_filter_title_zamowienie"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_towar', "1") != "0"  && !isset($parentsInContext['sealock\\virgoTowar'])  ) {
	if (P('show_table_towar', "1") == "2") {
		$tmpLookupTowar = virgoTowar::getVirgoListStatic();
?>
<input name='pzm_Towar_id_<?php echo $this->getId() ?>' id='pzm_Towar_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'towar');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php
	$customLabel = TE('TOWAR_'); 
	echo !is_null($customLabel) ? $customLabel : T('TOWAR') . '&nbsp;' . T('')
?>
							<?php echo ($oc == "towar" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoTowar::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoTowar::getVirgoListStatic();
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterTowar', null);
?>
						<select 
							name="virgo_filter_towar"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterTitleTowar', null);
?>
						<input
							name="virgo_filter_title_towar"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoWydanie'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_wydanie', "1") != "0"  && !isset($parentsInContext['sealock\\virgoWydanie'])  ) {
	if (P('show_table_wydanie', "1") == "2") {
		$tmpLookupWydanie = virgoWydanie::getVirgoListStatic();
?>
<input name='pzm_Wydanie_id_<?php echo $this->getId() ?>' id='pzm_Wydanie_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPozycjaZamowienia->getOrderColumn(); 
	$om = $resultPozycjaZamowienia->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'wydanie');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php
	$customLabel = TE('WYDANIE_'); 
	echo !is_null($customLabel) ? $customLabel : T('WYDANIE') . '&nbsp;' . T('')
?>
							<?php echo ($oc == "wydanie" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoWydanie::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoWydanie::getVirgoListStatic();
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterWydanie', null);
?>
						<select 
							name="virgo_filter_wydanie"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoPozycjaZamowienia::getLocalSessionValue('VirgoFilterTitleWydanie', null);
?>
						<input
							name="virgo_filter_title_wydanie"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
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
					$resultPozycjaZamowienia->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/virgoPozycjaZamowienia/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultPozycjaZamowienia['pzm_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoPozycjaZamowienia::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoPozycjaZamowienia::setContextId($resultPozycjaZamowienia['pzm_id'], false);
						$tmpContextId = $resultPozycjaZamowienia['pzm_id'];
					}
				}
				if (isset($tmpContextId) && $resultPozycjaZamowienia['pzm_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : "" ?>" 
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPozycjaZamowienia['pzm_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPozycjaZamowienia['pzm_id'] ?>">
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
PROFILE('ilo\u015B\u0107');
	if (P('show_table_ilosc', "1") == "1") {
PROFILE('render_data_table_ilosc');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="ilosc">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_ilosc'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_ilosc');
	}
PROFILE('ilo\u015B\u0107');
?>
<?php
PROFILE('cena netto');
	if (P('show_table_cena_netto', "0") == "1") {
PROFILE('render_data_table_cena_netto');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="cena_netto">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_cena_netto'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_cena_netto');
	}
PROFILE('cena netto');
?>
<?php
PROFILE('cena brutto');
	if (P('show_table_cena_brutto', "0") == "1") {
PROFILE('render_data_table_cena_brutto');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="cena_brutto">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_cena_brutto'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_cena_brutto');
	}
PROFILE('cena brutto');
?>
<?php
	if (class_exists('sealock\virgoZamowienie') && P('show_table_zamowienie', "1") != "0"  && !isset($parentsInContext["sealock\\virgoZamowienie"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_zamowienie', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="zamowienie">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_zamowienie', "1") == "1") {
		if (isset($resultPozycjaZamowienia['zamowienie'])) {
			echo $resultPozycjaZamowienia['zamowienie'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_zmw_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Zamowienie_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupZamowienie as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_zmw_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
	if (class_exists('sealock\virgoTowar') && P('show_table_towar', "1") != "0"  && !isset($parentsInContext["sealock\\virgoTowar"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_towar', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="towar">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_towar', "1") == "1") {
		if (isset($resultPozycjaZamowienia['towar'])) {
			echo $resultPozycjaZamowienia['towar'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_twr_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Towar_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupTowar as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_twr_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
	if (class_exists('sealock\virgoWydanie') && P('show_table_wydanie', "1") != "0"  && !isset($parentsInContext["sealock\\virgoWydanie"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_wydanie', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="wydanie">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_wydanie', "1") == "1") {
		if (isset($resultPozycjaZamowienia['wydanie'])) {
			echo $resultPozycjaZamowienia['wydanie'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_wdn_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Wydanie_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupWydanie as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_wdn_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
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
PROFILE('token');
	if (isset($resultPozycjaZamowienia)) {
		$tmpId = is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("POZYCJA_ZAMOWIENIA"), "\\'".rawurlencode($resultPozycjaZamowienia['pzm_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPozycjaZamowienia['pzm_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPozycjaZamowienia['pzm_id'] ?>">
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
PROFILE('ilo\u015B\u0107');
	if (P('show_table_ilosc', "1") == "1") {
PROFILE('render_data_table_ilosc');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="ilosc">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_ilosc'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_ilosc');
	}
PROFILE('ilo\u015B\u0107');
?>
<?php
PROFILE('cena netto');
	if (P('show_table_cena_netto', "0") == "1") {
PROFILE('render_data_table_cena_netto');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="cena_netto">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_cena_netto'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_cena_netto');
	}
PROFILE('cena netto');
?>
<?php
PROFILE('cena brutto');
	if (P('show_table_cena_brutto', "0") == "1") {
PROFILE('render_data_table_cena_brutto');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="cena_brutto">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				number_format($resultPozycjaZamowienia['pzm_cena_brutto'], 2, ',', ' ')
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
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
PROFILE('render_data_table_cena_brutto');
	}
PROFILE('cena brutto');
?>
<?php
	if (class_exists('sealock\virgoZamowienie') && P('show_table_zamowienie', "1") != "0"  && !isset($parentsInContext["sealock\\virgoZamowienie"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_zamowienie', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="zamowienie">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_zamowienie', "1") == "1") {
		if (isset($resultPozycjaZamowienia['zamowienie'])) {
			echo $resultPozycjaZamowienia['zamowienie'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_zmw_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Zamowienie_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupZamowienie as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_zmw_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
	if (class_exists('sealock\virgoTowar') && P('show_table_towar', "1") != "0"  && !isset($parentsInContext["sealock\\virgoTowar"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_towar', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="towar">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_towar', "1") == "1") {
		if (isset($resultPozycjaZamowienia['towar'])) {
			echo $resultPozycjaZamowienia['towar'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_twr_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Towar_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupTowar as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_twr_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
	if (class_exists('sealock\virgoWydanie') && P('show_table_wydanie', "1") != "0"  && !isset($parentsInContext["sealock\\virgoWydanie"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_wydanie', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="wydanie">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pzm_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPozycjaZamowienia['pzm_id']) ? $resultPozycjaZamowienia['pzm_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_wydanie', "1") == "1") {
		if (isset($resultPozycjaZamowienia['wydanie'])) {
			echo $resultPozycjaZamowienia['wydanie'];
		}
	} else {
//		echo $resultPozycjaZamowienia['pzm_wdn_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo $resultPozycjaZamowienia['pzm_id'] ?>');
	_pSF(form, 'pzm_Wydanie_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupWydanie as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPozycjaZamowienia['pzm_wdn_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
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
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
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
PROFILE('token');
	if (isset($resultPozycjaZamowienia)) {
		$tmpId = is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("POZYCJA_ZAMOWIENIA"), "\\'".rawurlencode($resultPozycjaZamowienia['pzm_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
			virgoPozycjaZamowienia::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultPozycjaZamowienia);
				unset($resultsPozycjaZamowienia);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpPozycjaZamowienia = new virgoPozycjaZamowienia();
						$tmpCount = $tmpPozycjaZamowienia->getAllRecordCount(' pzm_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoPozycjaZamowienia::clearRemoteContextId($tabModeEditMenu);
						}
					}
				}
PROFILE('rows rendering');
?>			
<?php
PROFILE('table_05');
				if ($showRows == 'all') {
					$pageCount = 1;
				} else {
					$pageCount = (int)($resultCount / $showRows) + 1;
					if ($resultCount % $showRows == 0) {
						$pageCount = $pageCount - 1;
					}
				}
PROFILE('table_05');
PROFILE('table_06_1');
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
PROFILE('table_06_1');
PROFILE('table_06_2');
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
PROFILE('table_06_2');
PROFILE('table_07');
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&pzm_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
<?php
			if (P('form_only') != "4") {
?>
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr.contextClass').removeClass("contextClass");
<?php
			}			
			$childrenToSubmit = array();
			$childrenToSubmit[$this->getId()] = prepareChildrenToSubmit($this->getId());
			$childrenToSubmitJSString = str_replace("\"", "'", json_encode($childrenToSubmit/*, JSON_FORCE_OBJECT*/));					
?>			
			var childrenToSubmit = <?php echo $childrenToSubmitJSString ?>;
			var pobId = <?php echo $this->getId() ?>;
		    	if (childrenToSubmit.hasOwnProperty(pobId)) {
			    	var currentChildrenToSubmit = childrenToSubmit[pobId];
			    	if (typeof(currentChildrenToSubmit) !== 'undefined') {
				    	if (/* mode == "Submit" && */ Object.keys(currentChildrenToSubmit).length > 0) {
							for (var child in currentChildrenToSubmit) {
							    if (currentChildrenToSubmit.hasOwnProperty(child)) {
							    	jsfs(child, "Submit", currentChildrenToSubmit[child]);
							   }
							}
				    	}
				    }
				}
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
		form.pzm_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.pzm_id_<?php echo $this->getId() ?>.value=virgoId; 
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
PROFILE('table_07');
PROFILE('table_08');
?>
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
PROFILE('TABLE_ACTIONS_ADD');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('ADD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_ADD');
PROFILE('TABLE_ACTIONS_SEARCH');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_SEARCH');
?>
<?php
PROFILE('TABLE_ACTIONS_REPORT');
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
								  if (children[i].getAttribute('name') == 'pzm_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pzm_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
PROFILE('TABLE_ACTIONS_REPORT');
PROFILE('TABLE_ACTIONS_EXPORT');
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
								  if (children[i].getAttribute('name') == 'pzm_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pzm_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
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
								  if (children[i].getAttribute('name') == 'pzm_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pzm_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPDATE_TITLE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
			$actions = virgoRole::getExtraActions('ET');
PROFILE('TABLE_ACTIONS_ET');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
PROFILE('TABLE_ACTIONS_ET');
?>
					</div>
					<div id="operations_import_<?php echo $this->getId() ?>" style="display: none;" class="operations">
<?php
			if ($this->canExecute("upload")) {
?>
			<input type="file" name="virgo_upload_file">
<?php
PROFILE('TABLE_ACTIONS_UPLOAD');
				$separatorString = ","; //$componentParams->get('import_separator');
				if ($separatorString == "") {
?>
			<input name="field_separator_in_import" size="1"
<?php
					$sessionSeparator = virgoPozycjaZamowienia::getImportFieldSeparator();
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
						$sessionSeparator = virgoPozycjaZamowienia::getImportFieldSeparator();
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
PROFILE('TABLE_ACTIONS_UPLOAD');				
PROFILE('TABLE_ACTIONS_RESZTA');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('POZYCJE_ZAMOWIEN'), "") ?>'))) return false;
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
PROFILE('TABLE_ACTIONS_RESZTA');
?>

<?php
PROFILE('table_08');
?>
<?php
		}
PROFILE('TABLE');
/* MILESTONE 1.6 TableForm */
	} elseif ($pozycjaZamowieniaDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_pozycja_zamowienia") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var pozycjaZamowieniaChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == pozycjaZamowieniaChildrenDivOpen) {
					div.style.display = 'none';
					pozycjaZamowieniaChildrenDivOpen = '';
				} else {
					if (pozycjaZamowieniaChildrenDivOpen != '') {
						document.getElementById(pozycjaZamowieniaChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					pozycjaZamowieniaChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_pozycja_zamowienia" name="virgo_form_pozycja_zamowienia" enctype="multipart/form-data">
						<input type="text" name="pzm_id_<?php echo $this->getId() ?>" id="pzm_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_ilosc', "1") == "1") {
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
	if (P('show_table_cena_netto', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Cena netto
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_cena_brutto', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Cena brutto
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_zamowienie', "1") == "1" /* && ($masterComponentName != "zamowienie" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Zamówienie </td>
<?php
	}
?>
<?php
	if (P('show_table_towar', "1") == "1" /* && ($masterComponentName != "towar" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Towar </td>
<?php
	}
?>
<?php
	if (P('show_table_wydanie', "1") == "1" /* && ($masterComponentName != "wydanie" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Wydanie </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsPozycjaZamowienia = $resultPozycjaZamowienia->getRecordsToEdit();
				$idsToCorrect = $resultPozycjaZamowienia->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPozycjaZamowienia->pzm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultPozycjaZamowienia->pzm_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('ilo\u015B\u0107');
	if (P('show_table_ilosc', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 0;
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ILOSC');
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
$('#pzm_ilosc_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('ilo\u015B\u0107');
	} else {
?> 
						<input
							type="hidden"
							id="ilosc_<?php echo $resultPozycjaZamowienia->pzm_id ?>" 
							name="ilosc_<?php echo $resultPozycjaZamowienia->pzm_id ?>"
							value="<?php echo htmlentities($resultPozycjaZamowienia->pzm_ilosc, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('cena netto');
	if (P('show_table_cena_netto', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 1;
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_netto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaNetto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_NETTO');
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
$('#pzm_cenaNetto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('cena netto');
	} else {
?> 
						<input
							type="hidden"
							id="cenaNetto_<?php echo $resultPozycjaZamowienia->pzm_id ?>" 
							name="cenaNetto_<?php echo $resultPozycjaZamowienia->pzm_id ?>"
							value="<?php echo htmlentities($resultPozycjaZamowienia->pzm_cena_netto, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('cena brutto');
	if (P('show_table_cena_brutto', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 2;
?>
<?php
	if (!isset($resultPozycjaZamowienia)) {
		$resultPozycjaZamowienia = new sealock\virgoPozycjaZamowienia();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_cena_brutto_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>" 
							name="pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPozycjaZamowienia->getCenaBrutto(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_CENA_BRUTTO');
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
$('#pzm_cenaBrutto_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('cena brutto');
	} else {
?> 
						<input
							type="hidden"
							id="cenaBrutto_<?php echo $resultPozycjaZamowienia->pzm_id ?>" 
							name="cenaBrutto_<?php echo $resultPozycjaZamowienia->pzm_id ?>"
							value="<?php echo htmlentities($resultPozycjaZamowienia->pzm_cena_brutto, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
	if (P('show_table_zamowienie', "1") == "1"/* && ($masterComponentName != "zamowienie" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 3;
?>
<?php
//		$limit_zamowienie = $componentParams->get('limit_to_zamowienie');
		$limit_zamowienie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoZamowienie");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_zamowienie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_zmw__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getZmwId())) {
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentValue = sealock\virgoZamowienie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_ZAMOWIENIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_zamowienie) && trim($limit_zamowienie) != "") {
		$whereList = $whereList . " zmw_id ";
		if (trim($limit_zamowienie) == "page_title") {
			$limit_zamowienie = "SELECT zmw_id FROM slk_zamowienia WHERE zmw_" . $limit_zamowienie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_zamowienie = \"$limit_zamowienie\";");
		$whereList = $whereList . " IN (" . $limit_zamowienie . ") ";
	}						
	$parentCount = sealock\virgoZamowienie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_zamowienie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_zamowienie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_zamowienie) || trim($limit_zamowienie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsZamowienie = sealock\virgoZamowienie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsZamowienie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getZmwId()) && $id == $resultPozycjaZamowienia->getZmwId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getZmwId();
				$parentZamowienie = new sealock\virgoZamowienie();
				$parentValue = $parentZamowienie->lookup($parentId);
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
	<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Zamowienie",
			virgo_field_name: "zamowienie",
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
					$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_zamowienie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddZamowienie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addzamowienie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_zamowienie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["zmw"])) {
		$parentValue = $context["zmw"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_zmw_id;
	}
	
?>
				<input type="hidden" id="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_zamowienie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_towar', "1") == "1"/* && ($masterComponentName != "towar" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 4;
?>
<?php
//		$limit_towar = $componentParams->get('limit_to_towar');
		$limit_towar = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoTowar");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_towar', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_twr__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getTwrId())) {
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentValue = sealock\virgoTowar::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_TOWAR');
?>
<?php
	$whereList = "";
	if (!is_null($limit_towar) && trim($limit_towar) != "") {
		$whereList = $whereList . " twr_id ";
		if (trim($limit_towar) == "page_title") {
			$limit_towar = "SELECT twr_id FROM slk_towary WHERE twr_" . $limit_towar . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_towar = \"$limit_towar\";");
		$whereList = $whereList . " IN (" . $limit_towar . ") ";
	}						
	$parentCount = sealock\virgoTowar::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_towar', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_towar_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			$resultsTowar = sealock\virgoTowar::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTowar)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getTwrId()) && $id == $resultPozycjaZamowienia->getTwrId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getTwrId();
				$parentTowar = new sealock\virgoTowar();
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
	<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
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
					$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_towar_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddTowar')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addtowar inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_towar_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["twr"])) {
		$parentValue = $context["twr"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_twr_id;
	}
	
?>
				<input type="hidden" id="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_towar_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_wydanie', "1") == "1"/* && ($masterComponentName != "wydanie" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPozycjaZamowienia) * 5;
?>
<?php
//		$limit_wydanie = $componentParams->get('limit_to_wydanie');
		$limit_wydanie = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoWydanie");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_wydanie', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPozycjaZamowienia->pzm_wdn__id = $tmpId;
//			}
			if (!is_null($resultPozycjaZamowienia->getWdnId())) {
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentValue = sealock\virgoWydanie::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_POZYCJA_ZAMOWIENIA_WYDANIE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_wydanie) && trim($limit_wydanie) != "") {
		$whereList = $whereList . " wdn_id ";
		if (trim($limit_wydanie) == "page_title") {
			$limit_wydanie = "SELECT wdn_id FROM slk_wydania WHERE wdn_" . $limit_wydanie . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_wydanie = \"$limit_wydanie\";");
		$whereList = $whereList . " IN (" . $limit_wydanie . ") ";
	}						
	$parentCount = sealock\virgoWydanie::getVirgoListSize($whereList);
	$showAjaxpzm = P('show_form_wydanie', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpzm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
							name="pzm_wydanie_<?php echo !is_null($resultPozycjaZamowienia->getId()) ? $resultPozycjaZamowienia->getId() : '' ?>" 
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
			if (is_null($limit_wydanie) || trim($limit_wydanie) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsWydanie = sealock\virgoWydanie::getVirgoList($whereList);
			while(list($id, $label)=each($resultsWydanie)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPozycjaZamowienia->getWdnId()) && $id == $resultPozycjaZamowienia->getWdnId() ? "selected='selected'" : "");
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
				$parentId = $resultPozycjaZamowienia->getWdnId();
				$parentWydanie = new sealock\virgoWydanie();
				$parentValue = $parentWydanie->lookup($parentId);
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
	<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" 
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
        $( "#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Wydanie",
			virgo_field_name: "wydanie",
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
					$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.value);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				  	$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pzm_wydanie_<?php echo $resultPozycjaZamowienia->getId() ?>').val('');
				$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').removeClass("locked");		
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
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddWydanie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addwydanie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pzm_wydanie_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["wdn"])) {
		$parentValue = $context["wdn"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_wdn_id;
	}
	
?>
				<input type="hidden" id="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_wydanie_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultPozycjaZamowienia->pzm_id])) {
		$errorMessage = $idsToCorrect[$resultPozycjaZamowienia->pzm_id];
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
PROFILE('rows rendering');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
/* MILESTONE 1.10 AddNewParents */
	} elseif ($pozycjaZamowieniaDisplayMode == "ADD_NEW_PARENT_ZAMOWIENIE") {
		$resultZamowienie = sealock\virgoZamowienie::createGuiAware();
		$resultZamowienie->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Zamówienie</label>
<?php
	if (P('show_create_numer', "1") == "1" || P('show_create_numer', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="zmw_numer_<?php echo $resultZamowienie->getId() ?>">
* <?php echo T('NUMER') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "numer") {
				$resultPozycjaZamowienia->setNumer($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_numer', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPozycjaZamowienia->getNumer(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="numer" name="zmw_numer_<?php echo $resultZamowienie->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getNumer(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultZamowienie)) {
		$resultZamowienie = new sealock\virgoZamowienie();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="zmw_numer_<?php echo $resultZamowienie->getId() ?>" 
							name="zmw_numer_<?php echo $resultZamowienie->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultZamowienie->getNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ZAMOWIENIE_NUMER');
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
$('#zmw_numer_<?php echo $resultZamowienie->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_data_zlozenia', "1") == "1" || P('show_create_data_zlozenia', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_data_zlozenia_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="zmw_dataZlozenia_<?php echo $resultZamowienie->getId() ?>">
 <?php echo P('show_create_data_zlozenia_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DATA_ZLOZENIA') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "data_zlozenia") {
				$resultPozycjaZamowienia->setDataZlozenia($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_data_zlozenia', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPozycjaZamowienia->getDataZlozenia(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="dataZlozenia" name="zmw_dataZlozenia_<?php echo $resultZamowienie->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getDataZlozenia(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultZamowienie)) {
		$resultZamowienie = new sealock\virgoZamowienie();
	}
?>
<?php
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
		$locale = setlocale(LC_ALL,"0");
		if (isset($locale) && trim($locale) != "") {
			$lang = substr($locale, 0, 2);
		} else {
			$lang = "en";
		}
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d";
	$tmp_date = $resultZamowienie->getDataZlozenia();
?>
						<div class="date" style="display: inline;">
							<input 
								type="text" 
								class="inputbox" 
								style="" 
								id="zmw_dataZlozenia_<?php echo $resultZamowienie->getId() ?>" 
								name="zmw_dataZlozenia_<?php echo $resultZamowienie->getId() ?>" 
								size="10" 
								value="<?php echo $tmp_date ?>" 
								onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
								tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
								>
						</div>
<script type="text/javascript">
$(function(){ 
  $("#zmw_dataZlozenia_<?php echo $resultZamowienie->getId() ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  


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
	if (class_exists('sealock\virgoStatusZamowienia') && ((P('show_create_status_zamowienia', "1") == "1" || P('show_create_status_zamowienia', "1") == "2" || P('show_create_status_zamowienia', "1") == "3") && !isset($context["szm"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="zmw_statusZamowienia_<?php echo isset($resultZamowienie->zmw_id) ? $resultZamowienie->zmw_id : '' ?>">
 *
<?php $customLabel = TE('STATUS_ZAMOWIENIA_'); echo !is_null($customLabel) ? $customLabel : T('STATUS_ZAMOWIENIA') . ' ' . T('') ?> 
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
//		$limit_status_zamowienia = $componentParams->get('limit_to_status_zamowienia');
		$limit_status_zamowienia = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoStatusZamowienia");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_status_zamowienia', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultZamowienie->zmw_szm__id = $tmpId;
//			}
			if (!is_null($resultZamowienie->getSzmId())) {
				$parentId = $resultZamowienie->getSzmId();
				$parentValue = sealock\virgoStatusZamowienia::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="zmw_statusZamowienia_<?php echo $resultZamowienie->getId() ?>" name="zmw_statusZamowienia_<?php echo $resultZamowienie->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ZAMOWIENIE_STATUS_ZAMOWIENIA');
?>
<?php
	$whereList = "";
	if (!is_null($limit_status_zamowienia) && trim($limit_status_zamowienia) != "") {
		$whereList = $whereList . " szm_id ";
		if (trim($limit_status_zamowienia) == "page_title") {
			$limit_status_zamowienia = "SELECT szm_id FROM slk_statusy_zamowien WHERE szm_" . $limit_status_zamowienia . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_status_zamowienia = \"$limit_status_zamowienia\";");
		$whereList = $whereList . " IN (" . $limit_status_zamowienia . ") ";
	}						
	$parentCount = sealock\virgoStatusZamowienia::getVirgoListSize($whereList);
	$showAjaxzmw = P('show_create_status_zamowienia', "1") == "3" || $parentCount > 100;
	if (!$showAjaxzmw) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="zmw_statusZamowienia_<?php echo !is_null($resultZamowienie->getId()) ? $resultZamowienie->getId() : '' ?>" 
							name="zmw_statusZamowienia_<?php echo !is_null($resultZamowienie->getId()) ? $resultZamowienie->getId() : '' ?>" 
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
			if (is_null($limit_status_zamowienia) || trim($limit_status_zamowienia) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsStatusZamowienia = sealock\virgoStatusZamowienia::getVirgoList($whereList);
			while(list($id, $label)=each($resultsStatusZamowienia)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultZamowienie->getSzmId()) && $id == $resultZamowienie->getSzmId() ? "selected='selected'" : "");
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
				$parentId = $resultZamowienie->getSzmId();
				$parentStatusZamowienia = new sealock\virgoStatusZamowienia();
				$parentValue = $parentStatusZamowienia->lookup($parentId);
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
	<input type="hidden" id="zmw_status_zamowienia_<?php echo $resultZamowienie->getId() ?>" name="zmw_statusZamowienia_<?php echo $resultZamowienie->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>" 
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
        $( "#zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "StatusZamowienia",
			virgo_field_name: "status_zamowienia",
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
					$('#zmw_status_zamowienia_<?php echo $resultZamowienie->getId() ?>').val(ui.item.value);
				  	$('#zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>').val(ui.item.label);
				  	$('#zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#zmw_status_zamowienia_<?php echo $resultZamowienie->getId() ?>').val('');
				$('#zmw_status_zamowienia_dropdown_<?php echo $resultZamowienie->getId() ?>').removeClass("locked");		
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
$('#pzm_status_zamowienia_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["szm"])) {
		$parentValue = $context["szm"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_szm_id;
	}
	
?>
				<input type="hidden" id="pzm_statusZamowienia_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_statusZamowienia_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoOdbiorca') && ((P('show_create_odbiorca', "1") == "1" || P('show_create_odbiorca', "1") == "2" || P('show_create_odbiorca', "1") == "3") && !isset($context["odb"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="zmw_odbiorca_<?php echo isset($resultZamowienie->zmw_id) ? $resultZamowienie->zmw_id : '' ?>">
 *
<?php $customLabel = TE('ODBIORCA_'); echo !is_null($customLabel) ? $customLabel : T('ODBIORCA') . ' ' . T('') ?> 
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
//		$limit_odbiorca = $componentParams->get('limit_to_odbiorca');
		$limit_odbiorca = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoOdbiorca");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_odbiorca', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultZamowienie->zmw_odb__id = $tmpId;
//			}
			if (!is_null($resultZamowienie->getOdbId())) {
				$parentId = $resultZamowienie->getOdbId();
				$parentValue = sealock\virgoOdbiorca::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>" name="zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_ZAMOWIENIE_ODBIORCA');
?>
<?php
	$whereList = "";
	if (!is_null($limit_odbiorca) && trim($limit_odbiorca) != "") {
		$whereList = $whereList . " odb_id ";
		if (trim($limit_odbiorca) == "page_title") {
			$limit_odbiorca = "SELECT odb_id FROM slk_odbiorcy WHERE odb_" . $limit_odbiorca . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_odbiorca = \"$limit_odbiorca\";");
		$whereList = $whereList . " IN (" . $limit_odbiorca . ") ";
	}						
	$parentCount = sealock\virgoOdbiorca::getVirgoListSize($whereList);
	$showAjaxzmw = P('show_create_odbiorca', "1") == "3" || $parentCount > 100;
	if (!$showAjaxzmw) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="zmw_odbiorca_<?php echo !is_null($resultZamowienie->getId()) ? $resultZamowienie->getId() : '' ?>" 
							name="zmw_odbiorca_<?php echo !is_null($resultZamowienie->getId()) ? $resultZamowienie->getId() : '' ?>" 
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
			if (is_null($limit_odbiorca) || trim($limit_odbiorca) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsOdbiorca = sealock\virgoOdbiorca::getVirgoList($whereList);
			while(list($id, $label)=each($resultsOdbiorca)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultZamowienie->getOdbId()) && $id == $resultZamowienie->getOdbId() ? "selected='selected'" : "");
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
				$parentId = $resultZamowienie->getOdbId();
				$parentOdbiorca = new sealock\virgoOdbiorca();
				$parentValue = $parentOdbiorca->lookup($parentId);
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
	<input type="hidden" id="zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>" name="zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>" 
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
        $( "#zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Odbiorca",
			virgo_field_name: "odbiorca",
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
					$('#zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>').val(ui.item.value);
				  	$('#zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>').val(ui.item.label);
				  	$('#zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#zmw_odbiorca_<?php echo $resultZamowienie->getId() ?>').val('');
				$('#zmw_odbiorca_dropdown_<?php echo $resultZamowienie->getId() ?>').removeClass("locked");		
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
$('#pzm_odbiorca_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["odb"])) {
		$parentValue = $context["odb"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_odb_id;
	}
	
?>
				<input type="hidden" id="pzm_odbiorca_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_odbiorca_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewZamowienie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewzamowienie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewZamowienie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 <div class="button_wrapper button_wrapper_backfromparent inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='BackFromParent';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('pzm_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="pzm_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="pzm_ilosc_<?php echo $childId ?>" 
	value="<?php echo R('pzm_ilosc_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaNetto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaNetto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaBrutto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaBrutto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_zamowienie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_zamowienie_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_towar_<?php echo $childId ?>" 
	value="<?php echo R('pzm_towar_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_wydanie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_wydanie_' . $childId) ?>"
/>
<?php		
/* MILESTONE 1.10 AddNewParents */
	} elseif ($pozycjaZamowieniaDisplayMode == "ADD_NEW_PARENT_TOWAR") {
		$resultTowar = sealock\virgoTowar::createGuiAware();
		$resultTowar->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Towar</label>
<?php
	if (P('show_create_kod', "1") == "1" || P('show_create_kod', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="twr_kod_<?php echo $resultTowar->getId() ?>">
* <?php echo T('KOD') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "kod") {
				$resultPozycjaZamowienia->setKod($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_kod', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPozycjaZamowienia->getKod(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="kod" name="twr_kod_<?php echo $resultTowar->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getKod(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new sealock\virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_kod_<?php echo $resultTowar->getId() ?>" 
							name="twr_kod_<?php echo $resultTowar->getId() ?>"
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
	$hint = TE('HINT_TOWAR_KOD');
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
$('#twr_kod_<?php echo $resultTowar->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_nazwa', "1") == "1" || P('show_create_nazwa', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="twr_nazwa_<?php echo $resultTowar->getId() ?>">
* <?php echo T('NAZWA') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "nazwa") {
				$resultPozycjaZamowienia->setNazwa($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_nazwa', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPozycjaZamowienia->getNazwa(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="nazwa" name="twr_nazwa_<?php echo $resultTowar->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getNazwa(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new sealock\virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="twr_nazwa_<?php echo $resultTowar->getId() ?>" 
							name="twr_nazwa_<?php echo $resultTowar->getId() ?>"
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
	$hint = TE('HINT_TOWAR_NAZWA');
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
$('#twr_nazwa_<?php echo $resultTowar->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_stan_aktualny', "1") == "1" || P('show_create_stan_aktualny', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_stan_aktualny_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="twr_stanAktualny_<?php echo $resultTowar->getId() ?>">
 <?php echo P('show_create_stan_aktualny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STAN_AKTUALNY') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "stan_aktualny") {
				$resultPozycjaZamowienia->setStanAktualny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_stan_aktualny', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getStanAktualny(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="stanAktualny" name="twr_stanAktualny_<?php echo $resultTowar->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getStanAktualny(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new sealock\virgoTowar();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_stan_aktualny_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="twr_stanAktualny_<?php echo $resultTowar->getId() ?>" 
							name="twr_stanAktualny_<?php echo $resultTowar->getId() ?>"
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
	$hint = TE('HINT_TOWAR_STAN_AKTUALNY');
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
$('#twr_stanAktualny_<?php echo $resultTowar->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_stan_minimalny', "1") == "1" || P('show_create_stan_minimalny', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="twr_stanMinimalny_<?php echo $resultTowar->getId() ?>">
* <?php echo T('STAN_MINIMALNY') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "stan_minimalny") {
				$resultPozycjaZamowienia->setStanMinimalny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_stan_minimalny', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getStanMinimalny(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="stanMinimalny" name="twr_stanMinimalny_<?php echo $resultTowar->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getStanMinimalny(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new sealock\virgoTowar();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="twr_stanMinimalny_<?php echo $resultTowar->getId() ?>" 
							name="twr_stanMinimalny_<?php echo $resultTowar->getId() ?>"
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
	$hint = TE('HINT_TOWAR_STAN_MINIMALNY');
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
$('#twr_stanMinimalny_<?php echo $resultTowar->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (P('show_create_produkt', "1") == "1" || P('show_create_produkt', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_produkt_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="twr_produkt_<?php echo $resultTowar->getId() ?>">
 <?php echo P('show_create_produkt_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PRODUKT') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "produkt") {
				$resultPozycjaZamowienia->setProdukt($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_produkt', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="produkt"
>
<?php
	if (is_null($resultPozycjaZamowienia->getProdukt()) || $resultPozycjaZamowienia->getProdukt() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPozycjaZamowienia->getProdukt() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPozycjaZamowienia->getProdukt() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultTowar)) {
		$resultTowar = new sealock\virgoTowar();
	}
?>
<select class="inputbox" id="twr_produkt_<?php echo $resultTowar->getId() ?>" name="twr_produkt_<?php echo $resultTowar->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TOWAR_PRODUKT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultTowar->getProdukt() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultTowar->getProdukt() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultTowar->getProdukt()) || $resultTowar->getProdukt() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#twr_produkt_<?php echo $resultTowar->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (class_exists('sealock\virgoGrupaTowaru') && ((P('show_create_grupa_towaru', "1") == "1" || P('show_create_grupa_towaru', "1") == "2" || P('show_create_grupa_towaru', "1") == "3") && !isset($context["gtw"]))) {
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
<?php $customLabel = TE('GRUPA_TOWARU_'); echo !is_null($customLabel) ? $customLabel : T('GRUPA_TOWARU') . ' ' . T('') ?> 
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
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoGrupaTowaru");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_grupa_towaru', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultTowar->twr_gtw__id = $tmpId;
//			}
			if (!is_null($resultTowar->getGtwId())) {
				$parentId = $resultTowar->getGtwId();
				$parentValue = sealock\virgoGrupaTowaru::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_grupaTowaru_<?php echo $resultTowar->getId() ?>" name="twr_grupaTowaru_<?php echo $resultTowar->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_TOWAR_GRUPA_TOWARU');
?>
<?php
	$whereList = "";
	if (!is_null($limit_grupa_towaru) && trim($limit_grupa_towaru) != "") {
		$whereList = $whereList . " gtw_id ";
		if (trim($limit_grupa_towaru) == "page_title") {
			$limit_grupa_towaru = "SELECT gtw_id FROM slk_grupy_towarow WHERE gtw_" . $limit_grupa_towaru . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_towaru = \"$limit_grupa_towaru\";");
		$whereList = $whereList . " IN (" . $limit_grupa_towaru . ") ";
	}						
	$parentCount = sealock\virgoGrupaTowaru::getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_grupa_towaru', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_grupaTowaru_<?php echo !is_null($resultTowar->getId()) ? $resultTowar->getId() : '' ?>" 
							name="twr_grupaTowaru_<?php echo !is_null($resultTowar->getId()) ? $resultTowar->getId() : '' ?>" 
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
			$resultsGrupaTowaru = sealock\virgoGrupaTowaru::getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaTowaru)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultTowar->getGtwId()) && $id == $resultTowar->getGtwId() ? "selected='selected'" : "");
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
				$parentId = $resultTowar->getGtwId();
				$parentGrupaTowaru = new sealock\virgoGrupaTowaru();
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
	<input type="hidden" id="twr_grupa_towaru_<?php echo $resultTowar->getId() ?>" name="twr_grupaTowaru_<?php echo $resultTowar->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>" 
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
        $( "#twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>" ).autocomplete({
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
					$('#twr_grupa_towaru_<?php echo $resultTowar->getId() ?>').val(ui.item.value);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>').val(ui.item.label);
				  	$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_grupa_towaru_<?php echo $resultTowar->getId() ?>').val('');
				$('#twr_grupa_towaru_dropdown_<?php echo $resultTowar->getId() ?>').removeClass("locked");		
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
$('#pzm_grupa_towaru_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
		$parentValue = $resultPozycjaZamowienia->pzm_gtw_id;
	}
	
?>
				<input type="hidden" id="pzm_grupaTowaru_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_grupaTowaru_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('sealock\virgoJednostka') && ((P('show_create_jednostka', "1") == "1" || P('show_create_jednostka', "1") == "2" || P('show_create_jednostka', "1") == "3") && !isset($context["jdn"]))) {
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
<?php $customLabel = TE('JEDNOSTKA_'); echo !is_null($customLabel) ? $customLabel : T('JEDNOSTKA') . ' ' . T('') ?> 
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
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoJednostka");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_jednostka', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultTowar->twr_jdn__id = $tmpId;
//			}
			if (!is_null($resultTowar->getJdnId())) {
				$parentId = $resultTowar->getJdnId();
				$parentValue = sealock\virgoJednostka::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->getId() ?>" name="twr_jednostka_<?php echo $resultTowar->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_TOWAR_JEDNOSTKA');
?>
<?php
	$whereList = "";
	if (!is_null($limit_jednostka) && trim($limit_jednostka) != "") {
		$whereList = $whereList . " jdn_id ";
		if (trim($limit_jednostka) == "page_title") {
			$limit_jednostka = "SELECT jdn_id FROM slk_jednostki WHERE jdn_" . $limit_jednostka . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_jednostka = \"$limit_jednostka\";");
		$whereList = $whereList . " IN (" . $limit_jednostka . ") ";
	}						
	$parentCount = sealock\virgoJednostka::getVirgoListSize($whereList);
	$showAjaxtwr = P('show_create_jednostka', "1") == "3" || $parentCount > 100;
	if (!$showAjaxtwr) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="twr_jednostka_<?php echo !is_null($resultTowar->getId()) ? $resultTowar->getId() : '' ?>" 
							name="twr_jednostka_<?php echo !is_null($resultTowar->getId()) ? $resultTowar->getId() : '' ?>" 
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
			$resultsJednostka = sealock\virgoJednostka::getVirgoList($whereList);
			while(list($id, $label)=each($resultsJednostka)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultTowar->getJdnId()) && $id == $resultTowar->getJdnId() ? "selected='selected'" : "");
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
				$parentId = $resultTowar->getJdnId();
				$parentJednostka = new sealock\virgoJednostka();
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
	<input type="hidden" id="twr_jednostka_<?php echo $resultTowar->getId() ?>" name="twr_jednostka_<?php echo $resultTowar->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>" 
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
        $( "#twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>" ).autocomplete({
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
					$('#twr_jednostka_<?php echo $resultTowar->getId() ?>').val(ui.item.value);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>').val(ui.item.label);
				  	$('#twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#twr_jednostka_<?php echo $resultTowar->getId() ?>').val('');
				$('#twr_jednostka_dropdown_<?php echo $resultTowar->getId() ?>').removeClass("locked");		
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
$('#pzm_jednostka_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
		$parentValue = $resultPozycjaZamowienia->pzm_jdn_id;
	}
	
?>
				<input type="hidden" id="pzm_jednostka_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_jednostka_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewTowar')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewtowar inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewTowar';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 <div class="button_wrapper button_wrapper_backfromparent inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='BackFromParent';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('pzm_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="pzm_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="pzm_ilosc_<?php echo $childId ?>" 
	value="<?php echo R('pzm_ilosc_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaNetto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaNetto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaBrutto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaBrutto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_zamowienie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_zamowienie_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_towar_<?php echo $childId ?>" 
	value="<?php echo R('pzm_towar_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_wydanie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_wydanie_' . $childId) ?>"
/>
<?php		
/* MILESTONE 1.10 AddNewParents */
	} elseif ($pozycjaZamowieniaDisplayMode == "ADD_NEW_PARENT_WYDANIE") {
		$resultWydanie = sealock\virgoWydanie::createGuiAware();
		$resultWydanie->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Wydanie</label>
<?php
	if (P('show_create_ilosc', "1") == "1" || P('show_create_ilosc', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="wdn_ilosc_<?php echo $resultWydanie->getId() ?>">
* <?php echo T('ILOSC') ?>
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
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ilosc") {
				$resultPozycjaZamowienia->setIlosc($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ilosc', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo number_format($resultPozycjaZamowienia->getIlosc(), 2, ',', ' ') ?>
						&nbsp;</span>
						<input type="hidden" id="ilosc" name="wdn_ilosc_<?php echo $resultWydanie->getId() ?>" value="<?php echo htmlentities($resultPozycjaZamowienia->getIlosc(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultWydanie)) {
		$resultWydanie = new sealock\virgoWydanie();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="wdn_ilosc_<?php echo $resultWydanie->getId() ?>" 
							name="wdn_ilosc_<?php echo $resultWydanie->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultWydanie->getIlosc(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_WYDANIE_ILOSC');
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
$('#wdn_ilosc_<?php echo $resultWydanie->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
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
	if (class_exists('sealock\virgoProdukt') && ((P('show_create_produkt', "1") == "1" || P('show_create_produkt', "1") == "2" || P('show_create_produkt', "1") == "3") && !isset($context["prd"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="wdn_produkt_<?php echo isset($resultWydanie->wdn_id) ? $resultWydanie->wdn_id : '' ?>">
 *
<?php $customLabel = TE('PRODUKT_'); echo !is_null($customLabel) ? $customLabel : T('PRODUKT') . ' ' . T('') ?> 
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
//		$limit_produkt = $componentParams->get('limit_to_produkt');
		$limit_produkt = null;
		$tmpId = sealock\virgoPozycjaZamowienia::getParentInContext("sealock\\virgoProdukt");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_produkt', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultWydanie->wdn_prd__id = $tmpId;
//			}
			if (!is_null($resultWydanie->getPrdId())) {
				$parentId = $resultWydanie->getPrdId();
				$parentValue = sealock\virgoProdukt::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="wdn_produkt_<?php echo $resultWydanie->getId() ?>" name="wdn_produkt_<?php echo $resultWydanie->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_WYDANIE_PRODUKT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_produkt) && trim($limit_produkt) != "") {
		$whereList = $whereList . " prd_id ";
		if (trim($limit_produkt) == "page_title") {
			$limit_produkt = "SELECT prd_id FROM slk_produkty WHERE prd_" . $limit_produkt . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_produkt = \"$limit_produkt\";");
		$whereList = $whereList . " IN (" . $limit_produkt . ") ";
	}						
	$parentCount = sealock\virgoProdukt::getVirgoListSize($whereList);
	$showAjaxwdn = P('show_create_produkt', "1") == "3" || $parentCount > 100;
	if (!$showAjaxwdn) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="wdn_produkt_<?php echo !is_null($resultWydanie->getId()) ? $resultWydanie->getId() : '' ?>" 
							name="wdn_produkt_<?php echo !is_null($resultWydanie->getId()) ? $resultWydanie->getId() : '' ?>" 
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
			if (is_null($limit_produkt) || trim($limit_produkt) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsProdukt = sealock\virgoProdukt::getVirgoList($whereList);
			while(list($id, $label)=each($resultsProdukt)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultWydanie->getPrdId()) && $id == $resultWydanie->getPrdId() ? "selected='selected'" : "");
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
				$parentId = $resultWydanie->getPrdId();
				$parentProdukt = new sealock\virgoProdukt();
				$parentValue = $parentProdukt->lookup($parentId);
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
	<input type="hidden" id="wdn_produkt_<?php echo $resultWydanie->getId() ?>" name="wdn_produkt_<?php echo $resultWydanie->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>" 
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
        $( "#wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Produkt",
			virgo_field_name: "produkt",
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
					$('#wdn_produkt_<?php echo $resultWydanie->getId() ?>').val(ui.item.value);
				  	$('#wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>').val(ui.item.label);
				  	$('#wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#wdn_produkt_<?php echo $resultWydanie->getId() ?>').val('');
				$('#wdn_produkt_dropdown_<?php echo $resultWydanie->getId() ?>').removeClass("locked");		
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
$('#pzm_produkt_dropdown_<?php echo $resultPozycjaZamowienia->getId() ?>').qtip({position: {
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
	if (isset($context["prd"])) {
		$parentValue = $context["prd"];
	} else {
		$parentValue = $resultPozycjaZamowienia->pzm_prd_id;
	}
	
?>
				<input type="hidden" id="pzm_produkt_<?php echo $resultPozycjaZamowienia->pzm_id ?>" name="pzm_produkt_<?php echo $resultPozycjaZamowienia->pzm_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewWydanie')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewwydanie inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewWydanie';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 <div class="button_wrapper button_wrapper_backfromparent inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='BackFromParent';
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('pzm_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="pzm_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="pzm_ilosc_<?php echo $childId ?>" 
	value="<?php echo R('pzm_ilosc_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaNetto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaNetto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_cenaBrutto_<?php echo $childId ?>" 
	value="<?php echo R('pzm_cenaBrutto_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_zamowienie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_zamowienie_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_towar_<?php echo $childId ?>" 
	value="<?php echo R('pzm_towar_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pzm_wydanie_<?php echo $childId ?>" 
	value="<?php echo R('pzm_wydanie_' . $childId) ?>"
/>
<?php		
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $pozycjaZamowieniaDisplayMode ?>">
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
	_pSF(form, 'pzm_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPozycjaZamowienia) ? (is_array($resultPozycjaZamowienia) ? $resultPozycjaZamowienia['pzm_id'] : $resultPozycjaZamowienia->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_slk_pozycja_zamowienia" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_slk_pozycja_zamowienia').style.display='none';">
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
	$infos = virgoPozycjaZamowienia::getExtraFilesInfo();
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

