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
	use sealock\virgoRodzajDokumentu;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaDokumentow'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaDokumentow'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_slk_rodzaj_dokumentu');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_slk_rodzaj_dokumentu/sealock.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'slk_rdk.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/sealock/virgoRodzajDokumentu/slk_rdk.css" type="text/css" /> 
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
<div class="virgo_container_sealock virgo_container_entity_rodzaj_dokumentu" style="border: none;">
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
		$contextId = null;		
			$resultRodzajDokumentu = virgoRodzajDokumentu::createGuiAware();
			$contextId = $resultRodzajDokumentu->getContextId();
			if (isset($contextId)) {
				if (virgoRodzajDokumentu::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultRodzajDokumentu->load($contextId);
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
		if ($className == "virgoRodzajDokumentu") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultRodzajDokumentu = new virgoRodzajDokumentu($tmpId);
				virgoRodzajDokumentu::setDisplayMode("FORM");
			} else {
				$resultRodzajDokumentu = new virgoRodzajDokumentu();
				virgoRodzajDokumentu::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultRodzajDokumentu->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultRodzajDokumentu->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultRodzajDokumentu = new virgoRodzajDokumentu($allPrivateRecords[0]['rdk_id']);
						$resultRodzajDokumentu->putInContext(false);
					} else {
						$resultRodzajDokumentu = new virgoRodzajDokumentu();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultRodzajDokumentu->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultRodzajDokumentu = new virgoRodzajDokumentu($records[0]['rdk_id']);
							$resultRodzajDokumentu->putInContext(false);
						} else {
							$resultRodzajDokumentu = new virgoRodzajDokumentu();
						}
					} else {
						$resultRodzajDokumentu = new virgoRodzajDokumentu();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultRodzajDokumentu = new virgoRodzajDokumentu(virgoUser::getUserId());
			$resultRodzajDokumentu->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultRodzajDokumentu = new virgoRodzajDokumentu();
		}
?>
<?php
	$rodzajDokumentuDisplayMode = virgoRodzajDokumentu::getDisplayMode();
