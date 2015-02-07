<?php
/**
* Module Zamówienie
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusZamowienia'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoOdbiorca'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoZamowienie {

		 private  $zmw_id = null;
		 private  $zmw_numer = null;

		 private  $zmw_data_zlozenia = null;

		 private  $zmw_szm_id = null;
		 private  $zmw_odb_id = null;

		 private   $zmw_date_created = null;
		 private   $zmw_usr_created_id = null;
		 private   $zmw_date_modified = null;
		 private   $zmw_usr_modified_id = null;
		 private   $zmw_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {

			if (is_null($this->zmw_szm_id)) {
				$tmpIds = virgoStatusZamowienia::selectAllAsIdsStatic(' NOT EXISTS (SELECT * FROM slk_status_zamowienia_workflows WHERE szw_szm_prev_id = szm_id ) ', ' szm_kolejnosc_wyswietlania ASC ');
				foreach ($tmpIds as $tmpId) {
					$this->setSzmId($tmpId);
					break;
				}
			}

			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->zmw_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoZamowienie();
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
        	$this->zmw_id = null;
		    $this->zmw_date_created = null;
		    $this->zmw_usr_created_id = null;
		    $this->zmw_date_modified = null;
		    $this->zmw_usr_modified_id = null;
		    $this->zmw_virgo_title = null;
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
			return $this->zmw_id;
		}

		function getNumer() {
			return $this->zmw_numer;
		}
		
		 private  function setNumer($val) {
			$this->zmw_numer = $val;
		}
		function getDataZlozenia() {
			return $this->zmw_data_zlozenia;
		}
		
		 private  function setDataZlozenia($val) {
			$this->zmw_data_zlozenia = $val;
		}

		function getStatusZamowieniaId() {
			return $this->zmw_szm_id;
		}
		
		 private  function setStatusZamowieniaId($val) {
			$this->zmw_szm_id = $val;
		}
		function getOdbiorcaId() {
			return $this->zmw_odb_id;
		}
		
		 private  function setOdbiorcaId($val) {
			$this->zmw_odb_id = $val;
		}

		function getDateCreated() {
			return $this->zmw_date_created;
		}
		function getUsrCreatedId() {
			return $this->zmw_usr_created_id;
		}
		function getDateModified() {
			return $this->zmw_date_modified;
		}
		function getUsrModifiedId() {
			return $this->zmw_usr_modified_id;
		}


		function getSzmId() {
			return $this->getStatusZamowieniaId();
		}
		
		 private  function setSzmId($val) {
			$this->setStatusZamowieniaId($val);
		}
		function getOdbId() {
			return $this->getOdbiorcaId();
		}
		
		 private  function setOdbId($val) {
			$this->setOdbiorcaId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->zmw_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('zmw_numer_' . $this->zmw_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->zmw_numer = null;
		} else {
			$this->zmw_numer = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('zmw_dataZlozenia_' . $this->zmw_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->zmw_data_zlozenia = null;
		} else {
			$this->zmw_data_zlozenia = $tmpValue;
		}
	}
			$this->zmw_szm_id = strval(R('zmw_statusZamowienia_' . $this->zmw_id));
			$this->zmw_odb_id = strval(R('zmw_odbiorca_' . $this->zmw_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('zmw_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaZamowienie = array();	
			$criteriaFieldZamowienie = array();	
			$isNullZamowienie = R('virgo_search_numer_is_null');
			
			$criteriaFieldZamowienie["is_null"] = 0;
			if ($isNullZamowienie == "not_null") {
				$criteriaFieldZamowienie["is_null"] = 1;
			} elseif ($isNullZamowienie == "null") {
				$criteriaFieldZamowienie["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_numer');

//			if ($isSet) {
			$criteriaFieldZamowienie["value"] = $dataTypeCriteria;
//			}
			$criteriaZamowienie["numer"] = $criteriaFieldZamowienie;
			$criteriaFieldZamowienie = array();	
			$isNullZamowienie = R('virgo_search_dataZlozenia_is_null');
			
			$criteriaFieldZamowienie["is_null"] = 0;
			if ($isNullZamowienie == "not_null") {
				$criteriaFieldZamowienie["is_null"] = 1;
			} elseif ($isNullZamowienie == "null") {
				$criteriaFieldZamowienie["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_dataZlozenia_from');
		$dataTypeCriteria["to"] = R('virgo_search_dataZlozenia_to');

//			if ($isSet) {
			$criteriaFieldZamowienie["value"] = $dataTypeCriteria;
//			}
			$criteriaZamowienie["data_zlozenia"] = $criteriaFieldZamowienie;
			$criteriaParent = array();	
			$isNull = R('virgo_search_statusZamowienia_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_statusZamowienia', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaZamowienie["status_zamowienia"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_odbiorca_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_odbiorca', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaZamowienie["odbiorca"] = $criteriaParent;
			self::setCriteria($criteriaZamowienie);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_numer');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNumer', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNumer', null);
			}
			$tableFilter = R('virgo_filter_data_zlozenia');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDataZlozenia', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDataZlozenia', null);
			}
			$parentFilter = R('virgo_filter_status_zamowienia');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterStatusZamowienia', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStatusZamowienia', null);
			}
			$parentFilter = R('virgo_filter_title_status_zamowienia');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleStatusZamowienia', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleStatusZamowienia', null);
			}
			$parentFilter = R('virgo_filter_odbiorca');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterOdbiorca', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOdbiorca', null);
			}
			$parentFilter = R('virgo_filter_title_odbiorca');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleOdbiorca', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleOdbiorca', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseZamowienie = ' 1 = 1 ';
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
				$eventColumn = "zmw_" . P('event_column');
				$whereClauseZamowienie = $whereClauseZamowienie . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseZamowienie = $whereClauseZamowienie . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_zamowienia');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_zamowienia.zmw_szm_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_zamowienia.zmw_szm_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseZamowienie = $whereClauseZamowienie . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_odbiorca');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_zamowienia.zmw_odb_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_zamowienia.zmw_odb_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseZamowienie = $whereClauseZamowienie . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaZamowienie = self::getCriteria();
			if (isset($criteriaZamowienie["numer"])) {
				$fieldCriteriaNumer = $criteriaZamowienie["numer"];
				if ($fieldCriteriaNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_zamowienia.zmw_numer IS NOT NULL ';
				} elseif ($fieldCriteriaNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_zamowienia.zmw_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_numer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaZamowienie["data_zlozenia"])) {
				$fieldCriteriaDataZlozenia = $criteriaZamowienie["data_zlozenia"];
				if ($fieldCriteriaDataZlozenia["is_null"] == 1) {
$filter = $filter . ' AND slk_zamowienia.zmw_data_zlozenia IS NOT NULL ';
				} elseif ($fieldCriteriaDataZlozenia["is_null"] == 2) {
$filter = $filter . ' AND slk_zamowienia.zmw_data_zlozenia IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataZlozenia["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_data_zlozenia >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_data_zlozenia <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaZamowienie["status_zamowienia"])) {
				$parentCriteria = $criteriaZamowienie["status_zamowienia"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND zmw_szm_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_zamowienia.zmw_szm_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaZamowienie["odbiorca"])) {
				$parentCriteria = $criteriaZamowienie["odbiorca"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND zmw_odb_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_zamowienia.zmw_odb_id IN (SELECT odb_id FROM slk_odbiorcy WHERE odb_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseZamowienie = $whereClauseZamowienie . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseZamowienie = $whereClauseZamowienie . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseZamowienie = $whereClauseZamowienie . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterNumer', null);
				if (S($tableFilter)) {
					$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_numer LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDataZlozenia', null);
				if (S($tableFilter)) {
					$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_data_zlozenia LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterStatusZamowienia', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_szm_id IS NULL ";
					} else {
						$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_szm_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleStatusZamowienia', null);
				if (S($parentFilter)) {
					$whereClauseZamowienie = $whereClauseZamowienie . " AND slk_statusy_zamowien_parent.szm_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterOdbiorca', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_odb_id IS NULL ";
					} else {
						$whereClauseZamowienie = $whereClauseZamowienie . " AND zmw_odb_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleOdbiorca', null);
				if (S($parentFilter)) {
					$whereClauseZamowienie = $whereClauseZamowienie . " AND slk_odbiorcy_parent.odb_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseZamowienie;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseZamowienie = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_zamowienia.zmw_id, slk_zamowienia.zmw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'zmw_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_table_numer', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_numer zmw_numer";
			} else {
				if ($defaultOrderColumn == "zmw_numer") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_numer ";
				}
			}
			if (P('show_table_data_zlozenia', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_data_zlozenia zmw_data_zlozenia";
			} else {
				if ($defaultOrderColumn == "zmw_data_zlozenia") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_data_zlozenia ";
				}
			}
			if (class_exists('sealock\virgoStatusZamowienia') && P('show_table_status_zamowienia', "1") != "0") { // */ && !in_array("szm", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_szm_id as zmw_szm_id ";
				$queryString = $queryString . ", slk_statusy_zamowien_parent.szm_virgo_title as `status_zamowienia` ";
			} else {
				if ($defaultOrderColumn == "status_zamowienia") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien_parent.szm_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoOdbiorca') && P('show_table_odbiorca', "1") != "0") { // */ && !in_array("odb", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_odb_id as zmw_odb_id ";
				$queryString = $queryString . ", slk_odbiorcy_parent.odb_virgo_title as `odbiorca` ";
			} else {
				if ($defaultOrderColumn == "odbiorca") {
					$orderColumnNotDisplayed = " slk_odbiorcy_parent.odb_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_zamowienia ";
			if (class_exists('sealock\virgoStatusZamowienia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_zamowien AS slk_statusy_zamowien_parent ON (slk_zamowienia.zmw_szm_id = slk_statusy_zamowien_parent.szm_id) ";
			}
			if (class_exists('sealock\virgoOdbiorca')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_odbiorcy AS slk_odbiorcy_parent ON (slk_zamowienia.zmw_odb_id = slk_odbiorcy_parent.odb_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseZamowienie = $whereClauseZamowienie . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseZamowienie, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseZamowienie,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_zamowienia"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " zmw_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " zmw_usr_created_id = ? ";
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
				. "\n FROM slk_zamowienia"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_zamowienia ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_zamowienia ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, zmw_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " zmw_usr_created_id = ? ";
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
				$query = "SELECT COUNT(zmw_id) cnt FROM zamowienia";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as zamowienia ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as zamowienia ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoZamowienie();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_zamowienia WHERE zmw_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->zmw_id = $row['zmw_id'];
$this->zmw_numer = $row['zmw_numer'];
$this->zmw_data_zlozenia = $row['zmw_data_zlozenia'];
						$this->zmw_szm_id = $row['zmw_szm_id'];
						$this->zmw_odb_id = $row['zmw_odb_id'];
						if ($fetchUsernames) {
							if ($row['zmw_date_created']) {
								if ($row['zmw_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['zmw_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['zmw_date_modified']) {
								if ($row['zmw_usr_modified_id'] == $row['zmw_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['zmw_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['zmw_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->zmw_date_created = $row['zmw_date_created'];
						$this->zmw_usr_created_id = $fetchUsernames ? $createdBy : $row['zmw_usr_created_id'];
						$this->zmw_date_modified = $row['zmw_date_modified'];
						$this->zmw_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['zmw_usr_modified_id'];
						$this->zmw_virgo_title = $row['zmw_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_zamowienia SET zmw_usr_created_id = {$userId} WHERE zmw_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->zmw_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoZamowienie::selectAllAsObjectsStatic('zmw_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->zmw_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->zmw_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('zmw_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_zmw = new virgoZamowienie();
				$tmp_zmw->load((int)$lookup_id);
				return $tmp_zmw->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoZamowienie');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" zmw_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoZamowienie', "10");
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
				$query = $query . " zmw_id as id, zmw_virgo_title as title ";
			}
			$query = $query . " FROM slk_zamowienia ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoZamowienie', 'sealock') == "1") {
				$privateCondition = " zmw_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY zmw_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resZamowienie = array();
				foreach ($rows as $row) {
					$resZamowienie[$row['id']] = $row['title'];
				}
				return $resZamowienie;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticZamowienie = new virgoZamowienie();
			return $staticZamowienie->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getStatusZamowieniaStatic($parentId) {
			return virgoStatusZamowienia::getById($parentId);
		}
		
		function getStatusZamowienia() {
			return virgoZamowienie::getStatusZamowieniaStatic($this->zmw_szm_id);
		}
		static function getOdbiorcaStatic($parentId) {
			return virgoOdbiorca::getById($parentId);
		}
		
		function getOdbiorca() {
			return virgoZamowienie::getOdbiorcaStatic($this->zmw_odb_id);
		}

		static function getPozycjeZamowienStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaZamowienia = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaZamowienia'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaZamowienia;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaZamowienia;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaZamowienia = virgoPozycjaZamowienia::selectAll('pzm_zmw_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaZamowienia as $resultPozycjaZamowienia) {
				$tmpPozycjaZamowienia = virgoPozycjaZamowienia::getById($resultPozycjaZamowienia['pzm_id']); 
				array_push($resPozycjaZamowienia, $tmpPozycjaZamowienia);
			}
			return $resPozycjaZamowienia;
		}

		function getPozycjeZamowien($orderBy = '', $extraWhere = null) {
			return virgoZamowienie::getPozycjeZamowienStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getNumer()) || trim($this->getNumer()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NUMER');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_data_zlozenia_obligatory', "0") == "1") {
				if (
(is_null($this->getDataZlozenia()) || trim($this->getDataZlozenia()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DATA_ZLOZENIA');
				}			
			}
				if (is_null($this->zmw_szm_id) || trim($this->zmw_szm_id) == "") {
					if (R('create_zmw_statusZamowienia_' . $this->zmw_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'STATUS_ZAMOWIENIA', '');
					}
			}			
				if (is_null($this->zmw_odb_id) || trim($this->zmw_odb_id) == "") {
					if (R('create_zmw_odbiorca_' . $this->zmw_id) == "1") { 
						$parent = new virgoOdbiorca();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->zmw_odb_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'ODBIORCA', '');
					}
			}			
 			if (!is_null($this->zmw_data_zlozenia) && trim($this->zmw_data_zlozenia) != "") {
				preg_match('/^(\d\d\d\d)-(\d\d)-(\d\d)$/i', $this->zmw_data_zlozenia, $matches);
				if (sizeof($matches) != 4) {
					return T('INCORRECT_DATE', 'DATA_ZLOZENIA');
				}
				if (!checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
					return T('INCORRECT_DATE', 'DATA_ZLOZENIA');
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			$virgo = $this;
		if (isset($virgoOld) && $virgoOld->zmw_szm_id != $virgo->zmw_szm_id) {
			if (!virgoStatusZamowieniaWorkflow::workflowTransitionAllowed($virgo->zmw_szm_id, $virgoOld->zmw_szm_id)) {
				return T('STATUS_CHANGE_OUT_OF_WORKFLOW');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_zamowienia WHERE zmw_id = " . $this->getId();
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
				$colNames = $colNames . ", zmw_numer";
				$values = $values . ", " . (is_null($objectToStore->getNumer()) ? "null" : "'" . QE($objectToStore->getNumer()) . "'");
				$colNames = $colNames . ", zmw_data_zlozenia";
				$values = $values . ", " . (is_null($objectToStore->getDataZlozenia()) ? "null" : "'" . QE($objectToStore->getDataZlozenia()) . "'");
				$colNames = $colNames . ", zmw_szm_id";
				$values = $values . ", " . (is_null($objectToStore->getSzmId()) || $objectToStore->getSzmId() == "" ? "null" : $objectToStore->getSzmId());
				$colNames = $colNames . ", zmw_odb_id";
				$values = $values . ", " . (is_null($objectToStore->getOdbId()) || $objectToStore->getOdbId() == "" ? "null" : $objectToStore->getOdbId());
				$query = "INSERT INTO slk_history_zamowienia (revision, ip, username, user_id, timestamp, zmw_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getNumer() != $objectToStore->getNumer()) {
				if (is_null($objectToStore->getNumer())) {
					$nullifiedProperties = $nullifiedProperties . "numer,";
				} else {
				$colNames = $colNames . ", zmw_numer";
				$values = $values . ", " . (is_null($objectToStore->getNumer()) ? "null" : "'" . QE($objectToStore->getNumer()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDataZlozenia() != $objectToStore->getDataZlozenia()) {
				if (is_null($objectToStore->getDataZlozenia())) {
					$nullifiedProperties = $nullifiedProperties . "data_zlozenia,";
				} else {
				$colNames = $colNames . ", zmw_data_zlozenia";
				$values = $values . ", " . (is_null($objectToStore->getDataZlozenia()) ? "null" : "'" . QE($objectToStore->getDataZlozenia()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getSzmId() != $objectToStore->getSzmId() && ($virgoOld->getSzmId() != 0 || $objectToStore->getSzmId() != ""))) { 
				$colNames = $colNames . ", zmw_szm_id";
				$values = $values . ", " . (is_null($objectToStore->getSzmId()) ? "null" : ($objectToStore->getSzmId() == "" ? "0" : $objectToStore->getSzmId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getOdbId() != $objectToStore->getOdbId() && ($virgoOld->getOdbId() != 0 || $objectToStore->getOdbId() != ""))) { 
				$colNames = $colNames . ", zmw_odb_id";
				$values = $values . ", " . (is_null($objectToStore->getOdbId()) ? "null" : ($objectToStore->getOdbId() == "" ? "0" : $objectToStore->getOdbId()));
			}
			$query = "INSERT INTO slk_history_zamowienia (revision, ip, username, user_id, timestamp, zmw_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_zamowienia");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'zmw_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_zamowienia ADD COLUMN (zmw_virgo_title VARCHAR(255));";
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
			if (isset($this->zmw_id) && $this->zmw_id != "") {
				$query = "UPDATE slk_zamowienia SET ";
			if (isset($this->zmw_numer)) {
				$query .= " zmw_numer = ? ,";
				$types .= "s";
				$values[] = $this->zmw_numer;
			} else {
				$query .= " zmw_numer = NULL ,";				
			}
			if (isset($this->zmw_data_zlozenia)) {
				$query .= " zmw_data_zlozenia = ? ,";
				$types .= "s";
				$values[] = $this->zmw_data_zlozenia;
			} else {
				$query .= " zmw_data_zlozenia = NULL ,";				
			}
				if (isset($this->zmw_szm_id) && trim($this->zmw_szm_id) != "") {
					$query = $query . " zmw_szm_id = ? , ";
					$types = $types . "i";
					$values[] = $this->zmw_szm_id;
				} else {
					$query = $query . " zmw_szm_id = NULL, ";
				}
				if (isset($this->zmw_odb_id) && trim($this->zmw_odb_id) != "") {
					$query = $query . " zmw_odb_id = ? , ";
					$types = $types . "i";
					$values[] = $this->zmw_odb_id;
				} else {
					$query = $query . " zmw_odb_id = NULL, ";
				}
				$query = $query . " zmw_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " zmw_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->zmw_date_modified;

				$query = $query . " zmw_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->zmw_usr_modified_id;

				$query = $query . " WHERE zmw_id = ? ";
				$types = $types . "i";
				$values[] = $this->zmw_id;
			} else {
				$query = "INSERT INTO slk_zamowienia ( ";
			$query = $query . " zmw_numer, ";
			$query = $query . " zmw_data_zlozenia, ";
				$query = $query . " zmw_szm_id, ";
				$query = $query . " zmw_odb_id, ";
				$query = $query . " zmw_virgo_title, zmw_date_created, zmw_usr_created_id) VALUES ( ";
			if (isset($this->zmw_numer)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->zmw_numer;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->zmw_data_zlozenia)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->zmw_data_zlozenia;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->zmw_szm_id) && trim($this->zmw_szm_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->zmw_szm_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->zmw_odb_id) && trim($this->zmw_odb_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->zmw_odb_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->zmw_date_created;
				$values[] = $this->zmw_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->zmw_id) || $this->zmw_id == "") {
					$this->zmw_id = QID();
				}
				if ($log) {
					L("zam\u00F3wienie stored successfully", "id = {$this->zmw_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->zmw_id) {
				$virgoOld = new virgoZamowienie($this->zmw_id);
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
					if ($this->zmw_id) {			
						$this->zmw_date_modified = date("Y-m-d H:i:s");
						$this->zmw_usr_modified_id = $userId;
					} else {
						$this->zmw_date_created = date("Y-m-d H:i:s");
						$this->zmw_usr_created_id = $userId;
					}
					$this->zmw_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "zam\u00F3wienie" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "zam\u00F3wienie" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
						}
					}
					$ret = $this->afterStore($virgoOld);
					if (isset($ret) && $ret != "") {
						return $ret;
					}

					$virgo = $this;
				}
			}
			return "";
		}

		static function portletActionShowStatusLog() {
			self::setDisplayMode("STATUS_LOG");
		}
		
		static function portletActionVirgoDefault() {
			$ret = 0;
			return $ret;
		}

		function parentDelete() {
			$query = "DELETE FROM slk_zamowienia WHERE zmw_id = {$this->zmw_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPozycjeZamowien();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'ZAMOWIENIE', 'POZYCJA_ZAMOWIENIA', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoZamowienie();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT zmw_id as id FROM slk_zamowienia";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'zmw_order_column')) {
				$orderBy = " ORDER BY zmw_order_column ASC ";
			} 
			if (property_exists($this, 'zmw_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY zmw_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoZamowienie();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoZamowienie($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_zamowienia SET zmw_virgo_title = '$title' WHERE zmw_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoZamowienie();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" zmw_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['zmw_id'];
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
			virgoZamowienie::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoZamowienie::setSessionValue('Sealock_Zamowienie-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoZamowienie::getSessionValue('Sealock_Zamowienie-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoZamowienie::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoZamowienie::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoZamowienie::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoZamowienie::getSessionValue('GLOBAL', $name, $default);
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
			$context['zmw_id'] = $id;
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
			$context['zmw_id'] = null;
			virgoZamowienie::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoZamowienie::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoZamowienie::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoZamowienie::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoZamowienie::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoZamowienie::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoZamowienie::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoZamowienie::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoZamowienie::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoZamowienie::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoZamowienie::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoZamowienie::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoZamowienie::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoZamowienie::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoZamowienie::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoZamowienie::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoZamowienie::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "zmw_id";
			}
			return virgoZamowienie::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoZamowienie::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoZamowienie::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoZamowienie::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoZamowienie::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoZamowienie::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoZamowienie::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoZamowienie::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoZamowienie::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoZamowienie::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoZamowienie::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoZamowienie::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoZamowienie::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->zmw_id) {
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
						L(T('STORED_CORRECTLY', 'ZAMOWIENIE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'numer', $this->zmw_numer);
						$fieldValues = $fieldValues . T($fieldValue, 'data złożenia', $this->zmw_data_zlozenia);
						$parentStatusZamowienia = new virgoStatusZamowienia();
						$fieldValues = $fieldValues . T($fieldValue, 'status zam\u00F3wienia', $parentStatusZamowienia->lookup($this->zmw_szm_id));
						$parentOdbiorca = new virgoOdbiorca();
						$fieldValues = $fieldValues . T($fieldValue, 'odbiorca', $parentOdbiorca->lookup($this->zmw_odb_id));
						$username = '';
						if ($this->zmw_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->zmw_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->zmw_date_created);
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
			$instance = new virgoZamowienie();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoZamowienie'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pozycje_zamowien') == "1") {
				$tmpPozycjaZamowienia = new virgoPozycjaZamowienia();
				$deletePozycjaZamowienia = R('DELETE');
				if (sizeof($deletePozycjaZamowienia) > 0) {
					virgoPozycjaZamowienia::multipleDelete($deletePozycjaZamowienia);
				}
				$resIds = $tmpPozycjaZamowienia->select(null, 'all', null, null, ' pzm_zmw_id = ' . $instance->getId(), ' SELECT pzm_id FROM slk_pozycje_zamowien ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pzm_id;
//					JRequest::setVar('pzm_zamowienie_' . $resId->pzm_id, $this->getId());
				} 
//				JRequest::setVar('pzm_zamowienie_', $instance->getId());
				$tmpPozycjaZamowienia->setRecordSet($resIdsString);
				if (!$tmpPozycjaZamowienia->portletActionStoreSelected()) {
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
			$instance = new virgoZamowienie();
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
			$tmpId = intval(R('zmw_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoZamowienie::getContextId();
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
			$this->zmw_id = null;
			$this->zmw_date_created = null;
			$this->zmw_usr_created_id = null;
			$this->zmw_date_modified = null;
			$this->zmw_usr_modified_id = null;
			$this->zmw_virgo_title = null;
			
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

		static function portletActionShowForStatusZamowienia() {
			$parentId = R('szm_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoStatusZamowienia($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForOdbiorca() {
			$parentId = R('odb_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoOdbiorca($parentId);
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
//			$ret = new virgoZamowienie();
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
				$instance = new virgoZamowienie();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoZamowienie::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'ZAMOWIENIE'), '', 'INFO');
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
				$resultZamowienie = new virgoZamowienie();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultZamowienie->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultZamowienie->load($idToEditInt);
					} else {
						$resultZamowienie->zmw_id = 0;
					}
				}
				$results[] = $resultZamowienie;
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
				$result = new virgoZamowienie();
				$result->loadFromRequest($idToStore);
				if ($result->zmw_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->zmw_id == 0) {
						$result->zmw_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->zmw_id)) {
							$result->zmw_id = 0;
						}
						$idsToCorrect[$result->zmw_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'ZAMOWIENIA'), '', 'INFO');
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
			$resultZamowienie = new virgoZamowienie();
			foreach ($idsToDelete as $idToDelete) {
				$resultZamowienie->load((int)trim($idToDelete));
				$res = $resultZamowienie->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'ZAMOWIENIA'), '', 'INFO');			
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
		$ret = $this->zmw_numer;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoZamowienie');
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
				$query = "UPDATE slk_zamowienia SET zmw_virgo_title = ? WHERE zmw_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT zmw_id AS id FROM slk_zamowienia ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoZamowienie($row['id']);
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
				$class2prefix["sealock\\virgoStatusZamowienia"] = "szm";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoStatusZamowienia"] = $class2prefix2;
				$class2prefix["sealock\\virgoOdbiorca"] = "odb";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoOdbiorca"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_zamowienia.zmw_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_zamowienia.zmw_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_zamowienia.zmw_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_zamowienia.zmw_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoZamowienie!', '', 'ERROR');
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
			$pdf->SetTitle('Zamówienia report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('ZAMOWIENIA');
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
			if (P('show_pdf_numer', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_data_zlozenia', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_status_zamowienia', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_odbiorca', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultZamowienie = new virgoZamowienie();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
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
			if (P('show_pdf_data_zlozenia', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Data złożenia');
				$minWidth['data z\u0142o\u017Cenia'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['data z\u0142o\u017Cenia']) {
						$minWidth['data z\u0142o\u017Cenia'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_status_zamowienia', "1") == "1") {
				$minWidth['status zam\u00F3wienia $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'status zam\u00F3wienia $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['status zam\u00F3wienia $relation.name']) {
						$minWidth['status zam\u00F3wienia $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_odbiorca', "1") == "1") {
				$minWidth['odbiorca $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'odbiorca $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['odbiorca $relation.name']) {
						$minWidth['odbiorca $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseZamowienie = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseZamowienie = $whereClauseZamowienie . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaZamowienie = $resultZamowienie->getCriteria();
			$fieldCriteriaNumer = $criteriaZamowienie["numer"];
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
			$fieldCriteriaDataZlozenia = $criteriaZamowienie["data_zlozenia"];
			if ($fieldCriteriaDataZlozenia["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Data złożenia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDataZlozenia["value"];
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
					$pdf->MultiCell(60, 100, 'Data złożenia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaZamowienie["status_zamowienia"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Status zamówienia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoStatusZamowienia::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Status zamówienia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaZamowienie["odbiorca"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Odbiorca', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoOdbiorca::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Odbiorca', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_zamowienia');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_zamowienia.zmw_szm_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_zamowienia.zmw_szm_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseZamowienie = $whereClauseZamowienie . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_odbiorca');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_zamowienia.zmw_odb_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_zamowienia.zmw_odb_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseZamowienie = $whereClauseZamowienie . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaZamowienie = self::getCriteria();
			if (isset($criteriaZamowienie["numer"])) {
				$fieldCriteriaNumer = $criteriaZamowienie["numer"];
				if ($fieldCriteriaNumer["is_null"] == 1) {
$filter = $filter . ' AND slk_zamowienia.zmw_numer IS NOT NULL ';
				} elseif ($fieldCriteriaNumer["is_null"] == 2) {
$filter = $filter . ' AND slk_zamowienia.zmw_numer IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNumer["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_numer like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaZamowienie["data_zlozenia"])) {
				$fieldCriteriaDataZlozenia = $criteriaZamowienie["data_zlozenia"];
				if ($fieldCriteriaDataZlozenia["is_null"] == 1) {
$filter = $filter . ' AND slk_zamowienia.zmw_data_zlozenia IS NOT NULL ';
				} elseif ($fieldCriteriaDataZlozenia["is_null"] == 2) {
$filter = $filter . ' AND slk_zamowienia.zmw_data_zlozenia IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDataZlozenia["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_data_zlozenia >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_zamowienia.zmw_data_zlozenia <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaZamowienie["status_zamowienia"])) {
				$parentCriteria = $criteriaZamowienie["status_zamowienia"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND zmw_szm_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_zamowienia.zmw_szm_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaZamowienie["odbiorca"])) {
				$parentCriteria = $criteriaZamowienie["odbiorca"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND zmw_odb_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_zamowienia.zmw_odb_id IN (SELECT odb_id FROM slk_odbiorcy WHERE odb_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseZamowienie = $whereClauseZamowienie . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseZamowienie = $whereClauseZamowienie . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_zamowienia.zmw_id, slk_zamowienia.zmw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_numer', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_numer zmw_numer";
			} else {
				if ($defaultOrderColumn == "zmw_numer") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_numer ";
				}
			}
			if (P('show_pdf_data_zlozenia', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_data_zlozenia zmw_data_zlozenia";
			} else {
				if ($defaultOrderColumn == "zmw_data_zlozenia") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_data_zlozenia ";
				}
			}
			if (class_exists('sealock\virgoStatusZamowienia') && P('show_pdf_status_zamowienia', "1") != "0") { // */ && !in_array("szm", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_szm_id as zmw_szm_id ";
				$queryString = $queryString . ", slk_statusy_zamowien_parent.szm_virgo_title as `status_zamowienia` ";
			} else {
				if ($defaultOrderColumn == "status_zamowienia") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien_parent.szm_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoOdbiorca') && P('show_pdf_odbiorca', "1") != "0") { // */ && !in_array("odb", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_odb_id as zmw_odb_id ";
				$queryString = $queryString . ", slk_odbiorcy_parent.odb_virgo_title as `odbiorca` ";
			} else {
				if ($defaultOrderColumn == "odbiorca") {
					$orderColumnNotDisplayed = " slk_odbiorcy_parent.odb_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_zamowienia ";
			if (class_exists('sealock\virgoStatusZamowienia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_zamowien AS slk_statusy_zamowien_parent ON (slk_zamowienia.zmw_szm_id = slk_statusy_zamowien_parent.szm_id) ";
			}
			if (class_exists('sealock\virgoOdbiorca')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_odbiorcy AS slk_odbiorcy_parent ON (slk_zamowienia.zmw_odb_id = slk_odbiorcy_parent.odb_id) ";
			}

		$resultsZamowienie = $resultZamowienie->select(
			'', 
			'all', 
			$resultZamowienie->getOrderColumn(), 
			$resultZamowienie->getOrderMode(), 
			$whereClauseZamowienie,
			$queryString);
		
		foreach ($resultsZamowienie as $resultZamowienie) {

			if (P('show_pdf_numer', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultZamowienie['zmw_numer'])) + 6;
				if ($tmpLen > $minWidth['numer']) {
					$minWidth['numer'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_data_zlozenia', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultZamowienie['zmw_data_zlozenia'])) + 6;
				if ($tmpLen > $minWidth['data z\u0142o\u017Cenia']) {
					$minWidth['data z\u0142o\u017Cenia'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_status_zamowienia', "1") == "1") {
			$parentValue = trim(virgoStatusZamowienia::lookup($resultZamowienie['zmwszm__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['status zam\u00F3wienia $relation.name']) {
					$minWidth['status zam\u00F3wienia $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_odbiorca', "1") == "1") {
			$parentValue = trim(virgoOdbiorca::lookup($resultZamowienie['zmwodb__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['odbiorca $relation.name']) {
					$minWidth['odbiorca $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaZamowienie = $resultZamowienie->getCriteria();
		if (is_null($criteriaZamowienie) || sizeof($criteriaZamowienie) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																										if (P('show_pdf_numer', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['numer'], $colHeight, T('NUMER'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_data_zlozenia', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['data z\u0142o\u017Cenia'], $colHeight, T('DATA_ZLOZENIA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_status_zamowienia', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['status zam\u00F3wienia $relation.name'], $colHeight, T('STATUS_ZAMOWIENIA') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_odbiorca', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['odbiorca $relation.name'], $colHeight, T('ODBIORCA') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsZamowienie as $resultZamowienie) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_numer', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['numer'], $colHeight, '' . $resultZamowienie['zmw_numer'], 'T', 'L', 0, 0);
				if (P('show_pdf_numer', "1") == "2") {
										if (!is_null($resultZamowienie['zmw_numer'])) {
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
										if (!is_null($resultZamowienie['zmw_numer'])) {
						$tmpSum = (float)$sums["numer"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultZamowienie['zmw_numer'];
						}
						$sums["numer"] = $tmpSum;
					}
				}
				if (P('show_pdf_numer', "1") == "4") {
										if (!is_null($resultZamowienie['zmw_numer'])) {
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
							$tmpSum = $tmpSum + $resultZamowienie['zmw_numer'];
						}
						$avgSums["numer"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_data_zlozenia', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['data z\u0142o\u017Cenia'], $colHeight, '' . $resultZamowienie['zmw_data_zlozenia'], 'T', 'L', 0, 0);
				if (P('show_pdf_data_zlozenia', "1") == "2") {
										if (!is_null($resultZamowienie['zmw_data_zlozenia'])) {
						$tmpCount = (float)$counts["data_zlozenia"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["data_zlozenia"] = $tmpCount;
					}
				}
				if (P('show_pdf_data_zlozenia', "1") == "3") {
										if (!is_null($resultZamowienie['zmw_data_zlozenia'])) {
						$tmpSum = (float)$sums["data_zlozenia"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultZamowienie['zmw_data_zlozenia'];
						}
						$sums["data_zlozenia"] = $tmpSum;
					}
				}
				if (P('show_pdf_data_zlozenia', "1") == "4") {
										if (!is_null($resultZamowienie['zmw_data_zlozenia'])) {
						$tmpCount = (float)$avgCounts["data_zlozenia"];
						$tmpSum = (float)$avgSums["data_zlozenia"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["data_zlozenia"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultZamowienie['zmw_data_zlozenia'];
						}
						$avgSums["data_zlozenia"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_status_zamowienia', "1") == "1") {
			$parentValue = virgoStatusZamowienia::lookup($resultZamowienie['zmw_szm_id']);
			$tmpLn = $pdf->MultiCell($minWidth['status zam\u00F3wienia $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_odbiorca', "1") == "1") {
			$parentValue = virgoOdbiorca::lookup($resultZamowienie['zmw_odb_id']);
			$tmpLn = $pdf->MultiCell($minWidth['odbiorca $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_data_zlozenia', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data z\u0142o\u017Cenia'];
				if (P('show_pdf_data_zlozenia', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["data_zlozenia"];
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
			if (P('show_pdf_data_zlozenia', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data z\u0142o\u017Cenia'];
				if (P('show_pdf_data_zlozenia', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["data_zlozenia"], 2, ',', ' ');
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
			if (P('show_pdf_data_zlozenia', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data z\u0142o\u017Cenia'];
				if (P('show_pdf_data_zlozenia', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["data_zlozenia"] == 0 ? "-" : $avgSums["data_zlozenia"] / $avgCounts["data_zlozenia"]);
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
				$reportTitle = T('ZAMOWIENIA');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultZamowienie = new virgoZamowienie();
			$whereClauseZamowienie = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseZamowienie = $whereClauseZamowienie . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_numer', "1") != "0") {
					$data = $data . $stringDelimeter .'Numer' . $stringDelimeter . $separator;
				}
				if (P('show_export_data_zlozenia', "1") != "0") {
					$data = $data . $stringDelimeter .'Data złożenia' . $stringDelimeter . $separator;
				}
				if (P('show_export_status_zamowienia', "1") != "0") {
					$data = $data . $stringDelimeter . 'Status zamówienia ' . $stringDelimeter . $separator;
				}
				if (P('show_export_odbiorca', "1") != "0") {
					$data = $data . $stringDelimeter . 'Odbiorca ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_zamowienia.zmw_id, slk_zamowienia.zmw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_numer', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_numer zmw_numer";
			} else {
				if ($defaultOrderColumn == "zmw_numer") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_numer ";
				}
			}
			if (P('show_export_data_zlozenia', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_data_zlozenia zmw_data_zlozenia";
			} else {
				if ($defaultOrderColumn == "zmw_data_zlozenia") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_data_zlozenia ";
				}
			}
			if (class_exists('sealock\virgoStatusZamowienia') && P('show_export_status_zamowienia', "1") != "0") { // */ && !in_array("szm", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_szm_id as zmw_szm_id ";
				$queryString = $queryString . ", slk_statusy_zamowien_parent.szm_virgo_title as `status_zamowienia` ";
			} else {
				if ($defaultOrderColumn == "status_zamowienia") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien_parent.szm_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoOdbiorca') && P('show_export_odbiorca', "1") != "0") { // */ && !in_array("odb", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_odb_id as zmw_odb_id ";
				$queryString = $queryString . ", slk_odbiorcy_parent.odb_virgo_title as `odbiorca` ";
			} else {
				if ($defaultOrderColumn == "odbiorca") {
					$orderColumnNotDisplayed = " slk_odbiorcy_parent.odb_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_zamowienia ";
			if (class_exists('sealock\virgoStatusZamowienia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_zamowien AS slk_statusy_zamowien_parent ON (slk_zamowienia.zmw_szm_id = slk_statusy_zamowien_parent.szm_id) ";
			}
			if (class_exists('sealock\virgoOdbiorca')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_odbiorcy AS slk_odbiorcy_parent ON (slk_zamowienia.zmw_odb_id = slk_odbiorcy_parent.odb_id) ";
			}

			$resultsZamowienie = $resultZamowienie->select(
				'', 
				'all', 
				$resultZamowienie->getOrderColumn(), 
				$resultZamowienie->getOrderMode(), 
				$whereClauseZamowienie,
				$queryString);
			foreach ($resultsZamowienie as $resultZamowienie) {
				if (P('show_export_numer', "1") != "0") {
			$data = $data . $stringDelimeter . $resultZamowienie['zmw_numer'] . $stringDelimeter . $separator;
				}
				if (P('show_export_data_zlozenia', "1") != "0") {
			$data = $data . $resultZamowienie['zmw_data_zlozenia'] . $separator;
				}
				if (P('show_export_status_zamowienia', "1") != "0") {
					$parentValue = virgoStatusZamowienia::lookup($resultZamowienie['zmw_szm_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_odbiorca', "1") != "0") {
					$parentValue = virgoOdbiorca::lookup($resultZamowienie['zmw_odb_id']);
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
				$reportTitle = T('ZAMOWIENIA');
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
			$resultZamowienie = new virgoZamowienie();
			$whereClauseZamowienie = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseZamowienie = $whereClauseZamowienie . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Numer');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_data_zlozenia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Data złożenia');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_status_zamowienia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Status zamówienia ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoStatusZamowienia::getVirgoList();
					$formulaStatusZamowienia = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaStatusZamowienia != "") {
							$formulaStatusZamowienia = $formulaStatusZamowienia . ',';
						}
						$formulaStatusZamowienia = $formulaStatusZamowienia . $key;
					}
				}
				if (P('show_export_odbiorca', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Odbiorca ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoOdbiorca::getVirgoList();
					$formulaOdbiorca = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaOdbiorca != "") {
							$formulaOdbiorca = $formulaOdbiorca . ',';
						}
						$formulaOdbiorca = $formulaOdbiorca . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_zamowienia.zmw_id, slk_zamowienia.zmw_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_numer', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_numer zmw_numer";
			} else {
				if ($defaultOrderColumn == "zmw_numer") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_numer ";
				}
			}
			if (P('show_export_data_zlozenia', "1") != "0") {
				$queryString = $queryString . ", slk_zamowienia.zmw_data_zlozenia zmw_data_zlozenia";
			} else {
				if ($defaultOrderColumn == "zmw_data_zlozenia") {
					$orderColumnNotDisplayed = " slk_zamowienia.zmw_data_zlozenia ";
				}
			}
			if (class_exists('sealock\virgoStatusZamowienia') && P('show_export_status_zamowienia', "1") != "0") { // */ && !in_array("szm", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_szm_id as zmw_szm_id ";
				$queryString = $queryString . ", slk_statusy_zamowien_parent.szm_virgo_title as `status_zamowienia` ";
			} else {
				if ($defaultOrderColumn == "status_zamowienia") {
					$orderColumnNotDisplayed = " slk_statusy_zamowien_parent.szm_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoOdbiorca') && P('show_export_odbiorca', "1") != "0") { // */ && !in_array("odb", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_zamowienia.zmw_odb_id as zmw_odb_id ";
				$queryString = $queryString . ", slk_odbiorcy_parent.odb_virgo_title as `odbiorca` ";
			} else {
				if ($defaultOrderColumn == "odbiorca") {
					$orderColumnNotDisplayed = " slk_odbiorcy_parent.odb_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_zamowienia ";
			if (class_exists('sealock\virgoStatusZamowienia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_zamowien AS slk_statusy_zamowien_parent ON (slk_zamowienia.zmw_szm_id = slk_statusy_zamowien_parent.szm_id) ";
			}
			if (class_exists('sealock\virgoOdbiorca')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_odbiorcy AS slk_odbiorcy_parent ON (slk_zamowienia.zmw_odb_id = slk_odbiorcy_parent.odb_id) ";
			}

			$resultsZamowienie = $resultZamowienie->select(
				'', 
				'all', 
				$resultZamowienie->getOrderColumn(), 
				$resultZamowienie->getOrderMode(), 
				$whereClauseZamowienie,
				$queryString);
			$index = 1;
			foreach ($resultsZamowienie as $resultZamowienie) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultZamowienie['zmw_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_numer', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultZamowienie['zmw_numer'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_data_zlozenia', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultZamowienie['zmw_data_zlozenia'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_status_zamowienia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoStatusZamowienia::lookup($resultZamowienie['zmw_szm_id']);
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
					$objValidation->setFormula1('"' . $formulaStatusZamowienia . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_odbiorca', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoOdbiorca::lookup($resultZamowienie['zmw_odb_id']);
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
					$objValidation->setFormula1('"' . $formulaOdbiorca . '"');
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
					$propertyColumnHash['numer'] = 'zmw_numer';
					$propertyColumnHash['numer'] = 'zmw_numer';
					$propertyColumnHash['data z\u0142o\u017Cenia'] = 'zmw_data_zlozenia';
					$propertyColumnHash['data_zlozenia'] = 'zmw_data_zlozenia';
					$dateFormat = P('import_format_data_zlozenia');
					if (isset($dateFormat)) {
						$propertyDateFormatHash['zmw_data_zlozenia'] = $dateFormat;
					}
					$propertyClassHash['status zam\u00F3wienia'] = 'StatusZamowienia';
					$propertyClassHash['status_zamowienia'] = 'StatusZamowienia';
					$propertyColumnHash['status zam\u00F3wienia'] = 'zmw_szm_id';
					$propertyColumnHash['status_zamowienia'] = 'zmw_szm_id';
					$propertyClassHash['odbiorca'] = 'Odbiorca';
					$propertyClassHash['odbiorca'] = 'Odbiorca';
					$propertyColumnHash['odbiorca'] = 'zmw_odb_id';
					$propertyColumnHash['odbiorca'] = 'zmw_odb_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importZamowienie = new virgoZamowienie();
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
										L(T('PROPERTY_NOT_FOUND', T('ZAMOWIENIE'), $columns[$index]), '', 'ERROR');
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
										$importZamowienie->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_status_zamowienia');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoStatusZamowienia::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoStatusZamowienia::token2Id($tmpToken);
	}
	$importZamowienie->setSzmId($defaultValue);
}
$defaultValue = P('import_default_value_odbiorca');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoOdbiorca::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoOdbiorca::token2Id($tmpToken);
	}
	$importZamowienie->setOdbId($defaultValue);
}
							$errorMessage = $importZamowienie->store();
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
		

		static function portletActionVirgoChangeStatusZamowienia() {
			$instance = new virgoZamowienie();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoStatusZamowienia::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setSzmId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('STATUS_ZAMOWIENIA'), $title), '', 'INFO');
					return 0;
				} else {
					L($errorMessage, '', 'ERROR');
					return -1;
				}
			} else {
				L("$messages.PARENT_NOT_FOUND", '', 'ERROR');
				return -1;
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

		static function portletActionVirgoSetStatusZamowienia() {
			$this->loadFromDB();
			$parentId = R('zmw_StatusZamowienia_id_' . $_SESSION['current_portlet_object_id']);
			$this->setSzmId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetOdbiorca() {
			$this->loadFromDB();
			$parentId = R('zmw_Odbiorca_id_' . $_SESSION['current_portlet_object_id']);
			$this->setOdbId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddOdbiorca() {
			self::setDisplayMode("ADD_NEW_PARENT_ODBIORCA");
		}

		static function portletActionStoreNewOdbiorca() {
			$id = -1;
			if (virgoOdbiorca::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_ODBIORCA");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['zmw_odbiorca_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_zamowienia` (
  `zmw_id` bigint(20) unsigned NOT NULL auto_increment,
  `zmw_virgo_state` varchar(50) default NULL,
  `zmw_virgo_title` varchar(255) default NULL,
	`zmw_szm_id` int(11) default NULL,
	`zmw_odb_id` int(11) default NULL,
  `zmw_numer` varchar(255), 
  `zmw_data_zlozenia` date, 
  `zmw_date_created` datetime NOT NULL,
  `zmw_date_modified` datetime default NULL,
  `zmw_usr_created_id` int(11) NOT NULL,
  `zmw_usr_modified_id` int(11) default NULL,
  KEY `zmw_szm_fk` (`zmw_szm_id`),
  KEY `zmw_odb_fk` (`zmw_odb_id`),
  PRIMARY KEY  (`zmw_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/zamowienie.sql 
INSERT INTO `slk_zamowienia` (`zmw_virgo_title`, `zmw_numer`, `zmw_data_zlozenia`) 
VALUES (title, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_zamowienia table already exists.", '', 'FATAL');
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
			return "zmw";
		}
		
		static function getPlural() {
			return "zamowienia";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoStatusZamowienia";
			$ret[] = "virgoOdbiorca";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPozycjaZamowienia";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_zamowienia'));
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
			$virgoVersion = virgoZamowienie::getVirgoVersion();
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
	
	

