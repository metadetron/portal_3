<?php
/**
* Module Status zamówienia
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowieniaWorkflow'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowieniaWorkflow'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoStatusZamowienia {

		 private  $szm_id = null;
		 private  $szm_kod = null;

		 private  $szm_nazwa = null;

		 private  $szm_opis = null;

		 private  $szm_kolejnosc_wyswietlania = null;


		 private   $_statusZamowieniaPrevIdsToAddArray = null;
		 private   $_statusZamowieniaPrevIdsToDeleteArray = null;
		 private   $_statusZamowieniaNextIdsToAddArray = null;
		 private   $_statusZamowieniaNextIdsToDeleteArray = null;
		 private   $szm_date_created = null;
		 private   $szm_usr_created_id = null;
		 private   $szm_date_modified = null;
		 private   $szm_usr_modified_id = null;
		 private   $szm_virgo_title = null;
		 private   $szm_virgo_deleted = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->szm_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoStatusZamowienia();
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
        	$this->szm_id = null;
		    $this->szm_date_created = null;
		    $this->szm_usr_created_id = null;
		    $this->szm_date_modified = null;
		    $this->szm_usr_modified_id = null;
		    $this->szm_virgo_title = null;
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
			return $this->szm_id;
		}

		function getKod() {
			return $this->szm_kod;
		}
		
		 private  function setKod($val) {
			$this->szm_kod = $val;
		}
		function getNazwa() {
			return $this->szm_nazwa;
		}
		
		 private  function setNazwa($val) {
			$this->szm_nazwa = $val;
		}
		function getOpis() {
			return $this->szm_opis;
		}
		
		 private  function setOpis($val) {
			$this->szm_opis = $val;
		}
		function getKolejnoscWyswietlania() {
			return $this->szm_kolejnosc_wyswietlania;
		}
		
		 private  function setKolejnoscWyswietlania($val) {
			$this->szm_kolejnosc_wyswietlania = $val;
		}


		function getDateCreated() {
			return $this->szm_date_created;
		}
		function getUsrCreatedId() {
			return $this->szm_usr_created_id;
		}
		function getDateModified() {
			return $this->szm_date_modified;
		}
		function getUsrModifiedId() {
			return $this->szm_usr_modified_id;
		}



		function getOpisSnippet($wordCount) {
			if (is_null($this->getOpis()) || trim($this->getOpis()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getOpis(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function loadRecordFromRequest($rowId) {
			$this->szm_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('szm_kod_' . $this->szm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->szm_kod = null;
		} else {
			$this->szm_kod = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('szm_nazwa_' . $this->szm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->szm_nazwa = null;
		} else {
			$this->szm_nazwa = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('szm_opis_' . $this->szm_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->szm_opis = null;
		} else {
			$this->szm_opis = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('szm_kolejnoscWyswietlania_' . $this->szm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->szm_kolejnosc_wyswietlania = null;
		} else {
			$this->szm_kolejnosc_wyswietlania = $tmpValue;
		}
	}
			$tmp_ids = R('szm_statusZamowieniaWorkflowNext_' . $this->szm_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_statusZamowieniaPrevIdsToAddArray = $tmp_ids;
				$this->_statusZamowieniaPrevIdsToDeleteArray = array();
				$currentConnections = $this->getStatusZamowieniaWorkflowsNext();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getStatusZamowieniaPrevId(), $tmp_ids)) {
						foreach($this->_statusZamowieniaPrevIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getStatusZamowieniaPrevId()) {
								unset($this->_statusZamowieniaPrevIdsToAddArray[$key]);
							}
						}
						$this->_statusZamowieniaPrevIdsToAddArray = array_values($this->_statusZamowieniaPrevIdsToAddArray);
					} else {
						$this->_statusZamowieniaPrevIdsToDeleteArray[] = $currentConnection->getStatusZamowieniaPrevId();
					}
				}
			}
			$tmp_ids = R('szm_statusZamowieniaWorkflowPrev_' . $this->szm_id, null); 			if (is_null($tmp_ids)) {
				$tmp_ids = array();
			}
			if (is_array($tmp_ids)) { 
				$this->_statusZamowieniaNextIdsToAddArray = $tmp_ids;
				$this->_statusZamowieniaNextIdsToDeleteArray = array();
				$currentConnections = $this->getStatusZamowieniaWorkflowsPrev();
				foreach ($currentConnections as $currentConnection) {
					if (in_array($currentConnection->getStatusZamowieniaNextId(), $tmp_ids)) {
						foreach($this->_statusZamowieniaNextIdsToAddArray as $key => $value) {
							if ($value == $currentConnection->getStatusZamowieniaNextId()) {
								unset($this->_statusZamowieniaNextIdsToAddArray[$key]);
							}
						}
						$this->_statusZamowieniaNextIdsToAddArray = array_values($this->_statusZamowieniaNextIdsToAddArray);
					} else {
						$this->_statusZamowieniaNextIdsToDeleteArray[] = $currentConnection->getStatusZamowieniaNextId();
					}
				}
			}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('szm_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaStatusZamowienia = array();	
			$criteriaFieldStatusZamowienia = array();	
			$isNullStatusZamowienia = R('virgo_search_kod_is_null');
			
			$criteriaFieldStatusZamowienia["is_null"] = 0;
			if ($isNullStatusZamowienia == "not_null") {
				$criteriaFieldStatusZamowienia["is_null"] = 1;
			} elseif ($isNullStatusZamowienia == "null") {
				$criteriaFieldStatusZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_kod');

//			if ($isSet) {
			$criteriaFieldStatusZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaStatusZamowienia["kod"] = $criteriaFieldStatusZamowienia;
			$criteriaFieldStatusZamowienia = array();	
			$isNullStatusZamowienia = R('virgo_search_nazwa_is_null');
			
			$criteriaFieldStatusZamowienia["is_null"] = 0;
			if ($isNullStatusZamowienia == "not_null") {
				$criteriaFieldStatusZamowienia["is_null"] = 1;
			} elseif ($isNullStatusZamowienia == "null") {
				$criteriaFieldStatusZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_nazwa');

//			if ($isSet) {
			$criteriaFieldStatusZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaStatusZamowienia["nazwa"] = $criteriaFieldStatusZamowienia;
			$criteriaFieldStatusZamowienia = array();	
			$isNullStatusZamowienia = R('virgo_search_opis_is_null');
			
			$criteriaFieldStatusZamowienia["is_null"] = 0;
			if ($isNullStatusZamowienia == "not_null") {
				$criteriaFieldStatusZamowienia["is_null"] = 1;
			} elseif ($isNullStatusZamowienia == "null") {
				$criteriaFieldStatusZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_opis');

//			if ($isSet) {
			$criteriaFieldStatusZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaStatusZamowienia["opis"] = $criteriaFieldStatusZamowienia;
			$criteriaFieldStatusZamowienia = array();	
			$isNullStatusZamowienia = R('virgo_search_kolejnoscWyswietlania_is_null');
			
			$criteriaFieldStatusZamowienia["is_null"] = 0;
			if ($isNullStatusZamowienia == "not_null") {
				$criteriaFieldStatusZamowienia["is_null"] = 1;
			} elseif ($isNullStatusZamowienia == "null") {
				$criteriaFieldStatusZamowienia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_kolejnoscWyswietlania_from');
		$dataTypeCriteria["to"] = R('virgo_search_kolejnoscWyswietlania_to');

//			if ($isSet) {
			$criteriaFieldStatusZamowienia["value"] = $dataTypeCriteria;
//			}
			$criteriaStatusZamowienia["kolejnosc_wyswietlania"] = $criteriaFieldStatusZamowienia;
			$parent = R('virgo_search_statusZamowieniaNext', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaStatusZamowienia["status_zamowienianext"] = $criteriaParent;
			}
			$parent = R('virgo_search_statusZamowieniaPrev', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
				$criteriaStatusZamowienia["status_zamowieniaprev"] = $criteriaParent;
			}
			self::setCriteria($criteriaStatusZamowienia);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_kod');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKod', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKod', null);
			}
			$tableFilter = R('virgo_filter_nazwa');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNazwa', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNazwa', null);
			}
			$tableFilter = R('virgo_filter_opis');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOpis', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOpis', null);
			}
			$tableFilter = R('virgo_filter_kolejnosc_wyswietlania');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKolejnoscWyswietlania', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKolejnoscWyswietlania', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseStatusZamowienia = ' 1 = 1 ';
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
				$eventColumn = "szm_" . P('event_column');
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaStatusZamowienia = self::getCriteria();
			if (isset($criteriaStatusZamowienia["kod"])) {
				$fieldCriteriaKod = $criteriaStatusZamowienia["kod"];
				if ($fieldCriteriaKod["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kod IS NOT NULL ';
				} elseif ($fieldCriteriaKod["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kod IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKod["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_kod like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaStatusZamowienia["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaStatusZamowienia["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaStatusZamowienia["opis"])) {
				$fieldCriteriaOpis = $criteriaStatusZamowienia["opis"];
				if ($fieldCriteriaOpis["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_opis IS NOT NULL ';
				} elseif ($fieldCriteriaOpis["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_opis IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOpis["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_opis like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaStatusZamowienia["kolejnosc_wyswietlania"])) {
				$fieldCriteriaKolejnoscWyswietlania = $criteriaStatusZamowienia["kolejnosc_wyswietlania"];
				if ($fieldCriteriaKolejnoscWyswietlania["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania IS NOT NULL ';
				} elseif ($fieldCriteriaKolejnoscWyswietlania["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKolejnoscWyswietlania["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania = ? ";
				} else {
					$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaStatusZamowienia["status_zamowienianext"])) {
				$parentCriteria = $criteriaStatusZamowienia["status_zamowienianext"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND slk_statusy_zamowien.szm_id IN (SELECT second_parent.szw_szm_id FROM slk_status_zamowienia_workflows AS second_parent WHERE second_parent.szw_szm_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			if (isset($criteriaStatusZamowienia["status_zamowieniaprev"])) {
				$parentCriteria = $criteriaStatusZamowienia["status_zamowieniaprev"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND slk_statusy_zamowien.szm_id IN (SELECT second_parent.szw_szm_id FROM slk_status_zamowienia_workflows AS second_parent WHERE second_parent.szw_szm_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterKod', null);
				if (S($tableFilter)) {
					$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND szm_kod LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterNazwa', null);
				if (S($tableFilter)) {
					$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND szm_nazwa LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOpis', null);
				if (S($tableFilter)) {
					$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND szm_opis LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterKolejnoscWyswietlania', null);
				if (S($tableFilter)) {
					$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND szm_kolejnosc_wyswietlania LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseStatusZamowienia;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseStatusZamowienia = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_statusy_zamowien.szm_id, slk_statusy_zamowien.szm_virgo_title ";
			$queryString = $queryString . " ,slk_statusy_zamowien.szm_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'szm_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_table_kod', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kod szm_kod";
			} else {
				if ($defaultOrderColumn == "szm_kod") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kod ";
				}
			}
			if (P('show_table_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_nazwa szm_nazwa";
			} else {
				if ($defaultOrderColumn == "szm_nazwa") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_nazwa ";
				}
			}
			if (P('show_table_opis', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_opis szm_opis";
			} else {
				if ($defaultOrderColumn == "szm_opis") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_opis ";
				}
			}
			if (P('show_table_kolejnosc_wyswietlania', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kolejnosc_wyswietlania szm_kolejnosc_wyswietlania";
			} else {
				if ($defaultOrderColumn == "szm_kolejnosc_wyswietlania") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kolejnosc_wyswietlania ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_statusy_zamowien ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseStatusZamowienia, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseStatusZamowienia,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_statusy_zamowien"
			;
			$componentParams = null;
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
				. "\n FROM slk_statusy_zamowien"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_statusy_zamowien ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_statusy_zamowien ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, szm_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
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
				$query = "SELECT COUNT(szm_id) cnt FROM statusy_zamowien";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as statusy_zamowien ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as statusy_zamowien ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoStatusZamowienia();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_statusy_zamowien WHERE szm_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->szm_id = $row['szm_id'];
$this->szm_kod = $row['szm_kod'];
$this->szm_nazwa = $row['szm_nazwa'];
$this->szm_opis = $row['szm_opis'];
$this->szm_kolejnosc_wyswietlania = $row['szm_kolejnosc_wyswietlania'];
						if ($fetchUsernames) {
							if ($row['szm_date_created']) {
								if ($row['szm_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['szm_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['szm_date_modified']) {
								if ($row['szm_usr_modified_id'] == $row['szm_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['szm_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['szm_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->szm_date_created = $row['szm_date_created'];
						$this->szm_usr_created_id = $fetchUsernames ? $createdBy : $row['szm_usr_created_id'];
						$this->szm_date_modified = $row['szm_date_modified'];
						$this->szm_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['szm_usr_modified_id'];
						$this->szm_virgo_title = $row['szm_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_statusy_zamowien SET szm_usr_created_id = {$userId} WHERE szm_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->szm_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoStatusZamowienia::selectAllAsObjectsStatic('szm_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->szm_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->szm_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('szm_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_szm = new virgoStatusZamowienia();
				$tmp_szm->load((int)$lookup_id);
				return $tmp_szm->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoStatusZamowienia');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" szm_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoStatusZamowienia', "10");
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
				$query = $query . " szm_id as id, szm_virgo_title as title ";
			}
			$query = $query . " FROM slk_statusy_zamowien ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			$query = $query . " AND (szm_virgo_deleted IS NULL OR szm_virgo_deleted = 0) ";
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY szm_kolejnosc_wyswietlania ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resStatusZamowienia = array();
				foreach ($rows as $row) {
					$resStatusZamowienia[$row['id']] = $row['title'];
				}
				return $resStatusZamowienia;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticStatusZamowienia = new virgoStatusZamowienia();
			return $staticStatusZamowienia->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getZamowieniaStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resZamowienie = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resZamowienie;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resZamowienie;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsZamowienie = virgoZamowienie::selectAll('zmw_szm_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsZamowienie as $resultZamowienie) {
				$tmpZamowienie = virgoZamowienie::getById($resultZamowienie['zmw_id']); 
				array_push($resZamowienie, $tmpZamowienie);
			}
			return $resZamowienie;
		}

		function getZamowienia($orderBy = '', $extraWhere = null) {
			return virgoStatusZamowienia::getZamowieniaStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getStatusZamowieniaWorkflowsNextStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resStatusZamowieniaWorkflow = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowieniaWorkflow'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resStatusZamowieniaWorkflow;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resStatusZamowieniaWorkflow;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsStatusZamowieniaWorkflowNext = virgoStatusZamowieniaWorkflow::selectAll('szw_szm_next_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsStatusZamowieniaWorkflowNext as $resultStatusZamowieniaWorkflowNext) {
				$tmpStatusZamowieniaWorkflowNext = virgoStatusZamowieniaWorkflow::getById($resultStatusZamowieniaWorkflowNext['szw_id']); 
				array_push($resStatusZamowieniaWorkflow, $tmpStatusZamowieniaWorkflowNext);
			}
			return $resStatusZamowieniaWorkflow;
		}

		function getStatusZamowieniaWorkflowsNext($orderBy = '', $extraWhere = null) {
			return virgoStatusZamowienia::getStatusZamowieniaWorkflowsNextStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getStatusZamowieniaWorkflowsPrevStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resStatusZamowieniaWorkflow = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowieniaWorkflow'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resStatusZamowieniaWorkflow;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resStatusZamowieniaWorkflow;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsStatusZamowieniaWorkflowPrev = virgoStatusZamowieniaWorkflow::selectAll('szw_szm_prev_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsStatusZamowieniaWorkflowPrev as $resultStatusZamowieniaWorkflowPrev) {
				$tmpStatusZamowieniaWorkflowPrev = virgoStatusZamowieniaWorkflow::getById($resultStatusZamowieniaWorkflowPrev['szw_id']); 
				array_push($resStatusZamowieniaWorkflow, $tmpStatusZamowieniaWorkflowPrev);
			}
			return $resStatusZamowieniaWorkflow;
		}

		function getStatusZamowieniaWorkflowsPrev($orderBy = '', $extraWhere = null) {
			return virgoStatusZamowienia::getStatusZamowieniaWorkflowsPrevStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getKod()) || trim($this->getKod()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'KOD');
			}			
			if (
(is_null($this->getNazwa()) || trim($this->getNazwa()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAZWA');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_opis_obligatory', "0") == "1") {
				if (
(is_null($this->getOpis()) || trim($this->getOpis()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'OPIS');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_kolejnosc_wyswietlania_obligatory', "0") == "1") {
				if (
(is_null($this->getKolejnoscWyswietlania()) || trim($this->getKolejnoscWyswietlania()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'KOLEJNOSC_WYSWIETLANIA');
				}			
			}
 			if (!is_null($this->szm_kolejnosc_wyswietlania) && trim($this->szm_kolejnosc_wyswietlania) != "") {
				if (!is_numeric($this->szm_kolejnosc_wyswietlania)) {
					return T('INCORRECT_NUMBER', 'KOLEJNOSC_WYSWIETLANIA', $this->szm_kolejnosc_wyswietlania);
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->szm_id) && $this->szm_id != 0) {
			$uniqnessWhere = " szm_id != " . $this->szm_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(szm_kod) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->szm_kod;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM slk_statusy_zamowien ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('KOD');
				$values[] = $this->szm_kod; 
				return T('UNIQNESS_FAILED', 'STATUS_ZAMOWIENIA', implode(', ', $colNames), implode(', ', $values));
			}
		}
		$uniqnessWhere = " 1 = 1 ";
		if (!is_null($this->szm_id) && $this->szm_id != 0) {
			$uniqnessWhere = " szm_id != " . $this->szm_id . " ";			
		}
 		if (!$skipUniquenessCheck) {
 			if (!$skipUniquenessCheck) {
			$uniqnessWhere = $uniqnessWhere . ' AND UPPER(szm_nazwa) = UPPER(?) ';
			$types .= "s";
			$values[] = $this->szm_nazwa;
			}
 		}	
 		if (!$skipUniquenessCheck) {	
			$query = " SELECT COUNT(*) FROM slk_statusy_zamowien ";
			$query = $query . " WHERE " . $uniqnessWhere;
			$result = QPL($query, $types, $values);
			if ($result[0] > 0) {
				$valeus = array();
				$colNames = array();
				$colNames[] = T('NAZWA');
				$values[] = $this->szm_nazwa; 
				return T('UNIQNESS_FAILED', 'STATUS_ZAMOWIENIA', implode(', ', $colNames), implode(', ', $values));
			}
		}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_statusy_zamowien WHERE szm_id = " . $this->getId();
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
				$colNames = $colNames . ", szm_kod";
				$values = $values . ", " . (is_null($objectToStore->getKod()) ? "null" : "'" . QE($objectToStore->getKod()) . "'");
				$colNames = $colNames . ", szm_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				$colNames = $colNames . ", szm_opis";
				$values = $values . ", " . (is_null($objectToStore->getOpis()) ? "null" : "'" . QE($objectToStore->getOpis()) . "'");
				$colNames = $colNames . ", szm_kolejnosc_wyswietlania";
				$values = $values . ", " . (is_null($objectToStore->getKolejnoscWyswietlania()) ? "null" : "'" . QE($objectToStore->getKolejnoscWyswietlania()) . "'");
				$query = "INSERT INTO slk_history_statusy_zamowien (revision, ip, username, user_id, timestamp, szm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getKod() != $objectToStore->getKod()) {
				if (is_null($objectToStore->getKod())) {
					$nullifiedProperties = $nullifiedProperties . "kod,";
				} else {
				$colNames = $colNames . ", szm_kod";
				$values = $values . ", " . (is_null($objectToStore->getKod()) ? "null" : "'" . QE($objectToStore->getKod()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getNazwa() != $objectToStore->getNazwa()) {
				if (is_null($objectToStore->getNazwa())) {
					$nullifiedProperties = $nullifiedProperties . "nazwa,";
				} else {
				$colNames = $colNames . ", szm_nazwa";
				$values = $values . ", " . (is_null($objectToStore->getNazwa()) ? "null" : "'" . QE($objectToStore->getNazwa()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOpis() != $objectToStore->getOpis()) {
				if (is_null($objectToStore->getOpis())) {
					$nullifiedProperties = $nullifiedProperties . "opis,";
				} else {
				$colNames = $colNames . ", szm_opis";
				$values = $values . ", " . (is_null($objectToStore->getOpis()) ? "null" : "'" . QE($objectToStore->getOpis()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getKolejnoscWyswietlania() != $objectToStore->getKolejnoscWyswietlania()) {
				if (is_null($objectToStore->getKolejnoscWyswietlania())) {
					$nullifiedProperties = $nullifiedProperties . "kolejnosc_wyswietlania,";
				} else {
				$colNames = $colNames . ", szm_kolejnosc_wyswietlania";
				$values = $values . ", " . (is_null($objectToStore->getKolejnoscWyswietlania()) ? "null" : "'" . QE($objectToStore->getKolejnoscWyswietlania()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO slk_history_statusy_zamowien (revision, ip, username, user_id, timestamp, szm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_statusy_zamowien");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'szm_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_statusy_zamowien ADD COLUMN (szm_virgo_title VARCHAR(255));";
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
			if (isset($this->szm_id) && $this->szm_id != "") {
				$query = "UPDATE slk_statusy_zamowien SET ";
			if (isset($this->szm_kod)) {
				$query .= " szm_kod = ? ,";
				$types .= "s";
				$values[] = $this->szm_kod;
			} else {
				$query .= " szm_kod = NULL ,";				
			}
			if (isset($this->szm_nazwa)) {
				$query .= " szm_nazwa = ? ,";
				$types .= "s";
				$values[] = $this->szm_nazwa;
			} else {
				$query .= " szm_nazwa = NULL ,";				
			}
			if (isset($this->szm_opis)) {
				$query .= " szm_opis = ? ,";
				$types .= "s";
				$values[] = $this->szm_opis;
			} else {
				$query .= " szm_opis = NULL ,";				
			}
			if (isset($this->szm_kolejnosc_wyswietlania)) {
				$query .= " szm_kolejnosc_wyswietlania = ? ,";
				$types .= "i";
				$values[] = $this->szm_kolejnosc_wyswietlania;
			} else {
				$query .= " szm_kolejnosc_wyswietlania = NULL ,";				
			}
				if (isset($this->szm_virgo_deleted)) {
					$query = $query . " szm_virgo_deleted = ? , ";
					$types = $types . "i";
					$values[] = $this->szm_virgo_deleted;
				} else {
					$query = $query . " szm_virgo_deleted = NULL , ";
				}
				$query = $query . " szm_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " szm_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->szm_date_modified;

				$query = $query . " szm_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->szm_usr_modified_id;

				$query = $query . " WHERE szm_id = ? ";
				$types = $types . "i";
				$values[] = $this->szm_id;
			} else {
				$query = "INSERT INTO slk_statusy_zamowien ( ";
			$query = $query . " szm_kod, ";
			$query = $query . " szm_nazwa, ";
			$query = $query . " szm_opis, ";
			$query = $query . " szm_kolejnosc_wyswietlania, ";
				$query = $query . " szm_virgo_title, szm_date_created, szm_usr_created_id) VALUES ( ";
			if (isset($this->szm_kod)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->szm_kod;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->szm_nazwa)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->szm_nazwa;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->szm_opis)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->szm_opis;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->szm_kolejnosc_wyswietlania)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->szm_kolejnosc_wyswietlania;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->szm_date_created;
				$values[] = $this->szm_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->szm_id) || $this->szm_id == "") {
					$this->szm_id = QID();
				}
				if ($log) {
					L("status zam\u00F3wienia stored successfully", "id = {$this->szm_id}", "TRACE");
				}
				return true;
			}
		}
		

		static function addStatusZamowieniaPrevStatic($thisId, $id) {
			$query = " SELECT COUNT(szw_id) AS cnt FROM slk_status_zamowienia_workflows WHERE szw_szm_next_id = {$thisId} AND szw_szm_prev_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newStatusZamowieniaWorkflow = new virgoStatusZamowieniaWorkflow();
				$newStatusZamowieniaWorkflow->setStatusZamowieniaPrevId($id);
				$newStatusZamowieniaWorkflow->setStatusZamowieniaNextId($thisId);
				return $newStatusZamowieniaWorkflow->store();
			}			
			return "";
		}
		
		function addStatusZamowieniaPrev($id) {
			return virgoStatusZamowienia::addStatusZamowieniaPrevStatic($this->getId(), $id);
		}
		
		static function removeStatusZamowieniaPrevStatic($thisId, $id) {
			$query = " SELECT szw_id AS id FROM slk_status_zamowienia_workflows WHERE szw_szm_next_id = {$thisId} AND szw_szm_prev_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newStatusZamowieniaWorkflow = new virgoStatusZamowieniaWorkflow($re['id']);
				return $newStatusZamowieniaWorkflow->delete();
			}			
			return "";
		}
		
		function removeStatusZamowieniaPrev($id) {
			return virgoStatusZamowienia::removeStatusZamowieniaPrevStatic($this->getId(), $id);
		}

		static function addStatusZamowieniaNextStatic($thisId, $id) {
			$query = " SELECT COUNT(szw_id) AS cnt FROM slk_status_zamowienia_workflows WHERE szw_szm_prev_id = {$thisId} AND szw_szm_next_id = {$id} ";
			$res = Q1($query);
			if ($res == 0) {
				$newStatusZamowieniaWorkflow = new virgoStatusZamowieniaWorkflow();
				$newStatusZamowieniaWorkflow->setStatusZamowieniaNextId($id);
				$newStatusZamowieniaWorkflow->setStatusZamowieniaPrevId($thisId);
				return $newStatusZamowieniaWorkflow->store();
			}			
			return "";
		}
		
		function addStatusZamowieniaNext($id) {
			return virgoStatusZamowienia::addStatusZamowieniaNextStatic($this->getId(), $id);
		}
		
		static function removeStatusZamowieniaNextStatic($thisId, $id) {
			$query = " SELECT szw_id AS id FROM slk_status_zamowienia_workflows WHERE szw_szm_prev_id = {$thisId} AND szw_szm_next_id = {$id} ";
			$res = QR($query);
			foreach ($res as $re) {
				$newStatusZamowieniaWorkflow = new virgoStatusZamowieniaWorkflow($re['id']);
				return $newStatusZamowieniaWorkflow->delete();
			}			
			return "";
		}
		
		function removeStatusZamowieniaNext($id) {
			return virgoStatusZamowienia::removeStatusZamowieniaNextStatic($this->getId(), $id);
		}
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->szm_id) {
				$virgoOld = new virgoStatusZamowienia($this->szm_id);
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
					if ($this->szm_id) {			
						$this->szm_date_modified = date("Y-m-d H:i:s");
						$this->szm_usr_modified_id = $userId;
					} else {
						$this->szm_date_created = date("Y-m-d H:i:s");
						$this->szm_usr_created_id = $userId;
					}
					$this->szm_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "status zam\u00F3wienia" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "status zam\u00F3wienia" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					if (!is_null($this->_statusZamowieniaPrevIdsToAddArray)) {
						foreach ($this->_statusZamowieniaPrevIdsToAddArray as $statusZamowieniaPrevId) {
							$ret = $this->addStatusZamowieniaPrev((int)$statusZamowieniaPrevId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_statusZamowieniaPrevIdsToDeleteArray)) {
						foreach ($this->_statusZamowieniaPrevIdsToDeleteArray as $statusZamowieniaPrevId) {
							$ret = $this->removeStatusZamowieniaPrev((int)$statusZamowieniaPrevId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_statusZamowieniaNextIdsToAddArray)) {
						foreach ($this->_statusZamowieniaNextIdsToAddArray as $statusZamowieniaNextId) {
							$ret = $this->addStatusZamowieniaNext((int)$statusZamowieniaNextId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
						}
					}
					if (!is_null($this->_statusZamowieniaNextIdsToDeleteArray)) {
						foreach ($this->_statusZamowieniaNextIdsToDeleteArray as $statusZamowieniaNextId) {
							$ret = $this->removeStatusZamowieniaNext((int)$statusZamowieniaNextId);
							if ($ret != "") {
								L($ret, '', 'ERROR');
							}
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
			$query = "DELETE FROM slk_statusy_zamowien WHERE szm_id = {$this->szm_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->szm_virgo_deleted = true;
			$this->szm_date_modified = date("Y-m-d H:i:s");
			$userId = virgoUser::getUserId();
			$this->szm_usr_modified_id = $userId;
			$this->parentStore(true);
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoStatusZamowienia();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT szm_id as id FROM slk_statusy_zamowien";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'szm_order_column')) {
				$orderBy = " ORDER BY szm_order_column ASC ";
			} 
			if (property_exists($this, 'szm_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY szm_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoStatusZamowienia();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoStatusZamowienia($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_statusy_zamowien SET szm_virgo_title = '$title' WHERE szm_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByKodStatic($token) {
			$tmpStatic = new virgoStatusZamowienia();
			$tmpId = $tmpStatic->getIdByKod($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByKodStatic($token) {
			$tmpStatic = new virgoStatusZamowienia();
			return $tmpStatic->getIdByKod($token);
		}
		
		function getIdByKod($token) {
			$res = $this->selectAll(" szm_kod = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['szm_id'];
			}
			return null;
		}
		static function getByNazwaStatic($token) {
			$tmpStatic = new virgoStatusZamowienia();
			$tmpId = $tmpStatic->getIdByNazwa($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNazwaStatic($token) {
			$tmpStatic = new virgoStatusZamowienia();
			return $tmpStatic->getIdByNazwa($token);
		}
		
		function getIdByNazwa($token) {
			$res = $this->selectAll(" szm_nazwa = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['szm_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoStatusZamowienia();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" szm_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['szm_id'];
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
			virgoStatusZamowienia::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoStatusZamowienia::setSessionValue('Sealock_StatusZamowienia-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoStatusZamowienia::getSessionValue('Sealock_StatusZamowienia-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoStatusZamowienia::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoStatusZamowienia::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoStatusZamowienia::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoStatusZamowienia::getSessionValue('GLOBAL', $name, $default);
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
			$context['szm_id'] = $id;
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
			$context['szm_id'] = null;
			virgoStatusZamowienia::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoStatusZamowienia::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoStatusZamowienia::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoStatusZamowienia::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoStatusZamowienia::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoStatusZamowienia::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoStatusZamowienia::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoStatusZamowienia::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoStatusZamowienia::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoStatusZamowienia::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoStatusZamowienia::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoStatusZamowienia::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoStatusZamowienia::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoStatusZamowienia::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoStatusZamowienia::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoStatusZamowienia::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoStatusZamowienia::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'szm_kolejnosc_wyswietlania');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "szm_id";
			}
			return virgoStatusZamowienia::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoStatusZamowienia::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoStatusZamowienia::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoStatusZamowienia::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoStatusZamowienia::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoStatusZamowienia::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoStatusZamowienia::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoStatusZamowienia::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoStatusZamowienia::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoStatusZamowienia::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoStatusZamowienia::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoStatusZamowienia::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoStatusZamowienia::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->szm_id) {
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
						L(T('STORED_CORRECTLY', 'STATUS_ZAMOWIENIA'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'kod', $this->szm_kod);
						$fieldValues = $fieldValues . T($fieldValue, 'nazwa', $this->szm_nazwa);
						$fieldValues = $fieldValues . T($fieldValue, 'opis', $this->szm_opis);
						$fieldValues = $fieldValues . T($fieldValue, 'kolejność wyświetlania', $this->szm_kolejnosc_wyswietlania);
						$username = '';
						if ($this->szm_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->szm_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->szm_date_created);
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
			$instance = new virgoStatusZamowienia();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowienia'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_zamowienia') == "1") {
				$tmpZamowienie = new virgoZamowienie();
				$deleteZamowienie = R('DELETE');
				if (sizeof($deleteZamowienie) > 0) {
					virgoZamowienie::multipleDelete($deleteZamowienie);
				}
				$resIds = $tmpZamowienie->select(null, 'all', null, null, ' zmw_szm_id = ' . $instance->getId(), ' SELECT zmw_id FROM slk_zamowienia ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->zmw_id;
//					JRequest::setVar('zmw_status_zamowienia_' . $resId->zmw_id, $this->getId());
				} 
//				JRequest::setVar('zmw_status_zamowienia_', $instance->getId());
				$tmpZamowienie->setRecordSet($resIdsString);
				if (!$tmpZamowienie->portletActionStoreSelected()) {
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
			$instance = new virgoStatusZamowienia();
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
			$tmpId = intval(R('szm_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoStatusZamowienia::getContextId();
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
			$this->szm_id = null;
			$this->szm_date_created = null;
			$this->szm_usr_created_id = null;
			$this->szm_date_modified = null;
			$this->szm_usr_modified_id = null;
			$this->szm_virgo_title = null;
			$this->szm_virgo_deleted = null;
			
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



		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoStatusZamowienia();
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
				$instance = new virgoStatusZamowienia();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoStatusZamowienia::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'STATUS_ZAMOWIENIA'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		static function portletActionVirgoUp() {
			$instance = new virgoStatusZamowienia();
			$instance->loadFromDB();
			$idToSwapWith = R('virgo_swap_up_with_' . $instance->getId());
			$objectToSwapWith = new virgoStatusZamowienia($idToSwapWith);
			$val1 = $instance->getKolejnoscWyswietlania();
			$val2 = $objectToSwapWith->getKolejnoscWyswietlania();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 + 1;
			}
			$objectToSwapWith->setKolejnoscWyswietlania($val1);
			$instance->setKolejnoscWyswietlania($val2);
			$objectToSwapWith->store(false);
			$instance->store(false);
			$instance->putInContext();
			return 0;
		}
		
		static function portletActionVirgoDown() {
			$instance = new virgoStatusZamowienia();
			$instance->loadFromDB();
			$idToSwapWith = R('virgo_swap_down_with_' . $instance->getId());
			$objectToSwapWith = new virgoStatusZamowienia($idToSwapWith);
			$val1 = $instance->getKolejnoscWyswietlania();
			$val2 = $objectToSwapWith->getKolejnoscWyswietlania();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 - 1;
			}
			$objectToSwapWith->setKolejnoscWyswietlania($val1);
			$instance->setKolejnoscWyswietlania($val2);
			$objectToSwapWith->store(false);
			$instance->store(false);
			$instance->putInContext();
			return 0;
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
				$resultStatusZamowienia = new virgoStatusZamowienia();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultStatusZamowienia->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultStatusZamowienia->load($idToEditInt);
					} else {
						$resultStatusZamowienia->szm_id = 0;
					}
				}
				$results[] = $resultStatusZamowienia;
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
				$result = new virgoStatusZamowienia();
				$result->loadFromRequest($idToStore);
				if ($result->szm_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->szm_id == 0) {
						$result->szm_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->szm_id)) {
							$result->szm_id = 0;
						}
						$idsToCorrect[$result->szm_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'STATUSY_ZAMOWIEN'), '', 'INFO');
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
			$resultStatusZamowienia = new virgoStatusZamowienia();
			foreach ($idsToDelete as $idToDelete) {
				$resultStatusZamowienia->load((int)trim($idToDelete));
				$res = $resultStatusZamowienia->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'STATUSY_ZAMOWIEN'), '', 'INFO');			
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
		$ret = $this->szm_nazwa;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoStatusZamowienia');
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
				$query = "UPDATE slk_statusy_zamowien SET szm_virgo_title = ? WHERE szm_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT szm_id AS id FROM slk_statusy_zamowien ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoStatusZamowienia($row['id']);
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
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_statusy_zamowien.szm_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_statusy_zamowien.szm_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_statusy_zamowien.szm_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_statusy_zamowien.szm_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoStatusZamowienia!', '', 'ERROR');
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
			$pdf->SetTitle('Statusy zamówień report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('STATUSY_ZAMOWIEN');
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
			if (P('show_pdf_kod', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_opis', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultStatusZamowienia = new virgoStatusZamowienia();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_kod', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Kod');
				$minWidth['kod'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['kod']) {
						$minWidth['kod'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Nazwa');
				$minWidth['nazwa'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['nazwa']) {
						$minWidth['nazwa'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_opis', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Opis');
				$minWidth['opis'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['opis']) {
						$minWidth['opis'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Kolejność wyświetlania');
				$minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['kolejno\u015B\u0107 wy\u015Bwietlania']) {
						$minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'] = min($tmpLen, $maxWidth);
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
			$whereClauseStatusZamowienia = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaStatusZamowienia = $resultStatusZamowienia->getCriteria();
			$fieldCriteriaKod = $criteriaStatusZamowienia["kod"];
			if ($fieldCriteriaKod["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Kod', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKod["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Kod', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaNazwa = $criteriaStatusZamowienia["nazwa"];
			if ($fieldCriteriaNazwa["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Nazwa', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaNazwa["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Nazwa', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOpis = $criteriaStatusZamowienia["opis"];
			if ($fieldCriteriaOpis["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Opis', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaOpis["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Opis', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaKolejnoscWyswietlania = $criteriaStatusZamowienia["kolejnosc_wyswietlania"];
			if ($fieldCriteriaKolejnoscWyswietlania["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Kolejność wyświetlania', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKolejnoscWyswietlania["value"];
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
					$pdf->MultiCell(60, 100, 'Kolejność wyświetlania', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaStatusZamowienia = self::getCriteria();
			if (isset($criteriaStatusZamowienia["kod"])) {
				$fieldCriteriaKod = $criteriaStatusZamowienia["kod"];
				if ($fieldCriteriaKod["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kod IS NOT NULL ';
				} elseif ($fieldCriteriaKod["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kod IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKod["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_kod like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaStatusZamowienia["nazwa"])) {
				$fieldCriteriaNazwa = $criteriaStatusZamowienia["nazwa"];
				if ($fieldCriteriaNazwa["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_nazwa IS NOT NULL ';
				} elseif ($fieldCriteriaNazwa["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_nazwa IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNazwa["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_nazwa like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaStatusZamowienia["opis"])) {
				$fieldCriteriaOpis = $criteriaStatusZamowienia["opis"];
				if ($fieldCriteriaOpis["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_opis IS NOT NULL ';
				} elseif ($fieldCriteriaOpis["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_opis IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOpis["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_opis like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaStatusZamowienia["kolejnosc_wyswietlania"])) {
				$fieldCriteriaKolejnoscWyswietlania = $criteriaStatusZamowienia["kolejnosc_wyswietlania"];
				if ($fieldCriteriaKolejnoscWyswietlania["is_null"] == 1) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania IS NOT NULL ';
				} elseif ($fieldCriteriaKolejnoscWyswietlania["is_null"] == 2) {
$filter = $filter . ' AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKolejnoscWyswietlania["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania = ? ";
				} else {
					$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_statusy_zamowien.szm_kolejnosc_wyswietlania <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaStatusZamowienia["status_zamowienianext"])) {
				$parentCriteria = $criteriaStatusZamowienia["status_zamowienianext"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND slk_statusy_zamowien.szm_id IN (SELECT second_parent.szw_szm_id FROM slk_status_zamowienia_workflows AS second_parent WHERE second_parent.szw_szm_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			if (isset($criteriaStatusZamowienia["status_zamowieniaprev"])) {
				$parentCriteria = $criteriaStatusZamowienia["status_zamowieniaprev"];
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$filter = $filter . " AND slk_statusy_zamowien.szm_id IN (SELECT second_parent.szw_szm_id FROM slk_status_zamowienia_workflows AS second_parent WHERE second_parent.szw_szm_id IN (" . implode(", ", $parentIds) . ")) ";
				}
			}
			$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_statusy_zamowien.szm_id, slk_statusy_zamowien.szm_virgo_title ";
			$queryString = $queryString . " ,slk_statusy_zamowien.szm_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'szm_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_kod', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kod szm_kod";
			} else {
				if ($defaultOrderColumn == "szm_kod") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kod ";
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_nazwa szm_nazwa";
			} else {
				if ($defaultOrderColumn == "szm_nazwa") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_nazwa ";
				}
			}
			if (P('show_pdf_opis', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_opis szm_opis";
			} else {
				if ($defaultOrderColumn == "szm_opis") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_opis ";
				}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kolejnosc_wyswietlania szm_kolejnosc_wyswietlania";
			} else {
				if ($defaultOrderColumn == "szm_kolejnosc_wyswietlania") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kolejnosc_wyswietlania ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_statusy_zamowien ";

		$resultsStatusZamowienia = $resultStatusZamowienia->select(
			'', 
			'all', 
			$resultStatusZamowienia->getOrderColumn(), 
			$resultStatusZamowienia->getOrderMode(), 
			$whereClauseStatusZamowienia,
			$queryString);
		
		foreach ($resultsStatusZamowienia as $resultStatusZamowienia) {

			if (P('show_pdf_kod', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultStatusZamowienia['szm_kod'])) + 6;
				if ($tmpLen > $minWidth['kod']) {
					$minWidth['kod'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_nazwa', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultStatusZamowienia['szm_nazwa'])) + 6;
				if ($tmpLen > $minWidth['nazwa']) {
					$minWidth['nazwa'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_opis', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultStatusZamowienia['szm_opis'])) + 6;
				if ($tmpLen > $minWidth['opis']) {
					$minWidth['opis'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultStatusZamowienia['szm_kolejnosc_wyswietlania'])) + 6;
				if ($tmpLen > $minWidth['kolejno\u015B\u0107 wy\u015Bwietlania']) {
					$minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaStatusZamowienia = $resultStatusZamowienia->getCriteria();
		if (is_null($criteriaStatusZamowienia) || sizeof($criteriaStatusZamowienia) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																				if (P('show_pdf_kod', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['kod'], $colHeight, T('KOD'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, T('NAZWA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_opis', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['opis'], $colHeight, T('OPIS'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'], $colHeight, T('KOLEJNOSC_WYSWIETLANIA'), 'T', 'C', 0, 0);
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
		foreach ($resultsStatusZamowienia as $resultStatusZamowienia) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_kod', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['kod'], $colHeight, '' . $resultStatusZamowienia['szm_kod'], 'T', 'L', 0, 0);
				if (P('show_pdf_kod', "1") == "2") {
										if (!is_null($resultStatusZamowienia['szm_kod'])) {
						$tmpCount = (float)$counts["kod"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["kod"] = $tmpCount;
					}
				}
				if (P('show_pdf_kod', "1") == "3") {
										if (!is_null($resultStatusZamowienia['szm_kod'])) {
						$tmpSum = (float)$sums["kod"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_kod'];
						}
						$sums["kod"] = $tmpSum;
					}
				}
				if (P('show_pdf_kod', "1") == "4") {
										if (!is_null($resultStatusZamowienia['szm_kod'])) {
						$tmpCount = (float)$avgCounts["kod"];
						$tmpSum = (float)$avgSums["kod"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["kod"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_kod'];
						}
						$avgSums["kod"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_nazwa', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['nazwa'], $colHeight, '' . $resultStatusZamowienia['szm_nazwa'], 'T', 'L', 0, 0);
				if (P('show_pdf_nazwa', "1") == "2") {
										if (!is_null($resultStatusZamowienia['szm_nazwa'])) {
						$tmpCount = (float)$counts["nazwa"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["nazwa"] = $tmpCount;
					}
				}
				if (P('show_pdf_nazwa', "1") == "3") {
										if (!is_null($resultStatusZamowienia['szm_nazwa'])) {
						$tmpSum = (float)$sums["nazwa"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_nazwa'];
						}
						$sums["nazwa"] = $tmpSum;
					}
				}
				if (P('show_pdf_nazwa', "1") == "4") {
										if (!is_null($resultStatusZamowienia['szm_nazwa'])) {
						$tmpCount = (float)$avgCounts["nazwa"];
						$tmpSum = (float)$avgSums["nazwa"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["nazwa"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_nazwa'];
						}
						$avgSums["nazwa"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_opis', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['opis'], $colHeight, '' . $resultStatusZamowienia['szm_opis'], 'T', 'L', 0, 0);
				if (P('show_pdf_opis', "1") == "2") {
										if (!is_null($resultStatusZamowienia['szm_opis'])) {
						$tmpCount = (float)$counts["opis"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["opis"] = $tmpCount;
					}
				}
				if (P('show_pdf_opis', "1") == "3") {
										if (!is_null($resultStatusZamowienia['szm_opis'])) {
						$tmpSum = (float)$sums["opis"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_opis'];
						}
						$sums["opis"] = $tmpSum;
					}
				}
				if (P('show_pdf_opis', "1") == "4") {
										if (!is_null($resultStatusZamowienia['szm_opis'])) {
						$tmpCount = (float)$avgCounts["opis"];
						$tmpSum = (float)$avgSums["opis"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["opis"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_opis'];
						}
						$avgSums["opis"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'], $colHeight, '' . $resultStatusZamowienia['szm_kolejnosc_wyswietlania'], 'T', 'R', 0, 0);
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "2") {
										if (!is_null($resultStatusZamowienia['szm_kolejnosc_wyswietlania'])) {
						$tmpCount = (float)$counts["kolejnosc_wyswietlania"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["kolejnosc_wyswietlania"] = $tmpCount;
					}
				}
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "3") {
										if (!is_null($resultStatusZamowienia['szm_kolejnosc_wyswietlania'])) {
						$tmpSum = (float)$sums["kolejnosc_wyswietlania"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_kolejnosc_wyswietlania'];
						}
						$sums["kolejnosc_wyswietlania"] = $tmpSum;
					}
				}
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "4") {
										if (!is_null($resultStatusZamowienia['szm_kolejnosc_wyswietlania'])) {
						$tmpCount = (float)$avgCounts["kolejnosc_wyswietlania"];
						$tmpSum = (float)$avgSums["kolejnosc_wyswietlania"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["kolejnosc_wyswietlania"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultStatusZamowienia['szm_kolejnosc_wyswietlania'];
						}
						$avgSums["kolejnosc_wyswietlania"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["kod"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["nazwa"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_opis', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['opis'];
				if (P('show_pdf_opis', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["opis"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'];
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["kolejnosc_wyswietlania"];
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["kod"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["nazwa"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_opis', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['opis'];
				if (P('show_pdf_opis', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["opis"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'];
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["kolejnosc_wyswietlania"], 2, ',', ' ');
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
			if (P('show_pdf_kod', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kod'];
				if (P('show_pdf_kod', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["kod"] == 0 ? "-" : $avgSums["kod"] / $avgCounts["kod"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_nazwa', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['nazwa'];
				if (P('show_pdf_nazwa', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["nazwa"] == 0 ? "-" : $avgSums["nazwa"] / $avgCounts["nazwa"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_opis', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['opis'];
				if (P('show_pdf_opis', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["opis"] == 0 ? "-" : $avgSums["opis"] / $avgCounts["opis"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_kolejnosc_wyswietlania', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['kolejno\u015B\u0107 wy\u015Bwietlania'];
				if (P('show_pdf_kolejnosc_wyswietlania', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["kolejnosc_wyswietlania"] == 0 ? "-" : $avgSums["kolejnosc_wyswietlania"] / $avgCounts["kolejnosc_wyswietlania"]);
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
				$reportTitle = T('STATUSY_ZAMOWIEN');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultStatusZamowienia = new virgoStatusZamowienia();
			$whereClauseStatusZamowienia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_kod', "1") != "0") {
					$data = $data . $stringDelimeter .'Kod' . $stringDelimeter . $separator;
				}
				if (P('show_export_nazwa', "1") != "0") {
					$data = $data . $stringDelimeter .'Nazwa' . $stringDelimeter . $separator;
				}
				if (P('show_export_opis', "1") != "0") {
					$data = $data . $stringDelimeter .'Opis' . $stringDelimeter . $separator;
				}
				if (P('show_export_kolejnosc_wyswietlania', "1") != "0") {
					$data = $data . $stringDelimeter .'Kolejność wyświetlania' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_statusy_zamowien.szm_id, slk_statusy_zamowien.szm_virgo_title ";
			$queryString = $queryString . " ,slk_statusy_zamowien.szm_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'szm_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_export_kod', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kod szm_kod";
			} else {
				if ($defaultOrderColumn == "szm_kod") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kod ";
				}
			}
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_nazwa szm_nazwa";
			} else {
				if ($defaultOrderColumn == "szm_nazwa") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_nazwa ";
				}
			}
			if (P('show_export_opis', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_opis szm_opis";
			} else {
				if ($defaultOrderColumn == "szm_opis") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_opis ";
				}
			}
			if (P('show_export_kolejnosc_wyswietlania', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kolejnosc_wyswietlania szm_kolejnosc_wyswietlania";
			} else {
				if ($defaultOrderColumn == "szm_kolejnosc_wyswietlania") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kolejnosc_wyswietlania ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_statusy_zamowien ";

			$resultsStatusZamowienia = $resultStatusZamowienia->select(
				'', 
				'all', 
				$resultStatusZamowienia->getOrderColumn(), 
				$resultStatusZamowienia->getOrderMode(), 
				$whereClauseStatusZamowienia,
				$queryString);
			foreach ($resultsStatusZamowienia as $resultStatusZamowienia) {
				if (P('show_export_kod', "1") != "0") {
			$data = $data . $stringDelimeter . $resultStatusZamowienia['szm_kod'] . $stringDelimeter . $separator;
				}
				if (P('show_export_nazwa', "1") != "0") {
			$data = $data . $stringDelimeter . $resultStatusZamowienia['szm_nazwa'] . $stringDelimeter . $separator;
				}
				if (P('show_export_opis', "1") != "0") {
			$data = $data . $stringDelimeter . $resultStatusZamowienia['szm_opis'] . $stringDelimeter . $separator;
				}
				if (P('show_export_kolejnosc_wyswietlania', "1") != "0") {
			$data = $data . $resultStatusZamowienia['szm_kolejnosc_wyswietlania'] . $separator;
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
				$reportTitle = T('STATUSY_ZAMOWIEN');
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
			$resultStatusZamowienia = new virgoStatusZamowienia();
			$whereClauseStatusZamowienia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseStatusZamowienia = $whereClauseStatusZamowienia . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_kod', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Kod');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Nazwa');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_opis', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Opis');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_kolejnosc_wyswietlania', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Kolejność wyświetlania');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_statusy_zamowien.szm_id, slk_statusy_zamowien.szm_virgo_title ";
			$queryString = $queryString . " ,slk_statusy_zamowien.szm_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'szm_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_export_kod', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kod szm_kod";
			} else {
				if ($defaultOrderColumn == "szm_kod") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kod ";
				}
			}
			if (P('show_export_nazwa', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_nazwa szm_nazwa";
			} else {
				if ($defaultOrderColumn == "szm_nazwa") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_nazwa ";
				}
			}
			if (P('show_export_opis', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_opis szm_opis";
			} else {
				if ($defaultOrderColumn == "szm_opis") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_opis ";
				}
			}
			if (P('show_export_kolejnosc_wyswietlania', "1") != "0") {
				$queryString = $queryString . ", slk_statusy_zamowien.szm_kolejnosc_wyswietlania szm_kolejnosc_wyswietlania";
			} else {
				if ($defaultOrderColumn == "szm_kolejnosc_wyswietlania") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien.szm_kolejnosc_wyswietlania ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_statusy_zamowien ";

			$resultsStatusZamowienia = $resultStatusZamowienia->select(
				'', 
				'all', 
				$resultStatusZamowienia->getOrderColumn(), 
				$resultStatusZamowienia->getOrderMode(), 
				$whereClauseStatusZamowienia,
				$queryString);
			$index = 1;
			foreach ($resultsStatusZamowienia as $resultStatusZamowienia) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultStatusZamowienia['szm_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_kod', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultStatusZamowienia['szm_kod'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_nazwa', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultStatusZamowienia['szm_nazwa'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_opis', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultStatusZamowienia['szm_opis'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_kolejnosc_wyswietlania', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultStatusZamowienia['szm_kolejnosc_wyswietlania'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
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
					$propertyColumnHash['kod'] = 'szm_kod';
					$propertyColumnHash['kod'] = 'szm_kod';
					$propertyColumnHash['nazwa'] = 'szm_nazwa';
					$propertyColumnHash['nazwa'] = 'szm_nazwa';
					$propertyColumnHash['opis'] = 'szm_opis';
					$propertyColumnHash['opis'] = 'szm_opis';
					$propertyColumnHash['kolejno\u015B\u0107 wy\u015Bwietlania'] = 'szm_kolejnosc_wyswietlania';
					$propertyColumnHash['kolejnosc_wyswietlania'] = 'szm_kolejnosc_wyswietlania';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importStatusZamowienia = new virgoStatusZamowienia();
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
										L(T('PROPERTY_NOT_FOUND', T('STATUS_ZAMOWIENIA'), $columns[$index]), '', 'ERROR');
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
										$importStatusZamowienia->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importStatusZamowienia->store();
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
		






		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `slk_statusy_zamowien` (
  `szm_id` bigint(20) unsigned NOT NULL auto_increment,
  `szm_virgo_state` varchar(50) default NULL,
  `szm_virgo_title` varchar(255) default NULL,
  `szm_virgo_deleted` boolean,
  `szm_kod` varchar(255), 
  `szm_nazwa` varchar(255), 
  `szm_opis` longtext, 
  `szm_kolejnosc_wyswietlania` integer,  
  `szm_date_created` datetime NOT NULL,
  `szm_date_modified` datetime default NULL,
  `szm_usr_created_id` int(11) NOT NULL,
  `szm_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`szm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/status_zamowienia.sql 
INSERT INTO `slk_statusy_zamowien` (`szm_virgo_title`, `szm_kod`, `szm_nazwa`, `szm_opis`, `szm_kolejnosc_wyswietlania`) 
VALUES (title, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_statusy_zamowien table already exists.", '', 'FATAL');
				L("Error ocurred, please contact site Administrator.", '', 'ERROR');
 				return false;
 			}
 			return true;
 		}


		static function onInstall($pobId, $title) {
		}

		static function getIdByKeyKod($kod) {
			$query = " SELECT szm_id FROM slk_statusy_zamowien WHERE 1 ";
			$query .= " AND szm_kod = '{$kod}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['szm_id'];
			}
			return null;
		}

		static function getByKeyKod($kod) {
			$id = self::getIdByKeyKod($kod);
			$ret = new virgoStatusZamowienia();
			if (isset($id)) {
				$ret->load($id);
			}
			return $ret;
		}
		static function getIdByKeyNazwa($nazwa) {
			$query = " SELECT szm_id FROM slk_statusy_zamowien WHERE 1 ";
			$query .= " AND szm_nazwa = '{$nazwa}' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['szm_id'];
			}
			return null;
		}

		static function getByKeyNazwa($nazwa) {
			$id = self::getIdByKeyNazwa($nazwa);
			$ret = new virgoStatusZamowienia();
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
			return "szm";
		}
		
		static function getPlural() {
			return "statusy_zamowien";
		}
		
		static function isDictionary() {
			return true;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoZamowienie";
			$ret[] = "virgoStatusZamowieniaWorkflow";
			$ret[] = "virgoStatusZamowieniaWorkflow";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_statusy_zamowien'));
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
			$virgoVersion = virgoStatusZamowienia::getVirgoVersion();
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
	
	