//	if ($rodzajDokumentuDisplayMode == "" || $rodzajDokumentuDisplayMode == "TABLE") {
//		$resultRodzajDokumentu = $resultRodzajDokumentu->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultRodzajDokumentu->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseRodzajDokumentu = $whereClauseRodzajDokumentu . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaRodzajDokumentu = $resultRodzajDokumentu->getCriteria();
		$countTmp = 0;
		if (isset($criteriaRodzajDokumentu["nazwa"])) {
			$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
			if ($fieldCriteriaNazwa["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaNazwa["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["symbol"])) {
			$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
			if ($fieldCriteriaSymbol["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaSymbol["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["zwiekszajacy"])) {
			$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
			if ($fieldCriteriaZwiekszajacy["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["wlasny"])) {
			$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
			if ($fieldCriteriaWlasny["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaWlasny["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["wewnetrzny"])) {
			$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
			if ($fieldCriteriaWewnetrzny["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["korekta"])) {
			$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
			if ($fieldCriteriaKorekta["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaKorekta["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["zastepczy"])) {
			$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
			if ($fieldCriteriaZastepczy["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaRodzajDokumentu["ostatni_numer"])) {
			$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
			if ($fieldCriteriaOstatniNumer["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
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
		if (isset($criteriaRodzajDokumentu["numeracja_rok"])) {
			$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
			if ($fieldCriteriaNumeracjaRok["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
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
		if (isset($criteriaRodzajDokumentu["grupa_dokumentow"])) {
			$parentCriteria = $criteriaRodzajDokumentu["grupa_dokumentow"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (is_null($criteriaRodzajDokumentu) || sizeof($criteriaRodzajDokumentu) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaRodzajDokumentu["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Nazwa') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaNazwa["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='nazwa';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Nazwa') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='nazwa';
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
			if (isset($criteriaRodzajDokumentu["symbol"])) {
				$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
				if ($fieldCriteriaSymbol["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Symbol') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaSymbol["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaSymbol["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='symbol';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaSymbol["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Symbol') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='symbol';
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
			if (isset($criteriaRodzajDokumentu["zwiekszajacy"])) {
				$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
				if ($fieldCriteriaZwiekszajacy["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Zwiększający') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaZwiekszajacy["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaZwiekszajacy["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zwiekszajacy';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Zwiększający') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zwiekszajacy';
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
			if (isset($criteriaRodzajDokumentu["wlasny"])) {
				$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
				if ($fieldCriteriaWlasny["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Własny') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaWlasny["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaWlasny["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wlasny';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaWlasny["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Własny') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wlasny';
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
			if (isset($criteriaRodzajDokumentu["wewnetrzny"])) {
				$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
				if ($fieldCriteriaWewnetrzny["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Wewnętrzny') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaWewnetrzny["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaWewnetrzny["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wewnetrzny';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Wewnętrzny') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='wewnetrzny';
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
			if (isset($criteriaRodzajDokumentu["korekta"])) {
				$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
				if ($fieldCriteriaKorekta["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Korekta') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaKorekta["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaKorekta["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='korekta';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaKorekta["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Korekta') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='korekta';
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
			if (isset($criteriaRodzajDokumentu["zastepczy"])) {
				$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
				if ($fieldCriteriaZastepczy["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Zastępczy') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaZastepczy["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaZastepczy["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zastepczy';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") {
				switch ($condition) {
					case 0: $renderCriteria = T("NO"); break;
					case 1: $renderCriteria = T("YES"); break;
					case 2: $renderCriteria = T("NO_DATA"); break;
				}
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Zastępczy') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='zastepczy';
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
			if (isset($criteriaRodzajDokumentu["ostatni_numer"])) {
				$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
				if ($fieldCriteriaOstatniNumer["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ostatni numer') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaOstatniNumer["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaOstatniNumer["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ostatni_numer';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
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
					<?php echo T('Ostatni numer') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ostatni_numer';
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
			if (isset($criteriaRodzajDokumentu["numeracja_rok"])) {
				$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
				if ($fieldCriteriaNumeracjaRok["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Numeracja rok') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaNumeracjaRok["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaNumeracjaRok["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='numeracja_rok';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
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
					<?php echo T('Numeracja rok') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='numeracja_rok';
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
			if (isset($criteriaRodzajDokumentu["grupa_dokumentow"])) {
				$parentCriteria = $criteriaRodzajDokumentu["grupa_dokumentow"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Grupa dokumentów') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='grupa_dokumentow';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$parentLookups = array();
						foreach ($parentIds as $parentId) {
							$parentLookups[] = sealock\virgoGrupaDokumentow::lookup($parentId);
						}
//	$tmpName =  $contextGrupaDokumentow->lookup($tmpId);
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Grupa dokumentów') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo implode(", ", $parentLookups) ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='grupa_dokumentow';
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
	if (isset($resultRodzajDokumentu)) {
		$tmpId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($rodzajDokumentuDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultRodzajDokumentu->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultRodzajDokumentu->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$rodzajDokumentuDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultRodzajDokumentu->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($rodzajDokumentuDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_rodzaj_dokumentu") {
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
<?php echo T('RODZAJ_DOKUMENTU') ?>:</legend>
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
	if (P('show_form_nazwa', "1") == "1" || P('show_form_nazwa', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?>   nazwa varchar" 
						for="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NAZWA') ?>
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
	if (P('show_form_nazwa', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="nazwa" name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NAZWA');
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
$('#rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_symbol', "1") == "1" || P('show_form_symbol', "1") == "2") {
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
						class="fieldlabel  obligatory   symbol varchar" 
						for="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>"
					>* <?php echo T('SYMBOL') ?>
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
	if (P('show_form_symbol', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="symbol" name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="10"
							size="10" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_SYMBOL');
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
$('#rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_zwiekszajacy', "1") == "1" || P('show_form_zwiekszajacy', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_zwiekszajacy_obligatory', "0") == "1" ? " obligatory " : "" ?>   zwiekszajacy bool" 
						for="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_zwiekszajacy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZWIEKSZAJACY') ?>
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
	if (P('show_form_zwiekszajacy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zwiekszajacy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZWIEKSZAJACY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_wlasny', "1") == "1" || P('show_form_wlasny', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_wlasny_obligatory', "0") == "1" ? " obligatory " : "" ?>   wlasny bool" 
						for="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_wlasny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WLASNY') ?>
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
	if (P('show_form_wlasny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wlasny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWlasny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWlasny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WLASNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWlasny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWlasny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_wewnetrzny', "1") == "1" || P('show_form_wewnetrzny', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_wewnetrzny_obligatory', "0") == "1" ? " obligatory " : "" ?>   wewnetrzny bool" 
						for="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_wewnetrzny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WEWNETRZNY') ?>
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
	if (P('show_form_wewnetrzny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wewnetrzny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WEWNETRZNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWewnetrzny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWewnetrzny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_korekta', "1") == "1" || P('show_form_korekta', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_korekta_obligatory', "0") == "1" ? " obligatory " : "" ?>   korekta bool" 
						for="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_korekta_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('KOREKTA') ?>
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
	if (P('show_form_korekta', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="korekta"
>
<?php
	if (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getKorekta() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getKorekta() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_KOREKTA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getKorekta() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getKorekta() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_zastepczy', "1") == "1" || P('show_form_zastepczy', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_zastepczy_obligatory', "0") == "1" ? " obligatory " : "" ?>   zastepczy bool" 
						for="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_zastepczy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZASTEPCZY') ?>
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
	if (P('show_form_zastepczy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zastepczy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZastepczy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZastepczy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZASTEPCZY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZastepczy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZastepczy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_ostatni_numer', "1") == "1" || P('show_form_ostatni_numer', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?>   ostatni_numer integer" 
						for="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('OSTATNI_NUMER') ?>
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
	if (P('show_form_ostatni_numer', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ostatniNumer" name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_OSTATNI_NUMER');
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
$('#rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_form_numeracja_rok', "1") == "1" || P('show_form_numeracja_rok', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?>   numeracja_rok integer" 
						for="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>"
					> <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NUMERACJA_ROK') ?>
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
	if (P('show_form_numeracja_rok', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="numeracjaRok" name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NUMERACJA_ROK');
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
$('#rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (class_exists('sealock\virgoGrupaDokumentow') && ((P('show_form_grupa_dokumentow', "1") == "1" || P('show_form_grupa_dokumentow', "1") == "2" || P('show_form_grupa_dokumentow', "1") == "3") && !isset($context["gdk"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="rdk_grupaDokumentow_<?php echo isset($resultRodzajDokumentu->rdk_id) ? $resultRodzajDokumentu->rdk_id : '' ?>">
 *
<?php $customLabel = TE('GRUPA_DOKUMENTOW_'); echo !is_null($customLabel) ? $customLabel : T('GRUPA_DOKUMENTOW') . ' ' . T('') ?> 
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
//		$limit_grupa_dokumentow = $componentParams->get('limit_to_grupa_dokumentow');
		$limit_grupa_dokumentow = null;
		$tmpId = sealock\virgoRodzajDokumentu::getParentInContext("sealock\\virgoGrupaDokumentow");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_grupa_dokumentow', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRodzajDokumentu->rdk_gdk__id = $tmpId;
//			}
			if (!is_null($resultRodzajDokumentu->getGdkId())) {
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentValue = sealock\virgoGrupaDokumentow::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_RODZAJ_DOKUMENTU_GRUPA_DOKUMENTOW');
?>
<?php
	$whereList = "";
	if (!is_null($limit_grupa_dokumentow) && trim($limit_grupa_dokumentow) != "") {
		$whereList = $whereList . " gdk_id ";
		if (trim($limit_grupa_dokumentow) == "page_title") {
			$limit_grupa_dokumentow = "SELECT gdk_id FROM slk_grupy_dokumentow WHERE gdk_" . $limit_grupa_dokumentow . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_dokumentow = \"$limit_grupa_dokumentow\";");
		$whereList = $whereList . " IN (" . $limit_grupa_dokumentow . ") ";
	}						
	$parentCount = sealock\virgoGrupaDokumentow::getVirgoListSize($whereList);
	$showAjaxrdk = P('show_form_grupa_dokumentow', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrdk) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
							name="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
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
			if (is_null($limit_grupa_dokumentow) || trim($limit_grupa_dokumentow) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaDokumentow = sealock\virgoGrupaDokumentow::getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaDokumentow)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultRodzajDokumentu->getGdkId()) && $id == $resultRodzajDokumentu->getGdkId() ? "selected='selected'" : "");
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
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentGrupaDokumentow = new sealock\virgoGrupaDokumentow();
				$parentValue = $parentGrupaDokumentow->lookup($parentId);
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
	<input type="hidden" id="rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" 
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
        $( "#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaDokumentow",
			virgo_field_name: "grupa_dokumentow",
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
					$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.value);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val('');
				$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').removeClass("locked");		
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
$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (isset($context["gdk"])) {
		$parentValue = $context["gdk"];
	} else {
		$parentValue = $resultRodzajDokumentu->rdk_gdk_id;
	}
	
?>
				<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_form_dokumenty_ksiegowe', '1') == "1") {
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
	if (false) { //$componentParams->get('show_form_dokumenty_ksiegowe') == "1") {
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
//	$componentParamsDokumentKsiegowy = &JComponentHelper::getParams('com_slk_dokument_ksiegowy');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_slk_rodzaj_dokumentu/slk_rodzaj_dokumentu_class.php");
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
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_bufor') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Bufor
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_operacji') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Data operacji
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_wystawienia') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Data wystawienia
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_numer') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Numer
*
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
				$resultsDokumentKsiegowy = $tmpDokumentKsiegowy->selectAll(' dks_rdk_id = ' . $resultRodzajDokumentu->rdk_id);
				$idsToCorrect = $tmpDokumentKsiegowy->getInvalidRecords();
				$index = 0;
				foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultDokumentKsiegowy->dks_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultDokumentKsiegowy->dks_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultDokumentKsiegowy->dks_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultDokumentKsiegowy->dks_id) ? 0 : $resultDokumentKsiegowy->dks_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultDokumentKsiegowy->dks_id;
		$resultDokumentKsiegowy = new virgoDokumentKsiegowy;
		$resultDokumentKsiegowy->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_bufor') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 0;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
	}
?>
<select class="inputbox" id="dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>" name="dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_DOKUMENT_KSIEGOWY_BUFOR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultDokumentKsiegowy->getBufor() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultDokumentKsiegowy->getBufor() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultDokumentKsiegowy->getBufor()) || $resultDokumentKsiegowy->getBufor() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>').qtip({position: {
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
							id="bufor_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="bufor_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_bufor, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_operacji') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 1;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
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
	$tmp_date = $resultDokumentKsiegowy->getDataOperacji();
?>
						<div class="date" style="display: inline;">
							<input 
								type="text" 
								class="inputbox" 
								style="" 
								id="dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>" 
								name="dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>" 
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
  $("#dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="dataOperacji_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="dataOperacji_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_data_operacji, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_wystawienia') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 2;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
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
	$tmp_date = $resultDokumentKsiegowy->getDataWystawienia();
?>
						<div class="date" style="display: inline;">
							<input 
								type="text" 
								class="inputbox" 
								style="" 
								id="dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>" 
								name="dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>" 
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
  $("#dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="dataWystawienia_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="dataWystawienia_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_data_wystawienia, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_numer') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 3;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>" 
							name="dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>"
							maxlength="20"
							size="20" 
							value="<?php echo htmlentities($resultDokumentKsiegowy->getNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_DOKUMENT_KSIEGOWY_NUMER');
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
$('#dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>').qtip({position: {
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
							id="numer_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="numer_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_numer, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$resultDokumentKsiegowy = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultDokumentKsiegowy->dks_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultDokumentKsiegowy->dks_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultDokumentKsiegowy->dks_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultDokumentKsiegowy->dks_id) ? 0 : $resultDokumentKsiegowy->dks_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultDokumentKsiegowy->dks_id;
		$resultDokumentKsiegowy = new virgoDokumentKsiegowy;
		$resultDokumentKsiegowy->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_bufor') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 0;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
	}
?>
<select class="inputbox" id="dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>" name="dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_DOKUMENT_KSIEGOWY_BUFOR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultDokumentKsiegowy->getBufor() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultDokumentKsiegowy->getBufor() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultDokumentKsiegowy->getBufor()) || $resultDokumentKsiegowy->getBufor() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#dks_bufor_<?php echo $resultDokumentKsiegowy->getId() ?>').qtip({position: {
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
							id="bufor_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="bufor_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_bufor, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_operacji') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 1;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
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
	$tmp_date = $resultDokumentKsiegowy->getDataOperacji();
?>
						<div class="date" style="display: inline;">
							<input 
								type="text" 
								class="inputbox" 
								style="" 
								id="dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>" 
								name="dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>" 
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
  $("#dks_dataOperacji_<?php echo $resultDokumentKsiegowy->getId() ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="dataOperacji_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="dataOperacji_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_data_operacji, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_data_wystawienia') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 2;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
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
	$tmp_date = $resultDokumentKsiegowy->getDataWystawienia();
?>
						<div class="date" style="display: inline;">
							<input 
								type="text" 
								class="inputbox" 
								style="" 
								id="dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>" 
								name="dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>" 
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
  $("#dks_dataWystawienia_<?php echo $resultDokumentKsiegowy->getId() ?>").datepicker({dateFormat: "yy-mm-dd"});
});
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="dataWystawienia_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="dataWystawienia_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_data_wystawienia, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsDokumentKsiegowy->get('show_table_numer') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 3;
?>
<?php
	if (!isset($resultDokumentKsiegowy)) {
		$resultDokumentKsiegowy = new sealock\virgoDokumentKsiegowy();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>" 
							name="dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>"
							maxlength="20"
							size="20" 
							value="<?php echo htmlentities($resultDokumentKsiegowy->getNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_DOKUMENT_KSIEGOWY_NUMER');
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
$('#dks_numer_<?php echo $resultDokumentKsiegowy->getId() ?>').qtip({position: {
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
							id="numer_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="numer_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_numer, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$tmpDokumentKsiegowy->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultRodzajDokumentu->getDateCreated()) {
		if ($resultRodzajDokumentu->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRodzajDokumentu->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRodzajDokumentu->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRodzajDokumentu->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRodzajDokumentu->getDateModified()) {
		if ($resultRodzajDokumentu->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRodzajDokumentu->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRodzajDokumentu->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRodzajDokumentu->getDateModified() ?>"	>
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
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("RODZAJ_DOKUMENTU"), "\\'".rawurlencode($resultRodzajDokumentu->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($rodzajDokumentuDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_rodzaj_dokumentu") {
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
<?php echo T('RODZAJ_DOKUMENTU') ?>:</legend>
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
		if (isset($resultRodzajDokumentu->rdk_id)) {
			$resultRodzajDokumentu->rdk_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_grupa_dokumentow');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoGrupaDokumentow::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoGrupaDokumentow::token2Id($tmpToken);
	}
	$resultRodzajDokumentu->setGdkId($defaultValue);
}
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_nazwa_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NAZWA') ?>
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
				$resultRodzajDokumentu->setNazwa($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_nazwa', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="nazwa" name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NAZWA');
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
$('#rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_symbol', "1") == "1" || P('show_create_symbol', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>">
* <?php echo T('SYMBOL') ?>
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
			if (P('event_column') == "symbol") {
				$resultRodzajDokumentu->setSymbol($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_symbol', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="symbol" name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="10"
							size="10" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_SYMBOL');
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
$('#rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_zwiekszajacy', "1") == "1" || P('show_create_zwiekszajacy', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_zwiekszajacy_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_zwiekszajacy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZWIEKSZAJACY') ?>
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
			if (P('event_column') == "zwiekszajacy") {
				$resultRodzajDokumentu->setZwiekszajacy($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_zwiekszajacy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zwiekszajacy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZWIEKSZAJACY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_wlasny', "1") == "1" || P('show_create_wlasny', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_wlasny_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_wlasny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WLASNY') ?>
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
			if (P('event_column') == "wlasny") {
				$resultRodzajDokumentu->setWlasny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_wlasny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wlasny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWlasny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWlasny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WLASNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWlasny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWlasny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_wewnetrzny', "1") == "1" || P('show_create_wewnetrzny', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_wewnetrzny_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_wewnetrzny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WEWNETRZNY') ?>
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
			if (P('event_column') == "wewnetrzny") {
				$resultRodzajDokumentu->setWewnetrzny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_wewnetrzny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wewnetrzny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WEWNETRZNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWewnetrzny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWewnetrzny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_korekta', "1") == "1" || P('show_create_korekta', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_korekta_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_korekta_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('KOREKTA') ?>
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
			if (P('event_column') == "korekta") {
				$resultRodzajDokumentu->setKorekta($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_korekta', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="korekta"
>
<?php
	if (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getKorekta() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getKorekta() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_KOREKTA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getKorekta() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getKorekta() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_zastepczy', "1") == "1" || P('show_create_zastepczy', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_zastepczy_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_zastepczy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZASTEPCZY') ?>
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
			if (P('event_column') == "zastepczy") {
				$resultRodzajDokumentu->setZastepczy($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_zastepczy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zastepczy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZastepczy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZastepczy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZASTEPCZY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZastepczy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZastepczy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_ostatni_numer', "1") == "1" || P('show_create_ostatni_numer', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_ostatni_numer_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('OSTATNI_NUMER') ?>
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
			if (P('event_column') == "ostatni_numer") {
				$resultRodzajDokumentu->setOstatniNumer($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ostatni_numer', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ostatniNumer" name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_OSTATNI_NUMER');
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
$('#rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_numeracja_rok', "1") == "1" || P('show_create_numeracja_rok', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_numeracja_rok_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NUMERACJA_ROK') ?>
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
			if (P('event_column') == "numeracja_rok") {
				$resultRodzajDokumentu->setNumeracjaRok($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_numeracja_rok', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="numeracjaRok" name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NUMERACJA_ROK');
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
$('#rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (class_exists('sealock\virgoGrupaDokumentow') && ((P('show_create_grupa_dokumentow', "1") == "1" || P('show_create_grupa_dokumentow', "1") == "2" || P('show_create_grupa_dokumentow', "1") == "3") && !isset($context["gdk"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="rdk_grupaDokumentow_<?php echo isset($resultRodzajDokumentu->rdk_id) ? $resultRodzajDokumentu->rdk_id : '' ?>">
 *
<?php $customLabel = TE('GRUPA_DOKUMENTOW_'); echo !is_null($customLabel) ? $customLabel : T('GRUPA_DOKUMENTOW') . ' ' . T('') ?> 
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
//		$limit_grupa_dokumentow = $componentParams->get('limit_to_grupa_dokumentow');
		$limit_grupa_dokumentow = null;
		$tmpId = sealock\virgoRodzajDokumentu::getParentInContext("sealock\\virgoGrupaDokumentow");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_grupa_dokumentow', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRodzajDokumentu->rdk_gdk__id = $tmpId;
//			}
			if (!is_null($resultRodzajDokumentu->getGdkId())) {
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentValue = sealock\virgoGrupaDokumentow::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_RODZAJ_DOKUMENTU_GRUPA_DOKUMENTOW');
?>
<?php
	$whereList = "";
	if (!is_null($limit_grupa_dokumentow) && trim($limit_grupa_dokumentow) != "") {
		$whereList = $whereList . " gdk_id ";
		if (trim($limit_grupa_dokumentow) == "page_title") {
			$limit_grupa_dokumentow = "SELECT gdk_id FROM slk_grupy_dokumentow WHERE gdk_" . $limit_grupa_dokumentow . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_dokumentow = \"$limit_grupa_dokumentow\";");
		$whereList = $whereList . " IN (" . $limit_grupa_dokumentow . ") ";
	}						
	$parentCount = sealock\virgoGrupaDokumentow::getVirgoListSize($whereList);
	$showAjaxrdk = P('show_create_grupa_dokumentow', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrdk) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
							name="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
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
			if (is_null($limit_grupa_dokumentow) || trim($limit_grupa_dokumentow) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaDokumentow = sealock\virgoGrupaDokumentow::getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaDokumentow)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultRodzajDokumentu->getGdkId()) && $id == $resultRodzajDokumentu->getGdkId() ? "selected='selected'" : "");
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
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentGrupaDokumentow = new sealock\virgoGrupaDokumentow();
				$parentValue = $parentGrupaDokumentow->lookup($parentId);
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
	<input type="hidden" id="rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" 
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
        $( "#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaDokumentow",
			virgo_field_name: "grupa_dokumentow",
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
					$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.value);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val('');
				$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').removeClass("locked");		
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
$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (isset($context["gdk"])) {
		$parentValue = $context["gdk"];
	} else {
		$parentValue = $resultRodzajDokumentu->rdk_gdk_id;
	}
	
?>
				<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_create_dokumenty_ksiegowe', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultRodzajDokumentu->rdk_id)) {
			$resultRodzajDokumentu->rdk_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_grupa_dokumentow');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoGrupaDokumentow::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoGrupaDokumentow::token2Id($tmpToken);
	}
	$resultRodzajDokumentu->setGdkId($defaultValue);
}
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_nazwa_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NAZWA') ?>
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
				$resultRodzajDokumentu->setNazwa($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_nazwa', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="nazwa" name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NAZWA');
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
$('#rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_symbol', "1") == "1" || P('show_create_symbol', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>">
* <?php echo T('SYMBOL') ?>
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
			if (P('event_column') == "symbol") {
				$resultRodzajDokumentu->setSymbol($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_symbol', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="symbol" name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="10"
							size="10" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_SYMBOL');
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
$('#rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_zwiekszajacy', "1") == "1" || P('show_create_zwiekszajacy', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_zwiekszajacy_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_zwiekszajacy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZWIEKSZAJACY') ?>
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
			if (P('event_column') == "zwiekszajacy") {
				$resultRodzajDokumentu->setZwiekszajacy($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_zwiekszajacy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zwiekszajacy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZWIEKSZAJACY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_wlasny', "1") == "1" || P('show_create_wlasny', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_wlasny_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_wlasny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WLASNY') ?>
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
			if (P('event_column') == "wlasny") {
				$resultRodzajDokumentu->setWlasny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_wlasny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wlasny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWlasny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWlasny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WLASNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWlasny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWlasny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_wewnetrzny', "1") == "1" || P('show_create_wewnetrzny', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_wewnetrzny_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_wewnetrzny_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WEWNETRZNY') ?>
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
			if (P('event_column') == "wewnetrzny") {
				$resultRodzajDokumentu->setWewnetrzny($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_wewnetrzny', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="wewnetrzny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WEWNETRZNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWewnetrzny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWewnetrzny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_korekta', "1") == "1" || P('show_create_korekta', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_korekta_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_korekta_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('KOREKTA') ?>
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
			if (P('event_column') == "korekta") {
				$resultRodzajDokumentu->setKorekta($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_korekta', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="korekta"
>
<?php
	if (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getKorekta() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getKorekta() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_KOREKTA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getKorekta() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getKorekta() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_zastepczy', "1") == "1" || P('show_create_zastepczy', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_zastepczy_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_zastepczy_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ZASTEPCZY') ?>
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
			if (P('event_column') == "zastepczy") {
				$resultRodzajDokumentu->setZastepczy($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_zastepczy', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="zastepczy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZastepczy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZastepczy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZASTEPCZY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZastepczy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZastepczy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_ostatni_numer', "1") == "1" || P('show_create_ostatni_numer', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_ostatni_numer_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('OSTATNI_NUMER') ?>
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
			if (P('event_column') == "ostatni_numer") {
				$resultRodzajDokumentu->setOstatniNumer($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ostatni_numer', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ostatniNumer" name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_OSTATNI_NUMER');
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
$('#rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (P('show_create_numeracja_rok', "1") == "1" || P('show_create_numeracja_rok', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>">
 <?php echo P('show_create_numeracja_rok_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('NUMERACJA_ROK') ?>
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
			if (P('event_column') == "numeracja_rok") {
				$resultRodzajDokumentu->setNumeracjaRok($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_numeracja_rok', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="numeracjaRok" name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NUMERACJA_ROK');
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
$('#rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (class_exists('sealock\virgoGrupaDokumentow') && ((P('show_create_grupa_dokumentow', "1") == "1" || P('show_create_grupa_dokumentow', "1") == "2" || P('show_create_grupa_dokumentow', "1") == "3") && !isset($context["gdk"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="rdk_grupaDokumentow_<?php echo isset($resultRodzajDokumentu->rdk_id) ? $resultRodzajDokumentu->rdk_id : '' ?>">
 *
<?php $customLabel = TE('GRUPA_DOKUMENTOW_'); echo !is_null($customLabel) ? $customLabel : T('GRUPA_DOKUMENTOW') . ' ' . T('') ?> 
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
//		$limit_grupa_dokumentow = $componentParams->get('limit_to_grupa_dokumentow');
		$limit_grupa_dokumentow = null;
		$tmpId = sealock\virgoRodzajDokumentu::getParentInContext("sealock\\virgoGrupaDokumentow");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_grupa_dokumentow', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRodzajDokumentu->rdk_gdk__id = $tmpId;
//			}
			if (!is_null($resultRodzajDokumentu->getGdkId())) {
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentValue = sealock\virgoGrupaDokumentow::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_RODZAJ_DOKUMENTU_GRUPA_DOKUMENTOW');
?>
<?php
	$whereList = "";
	if (!is_null($limit_grupa_dokumentow) && trim($limit_grupa_dokumentow) != "") {
		$whereList = $whereList . " gdk_id ";
		if (trim($limit_grupa_dokumentow) == "page_title") {
			$limit_grupa_dokumentow = "SELECT gdk_id FROM slk_grupy_dokumentow WHERE gdk_" . $limit_grupa_dokumentow . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_dokumentow = \"$limit_grupa_dokumentow\";");
		$whereList = $whereList . " IN (" . $limit_grupa_dokumentow . ") ";
	}						
	$parentCount = sealock\virgoGrupaDokumentow::getVirgoListSize($whereList);
	$showAjaxrdk = P('show_create_grupa_dokumentow', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrdk) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
							name="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
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
			if (is_null($limit_grupa_dokumentow) || trim($limit_grupa_dokumentow) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaDokumentow = sealock\virgoGrupaDokumentow::getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaDokumentow)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultRodzajDokumentu->getGdkId()) && $id == $resultRodzajDokumentu->getGdkId() ? "selected='selected'" : "");
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
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentGrupaDokumentow = new sealock\virgoGrupaDokumentow();
				$parentValue = $parentGrupaDokumentow->lookup($parentId);
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
	<input type="hidden" id="rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" 
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
        $( "#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaDokumentow",
			virgo_field_name: "grupa_dokumentow",
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
					$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.value);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val('');
				$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').removeClass("locked");		
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
$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (isset($context["gdk"])) {
		$parentValue = $context["gdk"];
	} else {
		$parentValue = $resultRodzajDokumentu->rdk_gdk_id;
	}
	
?>
				<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_create_dokumenty_ksiegowe', '1') == "1") {
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
	if ($resultRodzajDokumentu->getDateCreated()) {
		if ($resultRodzajDokumentu->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRodzajDokumentu->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRodzajDokumentu->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRodzajDokumentu->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRodzajDokumentu->getDateModified()) {
		if ($resultRodzajDokumentu->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRodzajDokumentu->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRodzajDokumentu->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRodzajDokumentu->getDateModified() ?>"	>
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
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($rodzajDokumentuDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('RODZAJ_DOKUMENTU') ?>:</legend>
				<ul>
<?php
	$criteriaRodzajDokumentu = $resultRodzajDokumentu->getCriteria();
?>
<?php
	if (P('show_search_nazwa', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["nazwa"])) {
			$fieldCriteriaNazwa = $criteriaRodzajDokumentu["nazwa"];
			$dataTypeCriteria = $fieldCriteriaNazwa["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('NAZWA') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_nazwa" 
							name="virgo_search_nazwa"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_nazwa_is_null" 
				name="virgo_search_nazwa_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaNazwa) && $fieldCriteriaNazwa["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaNazwa) && $fieldCriteriaNazwa["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaNazwa) && $fieldCriteriaNazwa["is_null"] == 2) {
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
	if (P('show_search_symbol', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["symbol"])) {
			$fieldCriteriaSymbol = $criteriaRodzajDokumentu["symbol"];
			$dataTypeCriteria = $fieldCriteriaSymbol["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('SYMBOL') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_symbol" 
							name="virgo_search_symbol"
							style="border: yellow 1 solid;" 
							maxlength="10"
							size="10" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_symbol_is_null" 
				name="virgo_search_symbol_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaSymbol) && $fieldCriteriaSymbol["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaSymbol) && $fieldCriteriaSymbol["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaSymbol) && $fieldCriteriaSymbol["is_null"] == 2) {
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
	if (P('show_search_zwiekszajacy', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["zwiekszajacy"])) {
			$fieldCriteriaZwiekszajacy = $criteriaRodzajDokumentu["zwiekszajacy"];
			$dataTypeCriteria = $fieldCriteriaZwiekszajacy["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ZWIEKSZAJACY') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_zwiekszajacy" name="virgo_search_zwiekszajacy">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_zwiekszajacy_is_null" 
				name="virgo_search_zwiekszajacy_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaZwiekszajacy) && $fieldCriteriaZwiekszajacy["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaZwiekszajacy) && $fieldCriteriaZwiekszajacy["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaZwiekszajacy) && $fieldCriteriaZwiekszajacy["is_null"] == 2) {
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
	if (P('show_search_wlasny', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["wlasny"])) {
			$fieldCriteriaWlasny = $criteriaRodzajDokumentu["wlasny"];
			$dataTypeCriteria = $fieldCriteriaWlasny["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('WLASNY') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_wlasny" name="virgo_search_wlasny">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_wlasny_is_null" 
				name="virgo_search_wlasny_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaWlasny) && $fieldCriteriaWlasny["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaWlasny) && $fieldCriteriaWlasny["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaWlasny) && $fieldCriteriaWlasny["is_null"] == 2) {
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
	if (P('show_search_wewnetrzny', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["wewnetrzny"])) {
			$fieldCriteriaWewnetrzny = $criteriaRodzajDokumentu["wewnetrzny"];
			$dataTypeCriteria = $fieldCriteriaWewnetrzny["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('WEWNETRZNY') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_wewnetrzny" name="virgo_search_wewnetrzny">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_wewnetrzny_is_null" 
				name="virgo_search_wewnetrzny_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaWewnetrzny) && $fieldCriteriaWewnetrzny["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaWewnetrzny) && $fieldCriteriaWewnetrzny["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaWewnetrzny) && $fieldCriteriaWewnetrzny["is_null"] == 2) {
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
	if (P('show_search_korekta', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["korekta"])) {
			$fieldCriteriaKorekta = $criteriaRodzajDokumentu["korekta"];
			$dataTypeCriteria = $fieldCriteriaKorekta["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('KOREKTA') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_korekta" name="virgo_search_korekta">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_korekta_is_null" 
				name="virgo_search_korekta_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaKorekta) && $fieldCriteriaKorekta["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaKorekta) && $fieldCriteriaKorekta["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaKorekta) && $fieldCriteriaKorekta["is_null"] == 2) {
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
	if (P('show_search_zastepczy', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["zastepczy"])) {
			$fieldCriteriaZastepczy = $criteriaRodzajDokumentu["zastepczy"];
			$dataTypeCriteria = $fieldCriteriaZastepczy["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ZASTEPCZY') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_zastepczy" name="virgo_search_zastepczy">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_zastepczy_is_null" 
				name="virgo_search_zastepczy_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaZastepczy) && $fieldCriteriaZastepczy["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaZastepczy) && $fieldCriteriaZastepczy["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaZastepczy) && $fieldCriteriaZastepczy["is_null"] == 2) {
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
	if (P('show_search_ostatni_numer', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["ostatni_numer"])) {
			$fieldCriteriaOstatniNumer = $criteriaRodzajDokumentu["ostatni_numer"];
			$dataTypeCriteria = $fieldCriteriaOstatniNumer["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('OSTATNI_NUMER') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_ostatniNumer_from" 
							name="virgo_search_ostatniNumer_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_ostatniNumer_to" 
							name="virgo_search_ostatniNumer_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_ostatniNumer_is_null" 
				name="virgo_search_ostatniNumer_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaOstatniNumer) && $fieldCriteriaOstatniNumer["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaOstatniNumer) && $fieldCriteriaOstatniNumer["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaOstatniNumer) && $fieldCriteriaOstatniNumer["is_null"] == 2) {
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
	if (P('show_search_numeracja_rok', "1") == "1") {

		if (isset($criteriaRodzajDokumentu["numeracja_rok"])) {
			$fieldCriteriaNumeracjaRok = $criteriaRodzajDokumentu["numeracja_rok"];
			$dataTypeCriteria = $fieldCriteriaNumeracjaRok["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('NUMERACJA_ROK') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_numeracjaRok_from" 
							name="virgo_search_numeracjaRok_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_numeracjaRok_to" 
							name="virgo_search_numeracjaRok_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_numeracjaRok_is_null" 
				name="virgo_search_numeracjaRok_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaNumeracjaRok) && $fieldCriteriaNumeracjaRok["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaNumeracjaRok) && $fieldCriteriaNumeracjaRok["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaNumeracjaRok) && $fieldCriteriaNumeracjaRok["is_null"] == 2) {
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
	if (P('show_search_grupa_dokumentow', '1') == "1") {
		if (isset($criteriaRodzajDokumentu["grupa_dokumentow"])) {
			$fieldCriteriaGrupaDokumentow = $criteriaRodzajDokumentu["grupa_dokumentow"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('GRUPA_DOKUMENTOW') ?> <?php echo T('') ?></label>
<?php
	$ids = (isset($fieldCriteriaGrupaDokumentow["ids"]) ? $fieldCriteriaGrupaDokumentow["ids"] : array());
	$resultsGrupaDokumentow = sealock\virgoGrupaDokumentow::getVirgoList();
	$maxListboxSize = 10;
?>
    <select class="inputbox " id="virgo_search_grupaDokumentow[]" name="virgo_search_grupaDokumentow[]" multiple
<?php
	if (sizeof($resultsGrupaDokumentow) > $maxListboxSize) {
		echo "size=" . $maxListboxSize;
	}
?>	
    >
<?php
	while(list($id, $label)=each($resultsGrupaDokumentow)) {
?>	
<option value="<?php echo $id ?>" 
<?php 
	echo (is_array($ids) && in_array($id, $ids) ? "selected='selected'" : "");
?>><?php echo $label ?>
</option>
<?php
	}
?>
    </select>
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
		if (isset($fieldCriteriaGrupaDokumentow) && $fieldCriteriaGrupaDokumentow["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaGrupaDokumentow) && $fieldCriteriaGrupaDokumentow["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaGrupaDokumentow) && $fieldCriteriaGrupaDokumentow["is_null"] == 2) {
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
	if (P('show_search_dokumenty_ksiegowe') == "1") {
?>
<?php
	$record = new sealock\virgoRodzajDokumentu();
	$recordId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->rdk_id;
	$record->load($recordId);
	$subrecordsDokumentyKsiegowe = $record->getDokumentyKsiegowe();
	$sizeDokumentyKsiegowe = count($subrecordsDokumentyKsiegowe);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Dokumenty księgowe
					</label>
<?php
	if ($sizeDokumentyKsiegowe == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsDokumentyKsiegowe as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeDokumentyKsiegowe) {
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
	unset($criteriaRodzajDokumentu);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	} elseif ($rodzajDokumentuDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('RODZAJ_DOKUMENTU') ?>:</legend>
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
	if (P('show_view_nazwa', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="nazwa"
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
<?php echo T('NAZWA') ?>
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
							<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="nazwa" name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_symbol', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="symbol"
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
<?php echo T('SYMBOL') ?>
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
							<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="symbol" name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_zwiekszajacy', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="zwiekszajacy"
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
<?php echo T('ZWIEKSZAJACY') ?>
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


<span 
	class="inputbox readonly" 
	id="zwiekszajacy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZwiekszajacy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

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
	if (P('show_view_wlasny', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="wlasny"
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
<?php echo T('WLASNY') ?>
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


<span 
	class="inputbox readonly" 
	id="wlasny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWlasny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWlasny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

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
	if (P('show_view_wewnetrzny', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="wewnetrzny"
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
<?php echo T('WEWNETRZNY') ?>
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


<span 
	class="inputbox readonly" 
	id="wewnetrzny"
>
<?php
	if (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getWewnetrzny() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

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
	if (P('show_view_korekta', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="korekta"
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
<?php echo T('KOREKTA') ?>
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


<span 
	class="inputbox readonly" 
	id="korekta"
>
<?php
	if (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getKorekta() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getKorekta() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

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
	if (P('show_view_zastepczy', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="zastepczy"
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
<?php echo T('ZASTEPCZY') ?>
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


<span 
	class="inputbox readonly" 
	id="zastepczy"
>
<?php
	if (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultRodzajDokumentu->getZastepczy() == 1) {
		$booleanValue = T("YES");
	} elseif ($resultRodzajDokumentu->getZastepczy() === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

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
	if (P('show_view_ostatni_numer', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="ostatni_numer"
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
<?php echo T('OSTATNI_NUMER') ?>
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
							<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ostatniNumer" name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_numeracja_rok', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="numeracja_rok"
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
<?php echo T('NUMERACJA_ROK') ?>
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
							<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="numeracjaRok" name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (class_exists('sealock\virgoGrupaDokumentow') && P('show_view_grupa_dokumentow', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "grupa_dokumentow" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="grupa_dokumentow"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Grupa dokumentów </span>
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
			if (!is_null($context) && isset($context['gdk_id'])) {
				$tmpId = $context['gdk_id'];
			}
			$readOnly = "";
			if ($resultRodzajDokumentu->getId() == 0) {
// przesuac do createforgui				$resultRodzajDokumentu->rdk_gdk__id = $tmpId;
			}
			$parentId = $resultRodzajDokumentu->getGrupaDokumentowId();
			$parentValue = sealock\virgoGrupaDokumentow::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="rdk_grupaDokumentow_<?php echo isset($resultRodzajDokumentu->rdk_id) ? $resultRodzajDokumentu->rdk_id : '' ?>" 
						name="rdk_grupaDokumentow_<?php echo isset($resultRodzajDokumentu->rdk_id) ? $resultRodzajDokumentu->rdk_id : '' ?>" 						
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
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_view_dokumenty_ksiegowe', '0') == "1") {
?>
<?php
	$record = new sealock\virgoRodzajDokumentu();
	$recordId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->rdk_id;
	$record->load($recordId);
	$subrecordsDokumentyKsiegowe = $record->getDokumentyKsiegowe();
	$sizeDokumentyKsiegowe = count($subrecordsDokumentyKsiegowe);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="rodzaj_dokumentu"
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
						Dokumenty księgowe 
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
	if ($sizeDokumentyKsiegowe == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsDokumentyKsiegowe as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeDokumentyKsiegowe) {
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
<?php echo T('RODZAJ_DOKUMENTU') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultRodzajDokumentu->getDateCreated()) {
		if ($resultRodzajDokumentu->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultRodzajDokumentu->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultRodzajDokumentu->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultRodzajDokumentu->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultRodzajDokumentu->getDateModified()) {
		if ($resultRodzajDokumentu->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultRodzajDokumentu->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultRodzajDokumentu->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultRodzajDokumentu->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultRodzajDokumentu->getDateModified() ?>"	>
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
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("RODZAJ_DOKUMENTU"), "\\'".$resultRodzajDokumentu->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	} elseif ($rodzajDokumentuDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "rdk_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultRodzajDokumentu->setShowPage(1); 
	$resultRodzajDokumentu->setShowRows('all'); 	
	$resultsRodzajDokumentu = $resultRodzajDokumentu->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
		if (isset($resultRodzajDokumentu[$eventColumn]) && isset($events[substr($resultRodzajDokumentu[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultRodzajDokumentu[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoRodzajDokumentu($resultRodzajDokumentu['rdk_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultRodzajDokumentu[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='rdk_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultRodzajDokumentu) {
?>
<?php
PROFILE('token');
	if (isset($resultRodzajDokumentu)) {
		$tmpId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId();
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultRodzajDokumentu->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.rdk_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var rodzajDokumentuChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == rodzajDokumentuChildrenDivOpen) {
					div.style.display = 'none';
					rodzajDokumentuChildrenDivOpen = '';
				} else {
					if (rodzajDokumentuChildrenDivOpen != '') {
						document.getElementById(rodzajDokumentuChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					rodzajDokumentuChildrenDivOpen = clickedDivId;
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
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultRodzajDokumentu->getShowPage(); 
			$showRows = $resultRodzajDokumentu->getShowRows(); 
?>
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Rodzaje dokumentów') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultRodzajDokumentu->getOrderColumn();
			$virgoOrderMode = $resultRodzajDokumentu->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsRodzajDokumentu = $resultRodzajDokumentu->getTableData($resultCount, $filterApplied);
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
	if (P('show_table_nazwa', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_nazwa');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('NAZWA') ?>							<?php echo ($oc == "rdk_nazwa" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterNazwa', null);
?>
						<input
							name="virgo_filter_nazwa"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_symbol', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_symbol');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('SYMBOL') ?>							<?php echo ($oc == "rdk_symbol" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterSymbol', null);
?>
						<input
							name="virgo_filter_symbol"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_zwiekszajacy', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_zwiekszajacy');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ZWIEKSZAJACY') ?>							<?php echo ($oc == "rdk_zwiekszajacy" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterZwiekszajacy', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_wlasny', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_wlasny');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('WLASNY') ?>							<?php echo ($oc == "rdk_wlasny" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterWlasny', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_wewnetrzny', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_wewnetrzny');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('WEWNETRZNY') ?>							<?php echo ($oc == "rdk_wewnetrzny" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterWewnetrzny', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_korekta', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_korekta');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('KOREKTA') ?>							<?php echo ($oc == "rdk_korekta" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterKorekta', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_zastepczy', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_zastepczy');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ZASTEPCZY') ?>							<?php echo ($oc == "rdk_zastepczy" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterZastepczy', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_ostatni_numer', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_ostatni_numer');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('OSTATNI_NUMER') ?>							<?php echo ($oc == "rdk_ostatni_numer" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterOstatniNumer', null);
?>
						<input
							name="virgo_filter_ostatni_numer"
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
	if (P('show_table_numeracja_rok', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'rdk_numeracja_rok');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('NUMERACJA_ROK') ?>							<?php echo ($oc == "rdk_numeracja_rok" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterNumeracjaRok', null);
?>
						<input
							name="virgo_filter_numeracja_rok"
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoGrupaDokumentow'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_grupa_dokumentow', "1") != "0"  && !isset($parentsInContext['sealock\\virgoGrupaDokumentow'])  ) {
	if (P('show_table_grupa_dokumentow', "1") == "2") {
		$tmpLookupGrupaDokumentow = virgoGrupaDokumentow::getVirgoListStatic();
?>
<input name='rdk_GrupaDokumentow_id_<?php echo $this->getId() ?>' id='rdk_GrupaDokumentow_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultRodzajDokumentu->getOrderColumn(); 
	$om = $resultRodzajDokumentu->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'grupa_dokumentow');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php
	$customLabel = TE('GRUPA_DOKUMENTOW_'); 
	echo !is_null($customLabel) ? $customLabel : T('GRUPA_DOKUMENTOW') . '&nbsp;' . T('')
?>
							<?php echo ($oc == "grupa_dokumentow" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoGrupaDokumentow::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoGrupaDokumentow::getVirgoListStatic();
			$parentFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterGrupaDokumentow', null);
?>
						<select 
							name="virgo_filter_grupa_dokumentow"
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
			$parentFilter = virgoRodzajDokumentu::getLocalSessionValue('VirgoFilterTitleGrupaDokumentow', null);
?>
						<input
							name="virgo_filter_title_grupa_dokumentow"
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
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_table_dokumenty_ksiegowe', '0') == "1") {
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
					$resultRodzajDokumentu->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/virgoRodzajDokumentu/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/sealock/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultRodzajDokumentu['rdk_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoRodzajDokumentu::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoRodzajDokumentu::setContextId($resultRodzajDokumentu['rdk_id'], false);
						$tmpContextId = $resultRodzajDokumentu['rdk_id'];
					}
				}
				if (isset($tmpContextId) && $resultRodzajDokumentu['rdk_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
<?php
				if (class_exists('sealock\virgoGrupaDokumentow') && P('show_view_grupa_dokumentow', "1") == "1") {
?>
 grupa_dokumentow_<?php echo isset($resultRodzajDokumentu['rdk_gdk_id']) ? $resultRodzajDokumentu['rdk_gdk_id'] : "" ?>
<?php
				}
?>
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRodzajDokumentu['rdk_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRodzajDokumentu['rdk_id'] ?>">
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
PROFILE('nazwa');
	if (P('show_table_nazwa', "0") == "1") {
PROFILE('render_data_table_nazwa');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="nazwa">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRodzajDokumentu['rdk_nazwa'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_nazwa');
	}
PROFILE('nazwa');
?>
<?php
PROFILE('symbol');
	if (P('show_table_symbol', "1") == "1") {
PROFILE('render_data_table_symbol');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="symbol">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRodzajDokumentu['rdk_symbol'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_symbol');
	}
PROFILE('symbol');
?>
<?php
PROFILE('zwi\u0119kszaj\u0105cy');
	if (P('show_table_zwiekszajacy', "0") == "1") {
PROFILE('render_data_table_zwiekszajacy');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="zwiekszajacy">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_zwiekszajacy', "1") == "1");
	if ($resultRodzajDokumentu['rdk_zwiekszajacy'] == 2 || is_null($resultRodzajDokumentu['rdk_zwiekszajacy'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_zwiekszajacy']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zwiekszajacy'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zwiekszajacy'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_zwiekszajacy');
	}
PROFILE('zwi\u0119kszaj\u0105cy');
?>
<?php
PROFILE('w\u0142asny');
	if (P('show_table_wlasny', "0") == "1") {
PROFILE('render_data_table_wlasny');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="wlasny">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_wlasny', "1") == "1");
	if ($resultRodzajDokumentu['rdk_wlasny'] == 2 || is_null($resultRodzajDokumentu['rdk_wlasny'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_wlasny']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wlasny'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wlasny'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_wlasny');
	}
PROFILE('w\u0142asny');
?>
<?php
PROFILE('wewn\u0119trzny');
	if (P('show_table_wewnetrzny', "0") == "1") {
PROFILE('render_data_table_wewnetrzny');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="wewnetrzny">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_wewnetrzny', "1") == "1");
	if ($resultRodzajDokumentu['rdk_wewnetrzny'] == 2 || is_null($resultRodzajDokumentu['rdk_wewnetrzny'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_wewnetrzny']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wewnetrzny'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wewnetrzny'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_wewnetrzny');
	}
PROFILE('wewn\u0119trzny');
?>
<?php
PROFILE('korekta');
	if (P('show_table_korekta', "0") == "1") {
PROFILE('render_data_table_korekta');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="korekta">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_korekta', "1") == "1");
	if ($resultRodzajDokumentu['rdk_korekta'] == 2 || is_null($resultRodzajDokumentu['rdk_korekta'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_korekta']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_korekta'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_korekta'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_korekta');
	}
PROFILE('korekta');
?>
<?php
PROFILE('zast\u0119pczy');
	if (P('show_table_zastepczy', "0") == "1") {
PROFILE('render_data_table_zastepczy');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="zastepczy">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_zastepczy', "1") == "1");
	if ($resultRodzajDokumentu['rdk_zastepczy'] == 2 || is_null($resultRodzajDokumentu['rdk_zastepczy'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_zastepczy']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zastepczy'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zastepczy'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_zastepczy');
	}
PROFILE('zast\u0119pczy');
?>
<?php
PROFILE('ostatni numer');
	if (P('show_table_ostatni_numer', "0") == "1") {
PROFILE('render_data_table_ostatni_numer');
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
			<li class="ostatni_numer">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
				$resultRodzajDokumentu['rdk_ostatni_numer'] 
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
PROFILE('render_data_table_ostatni_numer');
	}
PROFILE('ostatni numer');
?>
<?php
PROFILE('numeracja rok');
	if (P('show_table_numeracja_rok', "0") == "1") {
PROFILE('render_data_table_numeracja_rok');
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
			<li class="numeracja_rok">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
				$resultRodzajDokumentu['rdk_numeracja_rok'] 
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
PROFILE('render_data_table_numeracja_rok');
	}
PROFILE('numeracja rok');
?>
<?php
	if (class_exists('sealock\virgoGrupaDokumentow') && P('show_table_grupa_dokumentow', "1") != "0"  && !isset($parentsInContext["sealock\\virgoGrupaDokumentow"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_grupa_dokumentow', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="grupa_dokumentow">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	if (P('show_table_grupa_dokumentow', "1") == "1") {
		if (isset($resultRodzajDokumentu['grupa_dokumentow'])) {
			echo $resultRodzajDokumentu['grupa_dokumentow'];
		}
	} else {
//		echo $resultRodzajDokumentu['rdk_gdk_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetGrupaDokumentow';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
	_pSF(form, 'rdk_GrupaDokumentow_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupGrupaDokumentow as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultRodzajDokumentu['rdk_gdk_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_table_dokumenty_ksiegowe', '0') == "1") {
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
	if (isset($resultRodzajDokumentu)) {
		$tmpId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId();
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("RODZAJ_DOKUMENTU"), "\\'".rawurlencode($resultRodzajDokumentu['rdk_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRodzajDokumentu['rdk_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultRodzajDokumentu['rdk_id'] ?>">
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
PROFILE('nazwa');
	if (P('show_table_nazwa', "0") == "1") {
PROFILE('render_data_table_nazwa');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="nazwa">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRodzajDokumentu['rdk_nazwa'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_nazwa');
	}
PROFILE('nazwa');
?>
<?php
PROFILE('symbol');
	if (P('show_table_symbol', "1") == "1") {
PROFILE('render_data_table_symbol');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="symbol">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultRodzajDokumentu['rdk_symbol'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_symbol');
	}
PROFILE('symbol');
?>
<?php
PROFILE('zwi\u0119kszaj\u0105cy');
	if (P('show_table_zwiekszajacy', "0") == "1") {
PROFILE('render_data_table_zwiekszajacy');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="zwiekszajacy">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_zwiekszajacy', "1") == "1");
	if ($resultRodzajDokumentu['rdk_zwiekszajacy'] == 2 || is_null($resultRodzajDokumentu['rdk_zwiekszajacy'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_zwiekszajacy']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zwiekszajacy'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zwiekszajacy'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_zwiekszajacy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZwiekszajacyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_zwiekszajacy');
	}
PROFILE('zwi\u0119kszaj\u0105cy');
?>
<?php
PROFILE('w\u0142asny');
	if (P('show_table_wlasny', "0") == "1") {
PROFILE('render_data_table_wlasny');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="wlasny">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_wlasny', "1") == "1");
	if ($resultRodzajDokumentu['rdk_wlasny'] == 2 || is_null($resultRodzajDokumentu['rdk_wlasny'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_wlasny']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wlasny'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wlasny'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_wlasny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWlasnyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_wlasny');
	}
PROFILE('w\u0142asny');
?>
<?php
PROFILE('wewn\u0119trzny');
	if (P('show_table_wewnetrzny', "0") == "1") {
PROFILE('render_data_table_wewnetrzny');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="wewnetrzny">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_wewnetrzny', "1") == "1");
	if ($resultRodzajDokumentu['rdk_wewnetrzny'] == 2 || is_null($resultRodzajDokumentu['rdk_wewnetrzny'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_wewnetrzny']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wewnetrzny'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_wewnetrzny'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_wewnetrzny_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetWewnetrznyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_wewnetrzny');
	}
PROFILE('wewn\u0119trzny');
?>
<?php
PROFILE('korekta');
	if (P('show_table_korekta', "0") == "1") {
PROFILE('render_data_table_korekta');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="korekta">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_korekta', "1") == "1");
	if ($resultRodzajDokumentu['rdk_korekta'] == 2 || is_null($resultRodzajDokumentu['rdk_korekta'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_korekta']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_korekta'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_korekta'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_korekta_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetKorektaTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_korekta');
	}
PROFILE('korekta');
?>
<?php
PROFILE('zast\u0119pczy');
	if (P('show_table_zastepczy', "0") == "1") {
PROFILE('render_data_table_zastepczy');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="zastepczy">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_zastepczy', "1") == "1");
	if ($resultRodzajDokumentu['rdk_zastepczy'] == 2 || is_null($resultRodzajDokumentu['rdk_zastepczy'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo is_null($resultRodzajDokumentu['rdk_zastepczy']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zastepczy'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyFalse';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultRodzajDokumentu['rdk_zastepczy'] === 0) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_zastepczy_<?php echo $resultRodzajDokumentu['rdk_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetZastepczyTrue';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
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
PROFILE('render_data_table_zastepczy');
	}
PROFILE('zast\u0119pczy');
?>
<?php
PROFILE('ostatni numer');
	if (P('show_table_ostatni_numer', "0") == "1") {
PROFILE('render_data_table_ostatni_numer');
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
			<li class="ostatni_numer">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
				$resultRodzajDokumentu['rdk_ostatni_numer'] 
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
PROFILE('render_data_table_ostatni_numer');
	}
PROFILE('ostatni numer');
?>
<?php
PROFILE('numeracja rok');
	if (P('show_table_numeracja_rok', "0") == "1") {
PROFILE('render_data_table_numeracja_rok');
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
			<li class="numeracja_rok">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
				$resultRodzajDokumentu['rdk_numeracja_rok'] 
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
PROFILE('render_data_table_numeracja_rok');
	}
PROFILE('numeracja rok');
?>
<?php
	if (class_exists('sealock\virgoGrupaDokumentow') && P('show_table_grupa_dokumentow', "1") != "0"  && !isset($parentsInContext["sealock\\virgoGrupaDokumentow"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_grupa_dokumentow', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="grupa_dokumentow">
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
					form.rdk_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultRodzajDokumentu['rdk_id']) ? $resultRodzajDokumentu['rdk_id'] : '' ?>'; 
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
	if (P('show_table_grupa_dokumentow', "1") == "1") {
		if (isset($resultRodzajDokumentu['grupa_dokumentow'])) {
			echo $resultRodzajDokumentu['grupa_dokumentow'];
		}
	} else {
//		echo $resultRodzajDokumentu['rdk_gdk_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetGrupaDokumentow';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo $resultRodzajDokumentu['rdk_id'] ?>');
	_pSF(form, 'rdk_GrupaDokumentow_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupGrupaDokumentow as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultRodzajDokumentu['rdk_gdk_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_table_dokumenty_ksiegowe', '0') == "1") {
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
	if (isset($resultRodzajDokumentu)) {
		$tmpId = is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId();
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("RODZAJ_DOKUMENTU"), "\\'".rawurlencode($resultRodzajDokumentu['rdk_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
			virgoRodzajDokumentu::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultRodzajDokumentu);
				unset($resultsRodzajDokumentu);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpRodzajDokumentu = new virgoRodzajDokumentu();
						$tmpCount = $tmpRodzajDokumentu->getAllRecordCount(' rdk_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoRodzajDokumentu::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&rdk_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.rdk_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.rdk_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rdk_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rdk_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rdk_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rdk_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'rdk_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'rdk_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
					$sessionSeparator = virgoRodzajDokumentu::getImportFieldSeparator();
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
						$sessionSeparator = virgoRodzajDokumentu::getImportFieldSeparator();
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('RODZAJE_DOKUMENTOW'), "") ?>'))) return false;
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	} elseif ($rodzajDokumentuDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_rodzaj_dokumentu") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var rodzajDokumentuChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == rodzajDokumentuChildrenDivOpen) {
					div.style.display = 'none';
					rodzajDokumentuChildrenDivOpen = '';
				} else {
					if (rodzajDokumentuChildrenDivOpen != '') {
						document.getElementById(rodzajDokumentuChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					rodzajDokumentuChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_rodzaj_dokumentu" name="virgo_form_rodzaj_dokumentu" enctype="multipart/form-data">
						<input type="text" name="rdk_id_<?php echo $this->getId() ?>" id="rdk_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_nazwa', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Nazwa
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_symbol', "1") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Symbol
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_zwiekszajacy', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Zwiększający
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_wlasny', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Własny
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_wewnetrzny', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Wewnętrzny
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_korekta', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Korekta
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_zastepczy', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Zastępczy
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_ostatni_numer', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ostatni numer
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_numeracja_rok', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Numeracja rok
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_grupa_dokumentow', "1") == "1" /* && ($masterComponentName != "grupa_dokumentow" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Grupa dokumentów </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsRodzajDokumentu = $resultRodzajDokumentu->getRecordsToEdit();
				$idsToCorrect = $resultRodzajDokumentu->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsRodzajDokumentu as $resultRodzajDokumentu) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultRodzajDokumentu->rdk_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultRodzajDokumentu->rdk_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('nazwa');
	if (P('show_table_nazwa', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 0;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_nazwa_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getNazwa(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NAZWA');
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
$('#rdk_nazwa_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('nazwa');
	} else {
?> 
						<input
							type="hidden"
							id="nazwa_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="nazwa_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_nazwa, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('symbol');
	if (P('show_table_symbol', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 1;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  obligatory   short  " 
							type="text"
							id="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>"
							maxlength="10"
							size="10" 
							value="<?php echo htmlentities($resultRodzajDokumentu->getSymbol(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_SYMBOL');
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
$('#rdk_symbol_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('symbol');
	} else {
?> 
						<input
							type="hidden"
							id="symbol_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="symbol_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_symbol, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('zwi\u0119kszaj\u0105cy');
	if (P('show_table_zwiekszajacy', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 2;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZWIEKSZAJACY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZwiekszajacy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZwiekszajacy()) || $resultRodzajDokumentu->getZwiekszajacy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zwiekszajacy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('zwi\u0119kszaj\u0105cy');
	} else {
?> 
						<input
							type="hidden"
							id="zwiekszajacy_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="zwiekszajacy_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_zwiekszajacy, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('w\u0142asny');
	if (P('show_table_wlasny', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 3;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WLASNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWlasny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWlasny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWlasny()) || $resultRodzajDokumentu->getWlasny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wlasny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('w\u0142asny');
	} else {
?> 
						<input
							type="hidden"
							id="wlasny_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="wlasny_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_wlasny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('wewn\u0119trzny');
	if (P('show_table_wewnetrzny', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 4;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_WEWNETRZNY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getWewnetrzny() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getWewnetrzny() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getWewnetrzny()) || $resultRodzajDokumentu->getWewnetrzny() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_wewnetrzny_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('wewn\u0119trzny');
	} else {
?> 
						<input
							type="hidden"
							id="wewnetrzny_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="wewnetrzny_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_wewnetrzny, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('korekta');
	if (P('show_table_korekta', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 5;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_KOREKTA');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getKorekta() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getKorekta() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getKorekta()) || $resultRodzajDokumentu->getKorekta() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_korekta_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('korekta');
	} else {
?> 
						<input
							type="hidden"
							id="korekta_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="korekta_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_korekta, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('zast\u0119pczy');
	if (P('show_table_zastepczy', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 6;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
<select class="inputbox" id="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_ZASTEPCZY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultRodzajDokumentu->getZastepczy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultRodzajDokumentu->getZastepczy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultRodzajDokumentu->getZastepczy()) || $resultRodzajDokumentu->getZastepczy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#rdk_zastepczy_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('zast\u0119pczy');
	} else {
?> 
						<input
							type="hidden"
							id="zastepczy_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="zastepczy_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_zastepczy, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('ostatni numer');
	if (P('show_table_ostatni_numer', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 7;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ostatni_numer_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getOstatniNumer(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_OSTATNI_NUMER');
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
$('#rdk_ostatniNumer_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('ostatni numer');
	} else {
?> 
						<input
							type="hidden"
							id="ostatniNumer_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="ostatniNumer_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_ostatni_numer, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('numeracja rok');
	if (P('show_table_numeracja_rok', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 8;
?>
<?php
	if (!isset($resultRodzajDokumentu)) {
		$resultRodzajDokumentu = new sealock\virgoRodzajDokumentu();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_numeracja_rok_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>" 
							name="rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultRodzajDokumentu->getNumeracjaRok(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_RODZAJ_DOKUMENTU_NUMERACJA_ROK');
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
$('#rdk_numeracjaRok_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('numeracja rok');
	} else {
?> 
						<input
							type="hidden"
							id="numeracjaRok_<?php echo $resultRodzajDokumentu->rdk_id ?>" 
							name="numeracjaRok_<?php echo $resultRodzajDokumentu->rdk_id ?>"
							value="<?php echo htmlentities($resultRodzajDokumentu->rdk_numeracja_rok, ENT_QUOTES, "UTF-8") ?>"
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
	if (P('show_table_grupa_dokumentow', "1") == "1"/* && ($masterComponentName != "grupa_dokumentow" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsRodzajDokumentu) * 9;
?>
<?php
//		$limit_grupa_dokumentow = $componentParams->get('limit_to_grupa_dokumentow');
		$limit_grupa_dokumentow = null;
		$tmpId = sealock\virgoRodzajDokumentu::getParentInContext("sealock\\virgoGrupaDokumentow");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_grupa_dokumentow', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultRodzajDokumentu->rdk_gdk__id = $tmpId;
//			}
			if (!is_null($resultRodzajDokumentu->getGdkId())) {
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentValue = sealock\virgoGrupaDokumentow::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_RODZAJ_DOKUMENTU_GRUPA_DOKUMENTOW');
?>
<?php
	$whereList = "";
	if (!is_null($limit_grupa_dokumentow) && trim($limit_grupa_dokumentow) != "") {
		$whereList = $whereList . " gdk_id ";
		if (trim($limit_grupa_dokumentow) == "page_title") {
			$limit_grupa_dokumentow = "SELECT gdk_id FROM slk_grupy_dokumentow WHERE gdk_" . $limit_grupa_dokumentow . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_grupa_dokumentow = \"$limit_grupa_dokumentow\";");
		$whereList = $whereList . " IN (" . $limit_grupa_dokumentow . ") ";
	}						
	$parentCount = sealock\virgoGrupaDokumentow::getVirgoListSize($whereList);
	$showAjaxrdk = P('show_form_grupa_dokumentow', "1") == "3" || $parentCount > 100;
	if (!$showAjaxrdk) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
							name="rdk_grupaDokumentow_<?php echo !is_null($resultRodzajDokumentu->getId()) ? $resultRodzajDokumentu->getId() : '' ?>" 
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
			if (is_null($limit_grupa_dokumentow) || trim($limit_grupa_dokumentow) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsGrupaDokumentow = sealock\virgoGrupaDokumentow::getVirgoList($whereList);
			while(list($id, $label)=each($resultsGrupaDokumentow)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultRodzajDokumentu->getGdkId()) && $id == $resultRodzajDokumentu->getGdkId() ? "selected='selected'" : "");
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
				$parentId = $resultRodzajDokumentu->getGdkId();
				$parentGrupaDokumentow = new sealock\virgoGrupaDokumentow();
				$parentValue = $parentGrupaDokumentow->lookup($parentId);
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
	<input type="hidden" id="rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" 
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
        $( "#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "GrupaDokumentow",
			virgo_field_name: "grupa_dokumentow",
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
					$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.value);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				  	$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#rdk_grupa_dokumentow_<?php echo $resultRodzajDokumentu->getId() ?>').val('');
				$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').removeClass("locked");		
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
$('#rdk_grupa_dokumentow_dropdown_<?php echo $resultRodzajDokumentu->getId() ?>').qtip({position: {
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
	if (isset($context["gdk"])) {
		$parentValue = $context["gdk"];
	} else {
		$parentValue = $resultRodzajDokumentu->rdk_gdk_id;
	}
	
?>
				<input type="hidden" id="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" name="rdk_grupaDokumentow_<?php echo $resultRodzajDokumentu->rdk_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultRodzajDokumentu->rdk_id])) {
		$errorMessage = $idsToCorrect[$resultRodzajDokumentu->rdk_id];
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
		<div class="<?php echo $rodzajDokumentuDisplayMode ?>">
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
	_pSF(form, 'rdk_id_<?php echo $this->getId() ?>', '<?php echo isset($resultRodzajDokumentu) ? (is_array($resultRodzajDokumentu) ? $resultRodzajDokumentu['rdk_id'] : $resultRodzajDokumentu->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_slk_rodzaj_dokumentu" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_slk_rodzaj_dokumentu').style.display='none';">
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
	$infos = virgoRodzajDokumentu::getExtraFilesInfo();
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

