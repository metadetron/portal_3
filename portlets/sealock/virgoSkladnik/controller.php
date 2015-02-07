<?php
/**
* Module Składnik
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace sealock;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoSkladnik {

		 private  $skl_id = null;
		 private  $skl_ilosc = null;

		 private  $skl_twr_tworzy_id = null;
		 private  $skl_twr_id = null;

		 private   $skl_date_created = null;
		 private   $skl_usr_created_id = null;
		 private   $skl_date_modified = null;
		 private   $skl_usr_modified_id = null;
		 private   $skl_virgo_title = null;
		
		 private   $internalLog = null;		
				
		 private  function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function isDeletedVirgo() {
			return $this->skl_virgo_deleted;
		}

		static public function createGuiAware() {
			$ret = new virgoSkladnik();
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
        	$this->skl_id = null;
		    $this->skl_date_created = null;
		    $this->skl_usr_created_id = null;
		    $this->skl_date_modified = null;
		    $this->skl_usr_modified_id = null;
		    $this->skl_virgo_title = null;
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
			return $this->skl_id;
		}

		function getIlosc() {
			return $this->skl_ilosc;
		}
		
		 private  function setIlosc($val) {
			$this->skl_ilosc = $val;
		}

		function getTowarTworzyId() {
			return $this->skl_twr_tworzy_id;
		}
		
		 private  function setTowarTworzyId($val) {
			$this->skl_twr_tworzy_id = $val;
		}
		function getTowarId() {
			return $this->skl_twr_id;
		}
		
		 private  function setTowarId($val) {
			$this->skl_twr_id = $val;
		}

		function getDateCreated() {
			return $this->skl_date_created;
		}
		function getUsrCreatedId() {
			return $this->skl_usr_created_id;
		}
		function getDateModified() {
			return $this->skl_date_modified;
		}
		function getUsrModifiedId() {
			return $this->skl_usr_modified_id;
		}


		function getTwrTworzyId() {
			return $this->getTowarTworzyId();
		}
		
		 private  function setTwrTworzyId($val) {
			$this->setTowarTworzyId($val);
		}
		function getTwrId() {
			return $this->getTowarId();
		}
		
		 private  function setTwrId($val) {
			$this->setTowarId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->skl_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('skl_ilosc_' . $this->skl_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->skl_ilosc = null;
		} else {
			$this->skl_ilosc = $tmpValue;
		}
	}
			$this->skl_twr_tworzy_id = strval(R('skl_towarTworzy_' . $this->skl_id));
			$this->skl_twr_id = strval(R('skl_towar_' . $this->skl_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('skl_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaSkladnik = array();	
			$criteriaFieldSkladnik = array();	
			$isNullSkladnik = R('virgo_search_ilosc_is_null');
			
			$criteriaFieldSkladnik["is_null"] = 0;
			if ($isNullSkladnik == "not_null") {
				$criteriaFieldSkladnik["is_null"] = 1;
			} elseif ($isNullSkladnik == "null") {
				$criteriaFieldSkladnik["is_null"] = 2;
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
			$criteriaFieldSkladnik["value"] = $dataTypeCriteria;
//			}
			$criteriaSkladnik["ilosc"] = $criteriaFieldSkladnik;
			$criteriaParent = array();	
			$isNull = R('virgo_search_towartworzy_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_towarTworzy', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaSkladnik["towartworzy"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_towar_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_towar', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaSkladnik["towar"] = $criteriaParent;
			self::setCriteria($criteriaSkladnik);
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
			$parentFilter = R('virgo_filter_towartworzy');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTowarTworzy', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTowarTworzy', null);
			}
			$parentFilter = R('virgo_filter_title_towartworzy');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleTowarTworzy', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleTowarTworzy', null);
			}
			$parentFilter = R('virgo_filter_towar');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTowar', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTowar', null);
			}
			$parentFilter = R('virgo_filter_title_towar');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleTowar', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleTowar', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseSkladnik = ' 1 = 1 ';
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
				$eventColumn = "skl_" . P('event_column');
				$whereClauseSkladnik = $whereClauseSkladnik . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSkladnik = $whereClauseSkladnik . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towartworzy');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_skladniki.skl_twr_tworzy_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_skladniki.skl_twr_tworzy_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSkladnik = $whereClauseSkladnik . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_skladniki.skl_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_skladniki.skl_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSkladnik = $whereClauseSkladnik . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaSkladnik = self::getCriteria();
			if (isset($criteriaSkladnik["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaSkladnik["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_skladniki.skl_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_skladniki.skl_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_skladniki.skl_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_skladniki.skl_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaSkladnik["towartworzy"])) {
				$parentCriteria = $criteriaSkladnik["towartworzy"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND skl_twr_tworzy_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_skladniki.skl_twr_tworzy_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaSkladnik["towar"])) {
				$parentCriteria = $criteriaSkladnik["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND skl_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_skladniki.skl_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseSkladnik = $whereClauseSkladnik . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseSkladnik = $whereClauseSkladnik . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseSkladnik = $whereClauseSkladnik . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterIlosc', null);
				if (S($tableFilter)) {
					$whereClauseSkladnik = $whereClauseSkladnik . " AND skl_ilosc LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTowarTworzy', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseSkladnik = $whereClauseSkladnik . " AND skl_twr_tworzy_id IS NULL ";
					} else {
						$whereClauseSkladnik = $whereClauseSkladnik . " AND skl_twr_tworzy_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTowarTworzy', null);
				if (S($parentFilter)) {
					$whereClauseSkladnik = $whereClauseSkladnik . " AND slk_towary_parent.twr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterTowar', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseSkladnik = $whereClauseSkladnik . " AND skl_twr_id IS NULL ";
					} else {
						$whereClauseSkladnik = $whereClauseSkladnik . " AND skl_twr_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTowar', null);
				if (S($parentFilter)) {
					$whereClauseSkladnik = $whereClauseSkladnik . " AND slk_towary_parent.twr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseSkladnik;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseSkladnik = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT slk_skladniki.skl_id, slk_skladniki.skl_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_skladniki.skl_ilosc skl_ilosc";
			} else {
				if ($defaultOrderColumn == "skl_ilosc") {
					$orderColumnNotDisplayed = " slk_skladniki.skl_ilosc ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_table_towartworzy', "1") != "0") { // */ && !in_array("twrtworzy", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_tworzy_id as skl_skl_twr_tworzy_id ";
				$queryString = $queryString . ", slk_towary_tworzy.twr_virgo_title as towar_tworzy ";
			} else {
				if ($defaultOrderColumn == "towar_tworzy") {
					$orderColumnNotDisplayed = " slk_towary_tworzy.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_table_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_id as skl_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_skladniki ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_tworzy ON (slk_skladniki.skl_twr_tworzy_id = slk_towary_tworzy.twr_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_skladniki.skl_twr_id = slk_towary_parent.twr_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseSkladnik = $whereClauseSkladnik . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseSkladnik, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseSkladnik,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM slk_skladniki"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " skl_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " skl_usr_created_id = ? ";
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
				. "\n FROM slk_skladniki"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_skladniki ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_skladniki ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, skl_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " skl_usr_created_id = ? ";
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
				$query = "SELECT COUNT(skl_id) cnt FROM skladniki";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as skladniki ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as skladniki ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoSkladnik();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_skladniki WHERE skl_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->skl_id = $row['skl_id'];
$this->skl_ilosc = $row['skl_ilosc'];
						$this->skl_twr_tworzy_id = $row['skl_twr_tworzy_id'];
						$this->skl_twr_id = $row['skl_twr_id'];
						if ($fetchUsernames) {
							if ($row['skl_date_created']) {
								if ($row['skl_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['skl_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['skl_date_modified']) {
								if ($row['skl_usr_modified_id'] == $row['skl_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['skl_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['skl_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->skl_date_created = $row['skl_date_created'];
						$this->skl_usr_created_id = $fetchUsernames ? $createdBy : $row['skl_usr_created_id'];
						$this->skl_date_modified = $row['skl_date_modified'];
						$this->skl_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['skl_usr_modified_id'];
						$this->skl_virgo_title = $row['skl_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_skladniki SET skl_usr_created_id = {$userId} WHERE skl_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->skl_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoSkladnik::selectAllAsObjectsStatic('skl_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->skl_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->skl_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('skl_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_skl = new virgoSkladnik();
				$tmp_skl->load((int)$lookup_id);
				return $tmp_skl->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoSkladnik');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" skl_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoSkladnik', "10");
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
				$query = $query . " skl_id as id, skl_virgo_title as title ";
			}
			$query = $query . " FROM slk_skladniki ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoSkladnik', 'sealock') == "1") {
				$privateCondition = " skl_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY skl_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resSkladnik = array();
				foreach ($rows as $row) {
					$resSkladnik[$row['id']] = $row['title'];
				}
				return $resSkladnik;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticSkladnik = new virgoSkladnik();
			return $staticSkladnik->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getTowarTworzyStatic($parentId) {
			return virgoTowar::getById($parentId);
		}
		
		function getTowarTworzy() {
			return virgoSkladnik::getTowarTworzyStatic($this->skl_twr_tworzy_id);
		}
		static function getTowarStatic($parentId) {
			return virgoTowar::getById($parentId);
		}
		
		function getTowar() {
			return virgoSkladnik::getTowarStatic($this->skl_twr_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getIlosc()) || trim($this->getIlosc()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ILOSC');
			}			
				if (is_null($this->skl_twr_tworzy_id) || trim($this->skl_twr_tworzy_id) == "") {
					if (R('create_skl_towarTworzy_' . $this->skl_id) == "1") { 
						$parent = new virgoTowar();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->skl_twr_tworzy_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'TOWAR', 'TWORZY');
					}
			}			
				if (is_null($this->skl_twr_id) || trim($this->skl_twr_id) == "") {
					if (R('create_skl_towar_' . $this->skl_id) == "1") { 
						$parent = new virgoTowar();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->skl_twr_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'TOWAR', '');
					}
			}			
 			if (!is_null($this->skl_ilosc) && trim($this->skl_ilosc) != "") {
				if (!is_numeric($this->skl_ilosc)) {
					return T('INCORRECT_NUMBER', 'ILOSC', $this->skl_ilosc);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_skladniki WHERE skl_id = " . $this->getId();
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
				$colNames = $colNames . ", skl_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				$colNames = $colNames . ", skl_twr_tworzy_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrTworzyId()) || $objectToStore->getTwrTworzyId() == "" ? "null" : $objectToStore->getTwrTworzyId());
				$colNames = $colNames . ", skl_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) || $objectToStore->getTwrId() == "" ? "null" : $objectToStore->getTwrId());
				$query = "INSERT INTO slk_history_skladniki (revision, ip, username, user_id, timestamp, skl_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", skl_ilosc";
				$values = $values . ", " . (is_null($objectToStore->getIlosc()) ? "null" : "'" . QE($objectToStore->getIlosc()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getTwrTworzyId() != $objectToStore->getTwrTworzyId() && ($virgoOld->getTwrTworzyId() != 0 || $objectToStore->getTwrTworzyId() != ""))) { 
				$colNames = $colNames . ", skl_twr_tworzy_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrTworzyId()) ? "null" : ($objectToStore->getTwrTworzyId() == "" ? "0" : $objectToStore->getTwrTworzyId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getTwrId() != $objectToStore->getTwrId() && ($virgoOld->getTwrId() != 0 || $objectToStore->getTwrId() != ""))) { 
				$colNames = $colNames . ", skl_twr_id";
				$values = $values . ", " . (is_null($objectToStore->getTwrId()) ? "null" : ($objectToStore->getTwrId() == "" ? "0" : $objectToStore->getTwrId()));
			}
			$query = "INSERT INTO slk_history_skladniki (revision, ip, username, user_id, timestamp, skl_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_skladniki");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'skl_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_skladniki ADD COLUMN (skl_virgo_title VARCHAR(255));";
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
			if (isset($this->skl_id) && $this->skl_id != "") {
				$query = "UPDATE slk_skladniki SET ";
			if (isset($this->skl_ilosc)) {
				$query .= " skl_ilosc = ? ,";
				$types .= "d";
				$values[] = number_format($this->skl_ilosc, 2, '.', '');
			} else {
				$query .= " skl_ilosc = NULL ,";				
			}
				if (isset($this->skl_twr_tworzy_id) && trim($this->skl_twr_tworzy_id) != "") {
					$query = $query . " skl_twr_tworzy_id = ? , ";
					$types = $types . "i";
					$values[] = $this->skl_twr_tworzy_id;
				} else {
					$query = $query . " skl_twr_tworzy_id = NULL, ";
				}
				if (isset($this->skl_twr_id) && trim($this->skl_twr_id) != "") {
					$query = $query . " skl_twr_id = ? , ";
					$types = $types . "i";
					$values[] = $this->skl_twr_id;
				} else {
					$query = $query . " skl_twr_id = NULL, ";
				}
				$query = $query . " skl_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " skl_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->skl_date_modified;

				$query = $query . " skl_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->skl_usr_modified_id;

				$query = $query . " WHERE skl_id = ? ";
				$types = $types . "i";
				$values[] = $this->skl_id;
			} else {
				$query = "INSERT INTO slk_skladniki ( ";
			$query = $query . " skl_ilosc, ";
				$query = $query . " skl_twr_tworzy_id, ";
				$query = $query . " skl_twr_id, ";
				$query = $query . " skl_virgo_title, skl_date_created, skl_usr_created_id) VALUES ( ";
			if (isset($this->skl_ilosc)) {
				$query .= " ? ,";
				$types .= "d";
				$values[] = $this->skl_ilosc;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->skl_twr_tworzy_id) && trim($this->skl_twr_tworzy_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->skl_twr_tworzy_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->skl_twr_id) && trim($this->skl_twr_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->skl_twr_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->skl_date_created;
				$values[] = $this->skl_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->skl_id) || $this->skl_id == "") {
					$this->skl_id = QID();
				}
				if ($log) {
					L("sk\u0142adnik stored successfully", "id = {$this->skl_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->skl_id) {
				$virgoOld = new virgoSkladnik($this->skl_id);
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
					if ($this->skl_id) {			
						$this->skl_date_modified = date("Y-m-d H:i:s");
						$this->skl_usr_modified_id = $userId;
					} else {
						$this->skl_date_created = date("Y-m-d H:i:s");
						$this->skl_usr_created_id = $userId;
					}
					$this->skl_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "sk\u0142adnik" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "sk\u0142adnik" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM slk_skladniki WHERE skl_id = {$this->skl_id}";
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
			$tmp = new virgoSkladnik();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT skl_id as id FROM slk_skladniki";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'skl_order_column')) {
				$orderBy = " ORDER BY skl_order_column ASC ";
			} 
			if (property_exists($this, 'skl_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY skl_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoSkladnik();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoSkladnik($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_skladniki SET skl_virgo_title = '$title' WHERE skl_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoSkladnik();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" skl_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['skl_id'];
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
			virgoSkladnik::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoSkladnik::setSessionValue('Sealock_Skladnik-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoSkladnik::getSessionValue('Sealock_Skladnik-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoSkladnik::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoSkladnik::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoSkladnik::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoSkladnik::getSessionValue('GLOBAL', $name, $default);
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
			$context['skl_id'] = $id;
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
			$context['skl_id'] = null;
			virgoSkladnik::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoSkladnik::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoSkladnik::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoSkladnik::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoSkladnik::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoSkladnik::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoSkladnik::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoSkladnik::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoSkladnik::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoSkladnik::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoSkladnik::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoSkladnik::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoSkladnik::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoSkladnik::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoSkladnik::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoSkladnik::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoSkladnik::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "skl_id";
			}
			return virgoSkladnik::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoSkladnik::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoSkladnik::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoSkladnik::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoSkladnik::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoSkladnik::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoSkladnik::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoSkladnik::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoSkladnik::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoSkladnik::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoSkladnik::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoSkladnik::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoSkladnik::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->skl_id) {
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
						L(T('STORED_CORRECTLY', 'SKLADNIK'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'ilość', $this->skl_ilosc);
						$parentTowar = new virgoTowar();
						$fieldValues = $fieldValues . T($fieldValue, 'towar tworzy', $parentTowar->lookup($this->skl_twr_tworzy_id));
						$parentTowar = new virgoTowar();
						$fieldValues = $fieldValues . T($fieldValue, 'towar', $parentTowar->lookup($this->skl_twr_id));
						$username = '';
						if ($this->skl_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->skl_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->skl_date_created);
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
			$instance = new virgoSkladnik();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$instance = new virgoSkladnik();
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
			$tmpId = intval(R('skl_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoSkladnik::getContextId();
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
			$this->skl_id = null;
			$this->skl_date_created = null;
			$this->skl_usr_created_id = null;
			$this->skl_date_modified = null;
			$this->skl_usr_modified_id = null;
			$this->skl_virgo_title = null;
			
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

		static function portletActionShowForTowarTworzy() {
			$parentId = R('twr_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoTowar($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForTowar() {
			$parentId = R('twr_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoTowar($parentId);
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
//			$ret = new virgoSkladnik();
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
				$instance = new virgoSkladnik();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoSkladnik::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'SKLADNIK'), '', 'INFO');
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
				$resultSkladnik = new virgoSkladnik();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultSkladnik->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultSkladnik->load($idToEditInt);
					} else {
						$resultSkladnik->skl_id = 0;
					}
				}
				$results[] = $resultSkladnik;
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
				$result = new virgoSkladnik();
				$result->loadFromRequest($idToStore);
				if ($result->skl_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->skl_id == 0) {
						$result->skl_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->skl_id)) {
							$result->skl_id = 0;
						}
						$idsToCorrect[$result->skl_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'SKLADNIKI'), '', 'INFO');
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
			$resultSkladnik = new virgoSkladnik();
			foreach ($idsToDelete as $idToDelete) {
				$resultSkladnik->load((int)trim($idToDelete));
				$res = $resultSkladnik->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'SKLADNIKI'), '', 'INFO');			
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
		$ret = $this->skl_ilosc;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoSkladnik');
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
				$query = "UPDATE slk_skladniki SET skl_virgo_title = ? WHERE skl_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT skl_id AS id FROM slk_skladniki ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoSkladnik($row['id']);
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
				$class2prefix["sealock\\virgoTowar"] = "twr";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoGrupaTowaru"] = "gtw";
				$class2prefix2["sealock\\virgoJednostka"] = "jdn";
				$class2parentPrefix["sealock\\virgoTowar"] = $class2prefix2;
				$class2prefix["sealock\\virgoTowar"] = "twr";
				$class2prefix2 = array();
				$class2prefix2["sealock\\virgoGrupaTowaru"] = "gtw";
				$class2prefix2["sealock\\virgoJednostka"] = "jdn";
				$class2parentPrefix["sealock\\virgoTowar"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'slk_skladniki.skl_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'slk_skladniki.skl_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'slk_skladniki.skl_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'slk_skladniki.skl_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoSkladnik!', '', 'ERROR');
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
			$pdf->SetTitle('Składniki report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('SKLADNIKI');
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
			if (P('show_pdf_towartworzy', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_towar', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultSkladnik = new virgoSkladnik();
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
			if (P('show_pdf_towartworzy', "1") == "1") {
				$minWidth['towar tworzy'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'towar tworzy');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['towar tworzy']) {
						$minWidth['towar tworzy'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_towar', "1") == "1") {
				$minWidth['towar $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'towar $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['towar $relation.name']) {
						$minWidth['towar $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseSkladnik = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseSkladnik = $whereClauseSkladnik . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaSkladnik = $resultSkladnik->getCriteria();
			$fieldCriteriaIlosc = $criteriaSkladnik["ilosc"];
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
			$parentCriteria = $criteriaSkladnik["towartworzy"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoTowar::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaSkladnik["towar"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoTowar::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Towar', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towartworzy');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_skladniki.skl_twr_tworzy_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_skladniki.skl_twr_tworzy_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSkladnik = $whereClauseSkladnik . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_towar');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " slk_skladniki.skl_twr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " slk_skladniki.skl_twr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseSkladnik = $whereClauseSkladnik . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaSkladnik = self::getCriteria();
			if (isset($criteriaSkladnik["ilosc"])) {
				$fieldCriteriaIlosc = $criteriaSkladnik["ilosc"];
				if ($fieldCriteriaIlosc["is_null"] == 1) {
$filter = $filter . ' AND slk_skladniki.skl_ilosc IS NOT NULL ';
				} elseif ($fieldCriteriaIlosc["is_null"] == 2) {
$filter = $filter . ' AND slk_skladniki.skl_ilosc IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaIlosc["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") { 
				$filter = $filter . " AND slk_skladniki.skl_ilosc >= ? ";
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND slk_skladniki.skl_ilosc <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			if (isset($criteriaSkladnik["towartworzy"])) {
				$parentCriteria = $criteriaSkladnik["towartworzy"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND skl_twr_tworzy_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_skladniki.skl_twr_tworzy_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaSkladnik["towar"])) {
				$parentCriteria = $criteriaSkladnik["towar"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND skl_twr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND slk_skladniki.skl_twr_id IN (SELECT twr_id FROM slk_towary WHERE twr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseSkladnik = $whereClauseSkladnik . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseSkladnik = $whereClauseSkladnik . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_skladniki.skl_id, slk_skladniki.skl_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_skladniki.skl_ilosc skl_ilosc";
			} else {
				if ($defaultOrderColumn == "skl_ilosc") {
					$orderColumnNotDisplayed = " slk_skladniki.skl_ilosc ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_pdf_towartworzy', "1") != "0") { // */ && !in_array("twrtworzy", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_tworzy_id as skl_skl_twr_tworzy_id ";
				$queryString = $queryString . ", slk_towary_tworzy.twr_virgo_title as towar_tworzy ";
			} else {
				if ($defaultOrderColumn == "towar_tworzy") {
					$orderColumnNotDisplayed = " slk_towary_tworzy.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_pdf_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_id as skl_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_skladniki ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_tworzy ON (slk_skladniki.skl_twr_tworzy_id = slk_towary_tworzy.twr_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_skladniki.skl_twr_id = slk_towary_parent.twr_id) ";
			}

		$resultsSkladnik = $resultSkladnik->select(
			'', 
			'all', 
			$resultSkladnik->getOrderColumn(), 
			$resultSkladnik->getOrderMode(), 
			$whereClauseSkladnik,
			$queryString);
		
		foreach ($resultsSkladnik as $resultSkladnik) {

			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultSkladnik['skl_ilosc'])) + 6;
				if ($tmpLen > $minWidth['ilo\u015B\u0107']) {
					$minWidth['ilo\u015B\u0107'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_towartworzy', "1") == "1") {
			$parentValue = trim(virgoTowar::lookup($resultSkladnik['skl_twr_tworzy_id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['towar tworzy']) {
					$minWidth['towar tworzy'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = trim(virgoTowar::lookup($resultSkladnik['skltwr__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['towar $relation.name']) {
					$minWidth['towar $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaSkladnik = $resultSkladnik->getCriteria();
		if (is_null($criteriaSkladnik) || sizeof($criteriaSkladnik) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																								if (P('show_pdf_towartworzy', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['towar tworzy'], $colHeight, T('TOWAR') . ' ' . T('TWORZY'), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_ilosc', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, T('ILOSC'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_towar', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['towar $relation.name'], $colHeight, T('TOWAR') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsSkladnik as $resultSkladnik) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_towartworzy', "1") == "1") {
			$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_tworzy_id']);
			$tmpLn = $pdf->MultiCell($minWidth['towar tworzy'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_ilosc', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['ilo\u015B\u0107'], $colHeight, '' . number_format($resultSkladnik['skl_ilosc'], 2, ',', ' '), 'T', 'R', 0, 0);
				if (P('show_pdf_ilosc', "1") == "2") {
										if (!is_null($resultSkladnik['skl_ilosc'])) {
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
										if (!is_null($resultSkladnik['skl_ilosc'])) {
						$tmpSum = (float)$sums["ilosc"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultSkladnik['skl_ilosc'];
						}
						$sums["ilosc"] = $tmpSum;
					}
				}
				if (P('show_pdf_ilosc', "1") == "4") {
										if (!is_null($resultSkladnik['skl_ilosc'])) {
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
							$tmpSum = $tmpSum + $resultSkladnik['skl_ilosc'];
						}
						$avgSums["ilosc"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_towar', "1") == "1") {
			$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_id']);
			$tmpLn = $pdf->MultiCell($minWidth['towar $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
				$reportTitle = T('SKLADNIKI');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultSkladnik = new virgoSkladnik();
			$whereClauseSkladnik = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSkladnik = $whereClauseSkladnik . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_ilosc', "1") != "0") {
					$data = $data . $stringDelimeter .'Ilość' . $stringDelimeter . $separator;
				}
				if (P('show_export_towartworzy', "1") != "0") {
					$data = $data . $stringDelimeter . 'Towar Tworzy' . $stringDelimeter . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$data = $data . $stringDelimeter . 'Towar ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_skladniki.skl_id, slk_skladniki.skl_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_skladniki.skl_ilosc skl_ilosc";
			} else {
				if ($defaultOrderColumn == "skl_ilosc") {
					$orderColumnNotDisplayed = " slk_skladniki.skl_ilosc ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towartworzy', "1") != "0") { // */ && !in_array("twrtworzy", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_tworzy_id as skl_skl_twr_tworzy_id ";
				$queryString = $queryString . ", slk_towary_tworzy.twr_virgo_title as towar_tworzy ";
			} else {
				if ($defaultOrderColumn == "towar_tworzy") {
					$orderColumnNotDisplayed = " slk_towary_tworzy.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_id as skl_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_skladniki ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_tworzy ON (slk_skladniki.skl_twr_tworzy_id = slk_towary_tworzy.twr_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_skladniki.skl_twr_id = slk_towary_parent.twr_id) ";
			}

			$resultsSkladnik = $resultSkladnik->select(
				'', 
				'all', 
				$resultSkladnik->getOrderColumn(), 
				$resultSkladnik->getOrderMode(), 
				$whereClauseSkladnik,
				$queryString);
			foreach ($resultsSkladnik as $resultSkladnik) {
				if (P('show_export_ilosc', "1") != "0") {
			$data = $data . $resultSkladnik['skl_ilosc'] . $separator;
				}
				if (P('show_export_towartworzy', "1") != "0") {
					$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_tworzy_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_towar', "1") != "0") {
					$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_id']);
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
				$reportTitle = T('SKLADNIKI');
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
			$resultSkladnik = new virgoSkladnik();
			$whereClauseSkladnik = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseSkladnik = $whereClauseSkladnik . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_towartworzy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Towar Tworzy');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoTowar::getVirgoList();
					$formulaTowarTworzy = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaTowarTworzy != "") {
							$formulaTowarTworzy = $formulaTowarTworzy . ',';
						}
						$formulaTowarTworzy = $formulaTowarTworzy . $key;
					}
				}
				if (P('show_export_towar', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Towar ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoTowar::getVirgoList();
					$formulaTowar = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaTowar != "") {
							$formulaTowar = $formulaTowar . ',';
						}
						$formulaTowar = $formulaTowar . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_skladniki.skl_id, slk_skladniki.skl_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_ilosc', "1") != "0") {
				$queryString = $queryString . ", slk_skladniki.skl_ilosc skl_ilosc";
			} else {
				if ($defaultOrderColumn == "skl_ilosc") {
					$orderColumnNotDisplayed = " slk_skladniki.skl_ilosc ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towartworzy', "1") != "0") { // */ && !in_array("twrtworzy", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_tworzy_id as skl_skl_twr_tworzy_id ";
				$queryString = $queryString . ", slk_towary_tworzy.twr_virgo_title as towar_tworzy ";
			} else {
				if ($defaultOrderColumn == "towar_tworzy") {
					$orderColumnNotDisplayed = " slk_towary_tworzy.twr_virgo_title ";
				}
			}
			if (class_exists('sealock\virgoTowar') && P('show_export_towar', "1") != "0") { // */ && !in_array("twr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", slk_skladniki.skl_twr_id as skl_twr_id ";
				$queryString = $queryString . ", slk_towary_parent.twr_virgo_title as `towar` ";
			} else {
				if ($defaultOrderColumn == "towar") {
					$orderColumnNotDisplayed = " slk_towary_parent.twr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_skladniki ";
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_tworzy ON (slk_skladniki.skl_twr_tworzy_id = slk_towary_tworzy.twr_id) ";
			}
			if (class_exists('sealock\virgoTowar')) {
				$queryString = $queryString . " LEFT OUTER JOIN slk_towary AS slk_towary_parent ON (slk_skladniki.skl_twr_id = slk_towary_parent.twr_id) ";
			}

			$resultsSkladnik = $resultSkladnik->select(
				'', 
				'all', 
				$resultSkladnik->getOrderColumn(), 
				$resultSkladnik->getOrderMode(), 
				$whereClauseSkladnik,
				$queryString);
			$index = 1;
			foreach ($resultsSkladnik as $resultSkladnik) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultSkladnik['skl_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_ilosc', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultSkladnik['skl_ilosc'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_towartworzy', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_tworzy_id']);
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
					$objValidation->setFormula1('"' . $formulaTowarTworzy . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_towar', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTowar::lookup($resultSkladnik['skl_twr_id']);
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
					$objValidation->setFormula1('"' . $formulaTowar . '"');
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
					$propertyColumnHash['ilo\u015B\u0107'] = 'skl_ilosc';
					$propertyColumnHash['ilosc'] = 'skl_ilosc';
					$propertyClassHash['towar'] = 'Towar';
					$propertyClassHash['towar'] = 'Towar';
					$propertyColumnHash['towar tworzy'] = 'skl_twr_tworzy_id';
					$propertyColumnHash['towar tworzy'] = 'skl_twr_tworzy_id';
					$propertyClassHash['towar'] = 'Towar';
					$propertyClassHash['towar'] = 'Towar';
					$propertyColumnHash['towar'] = 'skl_twr_id';
					$propertyColumnHash['towar'] = 'skl_twr_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importSkladnik = new virgoSkladnik();
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
										L(T('PROPERTY_NOT_FOUND', T('SKLADNIK'), $columns[$index]), '', 'ERROR');
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
										$importSkladnik->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_towartworzy');
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
	$importSkladnik->setTwrTworzyId($defaultValue);
}
$defaultValue = P('import_default_value_towar');
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
	$importSkladnik->setTwrId($defaultValue);
}
							$errorMessage = $importSkladnik->store();
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
		




		static function portletActionVirgoSetTowarTworzy() {
			$this->loadFromDB();
			$parentId = R('skl_TowarTworzy_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTwrTworzyId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetTowar() {
			$this->loadFromDB();
			$parentId = R('skl_Towar_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTwrId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddTowarTworzy() {
			self::setDisplayMode("ADD_NEW_PARENT_TOWAR_TWORZY");
		}

		static function portletActionStoreNewTowarTworzy() {
			$id = -1;
			if (virgoTowar::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_TOWAR_TWORZY");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['skl_towarTworzy_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}
		static function portletActionAddTowar() {
			self::setDisplayMode("ADD_NEW_PARENT_TOWAR");
		}

		static function portletActionStoreNewTowar() {
			$id = -1;
			if (virgoTowar::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_TOWAR");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['skl_towar_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `slk_skladniki` (
  `skl_id` bigint(20) unsigned NOT NULL auto_increment,
  `skl_virgo_state` varchar(50) default NULL,
  `skl_virgo_title` varchar(255) default NULL,
	`skl_twr_tworzy_id` int(11) default NULL,
	`skl_twr_id` int(11) default NULL,
  `skl_ilosc` decimal(10,2),  
  `skl_date_created` datetime NOT NULL,
  `skl_date_modified` datetime default NULL,
  `skl_usr_created_id` int(11) NOT NULL,
  `skl_usr_modified_id` int(11) default NULL,
  KEY `skl_twr_tworzy_fk` (`skl_twr_tworzy_id`),
  KEY `skl_twr_fk` (`skl_twr_id`),
  PRIMARY KEY  (`skl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/skladnik.sql 
INSERT INTO `slk_skladniki` (`skl_virgo_title`, `skl_ilosc`) 
VALUES (title, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably slk_skladniki table already exists.", '', 'FATAL');
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
			return "skl";
		}
		
		static function getPlural() {
			return "skladniki";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoTowar";
			$ret[] = "virgoTowar";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'slk_skladniki'));
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
			$virgoVersion = virgoSkladnik::getVirgoVersion();
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
	
	

