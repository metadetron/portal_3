<?php
/**
* Module Element
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoElement {

		 var  $elm_id = null;
		 var  $elm_key = null;

		 var  $elm_processed = null;

		 var  $elm_result = null;

		 var  $elm_exc_id = null;

		 var   $elm_date_created = null;
		 var   $elm_usr_created_id = null;
		 var   $elm_date_modified = null;
		 var   $elm_usr_modified_id = null;
		 var   $elm_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoElement();
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
        	$this->elm_id = null;
		    $this->elm_date_created = null;
		    $this->elm_usr_created_id = null;
		    $this->elm_date_modified = null;
		    $this->elm_usr_modified_id = null;
		    $this->elm_virgo_title = null;
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
			return $this->elm_id;
		}

		function getKey() {
			return $this->elm_key;
		}
		
		 function setKey($val) {
			$this->elm_key = $val;
		}
		function getProcessed() {
			return $this->elm_processed;
		}
		
		 function setProcessed($val) {
			$this->elm_processed = $val;
		}
		function getResult() {
			return $this->elm_result;
		}
		
		 function setResult($val) {
			$this->elm_result = $val;
		}

		function getExecutionId() {
			return $this->elm_exc_id;
		}
		
		 function setExecutionId($val) {
			$this->elm_exc_id = $val;
		}

		function getDateCreated() {
			return $this->elm_date_created;
		}
		function getUsrCreatedId() {
			return $this->elm_usr_created_id;
		}
		function getDateModified() {
			return $this->elm_date_modified;
		}
		function getUsrModifiedId() {
			return $this->elm_usr_modified_id;
		}


		function getExcId() {
			return $this->getExecutionId();
		}
		
		 function setExcId($val) {
			$this->setExecutionId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->elm_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('elm_key_' . $this->elm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->elm_key = null;
		} else {
			$this->elm_key = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('elm_processed_' . $this->elm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->elm_processed = null;
		} else {
			$this->elm_processed = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('elm_result_' . $this->elm_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->elm_result = null;
		} else {
			$this->elm_result = $tmpValue;
		}
	}
			$this->elm_exc_id = strval(R('elm_execution_' . $this->elm_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('elm_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaElement = array();	
			$criteriaFieldElement = array();	
			$isNullElement = R('virgo_search_key_is_null');
			
			$criteriaFieldElement["is_null"] = 0;
			if ($isNullElement == "not_null") {
				$criteriaFieldElement["is_null"] = 1;
			} elseif ($isNullElement == "null") {
				$criteriaFieldElement["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_key');

//			if ($isSet) {
			$criteriaFieldElement["value"] = $dataTypeCriteria;
//			}
			$criteriaElement["key"] = $criteriaFieldElement;
			$criteriaFieldElement = array();	
			$isNullElement = R('virgo_search_processed_is_null');
			
			$criteriaFieldElement["is_null"] = 0;
			if ($isNullElement == "not_null") {
				$criteriaFieldElement["is_null"] = 1;
			} elseif ($isNullElement == "null") {
				$criteriaFieldElement["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_processed');

//			if ($isSet) {
			$criteriaFieldElement["value"] = $dataTypeCriteria;
//			}
			$criteriaElement["processed"] = $criteriaFieldElement;
			$criteriaFieldElement = array();	
			$isNullElement = R('virgo_search_result_is_null');
			
			$criteriaFieldElement["is_null"] = 0;
			if ($isNullElement == "not_null") {
				$criteriaFieldElement["is_null"] = 1;
			} elseif ($isNullElement == "null") {
				$criteriaFieldElement["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_result');

//			if ($isSet) {
			$criteriaFieldElement["value"] = $dataTypeCriteria;
//			}
			$criteriaElement["result"] = $criteriaFieldElement;
			$criteriaParent = array();	
			$isNull = R('virgo_search_execution_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_execution', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaElement["execution"] = $criteriaParent;
			self::setCriteria($criteriaElement);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_key');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterKey', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterKey', null);
			}
			$tableFilter = R('virgo_filter_processed');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterProcessed', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterProcessed', null);
			}
			$tableFilter = R('virgo_filter_result');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterResult', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterResult', null);
			}
			$parentFilter = R('virgo_filter_execution');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterExecution', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterExecution', null);
			}
			$parentFilter = R('virgo_filter_title_execution');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleExecution', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleExecution', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseElement = ' 1 = 1 ';
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
				$eventColumn = "elm_" . P('event_column');
				$whereClauseElement = $whereClauseElement . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseElement = $whereClauseElement . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_execution');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_elements.elm_exc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_elements.elm_exc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseElement = $whereClauseElement . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaElement = self::getCriteria();
			if (isset($criteriaElement["key"])) {
				$fieldCriteriaKey = $criteriaElement["key"];
				if ($fieldCriteriaKey["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_key IS NOT NULL ';
				} elseif ($fieldCriteriaKey["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_key IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKey["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_elements.elm_key like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaElement["processed"])) {
				$fieldCriteriaProcessed = $criteriaElement["processed"];
				if ($fieldCriteriaProcessed["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_processed IS NOT NULL ';
				} elseif ($fieldCriteriaProcessed["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_processed IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProcessed["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_elements.elm_processed = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaElement["result"])) {
				$fieldCriteriaResult = $criteriaElement["result"];
				if ($fieldCriteriaResult["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_result IS NOT NULL ';
				} elseif ($fieldCriteriaResult["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_result IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaResult["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_elements.elm_result like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaElement["execution"])) {
				$parentCriteria = $criteriaElement["execution"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND elm_exc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_elements.elm_exc_id IN (SELECT exc_id FROM prt_executions WHERE exc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseElement = $whereClauseElement . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseElement = $whereClauseElement . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseElement = $whereClauseElement . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterKey', null);
				if (S($tableFilter)) {
					$whereClauseElement = $whereClauseElement . " AND elm_key LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterProcessed', null);
				if (S($tableFilter)) {
					$whereClauseElement = $whereClauseElement . " AND elm_processed LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterResult', null);
				if (S($tableFilter)) {
					$whereClauseElement = $whereClauseElement . " AND elm_result LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterExecution', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseElement = $whereClauseElement . " AND elm_exc_id IS NULL ";
					} else {
						$whereClauseElement = $whereClauseElement . " AND elm_exc_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleExecution', null);
				if (S($parentFilter)) {
					$whereClauseElement = $whereClauseElement . " AND prt_executions_parent.exc_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseElement;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseElement = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_elements.elm_id, prt_elements.elm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_key', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_key elm_key";
			} else {
				if ($defaultOrderColumn == "elm_key") {
					$orderColumnNotDisplayed = " prt_elements.elm_key ";
				}
			}
			if (P('show_table_processed', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_processed elm_processed";
			} else {
				if ($defaultOrderColumn == "elm_processed") {
					$orderColumnNotDisplayed = " prt_elements.elm_processed ";
				}
			}
			if (P('show_table_result', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_result elm_result";
			} else {
				if ($defaultOrderColumn == "elm_result") {
					$orderColumnNotDisplayed = " prt_elements.elm_result ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_table_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_elements.elm_exc_id as elm_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_elements ";
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_elements.elm_exc_id = prt_executions_parent.exc_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseElement = $whereClauseElement . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseElement, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseElement,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_elements"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " elm_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " elm_usr_created_id = ? ";
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
				. "\n FROM prt_elements"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_elements ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_elements ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, elm_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " elm_usr_created_id = ? ";
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
				$query = "SELECT COUNT(elm_id) cnt FROM elements";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as elements ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as elements ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoElement();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_elements WHERE elm_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->elm_id = $row['elm_id'];
$this->elm_key = $row['elm_key'];
$this->elm_processed = $row['elm_processed'];
$this->elm_result = $row['elm_result'];
						$this->elm_exc_id = $row['elm_exc_id'];
						if ($fetchUsernames) {
							if ($row['elm_date_created']) {
								if ($row['elm_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['elm_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['elm_date_modified']) {
								if ($row['elm_usr_modified_id'] == $row['elm_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['elm_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['elm_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->elm_date_created = $row['elm_date_created'];
						$this->elm_usr_created_id = $fetchUsernames ? $createdBy : $row['elm_usr_created_id'];
						$this->elm_date_modified = $row['elm_date_modified'];
						$this->elm_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['elm_usr_modified_id'];
						$this->elm_virgo_title = $row['elm_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_elements SET elm_usr_created_id = {$userId} WHERE elm_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->elm_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoElement::selectAllAsObjectsStatic('elm_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->elm_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->elm_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('elm_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_elm = new virgoElement();
				$tmp_elm->load((int)$lookup_id);
				return $tmp_elm->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoElement');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" elm_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoElement', "10");
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
				$query = $query . " elm_id as id, elm_virgo_title as title ";
			}
			$query = $query . " FROM prt_elements ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoElement', 'portal') == "1") {
				$privateCondition = " elm_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY elm_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resElement = array();
				foreach ($rows as $row) {
					$resElement[$row['id']] = $row['title'];
				}
				return $resElement;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticElement = new virgoElement();
			return $staticElement->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getExecutionStatic($parentId) {
			return virgoExecution::getById($parentId);
		}
		
		function getExecution() {
			return virgoElement::getExecutionStatic($this->elm_exc_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getKey()) || trim($this->getKey()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'KEY');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_processed_obligatory', "0") == "1") {
				if (
(is_null($this->getProcessed()) || trim($this->getProcessed()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PROCESSED');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_result_obligatory', "0") == "1") {
				if (
(is_null($this->getResult()) || trim($this->getResult()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'RESULT');
				}			
			}
				if (is_null($this->elm_exc_id) || trim($this->elm_exc_id) == "") {
					if (R('create_elm_execution_' . $this->elm_id) == "1") { 
						$parent = new virgoExecution();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->elm_exc_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'EXECUTION', '');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_elements WHERE elm_id = " . $this->getId();
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
				$colNames = $colNames . ", elm_key";
				$values = $values . ", " . (is_null($objectToStore->getKey()) ? "null" : "'" . QE($objectToStore->getKey()) . "'");
				$colNames = $colNames . ", elm_processed";
				$values = $values . ", " . (is_null($objectToStore->getProcessed()) ? "null" : "'" . QE($objectToStore->getProcessed()) . "'");
				$colNames = $colNames . ", elm_result";
				$values = $values . ", " . (is_null($objectToStore->getResult()) ? "null" : "'" . QE($objectToStore->getResult()) . "'");
				$colNames = $colNames . ", elm_exc_id";
				$values = $values . ", " . (is_null($objectToStore->getExcId()) || $objectToStore->getExcId() == "" ? "null" : $objectToStore->getExcId());
				$query = "INSERT INTO prt_history_elements (revision, ip, username, user_id, timestamp, elm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getKey() != $objectToStore->getKey()) {
				if (is_null($objectToStore->getKey())) {
					$nullifiedProperties = $nullifiedProperties . "key,";
				} else {
				$colNames = $colNames . ", elm_key";
				$values = $values . ", " . (is_null($objectToStore->getKey()) ? "null" : "'" . QE($objectToStore->getKey()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getProcessed() != $objectToStore->getProcessed()) {
				if (is_null($objectToStore->getProcessed())) {
					$nullifiedProperties = $nullifiedProperties . "processed,";
				} else {
				$colNames = $colNames . ", elm_processed";
				$values = $values . ", " . (is_null($objectToStore->getProcessed()) ? "null" : "'" . QE($objectToStore->getProcessed()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getResult() != $objectToStore->getResult()) {
				if (is_null($objectToStore->getResult())) {
					$nullifiedProperties = $nullifiedProperties . "result,";
				} else {
				$colNames = $colNames . ", elm_result";
				$values = $values . ", " . (is_null($objectToStore->getResult()) ? "null" : "'" . QE($objectToStore->getResult()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getExcId() != $objectToStore->getExcId() && ($virgoOld->getExcId() != 0 || $objectToStore->getExcId() != ""))) { 
				$colNames = $colNames . ", elm_exc_id";
				$values = $values . ", " . (is_null($objectToStore->getExcId()) ? "null" : ($objectToStore->getExcId() == "" ? "0" : $objectToStore->getExcId()));
			}
			$query = "INSERT INTO prt_history_elements (revision, ip, username, user_id, timestamp, elm_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_elements");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'elm_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_elements ADD COLUMN (elm_virgo_title VARCHAR(255));";
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
			if (isset($this->elm_id) && $this->elm_id != "") {
				$query = "UPDATE prt_elements SET ";
			if (isset($this->elm_key)) {
				$query .= " elm_key = ? ,";
				$types .= "s";
				$values[] = $this->elm_key;
			} else {
				$query .= " elm_key = NULL ,";				
			}
			if (isset($this->elm_processed)) {
				$query .= " elm_processed = ? ,";
				$types .= "s";
				$values[] = $this->elm_processed;
			} else {
				$query .= " elm_processed = NULL ,";				
			}
			if (isset($this->elm_result)) {
				$query .= " elm_result = ? ,";
				$types .= "s";
				$values[] = $this->elm_result;
			} else {
				$query .= " elm_result = NULL ,";				
			}
				if (isset($this->elm_exc_id) && trim($this->elm_exc_id) != "") {
					$query = $query . " elm_exc_id = ? , ";
					$types = $types . "i";
					$values[] = $this->elm_exc_id;
				} else {
					$query = $query . " elm_exc_id = NULL, ";
				}
				$query = $query . " elm_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " elm_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->elm_date_modified;

				$query = $query . " elm_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->elm_usr_modified_id;

				$query = $query . " WHERE elm_id = ? ";
				$types = $types . "i";
				$values[] = $this->elm_id;
			} else {
				$query = "INSERT INTO prt_elements ( ";
			$query = $query . " elm_key, ";
			$query = $query . " elm_processed, ";
			$query = $query . " elm_result, ";
				$query = $query . " elm_exc_id, ";
				$query = $query . " elm_virgo_title, elm_date_created, elm_usr_created_id) VALUES ( ";
			if (isset($this->elm_key)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->elm_key;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->elm_processed)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->elm_processed;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->elm_result)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->elm_result;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->elm_exc_id) && trim($this->elm_exc_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->elm_exc_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->elm_date_created;
				$values[] = $this->elm_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->elm_id) || $this->elm_id == "") {
					$this->elm_id = QID();
				}
				if ($log) {
					L("element stored successfully", "id = {$this->elm_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->elm_id) {
				$virgoOld = new virgoElement($this->elm_id);
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
					if ($this->elm_id) {			
						$this->elm_date_modified = date("Y-m-d H:i:s");
						$this->elm_usr_modified_id = $userId;
					} else {
						$this->elm_date_created = date("Y-m-d H:i:s");
						$this->elm_usr_created_id = $userId;
					}
					$this->elm_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "element" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "element" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_elements WHERE elm_id = {$this->elm_id}";
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
			$tmp = new virgoElement();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT elm_id as id FROM prt_elements";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'elm_order_column')) {
				$orderBy = " ORDER BY elm_order_column ASC ";
			} 
			if (property_exists($this, 'elm_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY elm_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoElement();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoElement($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_elements SET elm_virgo_title = '$title' WHERE elm_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoElement();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" elm_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['elm_id'];
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
			virgoElement::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoElement::setSessionValue('Portal_Element-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoElement::getSessionValue('Portal_Element-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoElement::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoElement::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoElement::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoElement::getSessionValue('GLOBAL', $name, $default);
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
			$context['elm_id'] = $id;
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
			$context['elm_id'] = null;
			virgoElement::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoElement::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoElement::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoElement::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoElement::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoElement::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoElement::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoElement::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoElement::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoElement::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoElement::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoElement::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoElement::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoElement::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoElement::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoElement::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoElement::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "elm_id";
			}
			return virgoElement::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoElement::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoElement::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoElement::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoElement::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoElement::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoElement::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoElement::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoElement::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoElement::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoElement::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoElement::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoElement::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->elm_id) {
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
						L(T('STORED_CORRECTLY', 'ELEMENT'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'key', $this->elm_key);
						$fieldValues = $fieldValues . T($fieldValue, 'processed', $this->elm_processed);
						$fieldValues = $fieldValues . T($fieldValue, 'result', $this->elm_result);
						$parentExecution = new virgoExecution();
						$fieldValues = $fieldValues . T($fieldValue, 'execution', $parentExecution->lookup($this->elm_exc_id));
						$username = '';
						if ($this->elm_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->elm_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->elm_date_created);
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
			$instance = new virgoElement();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoElement'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$this->loadFromRequest();
			$oldId = $this->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			$errorMessage = $this->internalActionStore(false);
			if ($errorMessage == "") {
				$this->putInContext(isset($oldId));
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
			$tmpId = intval(R('elm_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoElement::getContextId();
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
			$this->elm_id = null;
			$this->elm_date_created = null;
			$this->elm_usr_created_id = null;
			$this->elm_date_modified = null;
			$this->elm_usr_modified_id = null;
			$this->elm_virgo_title = null;
			
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

		static function portletActionShowForExecution() {
			$parentId = R('exc_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoExecution($parentId);
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
//			$ret = new virgoElement();
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
				$instance = new virgoElement();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoElement::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'ELEMENT'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoSetProcessedTrue() {
			$this->loadFromDB();
			$this->setProcessed(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetProcessedFalse() {
			$this->loadFromDB();
			$this->setProcessed(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isProcessed() {
			return $this->getProcessed() == 1;
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
				$resultElement = new virgoElement();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultElement->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultElement->load($idToEditInt);
					} else {
						$resultElement->elm_id = 0;
					}
				}
				$results[] = $resultElement;
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
				$result = new virgoElement();
				$result->loadFromRequest($idToStore);
				if ($result->elm_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->elm_id == 0) {
						$result->elm_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->elm_id)) {
							$result->elm_id = 0;
						}
						$idsToCorrect[$result->elm_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'ELEMENTS'), '', 'INFO');
				}
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				L(T('INVALID_RECORDS', $errors), '', 'ERROR');
				$this->setInvalidRecords($idsToCorrect);
				return -1;
			}
		}

		function multipleDelete($idsToDelete) {
			$errorOcurred = 0;
			$resultElement = new virgoElement();
			foreach ($idsToDelete as $idToDelete) {
				$resultElement->load((int)trim($idToDelete));
				$res = $resultElement->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'ELEMENTS'), '', 'INFO');			
				self::setDisplayMode("TABLE");
				return 0;
			} else {
				return -1;
			}
		}

		function getSelectedIds($name = 'ids') {
			$idsString = R($name);
			if (trim($idsString) == "") {
				return array();
			}
			return preg_split("/,/", $idsString);			
		}
		
		static function portletActionDeleteSelected() {
			$idsToDelete = $this->getSelectedIds();
			return $this->multipleDelete($idsToDelete);
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
		$ret = $this->elm_key;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoElement');
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
				$query = "UPDATE prt_elements SET elm_virgo_title = ? WHERE elm_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT elm_id AS id FROM prt_elements ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoElement($row['id']);
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
				$class2prefix["portal\\virgoExecution"] = "exc";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoProcess"] = "prc";
				$class2parentPrefix["portal\\virgoExecution"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_elements.elm_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_elements.elm_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_elements.elm_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_elements.elm_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoElement!', '', 'ERROR');
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
			$pdf->SetTitle('Elements report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('ELEMENTS');
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
			if (P('show_pdf_key', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_processed', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_result', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_execution', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultElement = new virgoElement();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_key', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Key');
				$minWidth['key'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['key']) {
						$minWidth['key'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_processed', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Processed');
				$minWidth['processed'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['processed']) {
						$minWidth['processed'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Result');
				$minWidth['result'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['result']) {
						$minWidth['result'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_execution', "1") == "1") {
				$minWidth['execution $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'execution $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['execution $relation.name']) {
						$minWidth['execution $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseElement = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseElement = $whereClauseElement . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaElement = $resultElement->getCriteria();
			$fieldCriteriaKey = $criteriaElement["key"];
			if ($fieldCriteriaKey["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Key', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaKey["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Key', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaProcessed = $criteriaElement["processed"];
			if ($fieldCriteriaProcessed["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Processed', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaProcessed["value"];
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
					$pdf->MultiCell(60, 100, 'Processed', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaResult = $criteriaElement["result"];
			if ($fieldCriteriaResult["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Result', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaResult["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Result', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaElement["execution"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Execution', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoExecution::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Execution', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_execution');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_elements.elm_exc_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_elements.elm_exc_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseElement = $whereClauseElement . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaElement = self::getCriteria();
			if (isset($criteriaElement["key"])) {
				$fieldCriteriaKey = $criteriaElement["key"];
				if ($fieldCriteriaKey["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_key IS NOT NULL ';
				} elseif ($fieldCriteriaKey["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_key IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaKey["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_elements.elm_key like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaElement["processed"])) {
				$fieldCriteriaProcessed = $criteriaElement["processed"];
				if ($fieldCriteriaProcessed["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_processed IS NOT NULL ';
				} elseif ($fieldCriteriaProcessed["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_processed IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaProcessed["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_elements.elm_processed = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaElement["result"])) {
				$fieldCriteriaResult = $criteriaElement["result"];
				if ($fieldCriteriaResult["is_null"] == 1) {
$filter = $filter . ' AND prt_elements.elm_result IS NOT NULL ';
				} elseif ($fieldCriteriaResult["is_null"] == 2) {
$filter = $filter . ' AND prt_elements.elm_result IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaResult["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_elements.elm_result like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaElement["execution"])) {
				$parentCriteria = $criteriaElement["execution"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND elm_exc_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_elements.elm_exc_id IN (SELECT exc_id FROM prt_executions WHERE exc_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseElement = $whereClauseElement . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseElement = $whereClauseElement . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_elements.elm_id, prt_elements.elm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_key', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_key elm_key";
			} else {
				if ($defaultOrderColumn == "elm_key") {
					$orderColumnNotDisplayed = " prt_elements.elm_key ";
				}
			}
			if (P('show_pdf_processed', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_processed elm_processed";
			} else {
				if ($defaultOrderColumn == "elm_processed") {
					$orderColumnNotDisplayed = " prt_elements.elm_processed ";
				}
			}
			if (P('show_pdf_result', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_result elm_result";
			} else {
				if ($defaultOrderColumn == "elm_result") {
					$orderColumnNotDisplayed = " prt_elements.elm_result ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_pdf_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_elements.elm_exc_id as elm_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_elements ";
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_elements.elm_exc_id = prt_executions_parent.exc_id) ";
			}

		$resultsElement = $resultElement->select(
			'', 
			'all', 
			$resultElement->getOrderColumn(), 
			$resultElement->getOrderMode(), 
			$whereClauseElement,
			$queryString);
		
		foreach ($resultsElement as $resultElement) {

			if (P('show_pdf_key', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultElement['elm_key'])) + 6;
				if ($tmpLen > $minWidth['key']) {
					$minWidth['key'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_processed', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultElement['elm_processed'])) + 6;
				if ($tmpLen > $minWidth['processed']) {
					$minWidth['processed'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_result', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultElement['elm_result'])) + 6;
				if ($tmpLen > $minWidth['result']) {
					$minWidth['result'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_execution', "1") == "1") {
			$parentValue = trim(virgoExecution::lookup($resultElement['elmexc__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['execution $relation.name']) {
					$minWidth['execution $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaElement = $resultElement->getCriteria();
		if (is_null($criteriaElement) || sizeof($criteriaElement) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																															if (P('show_pdf_execution', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['execution $relation.name'], $colHeight, T('EXECUTION') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_key', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['key'], $colHeight, T('KEY'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_processed', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['processed'], $colHeight, T('PROCESSED'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_result', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['result'], $colHeight, T('RESULT'), 'T', 'C', 0, 0);
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
		foreach ($resultsElement as $resultElement) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_execution', "1") == "1") {
			$parentValue = virgoExecution::lookup($resultElement['elm_exc_id']);
			$tmpLn = $pdf->MultiCell($minWidth['execution $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_key', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['key'], $colHeight, '' . $resultElement['elm_key'], 'T', 'L', 0, 0);
				if (P('show_pdf_key', "1") == "2") {
										if (!is_null($resultElement['elm_key'])) {
						$tmpCount = (float)$counts["key"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["key"] = $tmpCount;
					}
				}
				if (P('show_pdf_key', "1") == "3") {
										if (!is_null($resultElement['elm_key'])) {
						$tmpSum = (float)$sums["key"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_key'];
						}
						$sums["key"] = $tmpSum;
					}
				}
				if (P('show_pdf_key', "1") == "4") {
										if (!is_null($resultElement['elm_key'])) {
						$tmpCount = (float)$avgCounts["key"];
						$tmpSum = (float)$avgSums["key"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["key"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_key'];
						}
						$avgSums["key"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_processed', "0") != "0") {
			$renderCriteria = "";
			switch ($resultElement['elm_processed']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['processed'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_processed', "1") == "2") {
										if (!is_null($resultElement['elm_processed'])) {
						$tmpCount = (float)$counts["processed"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["processed"] = $tmpCount;
					}
				}
				if (P('show_pdf_processed', "1") == "3") {
										if (!is_null($resultElement['elm_processed'])) {
						$tmpSum = (float)$sums["processed"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_processed'];
						}
						$sums["processed"] = $tmpSum;
					}
				}
				if (P('show_pdf_processed', "1") == "4") {
										if (!is_null($resultElement['elm_processed'])) {
						$tmpCount = (float)$avgCounts["processed"];
						$tmpSum = (float)$avgSums["processed"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["processed"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_processed'];
						}
						$avgSums["processed"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_result', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['result'], $colHeight, '' . $resultElement['elm_result'], 'T', 'L', 0, 0);
				if (P('show_pdf_result', "1") == "2") {
										if (!is_null($resultElement['elm_result'])) {
						$tmpCount = (float)$counts["result"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["result"] = $tmpCount;
					}
				}
				if (P('show_pdf_result', "1") == "3") {
										if (!is_null($resultElement['elm_result'])) {
						$tmpSum = (float)$sums["result"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_result'];
						}
						$sums["result"] = $tmpSum;
					}
				}
				if (P('show_pdf_result', "1") == "4") {
										if (!is_null($resultElement['elm_result'])) {
						$tmpCount = (float)$avgCounts["result"];
						$tmpSum = (float)$avgSums["result"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["result"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultElement['elm_result'];
						}
						$avgSums["result"] = $tmpSum;
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
			if (P('show_pdf_key', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['key'];
				if (P('show_pdf_key', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["key"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_processed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['processed'];
				if (P('show_pdf_processed', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["processed"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["result"];
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
			if (P('show_pdf_key', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['key'];
				if (P('show_pdf_key', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["key"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_processed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['processed'];
				if (P('show_pdf_processed', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["processed"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["result"], 2, ',', ' ');
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
			if (P('show_pdf_key', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['key'];
				if (P('show_pdf_key', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["key"] == 0 ? "-" : $avgSums["key"] / $avgCounts["key"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_processed', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['processed'];
				if (P('show_pdf_processed', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["processed"] == 0 ? "-" : $avgSums["processed"] / $avgCounts["processed"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_result', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['result'];
				if (P('show_pdf_result', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["result"] == 0 ? "-" : $avgSums["result"] / $avgCounts["result"]);
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
				$reportTitle = T('ELEMENTS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultElement = new virgoElement();
			$whereClauseElement = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseElement = $whereClauseElement . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_key', "1") != "0") {
					$data = $data . $stringDelimeter .'Key' . $stringDelimeter . $separator;
				}
				if (P('show_export_processed', "1") != "0") {
					$data = $data . $stringDelimeter .'Processed' . $stringDelimeter . $separator;
				}
				if (P('show_export_result', "1") != "0") {
					$data = $data . $stringDelimeter .'Result' . $stringDelimeter . $separator;
				}
				if (P('show_export_execution', "1") != "0") {
					$data = $data . $stringDelimeter . 'Execution ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_elements.elm_id, prt_elements.elm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_key', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_key elm_key";
			} else {
				if ($defaultOrderColumn == "elm_key") {
					$orderColumnNotDisplayed = " prt_elements.elm_key ";
				}
			}
			if (P('show_export_processed', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_processed elm_processed";
			} else {
				if ($defaultOrderColumn == "elm_processed") {
					$orderColumnNotDisplayed = " prt_elements.elm_processed ";
				}
			}
			if (P('show_export_result', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_result elm_result";
			} else {
				if ($defaultOrderColumn == "elm_result") {
					$orderColumnNotDisplayed = " prt_elements.elm_result ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_export_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_elements.elm_exc_id as elm_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_elements ";
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_elements.elm_exc_id = prt_executions_parent.exc_id) ";
			}

			$resultsElement = $resultElement->select(
				'', 
				'all', 
				$resultElement->getOrderColumn(), 
				$resultElement->getOrderMode(), 
				$whereClauseElement,
				$queryString);
			foreach ($resultsElement as $resultElement) {
				if (P('show_export_key', "1") != "0") {
			$data = $data . $stringDelimeter . $resultElement['elm_key'] . $stringDelimeter . $separator;
				}
				if (P('show_export_processed', "1") != "0") {
			$data = $data . $resultElement['elm_processed'] . $separator;
				}
				if (P('show_export_result', "1") != "0") {
			$data = $data . $stringDelimeter . $resultElement['elm_result'] . $stringDelimeter . $separator;
				}
				if (P('show_export_execution', "1") != "0") {
					$parentValue = virgoExecution::lookup($resultElement['elm_exc_id']);
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
				$reportTitle = T('ELEMENTS');
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
			$resultElement = new virgoElement();
			$whereClauseElement = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseElement = $whereClauseElement . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_key', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Key');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_processed', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Processed');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_result', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Result');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_execution', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Execution ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoExecution::getVirgoList();
					$formulaExecution = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaExecution != "") {
							$formulaExecution = $formulaExecution . ',';
						}
						$formulaExecution = $formulaExecution . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_elements.elm_id, prt_elements.elm_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_key', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_key elm_key";
			} else {
				if ($defaultOrderColumn == "elm_key") {
					$orderColumnNotDisplayed = " prt_elements.elm_key ";
				}
			}
			if (P('show_export_processed', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_processed elm_processed";
			} else {
				if ($defaultOrderColumn == "elm_processed") {
					$orderColumnNotDisplayed = " prt_elements.elm_processed ";
				}
			}
			if (P('show_export_result', "1") != "0") {
				$queryString = $queryString . ", prt_elements.elm_result elm_result";
			} else {
				if ($defaultOrderColumn == "elm_result") {
					$orderColumnNotDisplayed = " prt_elements.elm_result ";
				}
			}
			if (class_exists('portal\virgoExecution') && P('show_export_execution', "1") != "0") { // */ && !in_array("exc", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_elements.elm_exc_id as elm_exc_id ";
				$queryString = $queryString . ", prt_executions_parent.exc_virgo_title as `execution` ";
			} else {
				if ($defaultOrderColumn == "execution") {
					$orderColumnNotDisplayed = " prt_executions_parent.exc_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_elements ";
			if (class_exists('portal\virgoExecution')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_executions AS prt_executions_parent ON (prt_elements.elm_exc_id = prt_executions_parent.exc_id) ";
			}

			$resultsElement = $resultElement->select(
				'', 
				'all', 
				$resultElement->getOrderColumn(), 
				$resultElement->getOrderMode(), 
				$whereClauseElement,
				$queryString);
			$index = 1;
			foreach ($resultsElement as $resultElement) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultElement['elm_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_key', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultElement['elm_key'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_processed', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultElement['elm_processed'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_result', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultElement['elm_result'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_execution', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoExecution::lookup($resultElement['elm_exc_id']);
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
					$objValidation->setFormula1('"' . $formulaExecution . '"');
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
					$propertyColumnHash['key'] = 'elm_key';
					$propertyColumnHash['key'] = 'elm_key';
					$propertyColumnHash['processed'] = 'elm_processed';
					$propertyColumnHash['processed'] = 'elm_processed';
					$propertyColumnHash['result'] = 'elm_result';
					$propertyColumnHash['result'] = 'elm_result';
					$propertyClassHash['execution'] = 'Execution';
					$propertyClassHash['execution'] = 'Execution';
					$propertyColumnHash['execution'] = 'elm_exc_id';
					$propertyColumnHash['execution'] = 'elm_exc_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importElement = new virgoElement();
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
										L(T('PROPERTY_NOT_FOUND', T('ELEMENT'), $columns[$index]), '', 'ERROR');
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
										$importElement->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_execution');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoExecution::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoExecution::token2Id($tmpToken);
	}
	$importElement->setExcId($defaultValue);
}
							$errorMessage = $importElement->store();
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
		




		static function portletActionVirgoSetExecution() {
			$this->loadFromDB();
			$parentId = R('elm_Execution_id_' . $_SESSION['current_portlet_object_id']);
			$this->setExcId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddExecution() {
			self::setDisplayMode("ADD_NEW_PARENT_EXECUTION");
		}

		static function portletActionStoreNewExecution() {
			$id = -1;
			if (virgoExecution::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_EXECUTION");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['elm_execution_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
			function process() {
				$this->setProcessed(true);
				$this->store();
				$virgoKey = $this->getKey();
				$virgoExecution = $this->getExecution();
				$virgoResult = null;
				
				if (false) {
					$prefix = " ?> ";
					$sufix = " <?php ";
				} else {
					$prefix = "";
					$sufix = "";
				}
				ob_start();
				$ret = eval($prefix . " " . $this->getExecution()->getProcess()->getExecutionCode() . " " . $sufix);				
				if ('' !== $error = ob_get_clean()) {
					L($error, '', 'ERROR');
				}			
				
//				$this->setPrzetworzony(true);
				$this->setResult($virgoResult);
				$this->store();
				
				$query = "UPDATE prt_executions SET exc_progress = (SELECT ROUND(COUNT(elm_processed) * 100 / COUNT(elm_id)) percent FROM prt_elements WHERE elm_exc_id = {$virgoExecution->getId()}) WHERE exc_id = {$virgoExecution->getId()}" ;
				Q($query);
			}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_elements` (
  `elm_id` bigint(20) unsigned NOT NULL auto_increment,
  `elm_virgo_state` varchar(50) default NULL,
  `elm_virgo_title` varchar(255) default NULL,
	`elm_exc_id` int(11) default NULL,
  `elm_key` varchar(255), 
  `elm_processed` boolean,  
  `elm_result` varchar(255), 
  `elm_date_created` datetime NOT NULL,
  `elm_date_modified` datetime default NULL,
  `elm_usr_created_id` int(11) NOT NULL,
  `elm_usr_modified_id` int(11) default NULL,
  KEY `elm_exc_fk` (`elm_exc_id`),
  PRIMARY KEY  (`elm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/element.sql 
INSERT INTO `prt_elements` (`elm_virgo_title`, `elm_key`, `elm_processed`, `elm_result`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_elements table already exists.", '', 'FATAL');
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
			return "elm";
		}
		
		static function getPlural() {
			return "elements";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoExecution";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_elements'));
			foreach ($rows as $row) {
				return $row['table_type'];
			}
			return "";
		}
		
		static function getStructureVersion() {
			return "1.5" . 
''
			;
		}
		
		static function getVirgoVersion() {
			return
"2.0.0.0"  
			;
		}
		
		static function checkCompatibility() {
			$virgoVersion = virgoElement::getVirgoVersion();
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
	
	

