<?php
/**
* Module Bilans otwarcia
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoStatusBilansOtwarcia'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoMagazyn'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaBilansu'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoBilansOtwarcia {

		 private  $bot_id = null;
		 private  $bot_data = null;

		 private  $bot_sbo_id = null;
		 private  $bot_mgz_id = null;

		 private   $bot_date_created = null;
		 private   $bot_usr_created_id = null;
		 private   $bot_date_modified = null;
		 private   $bot_usr_modified_id = null;
		 private   $bot_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {

			if (is_null($this->bot_sbo_id)) {
				$tmpIds = virgoStatusBilansOtwarcia::selectAllAsIdsStatic(' NOT EXISTS (SELECT * FROM slk_status_bilans_otwarcia_workflows WHERE sbw_sbo_prev_id = sbo_id ) ', ' sbo_kolejnosc_wyswietlania ASC ');
				foreach ($tmpIds as $tmpId) {
					$this->setSboId($tmpId);
					break;
				}
			}

			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->bot_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoBilansOtwarcia();
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
        	$this->bot_id = null;
		    $this->bot_date_created = null;
		    $this->bot_usr_created_id = null;
		    $this->bot_date_modified = null;
		    $this->bot_usr_modified_id = null;
		    $this->bot_virgo_title = null;
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
			return $this->bot_id;
		}

		function getData() {
			return $this->bot_data;
		}
		
		 private  function setData($val) {
			$this->bot_data = $val;
		}

		function getStatusBilansOtwarciaId() {
			return $this->bot_sbo_id;
		}
		
		 private  function setStatusBilansOtwarciaId($val) {
			$this->bot_sbo_id = $val;
		}
		function getMagazynId() {
			return $this->bot_mgz_id;
		}
		
		 private  function setMagazynId($val) {
			$this->bot_mgz_id = $val;
		}

		function getDateCreated() {
			return $this->bot_date_created;
		}
		function getUsrCreatedId() {
			return $this->bot_usr_created_id;
		}
		function getDateModified() {
			return $this->bot_date_modified;
		}
		function getUsrModifiedId() {
			return $this->bot_usr_modified_id;
		}


		function getSboId() {
			return $this->getStatusBilansOtwarciaId();
		}
		
		 private  function setSboId($val) {
			$this->setStatusBilansOtwarciaId($val);
		}
		function getMgzId() {
			return $this->getMagazynId();
		}
		
		 private  function setMgzId($val) {
			$this->setMagazynId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->bot_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('bot_data_' . $this->bot_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->bot_data = null;
		} else {
			$this->bot_data = $tmpValue;
		}
	}
			$this->bot_sbo_id = strval(R('bot_statusBilansOtwarcia_' . $this->bot_id));
			$this->bot_mgz_id = strval(R('bot_magazyn_' . $this->bot_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('bot_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaBilansOtwarcia = array();	
			$criteriaFieldBilansOtwarcia = array();	
			$isNullBilansOtwarcia = R('virgo_search_data_is_null');
			
			$criteriaFieldBilansOtwarcia["is_null"] = 0;
			if ($isNullBilansOtwarcia == "not_null") {
				$criteriaFieldBilansOtwarcia["is_null"] = 1;
			} elseif ($isNullBilansOtwarcia == "null") {
				$criteriaFieldBilansOtwarcia["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_data_from');
		$dataTypeCriteria["to"] = R('virgo_search_data_to');

//			if ($isSet) {
			$criteriaFieldBilansOtwarcia["value"] = $dataTypeCriteria;
//			}
			$criteriaBilansOtwarcia["data"] = $criteriaFieldBilansOtwarcia;
			$criteriaParent = array();	
			$isNull = R('virgo_search_statusBilansOtwarcia_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_statusBilansOtwarcia', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaBilansOtwarcia["status_bilans_otwarcia"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_magazyn_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_magazyn', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaBilansOtwarcia["magazyn"] = $criteriaParent;
			self::setCriteria($criteriaBilansOtwarcia);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_data');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterData', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterData', null);
			}
			$parentFilter = R('virgo_filter_status_bilans_otwarcia');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarcia', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterStatusBilansOtwarcia', null);
			}
			$parentFilter = R('virgo_filter_title_status_bilans_otwarcia');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarcia', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleStatusBilansOtwarcia', null);
			}
			$parentFilter = R('virgo_filter_magazyn');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterMagazyn', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterMagazyn', null);
			}
			$parentFilter = R('virgo_filter_title_magazyn');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleMagazyn', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleMagazyn', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseBilansOtwarcia = ' 1 = 1 ';
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
				$eventColumn = "bot_" . P('event_column');
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarcia');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_bilansy_otwarcia.bot_sbo_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_bilansy_otwarcia.bot_sbo_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_magazyn');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_bilansy_otwarcia.bot_mgz_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_bilansy_otwarcia.bot_mgz_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaBilansOtwarcia = self::getCriteria();
			if (isset($criteriaBilansOtwarcia["data"])) {
				$fieldCriteriaData = $criteriaBilansOtwarcia["data"];
				if ($fieldCriteriaData["is_null"] == 1) {
$filter = $filter . ' AND slk_bilansy_otwarcia.bot_data IS NOT NULL ';
				} elseif ($fieldCriteriaData["is_null"] == 2) {
$filter = $filter . ' AND slk_bilansy_otwarcia.bot_data IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaData["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_bilansy_otwarcia.bot_data >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_bilansy_otwarcia.bot_data <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaBilansOtwarcia["status_bilans_otwarcia"])) {
				$parentCriteria = $criteriaBilansOtwarcia["status_bilans_otwarcia"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND bot_sbo_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_bilansy_otwarcia.bot_sbo_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaBilansOtwarcia["magazyn"])) {
				$parentCriteria = $criteriaBilansOtwarcia["magazyn"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND bot_mgz_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_bilansy_otwarcia.bot_mgz_id IN (SELECT mgz_id FROM slk_magazyny WHERE mgz_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterData', null);
				if (S($tableFilter)) {
					$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND bot_data LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterStatusBilansOtwarcia', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND bot_sbo_id IS NULL ";
					} else {
						$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND bot_sbo_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleStatusBilansOtwarcia', null);
				if (S($parentFilter)) {
					$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND slk_statusy_bilans_otwarcia_parent.sbo_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterMagazyn', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND bot_mgz_id IS NULL ";
					} else {
						$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND bot_mgz_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleMagazyn', null);
				if (S($parentFilter)) {
					$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND slk_magazyny_parent.mgz_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseBilansOtwarcia;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseBilansOtwarcia = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_bilansy_otwarcia.bot_id, slk_bilansy_otwarcia.bot_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'bot_kolejnosc_wyswietlania');
			$orderColumnNotDisplayed = "";
			if (P('show_table_data', "1") != "0") {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_data bot_data";
			} else {
				if ($defaultOrderColumn == "bot_data") {
					$orderColumnNotDisplayed = " slk_bilansy_otwarcia.bot_data ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_table_status_bilans_otwarcia', "1") != "0") { // */ && !in_array("sbo", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_sbo_id as bot_sbo_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_parent.sbo_virgo_title as `status_bilans_otwarcia` ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_parent.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoMagazyn') && P('show_table_magazyn', "1") != "0") { // */ && !in_array("mgz", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_mgz_id as bot_mgz_id ";
				$queryString = $queryString . ", slk_magazyny_parent.mgz_virgo_title as `magazyn` ";
			} else {
				if ($defaultOrderColumn == "magazyn") {
					$orderColumnNotDisplayed = " slk_magazyny_parent.mgz_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_bilansy_otwarcia ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_parent ON (slk_bilansy_otwarcia.bot_sbo_id = slk_statusy_bilans_otwarcia_parent.sbo_id) ";
			}
			if (class_exists('sealock\virgoMagazyn')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_magazyny AS slk_magazyny_parent ON (slk_bilansy_otwarcia.bot_mgz_id = slk_magazyny_parent.mgz_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseBilansOtwarcia, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseBilansOtwarcia,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_bilansy_otwarcia"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " bot_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " bot_usr_created_id = ? ";
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
				. "\n FROM slk_bilansy_otwarcia"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_bilansy_otwarcia ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_bilansy_otwarcia ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, bot_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " bot_usr_created_id = ? ";
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
				$query = "SELECT COUNT(bot_id) cnt FROM bilansy_otwarcia";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as bilansy_otwarcia ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as bilansy_otwarcia ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoBilansOtwarcia();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_bilansy_otwarcia WHERE bot_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->bot_id = $row['bot_id'];
$this->bot_data = $row['bot_data'];
						$this->bot_sbo_id = $row['bot_sbo_id'];
						$this->bot_mgz_id = $row['bot_mgz_id'];
						if ($fetchUsernames) {
							if ($row['bot_date_created']) {
								if ($row['bot_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['bot_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['bot_date_modified']) {
								if ($row['bot_usr_modified_id'] == $row['bot_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['bot_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['bot_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->bot_date_created = $row['bot_date_created'];
						$this->bot_usr_created_id = $fetchUsernames ? $createdBy : $row['bot_usr_created_id'];
						$this->bot_date_modified = $row['bot_date_modified'];
						$this->bot_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['bot_usr_modified_id'];
						$this->bot_virgo_title = $row['bot_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_bilansy_otwarcia SET bot_usr_created_id = {$userId} WHERE bot_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->bot_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoBilansOtwarcia::selectAllAsObjectsStatic('bot_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->bot_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->bot_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('bot_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_bot = new virgoBilansOtwarcia();
				$tmp_bot->load((int)$lookup_id);
				return $tmp_bot->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoBilansOtwarcia');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" bot_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoBilansOtwarcia', "10");
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
				$query = $query . " bot_id as id, bot_virgo_title as title ";
			}
			$query = $query . " FROM slk_bilansy_otwarcia ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoBilansOtwarcia', 'sealock') == "1") {
				$privateCondition = " bot_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY bot_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resBilansOtwarcia = array();
				foreach ($rows as $row) {
					$resBilansOtwarcia[$row['id']] = $row['title'];
				}
				return $resBilansOtwarcia;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticBilansOtwarcia = new virgoBilansOtwarcia();
			return $staticBilansOtwarcia->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getStatusBilansOtwarciaStatic($parentId) {
			return virgoStatusBilansOtwarcia::getById($parentId);
		}
		
		function getStatusBilansOtwarcia() {
			return virgoBilansOtwarcia::getStatusBilansOtwarciaStatic($this->bot_sbo_id);
		}
		static function getMagazynStatic($parentId) {
			return virgoMagazyn::getById($parentId);
		}
		
		function getMagazyn() {
			return virgoBilansOtwarcia::getMagazynStatic($this->bot_mgz_id);
		}

		static function getPozycjaBilansusStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPozycjaBilansu = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoPozycjaBilansu'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPozycjaBilansu;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPozycjaBilansu;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPozycjaBilansu = virgoPozycjaBilansu::selectAll('pbl_bot_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPozycjaBilansu as $resultPozycjaBilansu) {
				$tmpPozycjaBilansu = virgoPozycjaBilansu::getById($resultPozycjaBilansu['pbl_id']); 
				array_push($resPozycjaBilansu, $tmpPozycjaBilansu);
			}
			return $resPozycjaBilansu;
		}

		function getPozycjaBilansus($orderBy = '', $extraWhere = null) {
			return virgoBilansOtwarcia::getPozycjaBilansusStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getData()) || trim($this->getData()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'DATA');
			}			
				if (is_null($this->bot_sbo_id) || trim($this->bot_sbo_id) == "") {
					if (R('create_bot_statusBilansOtwarcia_' . $this->bot_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'STATUS_BILANS_OTWARCIA', '');
					}
			}			
				if (is_null($this->bot_mgz_id) || trim($this->bot_mgz_id) == "") {
					if (R('create_bot_magazyn_' . $this->bot_id) == "1") { 
						$parent = new virgoMagazyn();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->bot_mgz_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'MAGAZYN', '');
					}
			}			
 			if (!is_null($this->bot_data) && trim($this->bot_data) != "") {
				preg_match('/^(\d\d\d\d)-(\d\d)-(\d\d)$/i', $this->bot_data, $matches);
				if (sizeof($matches) != 4) {
					return T('INCORRECT_DATE', 'DATA');
				}
				if (!checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
					return T('INCORRECT_DATE', 'DATA');
				}
			}
		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			$virgo = $this;
		if (isset($virgoOld) && $virgoOld->bot_sbo_id != $virgo->bot_sbo_id) {
			if (!virgoStatusBilansOtwarciaWorkflow::workflowTransitionAllowed($virgo->bot_sbo_id, $virgoOld->bot_sbo_id)) {
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_bilansy_otwarcia WHERE bot_id = " . $this->getId();
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
				$colNames = $colNames . ", bot_data";
				$values = $values . ", " . (is_null($objectToStore->getData()) ? "null" : "'" . QE($objectToStore->getData()) . "'");
				$colNames = $colNames . ", bot_sbo_id";
				$values = $values . ", " . (is_null($objectToStore->getSboId()) || $objectToStore->getSboId() == "" ? "null" : $objectToStore->getSboId());
				$colNames = $colNames . ", bot_mgz_id";
				$values = $values . ", " . (is_null($objectToStore->getMgzId()) || $objectToStore->getMgzId() == "" ? "null" : $objectToStore->getMgzId());
				$query = "INSERT INTO slk_history_bilansy_otwarcia (revision, ip, username, user_id, timestamp, bot_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getData() != $objectToStore->getData()) {
				if (is_null($objectToStore->getData())) {
					$nullifiedProperties = $nullifiedProperties . "data,";
				} else {
				$colNames = $colNames . ", bot_data";
				$values = $values . ", " . (is_null($objectToStore->getData()) ? "null" : "'" . QE($objectToStore->getData()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getSboId() != $objectToStore->getSboId() && ($virgoOld->getSboId() != 0 || $objectToStore->getSboId() != ""))) { 
				$colNames = $colNames . ", bot_sbo_id";
				$values = $values . ", " . (is_null($objectToStore->getSboId()) ? "null" : ($objectToStore->getSboId() == "" ? "0" : $objectToStore->getSboId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getMgzId() != $objectToStore->getMgzId() && ($virgoOld->getMgzId() != 0 || $objectToStore->getMgzId() != ""))) { 
				$colNames = $colNames . ", bot_mgz_id";
				$values = $values . ", " . (is_null($objectToStore->getMgzId()) ? "null" : ($objectToStore->getMgzId() == "" ? "0" : $objectToStore->getMgzId()));
			}
			$query = "INSERT INTO slk_history_bilansy_otwarcia (revision, ip, username, user_id, timestamp, bot_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_bilansy_otwarcia");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'bot_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_bilansy_otwarcia ADD COLUMN (bot_virgo_title VARCHAR(255));";
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
			if (isset($this->bot_id) && $this->bot_id != "") {
				$query = "UPDATE slk_bilansy_otwarcia SET ";
			if (isset($this->bot_data)) {
				$query .= " bot_data = ? ,";
				$types .= "s";
				$values[] = $this->bot_data;
			} else {
				$query .= " bot_data = NULL ,";				
			}
				if (isset($this->bot_sbo_id) && trim($this->bot_sbo_id) != "") {
					$query = $query . " bot_sbo_id = ? , ";
					$types = $types . "i";
					$values[] = $this->bot_sbo_id;
				} else {
					$query = $query . " bot_sbo_id = NULL, ";
				}
				if (isset($this->bot_mgz_id) && trim($this->bot_mgz_id) != "") {
					$query = $query . " bot_mgz_id = ? , ";
					$types = $types . "i";
					$values[] = $this->bot_mgz_id;
				} else {
					$query = $query . " bot_mgz_id = NULL, ";
				}
				$query = $query . " bot_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " bot_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->bot_date_modified;

				$query = $query . " bot_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->bot_usr_modified_id;

				$query = $query . " WHERE bot_id = ? ";
				$types = $types . "i";
				$values[] = $this->bot_id;
			} else {
				$query = "INSERT INTO slk_bilansy_otwarcia ( ";
			$query = $query . " bot_data, ";
				$query = $query . " bot_sbo_id, ";
				$query = $query . " bot_mgz_id, ";
				$query = $query . " bot_virgo_title, bot_date_created, bot_usr_created_id) VALUES ( ";
			if (isset($this->bot_data)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->bot_data;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->bot_sbo_id) && trim($this->bot_sbo_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->bot_sbo_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->bot_mgz_id) && trim($this->bot_mgz_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->bot_mgz_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->bot_date_created;
				$values[] = $this->bot_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->bot_id) || $this->bot_id == "") {
					$this->bot_id = QID();
				}
				if ($log) {
					L("bilans otwarcia stored successfully", "id = {$this->bot_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->bot_id) {
				$virgoOld = new virgoBilansOtwarcia($this->bot_id);
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
					if ($this->bot_id) {			
						$this->bot_date_modified = date("Y-m-d H:i:s");
						$this->bot_usr_modified_id = $userId;
					} else {
						$this->bot_date_created = date("Y-m-d H:i:s");
						$this->bot_usr_created_id = $userId;
					}
					$this->bot_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "bilans otwarcia" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "bilans otwarcia" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_bilansy_otwarcia WHERE bot_id = {$this->bot_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPozycjaBilansus();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoBilansOtwarcia();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT bot_id as id FROM slk_bilansy_otwarcia";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'bot_order_column')) {
				$orderBy = " ORDER BY bot_order_column ASC ";
			} 
			if (property_exists($this, 'bot_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY bot_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoBilansOtwarcia();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoBilansOtwarcia($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_bilansy_otwarcia SET bot_virgo_title = '$title' WHERE bot_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoBilansOtwarcia();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" bot_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['bot_id'];
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
			virgoBilansOtwarcia::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoBilansOtwarcia::setSessionValue('Sealock_BilansOtwarcia-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoBilansOtwarcia::getSessionValue('Sealock_BilansOtwarcia-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoBilansOtwarcia::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoBilansOtwarcia::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoBilansOtwarcia::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoBilansOtwarcia::getSessionValue('GLOBAL', $name, $default);
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
			$context['bot_id'] = $id;
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
			$context['bot_id'] = null;
			virgoBilansOtwarcia::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoBilansOtwarcia::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoBilansOtwarcia::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoBilansOtwarcia::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoBilansOtwarcia::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoBilansOtwarcia::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoBilansOtwarcia::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoBilansOtwarcia::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoBilansOtwarcia::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoBilansOtwarcia::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoBilansOtwarcia::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoBilansOtwarcia::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoBilansOtwarcia::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoBilansOtwarcia::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoBilansOtwarcia::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoBilansOtwarcia::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoBilansOtwarcia::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "bot_id";
			}
			return virgoBilansOtwarcia::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoBilansOtwarcia::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoBilansOtwarcia::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoBilansOtwarcia::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoBilansOtwarcia::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoBilansOtwarcia::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoBilansOtwarcia::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoBilansOtwarcia::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoBilansOtwarcia::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoBilansOtwarcia::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoBilansOtwarcia::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoBilansOtwarcia::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoBilansOtwarcia::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->bot_id) {
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
						L(T('STORED_CORRECTLY', 'BILANS_OTWARCIA'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'data', $this->bot_data);
						$parentStatusBilansOtwarcia = new virgoStatusBilansOtwarcia();
						$fieldValues = $fieldValues . T($fieldValue, 'status bilans otwarcia', $parentStatusBilansOtwarcia->lookup($this->bot_sbo_id));
						$parentMagazyn = new virgoMagazyn();
						$fieldValues = $fieldValues . T($fieldValue, 'magazyn', $parentMagazyn->lookup($this->bot_mgz_id));
						$username = '';
						if ($this->bot_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->bot_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->bot_date_created);
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
			$instance = new virgoBilansOtwarcia();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoBilansOtwarcia'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pozycja_bilansus') == "1") {
				$tmpPozycjaBilansu = new virgoPozycjaBilansu();
				$deletePozycjaBilansu = R('DELETE');
				if (sizeof($deletePozycjaBilansu) > 0) {
					virgoPozycjaBilansu::multipleDelete($deletePozycjaBilansu);
				}
				$resIds = $tmpPozycjaBilansu->select(null, 'all', null, null, ' pbl_bot_id = ' . $instance->getId(), ' SELECT pbl_id FROM slk_pozycja_bilansus ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pbl_id;
//					JRequest::setVar('pbl_bilans_otwarcia_' . $resId->pbl_id, $this->getId());
				} 
//				JRequest::setVar('pbl_bilans_otwarcia_', $instance->getId());
				$tmpPozycjaBilansu->setRecordSet($resIdsString);
				if (!$tmpPozycjaBilansu->portletActionStoreSelected()) {
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
			$instance = new virgoBilansOtwarcia();
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
			$tmpId = intval(R('bot_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoBilansOtwarcia::getContextId();
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
			$this->bot_id = null;
			$this->bot_date_created = null;
			$this->bot_usr_created_id = null;
			$this->bot_date_modified = null;
			$this->bot_usr_modified_id = null;
			$this->bot_virgo_title = null;
			
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

		static function portletActionShowForStatusBilansOtwarcia() {
			$parentId = R('sbo_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoStatusBilansOtwarcia($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForMagazyn() {
			$parentId = R('mgz_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoMagazyn($parentId);
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
//			$ret = new virgoBilansOtwarcia();
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
				$instance = new virgoBilansOtwarcia();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoBilansOtwarcia::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'BILANS_OTWARCIA'), '', 'INFO');
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
				$resultBilansOtwarcia = new virgoBilansOtwarcia();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultBilansOtwarcia->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultBilansOtwarcia->load($idToEditInt);
					} else {
						$resultBilansOtwarcia->bot_id = 0;
					}
				}
				$results[] = $resultBilansOtwarcia;
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
				$result = new virgoBilansOtwarcia();
				$result->loadFromRequest($idToStore);
				if ($result->bot_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->bot_id == 0) {
						$result->bot_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->bot_id)) {
							$result->bot_id = 0;
						}
						$idsToCorrect[$result->bot_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'BILANSY_OTWARCIA'), '', 'INFO');
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
			$resultBilansOtwarcia = new virgoBilansOtwarcia();
			foreach ($idsToDelete as $idToDelete) {
				$resultBilansOtwarcia->load((int)trim($idToDelete));
				$res = $resultBilansOtwarcia->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'BILANSY_OTWARCIA'), '', 'INFO');			
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
		$ret = $this->bot_data;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoBilansOtwarcia');
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
				$query = "UPDATE slk_bilansy_otwarcia SET bot_virgo_title = ? WHERE bot_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT bot_id AS id FROM slk_bilansy_otwarcia ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoBilansOtwarcia($row['id']);
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
				$class2prefix["sealock\\virgoStatusBilansOtwarcia"] = "sbo";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoStatusBilansOtwarcia"] = $class2prefix2;
				$class2prefix["sealock\\virgoMagazyn"] = "mgz";
				$class2prefix2 = array();
				$class2parentPrefix["sealock\\virgoMagazyn"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_bilansy_otwarcia.bot_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_bilansy_otwarcia.bot_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_bilansy_otwarcia.bot_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_bilansy_otwarcia.bot_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoBilansOtwarcia!', '', 'ERROR');
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
			$pdf->SetTitle('Bilansy otwarcia report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('BILANSY_OTWARCIA');
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
			if (P('show_pdf_data', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_status_bilans_otwarcia', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_magazyn', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultBilansOtwarcia = new virgoBilansOtwarcia();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_data', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Data');
				$minWidth['data'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['data']) {
						$minWidth['data'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_status_bilans_otwarcia', "1") == "1") {
				$minWidth['status bilans otwarcia $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'status bilans otwarcia $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['status bilans otwarcia $relation.name']) {
						$minWidth['status bilans otwarcia $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_magazyn', "1") == "1") {
				$minWidth['magazyn $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'magazyn $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['magazyn $relation.name']) {
						$minWidth['magazyn $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseBilansOtwarcia = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaBilansOtwarcia = $resultBilansOtwarcia->getCriteria();
			$fieldCriteriaData = $criteriaBilansOtwarcia["data"];
			if ($fieldCriteriaData["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Data', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaData["value"];
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
					$pdf->MultiCell(60, 100, 'Data', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaBilansOtwarcia["status_bilans_otwarcia"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoStatusBilansOtwarcia::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Status bilans otwarcia', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaBilansOtwarcia["magazyn"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Magazyn', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoMagazyn::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Magazyn', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_status_bilans_otwarcia');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_bilansy_otwarcia.bot_sbo_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_bilansy_otwarcia.bot_sbo_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_magazyn');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_bilansy_otwarcia.bot_mgz_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_bilansy_otwarcia.bot_mgz_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaBilansOtwarcia = self::getCriteria();
			if (isset($criteriaBilansOtwarcia["data"])) {
				$fieldCriteriaData = $criteriaBilansOtwarcia["data"];
				if ($fieldCriteriaData["is_null"] == 1) {
$filter = $filter . ' AND slk_bilansy_otwarcia.bot_data IS NOT NULL ';
				} elseif ($fieldCriteriaData["is_null"] == 2) {
$filter = $filter . ' AND slk_bilansy_otwarcia.bot_data IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaData["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_bilansy_otwarcia.bot_data >= ? ";
				$types .= "s";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_bilansy_otwarcia.bot_data <= ? ";
				$types .= "s";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaBilansOtwarcia["status_bilans_otwarcia"])) {
				$parentCriteria = $criteriaBilansOtwarcia["status_bilans_otwarcia"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND bot_sbo_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND slk_bilansy_otwarcia.bot_sbo_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaBilansOtwarcia["magazyn"])) {
				$parentCriteria = $criteriaBilansOtwarcia["magazyn"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND bot_mgz_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_bilansy_otwarcia.bot_mgz_id IN (SELECT mgz_id FROM slk_magazyny WHERE mgz_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_bilansy_otwarcia.bot_id, slk_bilansy_otwarcia.bot_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_data', "1") != "0") {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_data bot_data";
			} else {
				if ($defaultOrderColumn == "bot_data") {
					$orderColumnNotDisplayed = " slk_bilansy_otwarcia.bot_data ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_pdf_status_bilans_otwarcia', "1") != "0") { // */ && !in_array("sbo", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_sbo_id as bot_sbo_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_parent.sbo_virgo_title as `status_bilans_otwarcia` ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_parent.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoMagazyn') && P('show_pdf_magazyn', "1") != "0") { // */ && !in_array("mgz", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_mgz_id as bot_mgz_id ";
				$queryString = $queryString . ", slk_magazyny_parent.mgz_virgo_title as `magazyn` ";
			} else {
				if ($defaultOrderColumn == "magazyn") {
					$orderColumnNotDisplayed = " slk_magazyny_parent.mgz_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_bilansy_otwarcia ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_parent ON (slk_bilansy_otwarcia.bot_sbo_id = slk_statusy_bilans_otwarcia_parent.sbo_id) ";
			}
			if (class_exists('sealock\virgoMagazyn')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_magazyny AS slk_magazyny_parent ON (slk_bilansy_otwarcia.bot_mgz_id = slk_magazyny_parent.mgz_id) ";
			}

		$resultsBilansOtwarcia = $resultBilansOtwarcia->select(
			'', 
			'all', 
			$resultBilansOtwarcia->getOrderColumn(), 
			$resultBilansOtwarcia->getOrderMode(), 
			$whereClauseBilansOtwarcia,
			$queryString);
		
		foreach ($resultsBilansOtwarcia as $resultBilansOtwarcia) {

			if (P('show_pdf_data', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultBilansOtwarcia['bot_data'])) + 6;
				if ($tmpLen > $minWidth['data']) {
					$minWidth['data'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_status_bilans_otwarcia', "1") == "1") {
			$parentValue = trim(virgoStatusBilansOtwarcia::lookup($resultBilansOtwarcia['botsbo__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['status bilans otwarcia $relation.name']) {
					$minWidth['status bilans otwarcia $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_magazyn', "1") == "1") {
			$parentValue = trim(virgoMagazyn::lookup($resultBilansOtwarcia['botmgz__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['magazyn $relation.name']) {
					$minWidth['magazyn $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaBilansOtwarcia = $resultBilansOtwarcia->getCriteria();
		if (is_null($criteriaBilansOtwarcia) || sizeof($criteriaBilansOtwarcia) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																								if (P('show_pdf_magazyn', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['magazyn $relation.name'], $colHeight, T('MAGAZYN') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_data', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['data'], $colHeight, T('DATA'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_status_bilans_otwarcia', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia $relation.name'], $colHeight, T('STATUS_BILANS_OTWARCIA') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsBilansOtwarcia as $resultBilansOtwarcia) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_magazyn', "1") == "1") {
			$parentValue = virgoMagazyn::lookup($resultBilansOtwarcia['bot_mgz_id']);
			$tmpLn = $pdf->MultiCell($minWidth['magazyn $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_data', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['data'], $colHeight, '' . $resultBilansOtwarcia['bot_data'], 'T', 'L', 0, 0);
				if (P('show_pdf_data', "1") == "2") {
										if (!is_null($resultBilansOtwarcia['bot_data'])) {
						$tmpCount = (float)$counts["data"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["data"] = $tmpCount;
					}
				}
				if (P('show_pdf_data', "1") == "3") {
										if (!is_null($resultBilansOtwarcia['bot_data'])) {
						$tmpSum = (float)$sums["data"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultBilansOtwarcia['bot_data'];
						}
						$sums["data"] = $tmpSum;
					}
				}
				if (P('show_pdf_data', "1") == "4") {
										if (!is_null($resultBilansOtwarcia['bot_data'])) {
						$tmpCount = (float)$avgCounts["data"];
						$tmpSum = (float)$avgSums["data"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["data"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultBilansOtwarcia['bot_data'];
						}
						$avgSums["data"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_status_bilans_otwarcia', "1") == "1") {
			$parentValue = virgoStatusBilansOtwarcia::lookup($resultBilansOtwarcia['bot_sbo_id']);
			$tmpLn = $pdf->MultiCell($minWidth['status bilans otwarcia $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_data', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data'];
				if (P('show_pdf_data', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["data"];
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
			if (P('show_pdf_data', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data'];
				if (P('show_pdf_data', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["data"], 2, ',', ' ');
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
			if (P('show_pdf_data', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['data'];
				if (P('show_pdf_data', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["data"] == 0 ? "-" : $avgSums["data"] / $avgCounts["data"]);
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
				$reportTitle = T('BILANSY_OTWARCIA');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultBilansOtwarcia = new virgoBilansOtwarcia();
			$whereClauseBilansOtwarcia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_data', "1") != "0") {
					$data = $data . $stringDelimeter .'Data' . $stringDelimeter . $separator;
				}
				if (P('show_export_status_bilans_otwarcia', "1") != "0") {
					$data = $data . $stringDelimeter . 'Status bilans otwarcia ' . $stringDelimeter . $separator;
				}
				if (P('show_export_magazyn', "1") != "0") {
					$data = $data . $stringDelimeter . 'Magazyn ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_bilansy_otwarcia.bot_id, slk_bilansy_otwarcia.bot_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_data', "1") != "0") {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_data bot_data";
			} else {
				if ($defaultOrderColumn == "bot_data") {
					$orderColumnNotDisplayed = " slk_bilansy_otwarcia.bot_data ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarcia', "1") != "0") { // */ && !in_array("sbo", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_sbo_id as bot_sbo_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_parent.sbo_virgo_title as `status_bilans_otwarcia` ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_parent.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoMagazyn') && P('show_export_magazyn', "1") != "0") { // */ && !in_array("mgz", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_mgz_id as bot_mgz_id ";
				$queryString = $queryString . ", slk_magazyny_parent.mgz_virgo_title as `magazyn` ";
			} else {
				if ($defaultOrderColumn == "magazyn") {
					$orderColumnNotDisplayed = " slk_magazyny_parent.mgz_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_bilansy_otwarcia ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_parent ON (slk_bilansy_otwarcia.bot_sbo_id = slk_statusy_bilans_otwarcia_parent.sbo_id) ";
			}
			if (class_exists('sealock\virgoMagazyn')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_magazyny AS slk_magazyny_parent ON (slk_bilansy_otwarcia.bot_mgz_id = slk_magazyny_parent.mgz_id) ";
			}

			$resultsBilansOtwarcia = $resultBilansOtwarcia->select(
				'', 
				'all', 
				$resultBilansOtwarcia->getOrderColumn(), 
				$resultBilansOtwarcia->getOrderMode(), 
				$whereClauseBilansOtwarcia,
				$queryString);
			foreach ($resultsBilansOtwarcia as $resultBilansOtwarcia) {
				if (P('show_export_data', "1") != "0") {
			$data = $data . $resultBilansOtwarcia['bot_data'] . $separator;
				}
				if (P('show_export_status_bilans_otwarcia', "1") != "0") {
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultBilansOtwarcia['bot_sbo_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_magazyn', "1") != "0") {
					$parentValue = virgoMagazyn::lookup($resultBilansOtwarcia['bot_mgz_id']);
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
				$reportTitle = T('BILANSY_OTWARCIA');
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
			$resultBilansOtwarcia = new virgoBilansOtwarcia();
			$whereClauseBilansOtwarcia = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseBilansOtwarcia = $whereClauseBilansOtwarcia . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_data', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Data');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_status_bilans_otwarcia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Status bilans otwarcia ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoStatusBilansOtwarcia::getVirgoList();
					$formulaStatusBilansOtwarcia = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaStatusBilansOtwarcia != "") {
							$formulaStatusBilansOtwarcia = $formulaStatusBilansOtwarcia . ',';
						}
						$formulaStatusBilansOtwarcia = $formulaStatusBilansOtwarcia . $key;
					}
				}
				if (P('show_export_magazyn', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Magazyn ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoMagazyn::getVirgoList();
					$formulaMagazyn = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaMagazyn != "") {
							$formulaMagazyn = $formulaMagazyn . ',';
						}
						$formulaMagazyn = $formulaMagazyn . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_bilansy_otwarcia.bot_id, slk_bilansy_otwarcia.bot_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_data', "1") != "0") {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_data bot_data";
			} else {
				if ($defaultOrderColumn == "bot_data") {
					$orderColumnNotDisplayed = " slk_bilansy_otwarcia.bot_data ";
				}
			}
			if (class_exists('sealock\virgoStatusBilansOtwarcia') && P('show_export_status_bilans_otwarcia', "1") != "0") { // */ && !in_array("sbo", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_sbo_id as bot_sbo_id ";
				$queryString = $queryString . ", slk_statusy_bilans_otwarcia_parent.sbo_virgo_title as `status_bilans_otwarcia` ";
			} else {
				if ($defaultOrderColumn == "status_bilans_otwarcia") {
					$orderColumnNotDisplayed = " slk_statusy_bilans_otwarcia_parent.sbo_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoMagazyn') && P('show_export_magazyn', "1") != "0") { // */ && !in_array("mgz", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_bilansy_otwarcia.bot_mgz_id as bot_mgz_id ";
				$queryString = $queryString . ", slk_magazyny_parent.mgz_virgo_title as `magazyn` ";
			} else {
				if ($defaultOrderColumn == "magazyn") {
					$orderColumnNotDisplayed = " slk_magazyny_parent.mgz_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_bilansy_otwarcia ";
			if (class_exists('sealock\virgoStatusBilansOtwarcia')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_statusy_bilans_otwarcia AS slk_statusy_bilans_otwarcia_parent ON (slk_bilansy_otwarcia.bot_sbo_id = slk_statusy_bilans_otwarcia_parent.sbo_id) ";
			}
			if (class_exists('sealock\virgoMagazyn')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_magazyny AS slk_magazyny_parent ON (slk_bilansy_otwarcia.bot_mgz_id = slk_magazyny_parent.mgz_id) ";
			}

			$resultsBilansOtwarcia = $resultBilansOtwarcia->select(
				'', 
				'all', 
				$resultBilansOtwarcia->getOrderColumn(), 
				$resultBilansOtwarcia->getOrderMode(), 
				$whereClauseBilansOtwarcia,
				$queryString);
			$index = 1;
			foreach ($resultsBilansOtwarcia as $resultBilansOtwarcia) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultBilansOtwarcia['bot_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_data', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultBilansOtwarcia['bot_data'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_status_bilans_otwarcia', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoStatusBilansOtwarcia::lookup($resultBilansOtwarcia['bot_sbo_id']);
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
					$objValidation->setFormula1('"' . $formulaStatusBilansOtwarcia . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_magazyn', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoMagazyn::lookup($resultBilansOtwarcia['bot_mgz_id']);
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
					$objValidation->setFormula1('"' . $formulaMagazyn . '"');
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
					$propertyColumnHash['data'] = 'bot_data';
					$propertyColumnHash['data'] = 'bot_data';
					$dateFormat = P('import_format_data');
					if (isset($dateFormat)) {
						$propertyDateFormatHash['bot_data'] = $dateFormat;
					}
					$propertyClassHash['status bilans otwarcia'] = 'StatusBilansOtwarcia';
					$propertyClassHash['status_bilans_otwarcia'] = 'StatusBilansOtwarcia';
					$propertyColumnHash['status bilans otwarcia'] = 'bot_sbo_id';
					$propertyColumnHash['status_bilans_otwarcia'] = 'bot_sbo_id';
					$propertyClassHash['magazyn'] = 'Magazyn';
					$propertyClassHash['magazyn'] = 'Magazyn';
					$propertyColumnHash['magazyn'] = 'bot_mgz_id';
					$propertyColumnHash['magazyn'] = 'bot_mgz_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importBilansOtwarcia = new virgoBilansOtwarcia();
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
										L(T('PROPERTY_NOT_FOUND', T('BILANS_OTWARCIA'), $columns[$index]), '', 'ERROR');
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
										$importBilansOtwarcia->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_status_bilans_otwarcia');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoStatusBilansOtwarcia::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoStatusBilansOtwarcia::token2Id($tmpToken);
	}
	$importBilansOtwarcia->setSboId($defaultValue);
}
$defaultValue = P('import_default_value_magazyn');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoMagazyn::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoMagazyn::token2Id($tmpToken);
	}
	$importBilansOtwarcia->setMgzId($defaultValue);
}
							$errorMessage = $importBilansOtwarcia->store();
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
		

		static function portletActionVirgoChangeStatusBilansOtwarcia() {
			$instance = new virgoBilansOtwarcia();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoStatusBilansOtwarcia::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setSboId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('STATUS_BILANS_OTWARCIA'), $title), '', 'INFO');
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

		static function portletActionVirgoSetStatusBilansOtwarcia() {
			$this->loadFromDB();
			$parentId = R('bot_StatusBilansOtwarcia_id_' . $_SESSION['current_portlet_object_id']);
			$this->setSboId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetMagazyn() {
			$this->loadFromDB();
			$parentId = R('bot_Magazyn_id_' . $_SESSION['current_portlet_object_id']);
			$this->setMgzId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddMagazyn() {
			self::setDisplayMode("ADD_NEW_PARENT_MAGAZYN");
		}

		static function portletActionStoreNewMagazyn() {
			$id = -1;
			if (virgoMagazyn::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_MAGAZYN");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['bot_magazyn_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_bilansy_otwarcia` (
  `bot_id` bigint(20) unsigned NOT NULL auto_increment,
  `bot_virgo_state` varchar(50) default NULL,
  `bot_virgo_title` varchar(255) default NULL,
	`bot_sbo_id` int(11) default NULL,
	`bot_mgz_id` int(11) default NULL,
  `bot_data` date, 
  `bot_date_created` datetime NOT NULL,
  `bot_date_modified` datetime default NULL,
  `bot_usr_created_id` int(11) NOT NULL,
  `bot_usr_modified_id` int(11) default NULL,
  KEY `bot_sbo_fk` (`bot_sbo_id`),
  KEY `bot_mgz_fk` (`bot_mgz_id`),
  PRIMARY KEY  (`bot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/bilans_otwarcia.sql 
INSERT INTO `slk_bilansy_otwarcia` (`bot_virgo_title`, `bot_data`) 
VALUES (title, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_bilansy_otwarcia table already exists.", '', 'FATAL');
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
			return "bot";
		}
		
		static function getPlural() {
			return "bilansy_otwarcia";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoStatusBilansOtwarcia";
			$ret[] = "virgoMagazyn";
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPozycjaBilansu";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_bilansy_otwarcia'));
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
			$virgoVersion = virgoBilansOtwarcia::getVirgoVersion();
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
	
	

