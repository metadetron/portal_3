<?php
/**
* Module Dokument księgowy
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoRodzajDokumentu'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaDokumentu'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoDokumentKsiegowy {

		 private  $dks_id = null;
		 private  $dks_bufor = null;

		 private  $dks_data_operacji = null;

		 private  $dks_data_wystawienia = null;

		 private  $dks_numer = null;

		 private  $dks_rdk_id = null;

		 private   $dks_date_created = null;
		 private   $dks_usr_created_id = null;
		 private   $dks_date_modified = null;
		 private   $dks_usr_modified_id = null;
		 private   $dks_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {
			$tmpRet = '$ret = ' . 1 . ';';
			eval($tmpRet);
			$this->dks_bufor = $ret;


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->dks_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoDokumentKsiegowy();
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
        	$this->dks_id = null;
		    $this->dks_date_created = null;
		    $this->dks_usr_created_id = null;
		    $this->dks_date_modified = null;
		    $this->dks_usr_modified_id = null;
		    $this->dks_virgo_title = null;
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
			return $this->dks_id;
		}

		function getBufor() {
			return $this->dks_bufor;
		}
		
		 private  function setBufor($val) {
			$this->dks_bufor = $val;
		}
		function getDataOperacji() {
			return $this->dks_data_operacji;
		}
		
		 private  function setDataOperacji($val) {
			$this->dks_data_operacji = $val;
		}
		function getDataWystawienia() {
			return $this->dks_data_wystawienia;
		}
		
		 private  function setDataWystawienia($val) {
			$this->dks_data_wystawienia = $val;
		}
		function getNumer() {
			return $this->dks_numer;
		}
		
		 private  function setNumer($val) {
			$this->dks_numer = $val;
		}

		function getRodzajDokumentuId() {
			return $this->dks_rdk_id;
		}
		
		 private  function setRodzajDokumentuId($val) {
			$this->dks_rdk_id = $val;
		}

		function getDateCreated() {
			return $this->dks_date_created;
		}
		function getUsrCreatedId() {
			return $this->dks_usr_created_id;
		}
		function getDateModified() {
			return $this->dks_date_modified;
		}
		function getUsrModifiedId() {
			return $this->dks_usr_modified_id;
		}


		function getRdkId() {
			return $this->getRodzajDokumentuId();
		}
		
		 private  function setRdkId($val) {
			$this->setRodzajDokumentuId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->dks_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('dks_bufor_' . $this->dks_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->dks_bufor = null;
		} else {
			$this->dks_bufor = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('dks_dataOperacji_' . $this->dks_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->dks_data_operacji = null;
		} else {
			$this->dks_data_operacji = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('dks_dataWystawienia_' . $this->dks_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->dks_data_wystawienia = null;
		} else {
			$this->dks_data_wystawienia = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('dks_numer_' . $this->dks_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->dks_numer = null;
		} else {
			$this->dks_numer = $tmpValue;
		}
	}
			$this->dks_rdk_id = strval(R('dks_rodzajDokumentu_' . $this->dks_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('dks_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaDokumentKsiegowy = array();	
			$criteriaFieldDokumentKsiegowy = array();	
			$isNullDokumentKsiegowy = R('virgo_search_bufor_is_null');
			
			$criteriaFieldDokumentKsiegowy["is_null"] = 0;
			if ($isNullDokumentKsiegowy == "not_null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 1;
			} elseif ($isNullDokumentKsiegowy == "null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_bufor');

//			if ($isSet) {
			$criteriaFieldDokumentKsiegowy["value"] = $dataTypeCriteria;
//			}
			$criteriaDokumentKsiegowy["bufor"] = $criteriaFieldDokumentKsiegowy;
			$criteriaFieldDokumentKsiegowy = array();	
			$isNullDokumentKsiegowy = R('virgo_search_dataOperacji_is_null');
			
			$criteriaFieldDokumentKsiegowy["is_null"] = 0;
			if ($isNullDokumentKsiegowy == "not_null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 1;
			} elseif ($isNullDokumentKsiegowy == "null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_dataOperacji_from');
		$dataTypeCriteria["to"] = R('virgo_search_dataOperacji_to');

//			if ($isSet) {
			$criteriaFieldDokumentKsiegowy["value"] = $dataTypeCriteria;
//			}
			$criteriaDokumentKsiegowy["data_operacji"] = $criteriaFieldDokumentKsiegowy;
			$criteriaFieldDokumentKsiegowy = array();	
			$isNullDokumentKsiegowy = R('virgo_search_dataWystawienia_is_null');
			
			$criteriaFieldDokumentKsiegowy["is_null"] = 0;
			if ($isNullDokumentKsiegowy == "not_null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 1;
			} elseif ($isNullDokumentKsiegowy == "null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_dataWystawienia_from');
		$dataTypeCriteria["to"] = R('virgo_search_dataWystawienia_to');

//			if ($isSet) {
			$criteriaFieldDokumentKsiegowy["value"] = $dataTypeCriteria;
//			}
			$criteriaDokumentKsiegowy["data_wystawienia"] = $criteriaFieldDokumentKsiegowy;
			$criteriaFieldDokumentKsiegowy = array();	
			$isNullDokumentKsiegowy = R('virgo_search_numer_is_null');
			
			$criteriaFieldDokumentKsiegowy["is_null"] = 0;
			if ($isNullDokumentKsiegowy == "not_null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 1;
			} elseif ($isNullDokumentKsiegowy == "null") {
				$criteriaFieldDokumentKsiegowy["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_numer');

//			if ($isSet) {
			$criteriaFieldDokumentKsiegowy["value"] = $dataTypeCriteria;
//			}
			$criteriaDokumentKsiegowy["numer"] = $criteriaFieldDokumentKsiegowy;
			$criteriaParent = array();	
			$isNull = R('virgo_search_rodzajDokumentu_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_rodzajDokumentu', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaDokumentKsiegowy["rodzaj_dokumentu"] = $criteriaParent;
			self::setCriteria($criteriaDokumentKsiegowy);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_bufor');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterBufor', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterBufor', null);
			}
			$tableFilter = R('virgo_filter_data_operacji');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDataOperacji', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDataOperacji', null);
			}
			$tableFilter = R('virgo_filter_data_wystawienia');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDataWystawienia', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDataWystawienia', null);
			}
			$tableFilter = R('virgo_filter_numer');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNumer', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNumer', null);
			}
			$parentFilter = R('virgo_filter_rodzaj_dokumentu');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterRodzajDokumentu', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterRodzajDokumentu', null);
			}
			$parentFilter = R('virgo_filter_title_rodzaj_dokumentu');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleRodzajDokumentu', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleRodzajDokumentu', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseDokumentKsiegowy = ' 1 = 1 ';
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
				$eventColumn = "dks_" . P('event_column');
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_rodzaj_dokumentu');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_dokumenty_ksiegowe.dks_rdk_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_dokumenty_ksiegowe.dks_rdk_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaDokumentKsiegowy = self::getCriteria();
			if (isset($criteriaDokumentKsiegowy["bufor"])) {
				$fieldCriteriaBufor = $criteriaDokumentKsiegowy["bufor"];
				if ($fieldCriteriaBufor["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_bufor IS NOT NULL ';
				} elseif ($fieldCriteriaBufor["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_bufor IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBufor["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_bufor = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaDokumentKsiegowy["data_operacji"])) {
				$fieldCriteriaDataOperacji = $criteriaDokumentKsiegowy["data_operacji"];
				if ($fieldCriteriaDataOperacji["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_operacji IS NOT NULL ';
				} elseif ($fieldCriteriaDataOperacji["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_operacji IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataOperacji["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_operacji >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_operacji <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaDokumentKsiegowy["data_wystawienia"])) {
				$fieldCriteriaDataWystawienia = $criteriaDokumentKsiegowy["data_wystawienia"];
				if ($fieldCriteriaDataWystawienia["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_wystawienia IS NOT NULL ';
				} elseif ($fieldCriteriaDataWystawienia["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_wystawienia IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataWystawienia["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_wystawienia >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_wystawienia <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaDokumentKsiegowy["numer"])) {
				$fieldCriteriaNumer = $criteriaDokumentKsiegowy["numer"];
				if ($fieldCriteriaNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_numer IS NOT NULL ';
				} elseif ($fieldCriteriaNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_numer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaDokumentKsiegowy["rodzaj_dokumentu"])) {
				$parentCriteria = $criteriaDokumentKsiegowy["rodzaj_dokumentu"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND dks_rdk_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_rdk_id IN (SELECT rdk_id FROM slk_rodzaje_dokumentow WHERE rdk_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterBufor', null);
				if (S($tableFilter)) {
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_bufor LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDataOperacji', null);
				if (S($tableFilter)) {
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_data_operacji LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDataWystawienia', null);
				if (S($tableFilter)) {
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_data_wystawienia LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterNumer', null);
				if (S($tableFilter)) {
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_numer LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterRodzajDokumentu', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_rdk_id IS NULL ";
					} else {
						$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND dks_rdk_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleRodzajDokumentu', null);
				if (S($parentFilter)) {
					$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND slk_rodzaje_dokumentow_parent.rdk_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseDokumentKsiegowy;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseDokumentKsiegowy = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_dokumenty_ksiegowe.dks_id, slk_dokumenty_ksiegowe.dks_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_bufor', "0") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_bufor dks_bufor";
			} else {
				if ($defaultOrderColumn == "dks_bufor") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_bufor ";
				}
			}
			if (P('show_table_data_operacji', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_operacji dks_data_operacji";
			} else {
				if ($defaultOrderColumn == "dks_data_operacji") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_operacji ";
				}
			}
			if (P('show_table_data_wystawienia', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_wystawienia dks_data_wystawienia";
			} else {
				if ($defaultOrderColumn == "dks_data_wystawienia") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_wystawienia ";
				}
			}
			if (P('show_table_numer', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_numer dks_numer";
			} else {
				if ($defaultOrderColumn == "dks_numer") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_numer ";
				}
			}
			if (class_exists('sealock\virgoRodzajDokumentu') && P('show_table_rodzaj_dokumentu', "1") != "0") { // */ && !in_array("rdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_rdk_id as dks_rdk_id ";
				$queryString = $queryString . ", slk_rodzaje_dokumentow_parent.rdk_virgo_title as `rodzaj_dokumentu` ";
			} else {
				if ($defaultOrderColumn == "rodzaj_dokumentu") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow_parent.rdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_dokumenty_ksiegowe ";
			if (class_exists('sealock\virgoRodzajDokumentu')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_rodzaje_dokumentow AS slk_rodzaje_dokumentow_parent ON (slk_dokumenty_ksiegowe.dks_rdk_id = slk_rodzaje_dokumentow_parent.rdk_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseDokumentKsiegowy, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseDokumentKsiegowy,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_dokumenty_ksiegowe"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " dks_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " dks_usr_created_id = ? ";
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
				. "\n FROM slk_dokumenty_ksiegowe"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_dokumenty_ksiegowe ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_dokumenty_ksiegowe ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, dks_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " dks_usr_created_id = ? ";
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
				$query = "SELECT COUNT(dks_id) cnt FROM dokumenty_ksiegowe";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as dokumenty_ksiegowe ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as dokumenty_ksiegowe ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoDokumentKsiegowy();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_dokumenty_ksiegowe WHERE dks_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->dks_id = $row['dks_id'];
$this->dks_bufor = $row['dks_bufor'];
$this->dks_data_operacji = $row['dks_data_operacji'];
$this->dks_data_wystawienia = $row['dks_data_wystawienia'];
$this->dks_numer = $row['dks_numer'];
						$this->dks_rdk_id = $row['dks_rdk_id'];
						if ($fetchUsernames) {
							if ($row['dks_date_created']) {
								if ($row['dks_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['dks_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['dks_date_modified']) {
								if ($row['dks_usr_modified_id'] == $row['dks_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['dks_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['dks_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->dks_date_created = $row['dks_date_created'];
						$this->dks_usr_created_id = $fetchUsernames ? $createdBy : $row['dks_usr_created_id'];
						$this->dks_date_modified = $row['dks_date_modified'];
						$this->dks_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['dks_usr_modified_id'];
						$this->dks_virgo_title = $row['dks_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_dokumenty_ksiegowe SET dks_usr_created_id = {$userId} WHERE dks_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->dks_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoDokumentKsiegowy::selectAllAsObjectsStatic('dks_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->dks_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->dks_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('dks_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_dks = new virgoDokumentKsiegowy();
				$tmp_dks->load((int)$lookup_id);
				return $tmp_dks->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoDokumentKsiegowy');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" dks_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoDokumentKsiegowy', "10");
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
				$query = $query . " dks_id as id, dks_virgo_title as title ";
			}
			$query = $query . " FROM slk_dokumenty_ksiegowe ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoDokumentKsiegowy', 'sealock') == "1") {
				$privateCondition = " dks_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY dks_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resDokumentKsiegowy = array();
				foreach ($rows as $row) {
					$resDokumentKsiegowy[$row['id']] = $row['title'];
				}
				return $resDokumentKsiegowy;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticDokumentKsiegowy = new virgoDokumentKsiegowy();
			return $staticDokumentKsiegowy->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getRodzajDokumentuStatic($parentId) {
			return virgoRodzajDokumentu::getById($parentId);
		}
		
		function getRodzajDokumentu() {
			return virgoDokumentKsiegowy::getRodzajDokumentuStatic($this->dks_rdk_id);
		}

		static function getPozycjeDokumentowStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaDokumentu = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaDokumentu'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaDokumentu;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaDokumentu;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaDokumentu = virgoPozycjaDokumentu::selectAll('pdk_dks_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaDokumentu as $resultPozycjaDokumentu) {
				$tmpPozycjaDokumentu = virgoPozycjaDokumentu::getById($resultPozycjaDokumentu['pdk_id']); 
				array_push($resPozycjaDokumentu, $tmpPozycjaDokumentu);
			}
			return $resPozycjaDokumentu;
		}

		function getPozycjeDokumentow($orderBy = '', $extraWhere = null) {
			return virgoDokumentKsiegowy::getPozycjeDokumentowStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_bufor_obligatory', "0") == "1") {
				if (
(is_null($this->getBufor()) || trim($this->getBufor()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'BUFOR');
				}			
			}
			if (
(is_null($this->getDataOperacji()) || trim($this->getDataOperacji()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'DATA_OPERACJI');
			}			
			if (
(is_null($this->getDataWystawienia()) || trim($this->getDataWystawienia()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'DATA_WYSTAWIENIA');
			}			
			if (
(is_null($this->getNumer()) || trim($this->getNumer()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NUMER');
			}			
				if (is_null($this->dks_rdk_id) || trim($this->dks_rdk_id) == "") {
					if (R('create_dks_rodzajDokumentu_' . $this->dks_id) == "1") { 
						$parent = new virgoRodzajDokumentu();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->dks_rdk_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'RODZAJ_DOKUMENTU', '');
					}
			}			
 			if (!is_null($this->dks_data_operacji) && trim($this->dks_data_operacji) != "") {
				preg_match('/^(\d\d\d\d)-(\d\d)-(\d\d)$/i', $this->dks_data_operacji, $matches);
				if (sizeof($matches) != 4) {
					return T('INCORRECT_DATE', 'DATA_OPERACJI');
				}
				if (!checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
					return T('INCORRECT_DATE', 'DATA_OPERACJI');
				}
			}
			if (!is_null($this->dks_data_wystawienia) && trim($this->dks_data_wystawienia) != "") {
				preg_match('/^(\d\d\d\d)-(\d\d)-(\d\d)$/i', $this->dks_data_wystawienia, $matches);
				if (sizeof($matches) != 4) {
					return T('INCORRECT_DATE', 'DATA_WYSTAWIENIA');
				}
				if (!checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
					return T('INCORRECT_DATE', 'DATA_WYSTAWIENIA');
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->dks_id) && $this->dks_id != 0) {
			$uniqnessWhere = " dks_id != " . $this->dks_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(dks_numer) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->dks_numer;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM slk_dokumenty_ksiegowe ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('NUMER');
				$values[] = $this->dks_numer; 
				return T('UNIQNESS_FAILED', 'DOKUMENT_KSIEGOWY', implode(', ', $colNames), implode(', ', $values));
			}
		}
			return "";
		}

				
		function beforeStore($virgoOld) {
		if (is_null($virgoOld)) {
			$rodzajDokumentu = $this->getRodzajDokumentu();
			$ret = $rodzajDokumentu->ustawNastepnyNumer($this);
			if (is_array($ret) && count($ret) > 0 && $ret[0] != "") {
				return $ret[0];
			}		
			$this->setNumer($ret);
		}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_dokumenty_ksiegowe WHERE dks_id = " . $this->getId();
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
				$colNames = $colNames . ", dks_bufor";
				$values = $values . ", " . (is_null($objectToStore->getBufor()) ? "null" : "'" . QE($objectToStore->getBufor()) . "'");
				$colNames = $colNames . ", dks_data_operacji";
				$values = $values . ", " . (is_null($objectToStore->getDataOperacji()) ? "null" : "'" . QE($objectToStore->getDataOperacji()) . "'");
				$colNames = $colNames . ", dks_data_wystawienia";
				$values = $values . ", " . (is_null($objectToStore->getDataWystawienia()) ? "null" : "'" . QE($objectToStore->getDataWystawienia()) . "'");
				$colNames = $colNames . ", dks_numer";
				$values = $values . ", " . (is_null($objectToStore->getNumer()) ? "null" : "'" . QE($objectToStore->getNumer()) . "'");
				$colNames = $colNames . ", dks_rdk_id";
				$values = $values . ", " . (is_null($objectToStore->getRdkId()) || $objectToStore->getRdkId() == "" ? "null" : $objectToStore->getRdkId());
				$query = "INSERT INTO slk_history_dokumenty_ksiegowe (revision, ip, username, user_id, timestamp, dks_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getBufor() != $objectToStore->getBufor()) {
				if (is_null($objectToStore->getBufor())) {
					$nullifiedProperties = $nullifiedProperties . "bufor,";
				} else {
				$colNames = $colNames . ", dks_bufor";
				$values = $values . ", " . (is_null($objectToStore->getBufor()) ? "null" : "'" . QE($objectToStore->getBufor()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDataOperacji() != $objectToStore->getDataOperacji()) {
				if (is_null($objectToStore->getDataOperacji())) {
					$nullifiedProperties = $nullifiedProperties . "data_operacji,";
				} else {
				$colNames = $colNames . ", dks_data_operacji";
				$values = $values . ", " . (is_null($objectToStore->getDataOperacji()) ? "null" : "'" . QE($objectToStore->getDataOperacji()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDataWystawienia() != $objectToStore->getDataWystawienia()) {
				if (is_null($objectToStore->getDataWystawienia())) {
					$nullifiedProperties = $nullifiedProperties . "data_wystawienia,";
				} else {
				$colNames = $colNames . ", dks_data_wystawienia";
				$values = $values . ", " . (is_null($objectToStore->getDataWystawienia()) ? "null" : "'" . QE($objectToStore->getDataWystawienia()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getNumer() != $objectToStore->getNumer()) {
				if (is_null($objectToStore->getNumer())) {
					$nullifiedProperties = $nullifiedProperties . "numer,";
				} else {
				$colNames = $colNames . ", dks_numer";
				$values = $values . ", " . (is_null($objectToStore->getNumer()) ? "null" : "'" . QE($objectToStore->getNumer()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getRdkId() != $objectToStore->getRdkId() && ($virgoOld->getRdkId() != 0 || $objectToStore->getRdkId() != ""))) { 
				$colNames = $colNames . ", dks_rdk_id";
				$values = $values . ", " . (is_null($objectToStore->getRdkId()) ? "null" : ($objectToStore->getRdkId() == "" ? "0" : $objectToStore->getRdkId()));
			}
			$query = "INSERT INTO slk_history_dokumenty_ksiegowe (revision, ip, username, user_id, timestamp, dks_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_dokumenty_ksiegowe");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'dks_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_dokumenty_ksiegowe ADD COLUMN (dks_virgo_title VARCHAR(255));";
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
			if (isset($this->dks_id) && $this->dks_id != "") {
				$query = "UPDATE slk_dokumenty_ksiegowe SET ";
			if (isset($this->dks_bufor)) {
				$query .= " dks_bufor = ? ,";
				$types .= "s";
				$values[] = $this->dks_bufor;
			} else {
				$query .= " dks_bufor = NULL ,";				
			}
			if (isset($this->dks_data_operacji)) {
				$query .= " dks_data_operacji = ? ,";
				$types .= "s";
				$values[] = $this->dks_data_operacji;
			} else {
				$query .= " dks_data_operacji = NULL ,";				
			}
			if (isset($this->dks_data_wystawienia)) {
				$query .= " dks_data_wystawienia = ? ,";
				$types .= "s";
				$values[] = $this->dks_data_wystawienia;
			} else {
				$query .= " dks_data_wystawienia = NULL ,";				
			}
			if (isset($this->dks_numer)) {
				$query .= " dks_numer = ? ,";
				$types .= "s";
				$values[] = $this->dks_numer;
			} else {
				$query .= " dks_numer = NULL ,";				
			}
				if (isset($this->dks_rdk_id) && trim($this->dks_rdk_id) != "") {
					$query = $query . " dks_rdk_id = ? , ";
					$types = $types . "i";
					$values[] = $this->dks_rdk_id;
				} else {
					$query = $query . " dks_rdk_id = NULL, ";
				}
				$query = $query . " dks_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " dks_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->dks_date_modified;

				$query = $query . " dks_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->dks_usr_modified_id;

				$query = $query . " WHERE dks_id = ? ";
				$types = $types . "i";
				$values[] = $this->dks_id;
			} else {
				$query = "INSERT INTO slk_dokumenty_ksiegowe ( ";
			$query = $query . " dks_bufor, ";
			$query = $query . " dks_data_operacji, ";
			$query = $query . " dks_data_wystawienia, ";
			$query = $query . " dks_numer, ";
				$query = $query . " dks_rdk_id, ";
				$query = $query . " dks_virgo_title, dks_date_created, dks_usr_created_id) VALUES ( ";
			if (isset($this->dks_bufor)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->dks_bufor;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->dks_data_operacji)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->dks_data_operacji;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->dks_data_wystawienia)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->dks_data_wystawienia;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->dks_numer)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->dks_numer;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->dks_rdk_id) && trim($this->dks_rdk_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->dks_rdk_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->dks_date_created;
				$values[] = $this->dks_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->dks_id) || $this->dks_id == "") {
					$this->dks_id = QID();
				}
				if ($log) {
					L("dokument ksi\u0119gowy stored successfully", "id = {$this->dks_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->dks_id) {
				$virgoOld = new virgoDokumentKsiegowy($this->dks_id);
			}
			$validationMessageText = $this->beforeStore($virgoOld);
			if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
				$this->logWarn('Before store failed for id = ' . $this->getId() . ": " . $validationMessageText);
				return trim($validationMessageText);				
			} else {
				$validationMessageText = $this->validateObject($virgoOld);
				if (!is_null($validationMessageText) && trim($validationMessageText) != "") {
					$this->logWarn('Validation failed for id = ' . $this->getId() . ": " . $validationMessageText);
					return trim($validationMessageText);				
				} else {
					$userId = virgoUser::getUserId();			
					if ($this->dks_id) {			
						$this->dks_date_modified = date("Y-m-d H:i:s");
						$this->dks_usr_modified_id = $userId;
					} else {
						$this->dks_date_created = date("Y-m-d H:i:s");
						$this->dks_usr_created_id = $userId;
					}
					$this->dks_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "dokument ksi\u0119gowy" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "dokument ksi\u0119gowy" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_dokumenty_ksiegowe WHERE dks_id = {$this->dks_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPozycjeDokumentow();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'DOKUMENT_KSIEGOWY', 'POZYCJA_DOKUMENTU', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoDokumentKsiegowy();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT dks_id as id FROM slk_dokumenty_ksiegowe";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'dks_order_column')) {
				$orderBy = " ORDER BY dks_order_column ASC ";
			} 
			if (property_exists($this, 'dks_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY dks_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoDokumentKsiegowy();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoDokumentKsiegowy($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_dokumenty_ksiegowe SET dks_virgo_title = '$title' WHERE dks_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoDokumentKsiegowy();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" dks_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['dks_id'];
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
			virgoDokumentKsiegowy::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoDokumentKsiegowy::setSessionValue('Sealock_DokumentKsiegowy-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoDokumentKsiegowy::getSessionValue('Sealock_DokumentKsiegowy-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoDokumentKsiegowy::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoDokumentKsiegowy::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoDokumentKsiegowy::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoDokumentKsiegowy::getSessionValue('GLOBAL', $name, $default);
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
			$context['dks_id'] = $id;
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
			$context['dks_id'] = null;
			virgoDokumentKsiegowy::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoDokumentKsiegowy::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoDokumentKsiegowy::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoDokumentKsiegowy::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoDokumentKsiegowy::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoDokumentKsiegowy::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoDokumentKsiegowy::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoDokumentKsiegowy::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoDokumentKsiegowy::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoDokumentKsiegowy::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoDokumentKsiegowy::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoDokumentKsiegowy::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoDokumentKsiegowy::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoDokumentKsiegowy::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoDokumentKsiegowy::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoDokumentKsiegowy::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoDokumentKsiegowy::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "dks_id";
			}
			return virgoDokumentKsiegowy::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoDokumentKsiegowy::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoDokumentKsiegowy::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoDokumentKsiegowy::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoDokumentKsiegowy::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoDokumentKsiegowy::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoDokumentKsiegowy::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoDokumentKsiegowy::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoDokumentKsiegowy::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoDokumentKsiegowy::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoDokumentKsiegowy::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoDokumentKsiegowy::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoDokumentKsiegowy::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->dks_id) {
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
						L(T('STORED_CORRECTLY', 'DOKUMENT_KSIEGOWY'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'bufor', $this->dks_bufor);
						$fieldValues = $fieldValues . T($fieldValue, 'data operacji', $this->dks_data_operacji);
						$fieldValues = $fieldValues . T($fieldValue, 'data wystawienia', $this->dks_data_wystawienia);
						$fieldValues = $fieldValues . T($fieldValue, 'numer', $this->dks_numer);
						$parentRodzajDokumentu = new virgoRodzajDokumentu();
						$fieldValues = $fieldValues . T($fieldValue, 'rodzaj dokumentu', $parentRodzajDokumentu->lookup($this->dks_rdk_id));
						$username = '';
						if ($this->dks_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->dks_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->dks_date_created);
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
			$instance = new virgoDokumentKsiegowy();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoDokumentKsiegowy'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pozycje_dokumentow') == "1") {
				$tmpPozycjaDokumentu = new virgoPozycjaDokumentu();
				$deletePozycjaDokumentu = R('DELETE');
				if (sizeof($deletePozycjaDokumentu) > 0) {
					virgoPozycjaDokumentu::multipleDelete($deletePozycjaDokumentu);
				}
				$resIds = $tmpPozycjaDokumentu->select(null, 'all', null, null, ' pdk_dks_id = ' . $instance->getId(), ' SELECT pdk_id FROM slk_pozycje_dokumentow ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pdk_id;
//					JRequest::setVar('pdk_dokument_ksiegowy_' . $resId->pdk_id, $this->getId());
				} 
//				JRequest::setVar('pdk_dokument_ksiegowy_', $instance->getId());
				$tmpPozycjaDokumentu->setRecordSet($resIdsString);
				if (!$tmpPozycjaDokumentu->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
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
			$instance = new virgoDokumentKsiegowy();
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
			$tmpId = intval(R('dks_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoDokumentKsiegowy::getContextId();
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
			$this->dks_id = null;
			$this->dks_date_created = null;
			$this->dks_usr_created_id = null;
			$this->dks_date_modified = null;
			$this->dks_usr_modified_id = null;
			$this->dks_virgo_title = null;
			
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

		static function portletActionShowForRodzajDokumentu() {
			$parentId = R('rdk_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoRodzajDokumentu($parentId);
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
//			$ret = new virgoDokumentKsiegowy();
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
				$instance = new virgoDokumentKsiegowy();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoDokumentKsiegowy::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'DOKUMENT_KSIEGOWY'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetBuforTrue() {
			$instance = new virgoDokumentKsiegowy();
			$instance->loadFromDB();
			$instance->setBufor(1);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetBuforFalse() {
			$instance = new virgoDokumentKsiegowy();
			$instance->loadFromDB();
			$instance->setBufor(0);
			$ret = $instance->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isBufor() {
			return $this->getBufor() == 1;
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
				$resultDokumentKsiegowy = new virgoDokumentKsiegowy();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultDokumentKsiegowy->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultDokumentKsiegowy->load($idToEditInt);
					} else {
						$resultDokumentKsiegowy->dks_id = 0;
					}
				}
				$results[] = $resultDokumentKsiegowy;
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
				$result = new virgoDokumentKsiegowy();
				$result->loadFromRequest($idToStore);
				if ($result->dks_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->dks_id == 0) {
						$result->dks_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->dks_id)) {
							$result->dks_id = 0;
						}
						$idsToCorrect[$result->dks_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'DOKUMENTY_KSIEGOWE'), '', 'INFO');
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
			$resultDokumentKsiegowy = new virgoDokumentKsiegowy();
			foreach ($idsToDelete as $idToDelete) {
				$resultDokumentKsiegowy->load((int)trim($idToDelete));
				$res = $resultDokumentKsiegowy->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'DOKUMENTY_KSIEGOWE'), '', 'INFO');			
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
		$ret = $this->dks_numer;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoDokumentKsiegowy');
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
    			$ret["beforeStore/dokument_ksiegowy.php"] = "<b>2014-05-04</b> <span style='font-size: 0.78em;'>22:19:55</span>";
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE slk_dokumenty_ksiegowe SET dks_virgo_title = ? WHERE dks_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT dks_id AS id FROM slk_dokumenty_ksiegowe ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoDokumentKsiegowy($row['id']);
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
					$className = $portletObject->getPortletDefinition()->getAlias();
					$masterObject = new $className();
					$tmpContextId = $masterObject->getRemoteContextId($parentPobId);
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
				$class2prefix["sealock\\virgoRodzajDokumentu"] = "rdk";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoGrupaDokumentow"] = "gdk";
				$class2parentPrefix["sealock\\virgoRodzajDokumentu"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_dokumenty_ksiegowe.dks_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_dokumenty_ksiegowe.dks_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_dokumenty_ksiegowe.dks_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_dokumenty_ksiegowe.dks_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoDokumentKsiegowy!', '', 'ERROR');
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
			$pdf->SetTitle('Dokumenty księgowe report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('DOKUMENTY_KSIEGOWE');
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
			if (P('show_pdf_bufor', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_numer', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_rodzaj_dokumentu', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultDokumentKsiegowy = new virgoDokumentKsiegowy();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_bufor', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Bufor');
				$minWidth['bufor'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['bufor']) {
						$minWidth['bufor'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Data operacji');
				$minWidth['data operacji'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['data operacji']) {
						$minWidth['data operacji'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Data wystawienia');
				$minWidth['data wystawienia'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['data wystawienia']) {
						$minWidth['data wystawienia'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_numer', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Numer');
				$minWidth['numer'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['numer']) {
						$minWidth['numer'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_rodzaj_dokumentu', "1") == "1") {
				$minWidth['rodzaj dokumentu $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'rodzaj dokumentu $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['rodzaj dokumentu $relation.name']) {
						$minWidth['rodzaj dokumentu $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseDokumentKsiegowy = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaDokumentKsiegowy = $resultDokumentKsiegowy->getCriteria();
			$fieldCriteriaBufor = $criteriaDokumentKsiegowy["bufor"];
			if ($fieldCriteriaBufor["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Bufor', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaBufor["value"];
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
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Bufor', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDataOperacji = $criteriaDokumentKsiegowy["data_operacji"];
			if ($fieldCriteriaDataOperacji["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Data operacji', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDataOperacji["value"];
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
					$pdf->MultiCell(60, 100, 'Data operacji', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDataWystawienia = $criteriaDokumentKsiegowy["data_wystawienia"];
			if ($fieldCriteriaDataWystawienia["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Data wystawienia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDataWystawienia["value"];
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
					$pdf->MultiCell(60, 100, 'Data wystawienia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaNumer = $criteriaDokumentKsiegowy["numer"];
			if ($fieldCriteriaNumer["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Numer', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaNumer["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Numer', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaDokumentKsiegowy["rodzaj_dokumentu"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Rodzaj dokumentu', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoRodzajDokumentu::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Rodzaj dokumentu', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_rodzaj_dokumentu');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_dokumenty_ksiegowe.dks_rdk_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_dokumenty_ksiegowe.dks_rdk_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaDokumentKsiegowy = self::getCriteria();
			if (isset($criteriaDokumentKsiegowy["bufor"])) {
				$fieldCriteriaBufor = $criteriaDokumentKsiegowy["bufor"];
				if ($fieldCriteriaBufor["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_bufor IS NOT NULL ';
				} elseif ($fieldCriteriaBufor["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_bufor IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaBufor["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_bufor = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaDokumentKsiegowy["data_operacji"])) {
				$fieldCriteriaDataOperacji = $criteriaDokumentKsiegowy["data_operacji"];
				if ($fieldCriteriaDataOperacji["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_operacji IS NOT NULL ';
				} elseif ($fieldCriteriaDataOperacji["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_operacji IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataOperacji["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_operacji >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_operacji <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaDokumentKsiegowy["data_wystawienia"])) {
				$fieldCriteriaDataWystawienia = $criteriaDokumentKsiegowy["data_wystawienia"];
				if ($fieldCriteriaDataWystawienia["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_wystawienia IS NOT NULL ';
				} elseif ($fieldCriteriaDataWystawienia["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_data_wystawienia IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataWystawienia["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_wystawienia >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_data_wystawienia <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaDokumentKsiegowy["numer"])) {
				$fieldCriteriaNumer = $criteriaDokumentKsiegowy["numer"];
				if ($fieldCriteriaNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_numer IS NOT NULL ';
				} elseif ($fieldCriteriaNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_dokumenty_ksiegowe.dks_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_numer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaDokumentKsiegowy["rodzaj_dokumentu"])) {
				$parentCriteria = $criteriaDokumentKsiegowy["rodzaj_dokumentu"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND dks_rdk_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_dokumenty_ksiegowe.dks_rdk_id IN (SELECT rdk_id FROM slk_rodzaje_dokumentow WHERE rdk_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_dokumenty_ksiegowe.dks_id, slk_dokumenty_ksiegowe.dks_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_bufor', "0") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_bufor dks_bufor";
			} else {
				if ($defaultOrderColumn == "dks_bufor") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_bufor ";
				}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_operacji dks_data_operacji";
			} else {
				if ($defaultOrderColumn == "dks_data_operacji") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_operacji ";
				}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_wystawienia dks_data_wystawienia";
			} else {
				if ($defaultOrderColumn == "dks_data_wystawienia") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_wystawienia ";
				}
			}
			if (P('show_pdf_numer', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_numer dks_numer";
			} else {
				if ($defaultOrderColumn == "dks_numer") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_numer ";
				}
			}
			if (class_exists('sealock\virgoRodzajDokumentu') && P('show_pdf_rodzaj_dokumentu', "1") != "0") { // */ && !in_array("rdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_rdk_id as dks_rdk_id ";
				$queryString = $queryString . ", slk_rodzaje_dokumentow_parent.rdk_virgo_title as `rodzaj_dokumentu` ";
			} else {
				if ($defaultOrderColumn == "rodzaj_dokumentu") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow_parent.rdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_dokumenty_ksiegowe ";
			if (class_exists('sealock\virgoRodzajDokumentu')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_rodzaje_dokumentow AS slk_rodzaje_dokumentow_parent ON (slk_dokumenty_ksiegowe.dks_rdk_id = slk_rodzaje_dokumentow_parent.rdk_id) ";
			}

		$resultsDokumentKsiegowy = $resultDokumentKsiegowy->select(
			'', 
			'all', 
			$resultDokumentKsiegowy->getOrderColumn(), 
			$resultDokumentKsiegowy->getOrderMode(), 
			$whereClauseDokumentKsiegowy,
			$queryString);
		
		foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {

			if (P('show_pdf_bufor', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultDokumentKsiegowy['dks_bufor'])) + 6;
				if ($tmpLen > $minWidth['bufor']) {
					$minWidth['bufor'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_data_operacji', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultDokumentKsiegowy['dks_data_operacji'])) + 6;
				if ($tmpLen > $minWidth['data operacji']) {
					$minWidth['data operacji'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_data_wystawienia', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultDokumentKsiegowy['dks_data_wystawienia'])) + 6;
				if ($tmpLen > $minWidth['data wystawienia']) {
					$minWidth['data wystawienia'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_numer', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultDokumentKsiegowy['dks_numer'])) + 6;
				if ($tmpLen > $minWidth['numer']) {
					$minWidth['numer'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_rodzaj_dokumentu', "1") == "1") {
			$parentValue = trim(virgoRodzajDokumentu::lookup($resultDokumentKsiegowy['dksrdk__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['rodzaj dokumentu $relation.name']) {
					$minWidth['rodzaj dokumentu $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaDokumentKsiegowy = $resultDokumentKsiegowy->getCriteria();
		if (is_null($criteriaDokumentKsiegowy) || sizeof($criteriaDokumentKsiegowy) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																	if (P('show_pdf_bufor', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['bufor'], $colHeight, T('BUFOR'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['data operacji'], $colHeight, T('DATA_OPERACJI'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['data wystawienia'], $colHeight, T('DATA_WYSTAWIENIA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_numer', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['numer'], $colHeight, T('NUMER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_rodzaj_dokumentu', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['rodzaj dokumentu $relation.name'], $colHeight, T('RODZAJ_DOKUMENTU') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_bufor', "0") != "0") {
			$renderCriteria = "";
			switch ($resultDokumentKsiegowy['dks_bufor']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['bufor'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_bufor', "1") == "2") {
										if (!is_null($resultDokumentKsiegowy['dks_bufor'])) {
						$tmpCount = (float)$counts["bufor"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["bufor"] = $tmpCount;
					}
				}
				if (P('show_pdf_bufor', "1") == "3") {
										if (!is_null($resultDokumentKsiegowy['dks_bufor'])) {
						$tmpSum = (float)$sums["bufor"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_bufor'];
						}
						$sums["bufor"] = $tmpSum;
					}
				}
				if (P('show_pdf_bufor', "1") == "4") {
										if (!is_null($resultDokumentKsiegowy['dks_bufor'])) {
						$tmpCount = (float)$avgCounts["bufor"];
						$tmpSum = (float)$avgSums["bufor"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["bufor"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_bufor'];
						}
						$avgSums["bufor"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_data_operacji', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['data operacji'], $colHeight, '' . $resultDokumentKsiegowy['dks_data_operacji'], 'T', 'L', 0, 0);
				if (P('show_pdf_data_operacji', "1") == "2") {
										if (!is_null($resultDokumentKsiegowy['dks_data_operacji'])) {
						$tmpCount = (float)$counts["data_operacji"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["data_operacji"] = $tmpCount;
					}
				}
				if (P('show_pdf_data_operacji', "1") == "3") {
										if (!is_null($resultDokumentKsiegowy['dks_data_operacji'])) {
						$tmpSum = (float)$sums["data_operacji"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_data_operacji'];
						}
						$sums["data_operacji"] = $tmpSum;
					}
				}
				if (P('show_pdf_data_operacji', "1") == "4") {
										if (!is_null($resultDokumentKsiegowy['dks_data_operacji'])) {
						$tmpCount = (float)$avgCounts["data_operacji"];
						$tmpSum = (float)$avgSums["data_operacji"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["data_operacji"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_data_operacji'];
						}
						$avgSums["data_operacji"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_data_wystawienia', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['data wystawienia'], $colHeight, '' . $resultDokumentKsiegowy['dks_data_wystawienia'], 'T', 'L', 0, 0);
				if (P('show_pdf_data_wystawienia', "1") == "2") {
										if (!is_null($resultDokumentKsiegowy['dks_data_wystawienia'])) {
						$tmpCount = (float)$counts["data_wystawienia"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["data_wystawienia"] = $tmpCount;
					}
				}
				if (P('show_pdf_data_wystawienia', "1") == "3") {
										if (!is_null($resultDokumentKsiegowy['dks_data_wystawienia'])) {
						$tmpSum = (float)$sums["data_wystawienia"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_data_wystawienia'];
						}
						$sums["data_wystawienia"] = $tmpSum;
					}
				}
				if (P('show_pdf_data_wystawienia', "1") == "4") {
										if (!is_null($resultDokumentKsiegowy['dks_data_wystawienia'])) {
						$tmpCount = (float)$avgCounts["data_wystawienia"];
						$tmpSum = (float)$avgSums["data_wystawienia"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["data_wystawienia"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_data_wystawienia'];
						}
						$avgSums["data_wystawienia"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_numer', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['numer'], $colHeight, '' . $resultDokumentKsiegowy['dks_numer'], 'T', 'L', 0, 0);
				if (P('show_pdf_numer', "1") == "2") {
										if (!is_null($resultDokumentKsiegowy['dks_numer'])) {
						$tmpCount = (float)$counts["numer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["numer"] = $tmpCount;
					}
				}
				if (P('show_pdf_numer', "1") == "3") {
										if (!is_null($resultDokumentKsiegowy['dks_numer'])) {
						$tmpSum = (float)$sums["numer"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_numer'];
						}
						$sums["numer"] = $tmpSum;
					}
				}
				if (P('show_pdf_numer', "1") == "4") {
										if (!is_null($resultDokumentKsiegowy['dks_numer'])) {
						$tmpCount = (float)$avgCounts["numer"];
						$tmpSum = (float)$avgSums["numer"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["numer"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultDokumentKsiegowy['dks_numer'];
						}
						$avgSums["numer"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_rodzaj_dokumentu', "1") == "1") {
			$parentValue = virgoRodzajDokumentu::lookup($resultDokumentKsiegowy['dks_rdk_id']);
			$tmpLn = $pdf->MultiCell($minWidth['rodzaj dokumentu $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_bufor', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['bufor'];
				if (P('show_pdf_bufor', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["bufor"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data operacji'];
				if (P('show_pdf_data_operacji', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["data_operacji"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data wystawienia'];
				if (P('show_pdf_data_wystawienia', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["data_wystawienia"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_numer', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numer'];
				if (P('show_pdf_numer', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["numer"];
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
			if (P('show_pdf_bufor', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['bufor'];
				if (P('show_pdf_bufor', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["bufor"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data operacji'];
				if (P('show_pdf_data_operacji', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["data_operacji"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data wystawienia'];
				if (P('show_pdf_data_wystawienia', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["data_wystawienia"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_numer', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numer'];
				if (P('show_pdf_numer', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["numer"], 2, ',', ' ');
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
			if (P('show_pdf_bufor', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['bufor'];
				if (P('show_pdf_bufor', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["bufor"] == 0 ? "-" : $avgSums["bufor"] / $avgCounts["bufor"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_data_operacji', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data operacji'];
				if (P('show_pdf_data_operacji', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["data_operacji"] == 0 ? "-" : $avgSums["data_operacji"] / $avgCounts["data_operacji"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_data_wystawienia', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data wystawienia'];
				if (P('show_pdf_data_wystawienia', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["data_wystawienia"] == 0 ? "-" : $avgSums["data_wystawienia"] / $avgCounts["data_wystawienia"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_numer', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['numer'];
				if (P('show_pdf_numer', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["numer"] == 0 ? "-" : $avgSums["numer"] / $avgCounts["numer"]);
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
				$reportTitle = T('DOKUMENTY_KSIEGOWE');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultDokumentKsiegowy = new virgoDokumentKsiegowy();
			$whereClauseDokumentKsiegowy = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_bufor', "0") != "0") {
					$data = $data . $stringDelimeter .'Bufor' . $stringDelimeter . $separator;
				}
				if (P('show_export_data_operacji', "1") != "0") {
					$data = $data . $stringDelimeter .'Data operacji' . $stringDelimeter . $separator;
				}
				if (P('show_export_data_wystawienia', "1") != "0") {
					$data = $data . $stringDelimeter .'Data wystawienia' . $stringDelimeter . $separator;
				}
				if (P('show_export_numer', "1") != "0") {
					$data = $data . $stringDelimeter .'Numer' . $stringDelimeter . $separator;
				}
				if (P('show_export_rodzaj_dokumentu', "1") != "0") {
					$data = $data . $stringDelimeter . 'Rodzaj dokumentu ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_dokumenty_ksiegowe.dks_id, slk_dokumenty_ksiegowe.dks_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_bufor', "0") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_bufor dks_bufor";
			} else {
				if ($defaultOrderColumn == "dks_bufor") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_bufor ";
				}
			}
			if (P('show_export_data_operacji', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_operacji dks_data_operacji";
			} else {
				if ($defaultOrderColumn == "dks_data_operacji") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_operacji ";
				}
			}
			if (P('show_export_data_wystawienia', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_wystawienia dks_data_wystawienia";
			} else {
				if ($defaultOrderColumn == "dks_data_wystawienia") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_wystawienia ";
				}
			}
			if (P('show_export_numer', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_numer dks_numer";
			} else {
				if ($defaultOrderColumn == "dks_numer") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_numer ";
				}
			}
			if (class_exists('sealock\virgoRodzajDokumentu') && P('show_export_rodzaj_dokumentu', "1") != "0") { // */ && !in_array("rdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_rdk_id as dks_rdk_id ";
				$queryString = $queryString . ", slk_rodzaje_dokumentow_parent.rdk_virgo_title as `rodzaj_dokumentu` ";
			} else {
				if ($defaultOrderColumn == "rodzaj_dokumentu") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow_parent.rdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_dokumenty_ksiegowe ";
			if (class_exists('sealock\virgoRodzajDokumentu')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_rodzaje_dokumentow AS slk_rodzaje_dokumentow_parent ON (slk_dokumenty_ksiegowe.dks_rdk_id = slk_rodzaje_dokumentow_parent.rdk_id) ";
			}

			$resultsDokumentKsiegowy = $resultDokumentKsiegowy->select(
				'', 
				'all', 
				$resultDokumentKsiegowy->getOrderColumn(), 
				$resultDokumentKsiegowy->getOrderMode(), 
				$whereClauseDokumentKsiegowy,
				$queryString);
			foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {
				if (P('show_export_bufor', "0") != "0") {
			$data = $data . $resultDokumentKsiegowy['dks_bufor'] . $separator;
				}
				if (P('show_export_data_operacji', "1") != "0") {
			$data = $data . $resultDokumentKsiegowy['dks_data_operacji'] . $separator;
				}
				if (P('show_export_data_wystawienia', "1") != "0") {
			$data = $data . $resultDokumentKsiegowy['dks_data_wystawienia'] . $separator;
				}
				if (P('show_export_numer', "1") != "0") {
			$data = $data . $stringDelimeter . $resultDokumentKsiegowy['dks_numer'] . $stringDelimeter . $separator;
				}
				if (P('show_export_rodzaj_dokumentu', "1") != "0") {
					$parentValue = virgoRodzajDokumentu::lookup($resultDokumentKsiegowy['dks_rdk_id']);
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
				$reportTitle = T('DOKUMENTY_KSIEGOWE');
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
			$resultDokumentKsiegowy = new virgoDokumentKsiegowy();
			$whereClauseDokumentKsiegowy = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseDokumentKsiegowy = $whereClauseDokumentKsiegowy . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_bufor', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Bufor');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_data_operacji', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Data operacji');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_data_wystawienia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Data wystawienia');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Numer');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_rodzaj_dokumentu', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Rodzaj dokumentu ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoRodzajDokumentu::getVirgoList();
					$formulaRodzajDokumentu = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaRodzajDokumentu != "") {
							$formulaRodzajDokumentu = $formulaRodzajDokumentu . ',';
						}
						$formulaRodzajDokumentu = $formulaRodzajDokumentu . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_dokumenty_ksiegowe.dks_id, slk_dokumenty_ksiegowe.dks_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_bufor', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_bufor dks_bufor";
			} else {
				if ($defaultOrderColumn == "dks_bufor") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_bufor ";
				}
			}
			if (P('show_export_data_operacji', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_operacji dks_data_operacji";
			} else {
				if ($defaultOrderColumn == "dks_data_operacji") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_operacji ";
				}
			}
			if (P('show_export_data_wystawienia', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_data_wystawienia dks_data_wystawienia";
			} else {
				if ($defaultOrderColumn == "dks_data_wystawienia") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_data_wystawienia ";
				}
			}
			if (P('show_export_numer', "1") != "0") {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_numer dks_numer";
			} else {
				if ($defaultOrderColumn == "dks_numer") {
					$orderColumnNotDisplayed = " slk_dokumenty_ksiegowe.dks_numer ";
				}
			}
			if (class_exists('sealock\virgoRodzajDokumentu') && P('show_export_rodzaj_dokumentu', "1") != "0") { // */ && !in_array("rdk", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_dokumenty_ksiegowe.dks_rdk_id as dks_rdk_id ";
				$queryString = $queryString . ", slk_rodzaje_dokumentow_parent.rdk_virgo_title as `rodzaj_dokumentu` ";
			} else {
				if ($defaultOrderColumn == "rodzaj_dokumentu") {
					$orderColumnNotDisplayed = " slk_rodzaje_dokumentow_parent.rdk_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_dokumenty_ksiegowe ";
			if (class_exists('sealock\virgoRodzajDokumentu')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_rodzaje_dokumentow AS slk_rodzaje_dokumentow_parent ON (slk_dokumenty_ksiegowe.dks_rdk_id = slk_rodzaje_dokumentow_parent.rdk_id) ";
			}

			$resultsDokumentKsiegowy = $resultDokumentKsiegowy->select(
				'', 
				'all', 
				$resultDokumentKsiegowy->getOrderColumn(), 
				$resultDokumentKsiegowy->getOrderMode(), 
				$whereClauseDokumentKsiegowy,
				$queryString);
			$index = 1;
			foreach ($resultsDokumentKsiegowy as $resultDokumentKsiegowy) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultDokumentKsiegowy['dks_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_bufor', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultDokumentKsiegowy['dks_bufor'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_data_operacji', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultDokumentKsiegowy['dks_data_operacji'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_data_wystawienia', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultDokumentKsiegowy['dks_data_wystawienia'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultDokumentKsiegowy['dks_numer'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_rodzaj_dokumentu', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoRodzajDokumentu::lookup($resultDokumentKsiegowy['dks_rdk_id']);
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
					$objValidation->setFormula1('"' . $formulaRodzajDokumentu . '"');
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
					$propertyColumnHash['bufor'] = 'dks_bufor';
					$propertyColumnHash['bufor'] = 'dks_bufor';
					$propertyColumnHash['data operacji'] = 'dks_data_operacji';
					$propertyColumnHash['data_operacji'] = 'dks_data_operacji';
					$dateFormat = P('import_format_data_operacji');
					if (isset($dateFormat)) {
						$propertyDateFormatHash['dks_data_operacji'] = $dateFormat;
					}
					$propertyColumnHash['data wystawienia'] = 'dks_data_wystawienia';
					$propertyColumnHash['data_wystawienia'] = 'dks_data_wystawienia';
					$dateFormat = P('import_format_data_wystawienia');
					if (isset($dateFormat)) {
						$propertyDateFormatHash['dks_data_wystawienia'] = $dateFormat;
					}
					$propertyColumnHash['numer'] = 'dks_numer';
					$propertyColumnHash['numer'] = 'dks_numer';
					$propertyClassHash['rodzaj dokumentu'] = 'RodzajDokumentu';
					$propertyClassHash['rodzaj_dokumentu'] = 'RodzajDokumentu';
					$propertyColumnHash['rodzaj dokumentu'] = 'dks_rdk_id';
					$propertyColumnHash['rodzaj_dokumentu'] = 'dks_rdk_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importDokumentKsiegowy = new virgoDokumentKsiegowy();
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
										L(T('PROPERTY_NOT_FOUND', T('DOKUMENT_KSIEGOWY'), $columns[$index]), '', 'ERROR');
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
										$importDokumentKsiegowy->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_rodzaj_dokumentu');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoRodzajDokumentu::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoRodzajDokumentu::token2Id($tmpToken);
	}
	$importDokumentKsiegowy->setRdkId($defaultValue);
}
							$errorMessage = $importDokumentKsiegowy->store();
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
		



		static function portletActionPreviousYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear-1);
		}

		static function portletActionPreviousMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth - 1;
			if ($selectedMonth == 0) {
				$selectedMonth = 12;
				$pob->portletActionPreviousYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionNextYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = $pob->getPortletSessionValue('selected_year', date("Y"));
			$pob->setPortletSessionValue('selected_year', $selectedYear+1);
		}

		static function portletActionNextMonth() {			
			$pob = self::getMyPortletObject();
			$selectedMonth = $pob->getPortletSessionValue('selected_month', date("m"));
			$selectedMonth = $selectedMonth + 1;
			if ($selectedMonth == 13) {
				$selectedMonth = 1;
				$pob->portletActionNextYear();
			}
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionCurrentMonth() {
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('selected_month', date("m"));
			$pob->setPortletSessionValue('selected_year', date("Y"));
		}

		static function portletActionSetMonth() {
			$pob = self::getMyPortletObject();
			$selectedMonth = R('virgo_cal_selected_month');
			$pob->setPortletSessionValue('selected_month', $selectedMonth);
		}

		static function portletActionSetYear() {
			$pob = self::getMyPortletObject();
			$selectedYear = R('virgo_cal_selected_year');
			$pob->setPortletSessionValue('selected_year', $selectedYear);
		}

		static function portletActionVirgoSetRodzajDokumentu() {
			$this->loadFromDB();
			$parentId = R('dks_RodzajDokumentu_id_' . $_SESSION['current_portlet_object_id']);
			$this->setRdkId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddRodzajDokumentu() {
			self::setDisplayMode("ADD_NEW_PARENT_RODZAJ_DOKUMENTU");
		}

		static function portletActionStoreNewRodzajDokumentu() {
			$id = -1;
			if (virgoRodzajDokumentu::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_RODZAJ_DOKUMENTU");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['dks_rodzajDokumentu_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_dokumenty_ksiegowe` (
  `dks_id` bigint(20) unsigned NOT NULL auto_increment,
  `dks_virgo_state` varchar(50) default NULL,
  `dks_virgo_title` varchar(255) default NULL,
	`dks_rdk_id` int(11) default NULL,
  `dks_bufor` boolean,  
  `dks_data_operacji` date, 
  `dks_data_wystawienia` date, 
  `dks_numer` varchar(255), 
  `dks_date_created` datetime NOT NULL,
  `dks_date_modified` datetime default NULL,
  `dks_usr_created_id` int(11) NOT NULL,
  `dks_usr_modified_id` int(11) default NULL,
  KEY `dks_rdk_fk` (`dks_rdk_id`),
  PRIMARY KEY  (`dks_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/dokument_ksiegowy.sql 
INSERT INTO `slk_dokumenty_ksiegowe` (`dks_virgo_title`, `dks_bufor`, `dks_data_operacji`, `dks_data_wystawienia`, `dks_numer`) 
VALUES (title, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_dokumenty_ksiegowe table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyNumer($numer) {
			$query = " SELECT dks_id FROM slk_dokumenty_ksiegowe WHERE 1 ";
			$query .= " AND dks_numer = '{$numer}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['dks_id'];
			}
			return null;
		}

		static function getByKeyNumer($numer) {
			$id = self::getIdByKeyNumer($numer);
			$ret = new virgoDokumentKsiegowy();
			if (isset($id)) {
				$ret->load($id);
			}
			return $ret;
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
			return "dks";
		}
		
		static function getPlural() {
			return "dokumenty_ksiegowe";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoRodzajDokumentu";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPozycjaDokumentu";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_dokumenty_ksiegowe'));
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
			$virgoVersion = virgoDokumentKsiegowy::getVirgoVersion();
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
	
	
