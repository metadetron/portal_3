<?php
/**
* Module Pozycja dokumentu
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoProdukt'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoDokumentKsiegowy'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPozycjaDokumentu {

		 private  $pdk_id = null;
		 private  $pdk_ilosc = null;

		 private  $pdk_kwota = null;

		 private  $pdk_prd_id = null;
		 private  $pdk_dks_id = null;

		 private   $pdk_date_created = null;
		 private   $pdk_usr_created_id = null;
		 private   $pdk_date_modified = null;
		 private   $pdk_usr_modified_id = null;
		 private   $pdk_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->pdk_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoPozycjaDokumentu();
			$parentsInContext = self::getParentsInContext();
			foreach ($parentsInContext as $className => $parentInfo) {
				if (isset($parentInfo['contextId'])) {
					$setter = "set".strtoupper($parentInfo['prefix'])."Id";
					if (method_exists($ret, $setter)) {
						call_user_func_array(array($ret, $setter), array($parentInfo['contextId']));
					}					
				}
			}
			return $ret;
		}

		public function __clone() {
        	$this->pdk_id = null;
		    $this->pdk_date_created = null;
		    $this->pdk_usr_created_id = null;
		    $this->pdk_date_modified = null;
		    $this->pdk_usr_modified_id = null;
		    $this->pdk_virgo_title = null;
    	}		
		
		function log($message, $level = "INFO") {
			L($message, '', $level);
		}
		
		function logFatal($message) {
			$this->log($message, "FATAL");
		}
		
		function logError($message) {
			$this->log($message, "ERROR");
		}

		function logWarn($message) {
			$this->log($message, "WARN");
		}
		
		function logInfo($message) {
			$this->log($message, "INFO");
		}
		
		function logDebug($message) {
			$this->log($message, "DEBUG");
		}
		
		function logTrace($message) {
			$this->log($message, "TRACE");
		}
		
		function isLogOn($level) {
			return false;
		}
		
		function isFatal() {
			return $this->isLogOn("FATAL");
		}
		
		function isError() {
			return $this->isLogOn("ERROR");
		}
		
		function isWarn() {
			return $this->isLogOn("WARN");
		}
		
		function isInfo() {
			return $this->isLogOn("INFO");
		}
		
		function isDebug() {
			return $this->isLogOn("DEBUG");
		}
		
		function isTrace() {
			return $this->isLogOn("TRACE");
		}
		
		function getId() {
			return $this->pdk_id;
		}

		function getIlosc() {
			return $this->pdk_ilosc;
		}
		
		 private  function setIlosc($val) {
			$this->pdk_ilosc = $val;
		}
		function getKwota() {
			return $this->pdk_kwota;
		}
		
		 private  function setKwota($val) {
			$this->pdk_kwota = $val;
		}

		function getProduktId() {
			return $this->pdk_prd_id;
		}
		
		 private  function setProduktId($val) {
			$this->pdk_prd_id = $val;
		}
		function getDokumentKsiegowyId() {
			return $this->pdk_dks_id;
		}
		
		 private  function setDokumentKsiegowyId($val) {
			$this->pdk_dks_id = $val;
		}

		function getDateCreated() {
			return $this->pdk_date_created;
		}
		function getUsrCreatedId() {
			return $this->pdk_usr_created_id;
		}
		function getDateModified() {
			return $this->pdk_date_modified;
		}
		function getUsrModifiedId() {
			return $this->pdk_usr_modified_id;
		}


		function getPrdId() {
			return $this->getProduktId();
		}
		
		 private  function setPrdId($val) {
			$this->setProduktId($val);
		}
		function getDksId() {
			return $this->getDokumentKsiegowyId();
		}
		
		 private  function setDksId($val) {
			$this->setDokumentKsiegowyId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->pdk_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('pdk_ilosc_' . $this->pdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pdk_ilosc = null;
		} else {
			$this->pdk_ilosc = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pdk_kwota_' . $this->pdk_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->pdk_kwota = null;
		} else {
			$this->pdk_kwota = $tmpValue;
		}
	}
			$this->pdk_prd_id = strval(R('pdk_produkt_' . $this->pdk_id));
			$this->pdk_dks_id = strval(R('pdk_dokumentKsiegowy_' . $this->pdk_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('pdk_id_' . $_SESSION['current_portlet_object_id']);
			}
			if (is_null($rowId) || trim($rowId) == "") {
				$rowId = "";
			} else {
				$rowId = intval($rowId);
				$this->load((int)$rowId);
			}
			$this->loadRecordFromRequest($rowId);
		}		

		static function loadSearchFromRequest() {
			$criteriaPozycjaDokumentu = array();	
			$criteriaFieldPozycjaDokumentu = array();	
			$isNullPozycjaDokumentu = R('virgo_search_ilosc_is_null');
			
			$criteriaFieldPozycjaDokumentu["is_null"] = 0;
			if ($isNullPozycjaDokumentu == "not_null") {
				$criteriaFieldPozycjaDokumentu["is_null"] = 1;
			} elseif ($isNullPozycjaDokumentu == "null") {
				$criteriaFieldPozycjaDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_ilosc_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_ilosc_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldPozycjaDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaPozycjaDokumentu["ilosc"] = $criteriaFieldPozycjaDokumentu;
			$criteriaFieldPozycjaDokumentu = array();	
			$isNullPozycjaDokumentu = R('virgo_search_kwota_is_null');
			
			$criteriaFieldPozycjaDokumentu["is_null"] = 0;
			if ($isNullPozycjaDokumentu == "not_null") {
				$criteriaFieldPozycjaDokumentu["is_null"] = 1;
			} elseif ($isNullPozycjaDokumentu == "null") {
				$criteriaFieldPozycjaDokumentu["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_kwota_from');
		if (!is_numeric($dataTypeCriteria["from"])) {
			$dataTypeCriteria["from"] = null;
		}
		$dataTypeCriteria["to"] = R('virgo_search_kwota_to');
		if (!is_numeric($dataTypeCriteria["to"])) {
			$dataTypeCriteria["to"] = null;
		}

//			if ($isSet) {
			$criteriaFieldPozycjaDokumentu["value"] = $dataTypeCriteria;
//			}
			$criteriaPozycjaDokumentu["kwota"] = $criteriaFieldPozycjaDokumentu;
			$criteriaParent = array();	
			$isNull = R('virgo_search_produkt_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_produkt', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPozycjaDokumentu["produkt"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_dokumentKsiegowy_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_dokumentKsiegowy', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPozycjaDokumentu["dokument_ksiegowy"] = $criteriaParent;
			self::setCriteria($criteriaPozycjaDokumentu);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_ilosc');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterIlosc', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterIlosc', null);
			}
			$tableFilter = R('virgo_filter_kwota');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKwota', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKwota', null);
			}
			$parentFilter = R('virgo_filter_produkt');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterProdukt', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProdukt', null);
			}
			$parentFilter = R('virgo_filter_title_produkt');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleProdukt', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleProdukt', null);
			}
			$parentFilter = R('virgo_filter_dokument_ksiegowy');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterDokumentKsiegowy', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDokumentKsiegowy', null);
			}
			$parentFilter = R('virgo_filter_title_dokument_ksiegowy');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleDokumentKsiegowy', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleDokumentKsiegowy', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePozycjaDokumentu = ' 1 = 1 ';
			if (P('form_only') == "3") {
				$pob = self::getMyPortletObject();
				$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
				$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
				$daysInfo = $pob->getPortletSessionValue('days_info', array());
				$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
				$firstDay = $tmpDay;
				if ((int)$tmpDay["mon"] == 12) {
					$lastDay = getdate(strtotime($tmpDay["year"]+1 . "-" .  1 . "-" . (((int)$tmpDay["mday"])-1)));
				} else {
					$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
				}
				$eventColumn = "pdk_" . P('event_column');
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_produkt');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_dokumentow.pdk_prd_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_dokumentow.pdk_prd_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_dokument_ksiegowy');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_dokumentow.pdk_dks_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_dokumentow.pdk_dks_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPozycjaDokumentu = self::getCriteria();
			if (isset($criteriaPozycjaDokumentu["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaPozycjaDokumentu["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaDokumentu["kwota"])) {
				$fieldCriteriaKwota = $criteriaPozycjaDokumentu["kwota"];
				if ($fieldCriteriaKwota["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_kwota IS NOT NULL ';
				} elseif ($fieldCriteriaKwota["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_kwota IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKwota["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_kwota >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_kwota <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaDokumentu["produkt"])) {
				$parentCriteria = $criteriaPozycjaDokumentu["produkt"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pdk_prd_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_dokumentow.pdk_prd_id IN (SELECT prd_id FROM slk_produkty WHERE prd_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaDokumentu["dokument_ksiegowy"])) {
				$parentCriteria = $criteriaPozycjaDokumentu["dokument_ksiegowy"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pdk_dks_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_dokumentow.pdk_dks_id IN (SELECT dks_id FROM slk_dokumenty_ksiegowe WHERE dks_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterIlosc', null);
				if (S($tableFilter)) {
					$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_ilosc LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterKwota', null);
				if (S($tableFilter)) {
					$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_kwota LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterProdukt', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_prd_id IS NULL ";
					} else {
						$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_prd_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleProdukt', null);
				if (S($parentFilter)) {
					$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND slk_produkty_parent.prd_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterDokumentKsiegowy', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_dks_id IS NULL ";
					} else {
						$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND pdk_dks_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleDokumentKsiegowy', null);
				if (S($parentFilter)) {
					$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND slk_dokumenty_ksiegowe_parent.dks_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePozycjaDokumentu;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePozycjaDokumentu = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_pozycje_dokumentow.pdk_id, slk_pozycje_dokumentow.pdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_ilosc pdk_ilosc";
			} else {
				if ($defaultOrderColumn == "pdk_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_ilosc ";
				}
			}
			if (P('show_table_kwota', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_kwota pdk_kwota";
			} else {
				if ($defaultOrderColumn == "pdk_kwota") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_kwota ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_table_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_prd_id as pdk_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_table_dokument_ksiegowy', "1") != "0") { // */ && !in_array("dks", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_dks_id as pdk_dks_id ";
				$queryString = $queryString . ", slk_dokumenty_ksiegowe_parent.dks_virgo_title as `dokument_ksiegowy` ";
			} else {
				if ($defaultOrderColumn == "dokument_ksiegowy") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe_parent.dks_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_dokumentow ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_pozycje_dokumentow.pdk_prd_id = slk_produkty_parent.prd_id) ";
			}
			if (class_exists('sealock\virgoDokumentKsiegowy')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_dokumenty_ksiegowe AS slk_dokumenty_ksiegowe_parent ON (slk_pozycje_dokumentow.pdk_dks_id = slk_dokumenty_ksiegowe_parent.dks_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePozycjaDokumentu, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePozycjaDokumentu,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_pozycje_dokumentow"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pdk_usr_created_id = '" . virgoUser::getUserId() . "' ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
			}			
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
   				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($where != '') {
				$query = $query . " WHERE " . $where . " ";
			}
			if ($orderBy != '') {
				$query = $query . " ORDER BY  " . $orderBy . " ";
			}
			return self::internalSelect($query, null, $types, $values);
		}
		
		function select($showPage, $showRows, $orderColumn, $orderMode, $where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pdk_usr_created_id = ? ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
				$types .= "i";
				$values[] = virgoUser::getUserId();
			}			
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
   				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($queryString == '') {
				$query = "SELECT * "
				. "\n FROM slk_pozycje_dokumentow"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_pozycje_dokumentow ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_pozycje_dokumentow ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, pdk_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pdk_usr_created_id = ? ";
				if ($where == '') {
					$where = $privateCondition;
				} else {
					$where = $where . " AND " . $privateCondition;
				}
				$types .= "i";
				$values[] = virgoUser::getUserId();
			}
			if (false) { //$componentParams->get('only_records_in_valid_range') == "1") {
				$rangeCondition = "";
   				if ($rangeCondition != "") {
					if ($where == '') {
						$where = $rangeCondition;
					} else {
						$where = $where . " AND " . $rangeCondition;
					}
				}
			}			
			if ($queryString == '') {
				$query = "SELECT COUNT(pdk_id) cnt FROM pozycje_dokumentow";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as pozycje_dokumentow ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as pozycje_dokumentow ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPozycjaDokumentu();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_pozycje_dokumentow WHERE pdk_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->pdk_id = $row['pdk_id'];
$this->pdk_ilosc = $row['pdk_ilosc'];
$this->pdk_kwota = $row['pdk_kwota'];
						$this->pdk_prd_id = $row['pdk_prd_id'];
						$this->pdk_dks_id = $row['pdk_dks_id'];
						if ($fetchUsernames) {
							if ($row['pdk_date_created']) {
								if ($row['pdk_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['pdk_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['pdk_date_modified']) {
								if ($row['pdk_usr_modified_id'] == $row['pdk_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['pdk_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['pdk_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->pdk_date_created = $row['pdk_date_created'];
						$this->pdk_usr_created_id = $fetchUsernames ? $createdBy : $row['pdk_usr_created_id'];
						$this->pdk_date_modified = $row['pdk_date_modified'];
						$this->pdk_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['pdk_usr_modified_id'];
						$this->pdk_virgo_title = $row['pdk_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_pozycje_dokumentow SET pdk_usr_created_id = {$userId} WHERE pdk_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->pdk_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPozycjaDokumentu::selectAllAsObjectsStatic('pdk_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->pdk_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->pdk_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('pdk_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_pdk = new virgoPozycjaDokumentu();
				$tmp_pdk->load((int)$lookup_id);
				return $tmp_pdk->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPozycjaDokumentu');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" pdk_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPozycjaDokumentu', "10");
				if ($sizeOf > $maxListLabelSize) {
					echo json_encode(array(array("id" => '', "title" => T('RESULTS') . ": $sizeOf.")));
					return;
				}
				echo json_encode($resultsLabels);
			}
		}

		function printVirgoListMatched($match, $fieldName) {
$this->printVirgoListMatchedInternal($match, $fieldName);
		}
		
		static function getVirgoListSize($where = '') {
			return self::getVirgoList($where = '', true);
		}

		static function getVirgoList($where = '', $sizeOnly = false, $hash = false) {
			$query = " SELECT ";
			if ($sizeOnly) {
				$query = $query . " COUNT(*) AS CNT ";
			} else {
				$query = $query . " pdk_id as id, pdk_virgo_title as title ";
			}
			$query = $query . " FROM slk_pozycje_dokumentow ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPozycjaDokumentu', 'sealock') == "1") {
				$privateCondition = " pdk_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY pdk_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPozycjaDokumentu = array();
				foreach ($rows as $row) {
					$resPozycjaDokumentu[$row['id']] = $row['title'];
				}
				return $resPozycjaDokumentu;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPozycjaDokumentu = new virgoPozycjaDokumentu();
			return $staticPozycjaDokumentu->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getProduktStatic($parentId) {
			return virgoProdukt::getById($parentId);
		}
		
		function getProdukt() {
			return virgoPozycjaDokumentu::getProduktStatic($this->pdk_prd_id);
		}
		static function getDokumentKsiegowyStatic($parentId) {
			return virgoDokumentKsiegowy::getById($parentId);
		}
		
		function getDokumentKsiegowy() {
			return virgoPozycjaDokumentu::getDokumentKsiegowyStatic($this->pdk_dks_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getIlosc()) || trim($this->getIlosc()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ILOSC');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_kwota_obligatory', "0") == "1") {
				if (
(is_null($this->getKwota()) || trim($this->getKwota()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'KWOTA');
				}			
			}
				if (is_null($this->pdk_prd_id) || trim($this->pdk_prd_id) == "") {
					if (R('create_pdk_produkt_' . $this->pdk_id) == "1") { 
						$parent = new virgoProdukt();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pdk_prd_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PRODUKT', '');
					}
			}			
				if (is_null($this->pdk_dks_id) || trim($this->pdk_dks_id) == "") {
					if (R('create_pdk_dokumentKsiegowy_' . $this->pdk_id) == "1") { 
						$parent = new virgoDokumentKsiegowy();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->pdk_dks_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'DOKUMENT_KSIEGOWY', '');
					}
			}			
 			if (!is_null($this->pdk_ilosc) && trim($this->pdk_ilosc) != "") {
				if (!is_numeric($this->pdk_ilosc)) {
					return T('INCORRECT_NUMBER', 'ILOSC', $this->pdk_ilosc);
				}
			}
			if (!is_null($this->pdk_kwota) && trim($this->pdk_kwota) != "") {
				if (!is_numeric($this->pdk_kwota)) {
					return T('INCORRECT_NUMBER', 'KWOTA', $this->pdk_kwota);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			return "";
		}

				
		function beforeStore($virgoOld) {
			return "";
		}		
		
		function afterStore($virgoOld) {
			return "";
		}
		
		function beforeDelete() {
			return "";
		}

		function afterDelete() {
			return "";
		}
		
		function getCurrentRevision() {
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_pozycje_dokumentow WHERE pdk_id = " . $this->getId();
	$result = QL($query);
			return $result[0];
		}
		
		function storeRecordChange($virgoOld, $user) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$username = $user->getUsername();
			$user_id = $user->getId();
			$new_revision = $this->getCurrentRevision() + 1;
			if ($new_revision == 1 && !is_null($virgoOld)) {
				$colNames = "";
				$values = "";
				$objectToStore = $virgoOld;
				$colNames = $colNames . ", pdk_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				$colNames = $colNames . ", pdk_kwota";
				$values = $values . ", " . (is_null($objectToStore->getKwota()) ? "null" : "'" . QE($objectToStore->getKwota()) . "'");
				$colNames = $colNames . ", pdk_prd_id";
				$values = $values . ", " . (is_null($objectToStore->getPrdId()) || $objectToStore->getPrdId() == "" ? "null" : $objectToStore->getPrdId());
				$colNames = $colNames . ", pdk_dks_id";
				$values = $values . ", " . (is_null($objectToStore->getDksId()) || $objectToStore->getDksId() == "" ? "null" : $objectToStore->getDksId());
				$query = "INSERT INTO slk_history_pozycje_dokumentow (revision, ip, username, user_id, timestamp, pdk_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getIlosc() != $objectToStore->getIlosc()) {
				if (is_null($objectToStore->getIlosc())) {
					$nullifiedProperties = $nullifiedProperties . "ilosc,";
				} else {
				$colNames = $colNames . ", pdk_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getKwota() != $objectToStore->getKwota()) {
				if (is_null($objectToStore->getKwota())) {
					$nullifiedProperties = $nullifiedProperties . "kwota,";
				} else {
				$colNames = $colNames . ", pdk_kwota";
				$values = $values . ", " . (is_null($objectToStore->getKwota()) ? "null" : "'" . QE($objectToStore->getKwota()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPrdId() != $objectToStore->getPrdId() && ($virgoOld->getPrdId() != 0 || $objectToStore->getPrdId() != ""))) { 
				$colNames = $colNames . ", pdk_prd_id";
				$values = $values . ", " . (is_null($objectToStore->getPrdId()) ? "null" : ($objectToStore->getPrdId() == "" ? "0" : $objectToStore->getPrdId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getDksId() != $objectToStore->getDksId() && ($virgoOld->getDksId() != 0 || $objectToStore->getDksId() != ""))) { 
				$colNames = $colNames . ", pdk_dks_id";
				$values = $values . ", " . (is_null($objectToStore->getDksId()) ? "null" : ($objectToStore->getDksId() == "" ? "0" : $objectToStore->getDksId()));
			}
			$query = "INSERT INTO slk_history_pozycje_dokumentow (revision, ip, username, user_id, timestamp, pdk_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_pozycje_dokumentow");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'pdk_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_pozycje_dokumentow ADD COLUMN (pdk_virgo_title VARCHAR(255));";
			Q($query);
			$this->fillVirgoTitles();
		}
		
		var $_error = null;
		
		function getError() {
			return $this->_error;
		}
		
		function parentStore($updateNulls = false, $log = false) {
			$types = "";
			$values = array();
			if (isset($this->pdk_id) && $this->pdk_id != "") {
				$query = "UPDATE slk_pozycje_dokumentow SET ";
			if (isset($this->pdk_ilosc)) {
				$query .= " pdk_ilosc = ? ,";
				$types .= "d";
				$values[] = number_format($this->pdk_ilosc, 2, '.', '');
			} else {
				$query .= " pdk_ilosc = NULL ,";				
			}
			if (isset($this->pdk_kwota)) {
				$query .= " pdk_kwota = ? ,";
				$types .= "d";
				$values[] = number_format($this->pdk_kwota, 2, '.', '');
			} else {
				$query .= " pdk_kwota = NULL ,";				
			}
				if (isset($this->pdk_prd_id) && trim($this->pdk_prd_id) != "") {
					$query = $query . " pdk_prd_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pdk_prd_id;
				} else {
					$query = $query . " pdk_prd_id = NULL, ";
				}
				if (isset($this->pdk_dks_id) && trim($this->pdk_dks_id) != "") {
					$query = $query . " pdk_dks_id = ? , ";
					$types = $types . "i";
					$values[] = $this->pdk_dks_id;
				} else {
					$query = $query . " pdk_dks_id = NULL, ";
				}
				$query = $query . " pdk_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " pdk_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->pdk_date_modified;

				$query = $query . " pdk_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->pdk_usr_modified_id;

				$query = $query . " WHERE pdk_id = ? ";
				$types = $types . "i";
				$values[] = $this->pdk_id;
			} else {
				$query = "INSERT INTO slk_pozycje_dokumentow ( ";
			$query = $query . " pdk_ilosc, ";
			$query = $query . " pdk_kwota, ";
				$query = $query . " pdk_prd_id, ";
				$query = $query . " pdk_dks_id, ";
				$query = $query . " pdk_virgo_title, pdk_date_created, pdk_usr_created_id) VALUES ( ";
			if (isset($this->pdk_ilosc)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->pdk_ilosc;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pdk_kwota)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->pdk_kwota;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->pdk_prd_id) && trim($this->pdk_prd_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pdk_prd_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->pdk_dks_id) && trim($this->pdk_dks_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->pdk_dks_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->pdk_date_created;
				$values[] = $this->pdk_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->pdk_id) || $this->pdk_id == "") {
					$this->pdk_id = QID();
				}
				if ($log) {
					L("pozycja dokumentu stored successfully", "id = {$this->pdk_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->pdk_id) {
				$virgoOld = new virgoPozycjaDokumentu($this->pdk_id);
			}
			$validationMessageText = $this->beforeStore($virgoOld);
			if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
				$this->logError('Before store failed for id = ' . $this->getId() . ": " . $validationMessageText);
				return trim($validationMessageText);				
			} else {
				$validationMessageText = $this->validateObject($virgoOld);
				if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
					$this->logWarn('Validation failed for id = ' . $this->getId() . ": " . $validationMessageText);
					return trim($validationMessageText);				
				} else {
					$userId = virgoUser::getUserId();			
					if ($this->pdk_id) {			
						$this->pdk_date_modified = date("Y-m-d H:i:s");
						$this->pdk_usr_modified_id = $userId;
					} else {
						$this->pdk_date_created = date("Y-m-d H:i:s");
						$this->pdk_usr_created_id = $userId;
					}
					$this->pdk_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "pozycja dokumentu" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "pozycja dokumentu" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					$ret = $this->afterStore($virgoOld);
					if (isset($ret) && $ret != "") {
						return $ret;
					}

				}
			}
			return "";
		}

		
		static function portletActionVirgoDefault() {
			$ret = 0;
			return $ret;
		}

		function parentDelete() {
			$query = "DELETE FROM slk_pozycje_dokumentow WHERE pdk_id = {$this->pdk_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoPozycjaDokumentu();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT pdk_id as id FROM slk_pozycje_dokumentow";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'pdk_order_column')) {
				$orderBy = " ORDER BY pdk_order_column ASC ";
			} 
			if (property_exists($this, 'pdk_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY pdk_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPozycjaDokumentu();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPozycjaDokumentu($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_pozycje_dokumentow SET pdk_virgo_title = '$title' WHERE pdk_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPozycjaDokumentu();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" pdk_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['pdk_id'];
			}
			return null;
		}



		private static function setSessionValue($namespace, $name, $value) {
			$_SESSION[$namespace . "-" . $name] = $value;
		}

		private static function getSessionValue($namespace, $name, $default) {
			if (isset($_SESSION[$namespace . "-" . $name])) {
				return $_SESSION[$namespace . "-" . $name];
			}
			virgoPozycjaDokumentu::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPozycjaDokumentu::setSessionValue('Sealock_PozycjaDokumentu-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPozycjaDokumentu::getSessionValue('Sealock_PozycjaDokumentu-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPozycjaDokumentu::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPozycjaDokumentu::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPozycjaDokumentu::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPozycjaDokumentu::getSessionValue('GLOBAL', $name, $default);
		}
		
/*		static function isDebug() {
			$session = &JFactory::getSession();
			$debug = $session->get("VIRGO_DEBUG_MODE");
			return ($debug == "ON");

		} */
		
		static function getComponentByMenuId($menu, $masteritemid) {
			$masteritem = $menu->getItem($masteritemid);
			$masterComponentName = str_replace("index.php?option=", "", $masteritem->link);
			$masterComponentName = substr($masterComponentName, 8);
			return $masterComponentName;
		}
		
		static function putInContextStatic($id, $verifyToken = true, $pobId = null) {
			$context = self::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['pdk_id'] = $id;
			self::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			self::setContextId($id, $verifyToken, $pobId);
			$query = "SELECT ppr_pob_id, pdf_namespace, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = ? AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = ? ";
			$rows = QPR($query, "si", array('parent_entity_pob_id', isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
			foreach ($rows as $row) {
				$className = $row['pdf_namespace'] . '\\' . $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$className::removeFromContext($row['ppr_pob_id']);
	 				$className::setShowPage(1);
	 				$className::setDisplayMode("TABLE");
	 			}
			}
		}		
		
		function putInContext($verifyToken = true, $pobId = null) {
			self::putInContextStatic($this->getId(), $verifyToken, $pobId);
		}		

		static function removeFromContext($pobId = null) {
			$context = self::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['pdk_id'] = null;
			virgoPozycjaDokumentu::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			if (is_null($pobId)) {
				self::setContextId(null);
			} else {
				self::setRemoteContextId(null, $pobId);				
			}
			$query = "SELECT ppr_pob_id, pdf_namespace, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = ? AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = ? ";
			$rows = QPR($query, "si", array('parent_entity_pob_id', isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
			foreach ($rows as $row) {
				$className = $row['pdf_namespace'] . '\\' . $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$className::removeFromContext($row['ppr_pob_id']);
	 				$className::setShowPage(1);
	 				$className::setDisplayMode("TABLE");
	 			}
			}
		}
		
		static function portletActionRemoveFromContext() {
			$classToRemove = R('virgo_remove_class');			
			$classToRemove::removeFromContext();
			return 0;
		}

		static function setRecordSet($criteria) {
			virgoPozycjaDokumentu::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPozycjaDokumentu::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPozycjaDokumentu::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPozycjaDokumentu::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPozycjaDokumentu::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPozycjaDokumentu::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPozycjaDokumentu::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPozycjaDokumentu::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPozycjaDokumentu::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPozycjaDokumentu::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPozycjaDokumentu::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPozycjaDokumentu::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPozycjaDokumentu::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPozycjaDokumentu::setRemoteSessionValue('ContextId', $contextId, $menuItem);
		}		

		static function getCustomDisplayMode() {
			$result = null;
			return $result;
		}
		
		static function getDisplayMode() {
			$ret = self::getCustomDisplayMode();
			if (isset($ret)) {
				return $ret;
			}
			$componentParams = null; 
			if (P('form_only', "0") == "1") {
				return "CREATE";
			} elseif (P('form_only', "0") == "5" || P('form_only', "0") == "6") { 				return "FORM";
			} elseif (P('form_only', "0") == "7") {
				return "VIEW";
			} else {
				$defaultMode = "";
				if (P('form_only', "0") == 2) {
					$defaultMode = 'SEARCH';
				} else {
					$defaultMode = 'TABLE';
				}
				return virgoPozycjaDokumentu::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPozycjaDokumentu::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "pdk_id";
			}
			return virgoPozycjaDokumentu::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPozycjaDokumentu::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPozycjaDokumentu::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPozycjaDokumentu::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPozycjaDokumentu::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPozycjaDokumentu::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPozycjaDokumentu::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPozycjaDokumentu::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPozycjaDokumentu::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPozycjaDokumentu::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPozycjaDokumentu::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPozycjaDokumentu::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPozycjaDokumentu::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->pdk_id) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
				$creating = true;
			}
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
				$errorMessage = $this->store();
				if ($errorMessage == "") {
					if ($showOKMessage) {
						L(T('STORED_CORRECTLY', 'POZYCJA_DOKUMENTU'), '', 'INFO');
					}
					if ($closeForm) {
						self::setDisplayMode("TABLE");
					}
					$componentParams = null; 
					if ($creating && false) { //$componentParams->get('send_email') == "1") {
						$email = $componentParams->get('send_email_address');
						$subject = $componentParams->get('send_email_subject');
						$body = $componentParams->get('send_email_body');
						$fieldValue = $componentParams->get('send_email_field_value');
						$from	= $config->getValue('mailfrom');
						$fromname= $config->getValue('fromname');
						$fieldValues = '';						
						$fieldValues = $fieldValues . T($fieldValue, 'ilość', $this->pdk_ilosc);
						$fieldValues = $fieldValues . T($fieldValue, 'kwota', $this->pdk_kwota);
						$parentProdukt = new virgoProdukt();
						$fieldValues = $fieldValues . T($fieldValue, 'produkt', $parentProdukt->lookup($this->pdk_prd_id));
						$parentDokumentKsiegowy = new virgoDokumentKsiegowy();
						$fieldValues = $fieldValues . T($fieldValue, 'dokument ksi\u0119gowy', $parentDokumentKsiegowy->lookup($this->pdk_dks_id));
						$username = '';
						if ($this->pdk_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->pdk_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->pdk_date_created);
						$fieldValues = $fieldValues . T($fieldValue, 'Client IP', $_SERVER[REMOTE_ADDR]);
						$body = T($body, $fieldValues);
						if (!JUtility::sendMail($from, $fromname, $email, $subject, $body)) {
							L('Email not sent', '', 'ERROR');
						}
					}
					return "";
				} else {
					if ($showError) {
						L($errorMessage, '', 'ERROR');
					}
					return $errorMessage;
				}
			} else {
				if ($showOKMessage) {
					L(T('NO_PERMISSION'), '', 'ERROR');
				}
				return T('NO_PERMISSION');
			}
		}
		
		static function portletActionStore($showOKMessage = true, &$id = null) {
			$originalDisplayMode = self::getDisplayMode();
			$instance = new virgoPozycjaDokumentu();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaDokumentu'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
					$showOKMessage = false;
				}
			}
			$errorMessage = $instance->internalActionStore(R('keep_form_open', "false") != "true", $showOKMessage);
			if ($errorMessage == "" && !isset($oldId)) {
				$instance->putInContext(isset($oldId));
				$masterEntityPobId = P('master_entity_pob_id', '');
				if ($masterEntityPobId != "") {
					$instance->putInContext(false, $masterEntityPobId);
				}
			}
			$currentItem = null; //$menu->getActive();
			$ret = null;
			$componentParams = null;
			if ($errorMessage == "") { 				$ret = 0;
				if (isset($id)) {
					$id = $instance->getId();
				}
			} else {
				$ret = -1;
			}
			if ($ret == -1) {
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			}
			return $ret;
		}
		
		static function portletActionStoreAndClear() {
			$originalDisplayMode = $this->getDisplayMode();
			$ret = $this->portletActionStore(true);
			if ($ret == 0) {
				self::removeFromContext();
				self::setDisplayMode($originalDisplayMode);
			}
			return $ret;
		}
		
		
		static function portletActionApply() {
			$instance = new virgoPozycjaDokumentu();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			$errorMessage = $instance->internalActionStore(false);
			if ($errorMessage == "") {
				$instance->putInContext(isset($oldId));
			}
			if ($errorMessage == "" && is_null($oldId)) {
				self::setDisplayMode("FORM");
			}
			if ($errorMessage == "") {
				return 0;
			} else {
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
				return -1;
			}
		}

		static function portletActionSelect($verifyToken = true, $pobId = null) {
			$tmpId = intval(R('pdk_id_' . $_SESSION['current_portlet_object_id']));
			$oldContextId = self::getContextId();
			if (isset($oldContextId) && $oldContextId == $tmpId) {
				self::removeFromContext();
			} else {
				self::putInContextStatic($tmpId, $verifyToken, $pobId);
			}
			return 0;
		}
		

		static function portletActionSelectAndSetParent() {
			$parentPobId = R('parent_pob_id');
			$parentPortletObject = new virgoPortletObject($parentPobId);
			$className = $parentPortletObject->getPortletDefinition()->getAlias();
			if (!class_exists($className)) {
				require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getNamespace().DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getAlias().DIRECTORY_SEPARATOR.'controller.php');
			}
			$class = new $className();
			$class->portletActionSelect(false, $parentPobId);
			return self::portletActionSelect(false);
		}
		
		static function portletActionSelectJson() {
			self::portletActionSelect(false);
			return virgoPozycjaDokumentu::getContextId();
		}
		
		static function portletActionView() {
			self::putInContextStatic(self::loadIdFromRequest());
			self::setDisplayMode("VIEW");
			return 0;
		}
		
		static function portletActionClearView() {
			$this->setCriteria(array());
			return $this->portletActionView();
		}
		

		static function portletActionClose() {
			self::setDisplayMode("TABLE");
			return 0;
		}
		
		static function portletActionForm() {
			$tmpId = self::loadIdFromRequest();
			self::putInContextStatic($tmpId);
			if ($tmpId) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
			}
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
			self::setDisplayMode("FORM");
			}
			return 0;
		}
		
		static function portletActionDuplicate() {
			self::putInContextStatic(self::loadIdFromRequest());
			$this->pdk_id = null;
			$this->pdk_date_created = null;
			$this->pdk_usr_created_id = null;
			$this->pdk_date_modified = null;
			$this->pdk_usr_modified_id = null;
			$this->pdk_virgo_title = null;
			
			self::setDisplayMode("CREATE");
			return 0;
		}
		
		static function portletActionShowHistory() {
			self::putInContextStatic(self::loadIdFromRequest());
			self::setDisplayMode("SHOW_HISTORY");
			return 0;
		}
		
		static function portletActionShowRevision() {
			self::setDisplayMode("SHOW_REVISION");
			return 0;
		}
		
		static function portletActionCustomMode() {
			$customMode = R('componentName');
			if (!is_null($customMode) && trim($customMode) != "") {			
				self::putInContextStatic(self::loadIdFromRequest());
				self::setDisplayMode($customMode);
			}
			return 0;
		}

		static function portletActionShowForProdukt() {
			$parentId = R('prd_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoProdukt($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForDokumentKsiegowy() {
			$parentId = R('dks_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoDokumentKsiegowy($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}


		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoPozycjaDokumentu();
//			return $ret;
			}
			return 0;
		}

		static function portletActionSearchForm() {
			self::setDisplayMode("SEARCH"); 
			self::setShowPage(1);
			return 0;
		}

		static function portletActionSearch() {
			self::loadSearchFromRequest();
			if (P('filter_mode', '0') == '0') {
				self::setDisplayMode("TABLE");
			}
			return 0;
		}
		
		static function portletActionClear() {
			$this->setCriteria(array());
			// self::setDisplayMode("TABLE");
			return 0;
		}

		static function portletActionRemoveCriterium() { 
			$column = R('virgo_filter_column');
			$criteria = self::getCriteria();
			unset($criteria[$column]);
			self::setCriteria($criteria);
			self::setDisplayMode("TABLE");
			return 0;
		}
		
		static function portletActionDelete() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("delete")) {
				$instance = new virgoPozycjaDokumentu();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPozycjaDokumentu::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'POZYCJA_DOKUMENTU'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		
		
		static function portletActionEditSelected() {
			$idsToDeleteString = R('ids');
			$idsToDeleteString = $idsToDeleteString . ",0";
			$this->setRecordSet($idsToDeleteString);
			$this->setInvalidRecords(array());
			self::setDisplayMode("TABLE_FORM");
			return 0;
		}		
		
		function getRecordsToEdit() {
			$idsToEditString = $this->getRecordSet();
			$idsToEdit = preg_split("/,/", $idsToEditString);
			$idsToCorrect = $this->getInvalidRecords();
			$results = array();
			foreach ($idsToEdit as $idToEdit) {
				$resultPozycjaDokumentu = new virgoPozycjaDokumentu();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPozycjaDokumentu->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPozycjaDokumentu->load($idToEditInt);
					} else {
						$resultPozycjaDokumentu->pdk_id = 0;
					}
				}
				$results[] = $resultPozycjaDokumentu;
			}
			return $results;
		}
		
		static function portletActionStoreSelected() {
			$validateNew = R('virgo_validate_new'); 
			$idsToStoreString = $this->getRecordSet();
			$idsToStore = preg_split("/,/", $idsToStoreString);
			$results = array();
			$errors = 0;
			$idsToCorrect = array();
			foreach ($idsToStore as $idToStore) {
				$result = new virgoPozycjaDokumentu();
				$result->loadFromRequest($idToStore);
				if ($result->pdk_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->pdk_id == 0) {
						$result->pdk_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->pdk_id)) {
							$result->pdk_id = 0;
						}
						$idsToCorrect[$result->pdk_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'POZYCJE_DOKUMENTOW'), '', 'INFO');
				}
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				L(T('INVALID_RECORDS', $errors), '', 'ERROR');
				$this->setInvalidRecords($idsToCorrect);
				return -1;
			}
		}

		static function multipleDelete($idsToDelete) {
			$errorOcurred = 0;
			$resultPozycjaDokumentu = new virgoPozycjaDokumentu();
			foreach ($idsToDelete as $idToDelete) {
				$resultPozycjaDokumentu->load((int)trim($idToDelete));
				$res = $resultPozycjaDokumentu->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'POZYCJE_DOKUMENTOW'), '', 'INFO');			
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				return -1;
			}
		}

		static function getSelectedIds($name = 'ids') {
			$idsString = R($name);
			if (trim($idsString) == "") {
				return array();
			}
			return preg_split("/,/", $idsString);			
		}
		
		static function portletActionDeleteSelected() {
			$idsToDelete = self::getSelectedIds();
			return self::multipleDelete($idsToDelete);
		}

		static function portletActionChangeOrder() {
			$column = R('virgo_order_column');
			$mode = R('virgo_order_mode');
			self::setOrderColumn($column);
			self::setOrderMode($mode);
			return 0;
		}
		
		static function portletActionChangePaging() {
			$showPage = R('virgo_show_page');
			if(preg_match('/^\d+$/',$showPage)) {
				if ((int)$showPage > 0) {
					self::setShowPage($showPage);
				}
			}			
			$showRows = R('virgo_show_rows');
			self::setShowRows($showRows);
			return 0;
		}
				
		function getVirgoTitleNull() {
		$ret = $this->pdk_ilosc;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPozycjaDokumentu');
			if (!is_null($paramTitleSource) && trim($paramTitleSource) != "") {
				$paramTitleSource = '$ret = ' . $paramTitleSource;
				eval($paramTitleSource);
				return $ret;
			} else {
				$ret = $this->getVirgoTitleNull();
				if (is_null($ret)) return "";
				return $ret;
			}
		}
		
		function formatMessage($message, $args) {
			$index = 1;
			foreach ($args as &$value) {
				$message = str_replace("$" . $index, $value, $message);
				$index = $index + 1;
			}
			unset($value);
			return $message;
		}
		
		static function getExtraFilesInfo() {
			$ret = array();
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE slk_pozycje_dokumentow SET pdk_virgo_title = ? WHERE pdk_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT pdk_id AS id FROM slk_pozycje_dokumentow ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPozycjaDokumentu($row['id']);
				$tmp->updateTitle();
			}
			L("Title updated", '', 'INFO');
			return 0;
		}
		

		function hideContentDueToNoParentSelected() {			
			$whenNoParentSelected = P("when_no_parent_selected", "E");
			if ($whenNoParentSelected == "H") {
				$parentPobIds = PN('parent_entity_pob_id');
				foreach ($parentPobIds as $parentPobId) {
					$portletObject = new virgoPortletObject($parentPobId);
					$className = $portletObject->getPortletDefinition()->getNamespace()."\\".$portletObject->getPortletDefinition()->getAlias();
					$tmpContextId = $className::getRemoteContextId($parentPobId);
					if (isset($tmpContextId)) {
						return false;
					}
				}
;				return true;
			} else {
				return false;
			}
		}

		static function getParentsInContext() {
			if (!isset($_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']])) {
				$ret = array();
				$parentPobIds = PN('parent_entity_pob_id');
				$class2prefix = array();
				$class2prefix["sealock\\virgoProdukt"] = "prd";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoTowar"] = "twr";
				$class2parentPrefix["sealock\\virgoProdukt"] = $class2prefix2;
				$class2prefix["sealock\\virgoDokumentKsiegowy"] = "dks";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoRodzajDokumentu"] = "rdk";
				$class2parentPrefix["sealock\\virgoDokumentKsiegowy"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_pozycje_dokumentow.pdk_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_pozycje_dokumentow.pdk_' . $parentInfo['prefix'] . '_id IS NULL';
						} elseif ($whenNoParentSelected == "A") {
							$parentInfo['condition'] = ' 1 ';
						} elseif ($whenNoParentSelected == "G") {
							$grandparentPobIds = PN('grandparent_entity_pob_id');
							foreach ($grandparentPobIds as $grandparentPobId) {
								$class2parent2 = $class2parentPrefix[$parentInfo['className']];
								$grandparentInfo = self::getEntityInfoByPobId($grandparentPobId, $class2parent2);
								if (isset($class2prefix2[$grandparentInfo['className']])) {
									if (isset($grandparentInfo['value'])) {
										$parentClassName = $parentInfo['className'];
										$tmp = new $parentClassName();
										$grandparentInfo['condition'] = 'slk_pozycje_dokumentow.pdk_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_pozycje_dokumentow.pdk_' . $parentInfo['prefix'] . '_id IS NULL';
							}
						} else {
							if ($whenNoParentSelected != "H") {
								L(T('PLEASE_SELECT_PARENT'), '', 'INFO');
							}
							$parentInfo['condition'] = ' 0 ';
						}
					}
					if (!$grandparentAdded) {
						$ret[$parentInfo['className']] = $parentInfo;
					}
				}
				$_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']] = $ret;
			} else {
				$ret = $_REQUEST['_virgo_parents_in_context_' . $_SESSION['current_portlet_object_id']];
			}
			return $ret;
		}
		
				static function getEntityInfoByPobId($parentPobId, $class2prefix) {
			$ret = array();
			$portletObject = new virgoPortletObject($parentPobId);
			$ret['name'] = $portletObject->getPortletDefinition()->getName();
			$className = $portletObject->getPortletDefinition()->getNamespace().'\\'.$portletObject->getPortletDefinition()->getAlias();
			if (!isset($class2prefix[$className])) {
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPozycjaDokumentu!', '', 'ERROR');
				return array();
			}
			$ret['prefix'] = $class2prefix[$className];
			$ret['className'] = $className;
			$tmpContextId = $className::getRemoteContextId($parentPobId);
			$ret['contextId'] = $tmpContextId;
			if (isset($tmpContextId) && $tmpContextId != "") {
				$ret['value'] =  "" . $className::lookup($tmpContextId);
			}
			return $ret;
		}

		static function portletActionReport() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
			ini_set('display_errors', '0');
			$pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$user = virgoUser::getUser();
			$pdf->SetCreator(null);
			$pdf->SetTitle('Pozycje dokumentów report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('POZYCJE_DOKUMENTOW');
			}
			$pdf->setHeaderData('', 0, $reportTitle, date ("Y.m.d H:i:s"));

			$font = P('pdf_font_name', 'freeserif');
			$includeBold = P('pdf_include_bold_font', '0');
			$fontBoldVariant = ($includeBold == "0" || is_null($includeBold) || trim($includeBold) == "") ? '' : 'B';

			$pdf->setHeaderFont(array($font, '', 10));
			$pdf->setFooterFont(array($font, '', 8));

			$fontSize = (float)P('pdf_font_size', '10');
			$pdf->SetFont($font, '', $fontSize);
			$columnsNumber = 0;	
			if (P('show_pdf_ilosc', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_kwota', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_produkt', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_dokument_ksiegowy', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPozycjaDokumentu = new virgoPozycjaDokumentu();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_ilosc', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Ilość');
				$minWidth['ilo\u015B\u0107'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
						$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_kwota', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Kwota');
				$minWidth['kwota'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['kwota']) {
						$minWidth['kwota'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_produkt', "1") == "1") {
				$minWidth['produkt $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'produkt $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['produkt $relation.name']) {
						$minWidth['produkt $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_dokument_ksiegowy', "1") == "1") {
				$minWidth['dokument ksi\u0119gowy $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'dokument ksi\u0119gowy $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['dokument ksi\u0119gowy $relation.name']) {
						$minWidth['dokument ksi\u0119gowy $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClausePozycjaDokumentu = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPozycjaDokumentu = $resultPozycjaDokumentu->getCriteria();
			$fieldCriteriaIlosc = $criteriaPozycjaDokumentu["ilosc"];
			if ($fieldCriteriaIlosc["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Ilość', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
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
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Ilość', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaKwota = $criteriaPozycjaDokumentu["kwota"];
			if ($fieldCriteriaKwota["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Kwota', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKwota["value"];
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
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Kwota', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPozycjaDokumentu["produkt"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoProdukt::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Produkt', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPozycjaDokumentu["dokument_ksiegowy"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Dokument księgowy', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoDokumentKsiegowy::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Dokument księgowy', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_produkt');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_dokumentow.pdk_prd_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_dokumentow.pdk_prd_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_dokument_ksiegowy');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_pozycje_dokumentow.pdk_dks_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_pozycje_dokumentow.pdk_dks_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPozycjaDokumentu = self::getCriteria();
			if (isset($criteriaPozycjaDokumentu["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaPozycjaDokumentu["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaDokumentu["kwota"])) {
				$fieldCriteriaKwota = $criteriaPozycjaDokumentu["kwota"];
				if ($fieldCriteriaKwota["is_null"] == 1) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_kwota IS NOT NULL ';
				} elseif ($fieldCriteriaKwota["is_null"] == 2) {
$filter = $filter . ' AND slk_pozycje_dokumentow.pdk_kwota IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKwota["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_kwota >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_pozycje_dokumentow.pdk_kwota <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaPozycjaDokumentu["produkt"])) {
				$parentCriteria = $criteriaPozycjaDokumentu["produkt"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pdk_prd_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_dokumentow.pdk_prd_id IN (SELECT prd_id FROM slk_produkty WHERE prd_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPozycjaDokumentu["dokument_ksiegowy"])) {
				$parentCriteria = $criteriaPozycjaDokumentu["dokument_ksiegowy"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND pdk_dks_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_pozycje_dokumentow.pdk_dks_id IN (SELECT dks_id FROM slk_dokumenty_ksiegowe WHERE dks_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_pozycje_dokumentow.pdk_id, slk_pozycje_dokumentow.pdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_ilosc pdk_ilosc";
			} else {
				if ($defaultOrderColumn == "pdk_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_ilosc ";
				}
			}
			if (P('show_pdf_kwota', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_kwota pdk_kwota";
			} else {
				if ($defaultOrderColumn == "pdk_kwota") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_kwota ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_pdf_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_prd_id as pdk_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_pdf_dokument_ksiegowy', "1") != "0") { // */ && !in_array("dks", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_dks_id as pdk_dks_id ";
				$queryString = $queryString . ", slk_dokumenty_ksiegowe_parent.dks_virgo_title as `dokument_ksiegowy` ";
			} else {
				if ($defaultOrderColumn == "dokument_ksiegowy") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe_parent.dks_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_dokumentow ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_pozycje_dokumentow.pdk_prd_id = slk_produkty_parent.prd_id) ";
			}
			if (class_exists('sealock\virgoDokumentKsiegowy')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_dokumenty_ksiegowe AS slk_dokumenty_ksiegowe_parent ON (slk_pozycje_dokumentow.pdk_dks_id = slk_dokumenty_ksiegowe_parent.dks_id) ";
			}

		$resultsPozycjaDokumentu = $resultPozycjaDokumentu->select(
			'', 
			'all', 
			$resultPozycjaDokumentu->getOrderColumn(), 
			$resultPozycjaDokumentu->getOrderMode(), 
			$whereClausePozycjaDokumentu,
			$queryString);
		
		foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {

			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPozycjaDokumentu['pdk_ilosc'])) + 6;
				if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
					$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_kwota', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPozycjaDokumentu['pdk_kwota'])) + 6;
				if ($tmpLen > $minWidth['kwota']) {
					$minWidth['kwota'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_produkt', "1") == "1") {
			$parentValue = trim(virgoProdukt::lookup($resultPozycjaDokumentu['pdkprd__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['produkt $relation.name']) {
					$minWidth['produkt $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_dokument_ksiegowy', "1") == "1") {
			$parentValue = trim(virgoDokumentKsiegowy::lookup($resultPozycjaDokumentu['pdkdks__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['dokument ksi\u0119gowy $relation.name']) {
					$minWidth['dokument ksi\u0119gowy $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPozycjaDokumentu = $resultPozycjaDokumentu->getCriteria();
		if (is_null($criteriaPozycjaDokumentu) || sizeof($criteriaPozycjaDokumentu) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																										if (P('show_pdf_ilosc', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, T('ILOSC'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_kwota', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['kwota'], $colHeight, T('KWOTA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_produkt', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['produkt $relation.name'], $colHeight, T('PRODUKT') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_dokument_ksiegowy', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['dokument ksi\u0119gowy $relation.name'], $colHeight, T('DOKUMENT_KSIEGOWY') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}

		for ($iTmp = 0; $iTmp < $maxLn; $iTmp++) {
			$dummyText .= " 
";
		}
		$pdf->MultiCell(4, $colHeight, $dummyText, '0', 'L', 0, 1); 
		$pdf->SetFont($font, '', $fontSize);
		$counts = array();
		$sums = array();
		$avgCounts = array();
		$avgSums = array();
		$pdf->SetDrawColor(200);
		foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, '' . number_format($resultPozycjaDokumentu['pdk_ilosc'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_ilosc', "1") == "2") {
										if (!is_null($resultPozycjaDokumentu['pdk_ilosc'])) {
						$tmpCount = (float)$counts["ilosc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["ilosc"] = $tmpCount;
					}
				}
				if (P('show_pdf_ilosc', "1") == "3") {
										if (!is_null($resultPozycjaDokumentu['pdk_ilosc'])) {
						$tmpSum = (float)$sums["ilosc"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaDokumentu['pdk_ilosc'];
						}
						$sums["ilosc"] = $tmpSum;
					}
				}
				if (P('show_pdf_ilosc', "1") == "4") {
										if (!is_null($resultPozycjaDokumentu['pdk_ilosc'])) {
						$tmpCount = (float)$avgCounts["ilosc"];
						$tmpSum = (float)$avgSums["ilosc"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["ilosc"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaDokumentu['pdk_ilosc'];
						}
						$avgSums["ilosc"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_kwota', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['kwota'], $colHeight, '' . number_format($resultPozycjaDokumentu['pdk_kwota'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_kwota', "1") == "2") {
										if (!is_null($resultPozycjaDokumentu['pdk_kwota'])) {
						$tmpCount = (float)$counts["kwota"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["kwota"] = $tmpCount;
					}
				}
				if (P('show_pdf_kwota', "1") == "3") {
										if (!is_null($resultPozycjaDokumentu['pdk_kwota'])) {
						$tmpSum = (float)$sums["kwota"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaDokumentu['pdk_kwota'];
						}
						$sums["kwota"] = $tmpSum;
					}
				}
				if (P('show_pdf_kwota', "1") == "4") {
										if (!is_null($resultPozycjaDokumentu['pdk_kwota'])) {
						$tmpCount = (float)$avgCounts["kwota"];
						$tmpSum = (float)$avgSums["kwota"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["kwota"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPozycjaDokumentu['pdk_kwota'];
						}
						$avgSums["kwota"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_produkt', "1") == "1") {
			$parentValue = virgoProdukt::lookup($resultPozycjaDokumentu['pdk_prd_id']);
			$tmpLn = $pdf->MultiCell($minWidth['produkt $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_dokument_ksiegowy', "1") == "1") {
			$parentValue = virgoDokumentKsiegowy::lookup($resultPozycjaDokumentu['pdk_dks_id']);
			$tmpLn = $pdf->MultiCell($minWidth['dokument ksi\u0119gowy $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			$dummyText = "";
			for ($iTmp = 0; $iTmp < $maxLn; $iTmp++) {
				$dummyText .= " 
";
			}
			$pdf->MultiCell(4, $colHeight, $dummyText, '0', 'L', 0, 1); 
//			$pdf->Cell(1, $colHeight, '', 0, 0); //, 0, 1);
//			$pdf->ln(50); //$maxLn * ($fontSize - 1) / 2);
		}
		if (sizeof($counts) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["ilosc"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_kwota', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kwota'];
				if (P('show_pdf_kwota', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["kwota"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
		}
		$pdf->Ln();
		if (sizeof($sums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["ilosc"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_kwota', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kwota'];
				if (P('show_pdf_kwota', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["kwota"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
		}
		$pdf->Ln();
		if (sizeof($avgCounts) > 0 && sizeof($avgSums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
			if (P('show_pdf_ilosc', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['ilo\u015B\u0107'];
				if (P('show_pdf_ilosc', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["ilosc"] == 0 ? "-" : $avgSums["ilosc"] / $avgCounts["ilosc"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_kwota', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kwota'];
				if (P('show_pdf_kwota', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["kwota"] == 0 ? "-" : $avgSums["kwota"] / $avgCounts["kwota"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
		}
		$pdf->Ln();
		$pdf->SetFont($font, '', $fontSize);
		$pdf->Output($reportTitle. '_' . date ("Ymd_His") . '.pdf', 'I'); 		ini_set('display_errors', '1');
		return 0;
			}
		
		static function portletActionExport() {
			$data = "";
			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('POZYCJE_DOKUMENTOW');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPozycjaDokumentu = new virgoPozycjaDokumentu();
			$whereClausePozycjaDokumentu = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_ilosc', "1") != "0") {
					$data = $data . $stringDelimeter .'Ilość' . $stringDelimeter . $separator;
				}
				if (P('show_export_kwota', "1") != "0") {
					$data = $data . $stringDelimeter .'Kwota' . $stringDelimeter . $separator;
				}
				if (P('show_export_produkt', "1") != "0") {
					$data = $data . $stringDelimeter . 'Produkt ' . $stringDelimeter . $separator;
				}
				if (P('show_export_dokument_ksiegowy', "1") != "0") {
					$data = $data . $stringDelimeter . 'Dokument księgowy ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_pozycje_dokumentow.pdk_id, slk_pozycje_dokumentow.pdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_ilosc pdk_ilosc";
			} else {
				if ($defaultOrderColumn == "pdk_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_ilosc ";
				}
			}
			if (P('show_export_kwota', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_kwota pdk_kwota";
			} else {
				if ($defaultOrderColumn == "pdk_kwota") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_kwota ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_export_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_prd_id as pdk_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_export_dokument_ksiegowy', "1") != "0") { // */ && !in_array("dks", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_dks_id as pdk_dks_id ";
				$queryString = $queryString . ", slk_dokumenty_ksiegowe_parent.dks_virgo_title as `dokument_ksiegowy` ";
			} else {
				if ($defaultOrderColumn == "dokument_ksiegowy") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe_parent.dks_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_dokumentow ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_pozycje_dokumentow.pdk_prd_id = slk_produkty_parent.prd_id) ";
			}
			if (class_exists('sealock\virgoDokumentKsiegowy')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_dokumenty_ksiegowe AS slk_dokumenty_ksiegowe_parent ON (slk_pozycje_dokumentow.pdk_dks_id = slk_dokumenty_ksiegowe_parent.dks_id) ";
			}

			$resultsPozycjaDokumentu = $resultPozycjaDokumentu->select(
				'', 
				'all', 
				$resultPozycjaDokumentu->getOrderColumn(), 
				$resultPozycjaDokumentu->getOrderMode(), 
				$whereClausePozycjaDokumentu,
				$queryString);
			foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {
				if (P('show_export_ilosc', "1") != "0") {
			$data = $data . $resultPozycjaDokumentu['pdk_ilosc'] . $separator;
				}
				if (P('show_export_kwota', "1") != "0") {
			$data = $data . $resultPozycjaDokumentu['pdk_kwota'] . $separator;
				}
				if (P('show_export_produkt', "1") != "0") {
					$parentValue = virgoProdukt::lookup($resultPozycjaDokumentu['pdk_prd_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_dokument_ksiegowy', "1") != "0") {
					$parentValue = virgoDokumentKsiegowy::lookup($resultPozycjaDokumentu['pdk_dks_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				$data = $data . "\n"; 
			}
			D($data, $reportTitle, "text/csv"); 
		}
				
		static function portletActionOffline() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel.php');		
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Writer'.DIRECTORY_SEPARATOR.'Excel2007.php');		
			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('POZYCJE_DOKUMENTOW');
			}
			$objPHPExcel = new \PHPExcel();
			$objPHPExcel->getProperties()->setCreator("virgo by METADETRON");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			$objPHPExcel->getProperties()->setTitle($reportTitle);
			$objPHPExcel->getProperties()->setSubject("");
			$objPHPExcel->getProperties()->setDescription("virgo generated Excel Sheet for offline data edition");
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getProtection()->setPassword('virgo');
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()->setTitle($reportTitle);
			$resultPozycjaDokumentu = new virgoPozycjaDokumentu();
			$whereClausePozycjaDokumentu = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePozycjaDokumentu = $whereClausePozycjaDokumentu . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Ilość');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_kwota', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Kwota');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Produkt ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoProdukt::getVirgoList();
					$formulaProdukt = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaProdukt != "") {
							$formulaProdukt = $formulaProdukt . ',';
						}
						$formulaProdukt = $formulaProdukt . $key;
					}
				}
				if (P('show_export_dokument_ksiegowy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Dokument księgowy ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoDokumentKsiegowy::getVirgoList();
					$formulaDokumentKsiegowy = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaDokumentKsiegowy != "") {
							$formulaDokumentKsiegowy = $formulaDokumentKsiegowy . ',';
						}
						$formulaDokumentKsiegowy = $formulaDokumentKsiegowy . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_pozycje_dokumentow.pdk_id, slk_pozycje_dokumentow.pdk_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_ilosc pdk_ilosc";
			} else {
				if ($defaultOrderColumn == "pdk_ilosc") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_ilosc ";
				}
			}
			if (P('show_export_kwota', "1") != "0") {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_kwota pdk_kwota";
			} else {
				if ($defaultOrderColumn == "pdk_kwota") {
					$orderColumnNotDisplayed = " slk_pozycje_dokumentow.pdk_kwota ";
				}
			}
			if (class_exists('sealock\virgoProdukt') && P('show_export_produkt', "1") != "0") { // */ && !in_array("prd", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_prd_id as pdk_prd_id ";
				$queryString = $queryString . ", slk_produkty_parent.prd_virgo_title as `produkt` ";
			} else {
				if ($defaultOrderColumn == "produkt") {
					$orderColumnNotDisplayed = " slk_produkty_parent.prd_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoDokumentKsiegowy') && P('show_export_dokument_ksiegowy', "1") != "0") { // */ && !in_array("dks", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_pozycje_dokumentow.pdk_dks_id as pdk_dks_id ";
				$queryString = $queryString . ", slk_dokumenty_ksiegowe_parent.dks_virgo_title as `dokument_ksiegowy` ";
			} else {
				if ($defaultOrderColumn == "dokument_ksiegowy") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe_parent.dks_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_pozycje_dokumentow ";
			if (class_exists('sealock\virgoProdukt')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_produkty AS slk_produkty_parent ON (slk_pozycje_dokumentow.pdk_prd_id = slk_produkty_parent.prd_id) ";
			}
			if (class_exists('sealock\virgoDokumentKsiegowy')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_dokumenty_ksiegowe AS slk_dokumenty_ksiegowe_parent ON (slk_pozycje_dokumentow.pdk_dks_id = slk_dokumenty_ksiegowe_parent.dks_id) ";
			}

			$resultsPozycjaDokumentu = $resultPozycjaDokumentu->select(
				'', 
				'all', 
				$resultPozycjaDokumentu->getOrderColumn(), 
				$resultPozycjaDokumentu->getOrderMode(), 
				$whereClausePozycjaDokumentu,
				$queryString);
			$index = 1;
			foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPozycjaDokumentu['pdk_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPozycjaDokumentu['pdk_ilosc'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_kwota', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPozycjaDokumentu['pdk_kwota'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_produkt', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoProdukt::lookup($resultPozycjaDokumentu['pdk_prd_id']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, $index, $parentValue);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
					$objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->getDataValidation();
					$objValidation->setType( \PHPExcel_Cell_DataValidation::TYPE_LIST );
					$objValidation->setErrorStyle( \PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
					$objValidation->setAllowBlank(false);
					$objValidation->setShowInputMessage(true);
					$objValidation->setShowErrorMessage(true);
					$objValidation->setShowDropDown(true);
					$objValidation->setErrorTitle('Input error');
					$objValidation->setError('Value is not in list.');
					$objValidation->setPromptTitle('Pick from list');
					$objValidation->setPrompt('Please pick a value from the drop-down list.');
					$objValidation->setFormula1('"' . $formulaProdukt . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_dokument_ksiegowy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoDokumentKsiegowy::lookup($resultPozycjaDokumentu['pdk_dks_id']);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, $index, $parentValue);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
					$objValidation = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->getDataValidation();
					$objValidation->setType( \PHPExcel_Cell_DataValidation::TYPE_LIST );
					$objValidation->setErrorStyle( \PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
					$objValidation->setAllowBlank(false);
					$objValidation->setShowInputMessage(true);
					$objValidation->setShowErrorMessage(true);
					$objValidation->setShowDropDown(true);
					$objValidation->setErrorTitle('Input error');
					$objValidation->setError('Value is not in list.');
					$objValidation->setPromptTitle('Pick from list');
					$objValidation->setPrompt('Please pick a value from the drop-down list.');
					$objValidation->setFormula1('"' . $formulaDokumentKsiegowy . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
			}
		    for($i = 1; $i <= $iloscKolumn; $i++) {
		        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		    }
		    $objPHPExcel->getActiveSheet()->calculateColumnWidths();
			$objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
			
			header('Content-Type: application/vnd.ms-excel');
			if (headers_sent()) {
				echo 'Some data has already been output to browser';
			}
			header('Content-Disposition: attachment; filename="' . $reportTitle . '.xlsx";');
//			header('Content-Length: '.strlen($data));		
			$objWriter->save("php://output");			
			exit();
		}		
		
		static function portletActionUpload() {
			$userfile = $_FILES['virgo_upload_file'];
			if ( $userfile['error'] || $userfile['size'] < 1 ) {
				L("$messages.FILE_NOT_UPLOADED", '', 'ERROR');		 
			} else {
// PATH_TXTUPL is not reliable? Lets use $config->getValue('tmp_path') instead
//				$componentParams = null;
//				$separatorString = $componentParams->get('field_separator_in_import');
				$separatorString = P('field_separator');
				if (is_null($separatorString) || $separatorString == "") {
					$separatorString = ",";
				} elseif ($separatorString == "TAB") {
					$separatorString = "\t";
				}
				$this->setImportFieldSeparator($separatorString);
				$tmp_dest = PORTAL_PATH.DIRECTORY_SEPARATOR."tmp".DIRECTORY_SEPARATOR.'tmp_upload_'.date("YmdHis").'.txt';
				$tmp_src   = $userfile['tmp_name'];
//				$user =& JFactory::getUser();
				if ( move_uploaded_file($tmp_src, $tmp_dest ) ) {
					$fh = fopen($tmp_dest, 'r');
					$firstLine = fgets($fh);
					$columns = split($separatorString, $firstLine);
					$propertyColumnHash = array();
					$propertyDateFormatHash = array();
					$propertyClassHash = array();
					$propertyColumnHash['ilo\u015B\u0107'] = 'pdk_ilosc';
					$propertyColumnHash['ilosc'] = 'pdk_ilosc';
					$propertyColumnHash['kwota'] = 'pdk_kwota';
					$propertyColumnHash['kwota'] = 'pdk_kwota';
					$propertyClassHash['produkt'] = 'Produkt';
					$propertyClassHash['produkt'] = 'Produkt';
					$propertyColumnHash['produkt'] = 'pdk_prd_id';
					$propertyColumnHash['produkt'] = 'pdk_prd_id';
					$propertyClassHash['dokument ksi\u0119gowy'] = 'DokumentKsiegowy';
					$propertyClassHash['dokument_ksiegowy'] = 'DokumentKsiegowy';
					$propertyColumnHash['dokument ksi\u0119gowy'] = 'pdk_dks_id';
					$propertyColumnHash['dokument_ksiegowy'] = 'pdk_dks_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPozycjaDokumentu = new virgoPozycjaDokumentu();
						$line = fgets($fh);
						if (is_null($line) || trim($line) == "") {
						} else {
							$values = split($separatorString, $line);
							$index = 0;
							foreach ($values as $value) {
								$value = trim($value);
								if (isset($columns[$index]) && trim($columns[$index]) != "VIRGO_IGNORE") {
									$fieldName = $propertyColumnHash[trim($columns[$index])];
									if (substr($fieldName, strlen($fieldName) - 3) == "_id") {
										$className = 'virgo' . $propertyClassHash[trim($columns[$index])];
										$parent = new $className();
										$value = $parent->getIdByVirgoTitle($value);
									}
									if (is_null($fieldName)) {
										L(T('PROPERTY_NOT_FOUND', T('POZYCJA_DOKUMENTU'), $columns[$index]), '', 'ERROR');
										return;
									} else {
										if (isset($propertyDateFormatHash[$fieldName])) {
											$dateFormat = $propertyDateFormatHash[$fieldName];
											if (version_compare(PHP_VERSION, '5.3.0') >= 0) {												
												$dateInfo = date_parse_from_format($dateFormat, $value);
												$value = $dateInfo['day'] . '.' . $dateInfo['month'] . '.' . $dateFormat['year'];

											}
											$value = date(DATE_FORMAT, strtotime($value));
										}
										$importPozycjaDokumentu->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_produkt');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoProdukt::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoProdukt::token2Id($tmpToken);
	}
	$importPozycjaDokumentu->setPrdId($defaultValue);
}
$defaultValue = P('import_default_value_dokument_ksiegowy');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoDokumentKsiegowy::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoDokumentKsiegowy::token2Id($tmpToken);
	}
	$importPozycjaDokumentu->setDksId($defaultValue);
}
							$errorMessage = $importPozycjaDokumentu->store();
							if ($errorMessage != "") {
								if ($importMode == "T") {
									L($errorMessage, '', 'ERROR');
									fclose($fh);
									unset($propertyColumnHash);
									unset($propertyClassHash); 
									return -1;
								} else {
									$recordsError++;
									L('Error on import: ' . $errorMessage, '', 'WARN');
								}
							} else {
								$recordsOK++;
							}
						}
					}
					fclose($fh);
					unset($propertyColumnHash);
					unset($propertyClassHash); 
					L(T('VALUES_UPLOADED', $recordsOK, $recordsError), '', 'INFO'); 
					return 0;
				}
			}
		}
		




		static function portletActionVirgoSetProdukt() {
			$this->loadFromDB();
			$parentId = R('pdk_Produkt_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrdId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetDokumentKsiegowy() {
			$this->loadFromDB();
			$parentId = R('pdk_DokumentKsiegowy_id_' . $_SESSION['current_portlet_object_id']);
			$this->setDksId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddProdukt() {
			self::setDisplayMode("ADD_NEW_PARENT_PRODUKT");
		}

		static function portletActionStoreNewProdukt() {
			$id = -1;
			if (virgoProdukt::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PRODUKT");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pdk_produkt_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}
		static function portletActionAddDokumentKsiegowy() {
			self::setDisplayMode("ADD_NEW_PARENT_DOKUMENT_KSIEGOWY");
		}

		static function portletActionStoreNewDokumentKsiegowy() {
			$id = -1;
			if (virgoDokumentKsiegowy::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_DOKUMENT_KSIEGOWY");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['pdk_dokumentKsiegowy_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `slk_pozycje_dokumentow` (
  `pdk_id` bigint(20) unsigned NOT NULL auto_increment,
  `pdk_virgo_state` varchar(50) default NULL,
  `pdk_virgo_title` varchar(255) default NULL,
	`pdk_prd_id` int(11) default NULL,
	`pdk_dks_id` int(11) default NULL,
  `pdk_ilosc` decimal(10,2),  
  `pdk_kwota` decimal(10,2),  
  `pdk_date_created` datetime NOT NULL,
  `pdk_date_modified` datetime default NULL,
  `pdk_usr_created_id` int(11) NOT NULL,
  `pdk_usr_modified_id` int(11) default NULL,
  KEY `pdk_prd_fk` (`pdk_prd_id`),
  KEY `pdk_dks_fk` (`pdk_dks_id`),
  PRIMARY KEY  (`pdk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/pozycja_dokumentu.sql 
INSERT INTO `slk_pozycje_dokumentow` (`pdk_virgo_title`, `pdk_ilosc`, `pdk_kwota`) 
VALUES (title, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_pozycje_dokumentow table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}


		static function token2Id($token, $extraLimit = null) {
			if (S($token)) {
				$ids = self::selectAllAsIdsStatic($extraLimit, true);
				foreach ($ids as $id) {
					if (getTokenValue($id) == $token) {
						return $id;
					}
				}
			}
			return null;
		}

		static function getMyPortletObject() {
			if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) {
				require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
				$pobId = $_SESSION['current_portlet_object_id'];
				return new virgoPortletObject($pobId);
			}
			return null;
		}
		
		static function getPrefix() {
			return "pdk";
		}
		
		static function getPlural() {
			return "pozycje_dokumentow";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoProdukt";
			$ret[] = "virgoDokumentKsiegowy";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_pozycje_dokumentow'));
			foreach ($rows as $row) {
				return $row['table_type'];
			}
			return "";
		}
		
		static function getStructureVersion() {
			return "1.4" . 
''
			;
		}
		
		static function getVirgoVersion() {
			return
"2.0.0.0"  
			;
		}
		
		static function checkCompatibility() {
			$virgoVersion = virgoPozycjaDokumentu::getVirgoVersion();
			if ($virgoVersion == INDEX_VERSION) {
				return 1;
			}
			$virgoVersionNumber = substr($virgoVersion, 0, strpos($virgoVersion, "."));
			$portalVersionNumber = substr(INDEX_VERSION, 0, strpos(INDEX_VERSION, "."));
			if ($virgoVersionNumber == $portalVersionNumber) {
				return 0;
			}
			return -1;
		}



		static function getParentInContext($parentName) {
			$parentsInContext = self::getParentsInContext();
			if (isset($parentsInContext[$parentName])) {
				$parentInfo = $parentsInContext[$parentName];
				if (isset($parentInfo['contextId'])) {
					return $parentInfo['contextId'];
				} else {
					return null;
				}
			} else {
				return null;
			}
		}

		/****************** database selects ******************/
		
	}
	
	
