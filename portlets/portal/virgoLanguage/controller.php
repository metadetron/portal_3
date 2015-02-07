<?php
/**
* Module Language
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTranslation'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoHtmlContent'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoLanguage {

		 var  $lng_id = null;
		 var  $lng_code = null;

		 var  $lng_name = null;

		 var  $lng_default = null;

		 var  $lng_public = null;

		 var  $lng_order = null;


		 var   $lng_date_created = null;
		 var   $lng_usr_created_id = null;
		 var   $lng_date_modified = null;
		 var   $lng_usr_modified_id = null;
		 var   $lng_virgo_title = null;
		 var   $lng_virgo_deleted = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoLanguage();
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
        	$this->lng_id = null;
		    $this->lng_date_created = null;
		    $this->lng_usr_created_id = null;
		    $this->lng_date_modified = null;
		    $this->lng_usr_modified_id = null;
		    $this->lng_virgo_title = null;
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
			return $this->lng_id;
		}

		function getCode() {
			return $this->lng_code;
		}
		
		 function setCode($val) {
			$this->lng_code = $val;
		}
		function getName() {
			return $this->lng_name;
		}
		
		 function setName($val) {
			$this->lng_name = $val;
		}
		function getDefault() {
			return $this->lng_default;
		}
		
		 function setDefault($val) {
			$this->lng_default = $val;
		}
		function getPublic() {
			return $this->lng_public;
		}
		
		 function setPublic($val) {
			$this->lng_public = $val;
		}
		function getOrder() {
			return $this->lng_order;
		}
		
		 function setOrder($val) {
			$this->lng_order = $val;
		}


		function getDateCreated() {
			return $this->lng_date_created;
		}
		function getUsrCreatedId() {
			return $this->lng_usr_created_id;
		}
		function getDateModified() {
			return $this->lng_date_modified;
		}
		function getUsrModifiedId() {
			return $this->lng_usr_modified_id;
		}



		function loadRecordFromRequest($rowId) {
			$this->lng_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('lng_code_' . $this->lng_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->lng_code = null;
		} else {
			$this->lng_code = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('lng_name_' . $this->lng_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->lng_name = null;
		} else {
			$this->lng_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('lng_default_' . $this->lng_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->lng_default = null;
		} else {
			$this->lng_default = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('lng_public_' . $this->lng_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->lng_public = null;
		} else {
			$this->lng_public = $tmpValue;
		}
	}

	$tmpValue = null;
	$tmpValue = R('lng_order_' . $this->lng_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->lng_order = null;
		} else {
			$this->lng_order = $tmpValue;
		}
	}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('lng_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaLanguage = array();	
			$criteriaFieldLanguage = array();	
			$isNullLanguage = R('virgo_search_code_is_null');
			
			$criteriaFieldLanguage["is_null"] = 0;
			if ($isNullLanguage == "not_null") {
				$criteriaFieldLanguage["is_null"] = 1;
			} elseif ($isNullLanguage == "null") {
				$criteriaFieldLanguage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_code');

//			if ($isSet) {
			$criteriaFieldLanguage["value"] = $dataTypeCriteria;
//			}
			$criteriaLanguage["code"] = $criteriaFieldLanguage;
			$criteriaFieldLanguage = array();	
			$isNullLanguage = R('virgo_search_name_is_null');
			
			$criteriaFieldLanguage["is_null"] = 0;
			if ($isNullLanguage == "not_null") {
				$criteriaFieldLanguage["is_null"] = 1;
			} elseif ($isNullLanguage == "null") {
				$criteriaFieldLanguage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldLanguage["value"] = $dataTypeCriteria;
//			}
			$criteriaLanguage["name"] = $criteriaFieldLanguage;
			$criteriaFieldLanguage = array();	
			$isNullLanguage = R('virgo_search_default_is_null');
			
			$criteriaFieldLanguage["is_null"] = 0;
			if ($isNullLanguage == "not_null") {
				$criteriaFieldLanguage["is_null"] = 1;
			} elseif ($isNullLanguage == "null") {
				$criteriaFieldLanguage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_default');

//			if ($isSet) {
			$criteriaFieldLanguage["value"] = $dataTypeCriteria;
//			}
			$criteriaLanguage["default"] = $criteriaFieldLanguage;
			$criteriaFieldLanguage = array();	
			$isNullLanguage = R('virgo_search_public_is_null');
			
			$criteriaFieldLanguage["is_null"] = 0;
			if ($isNullLanguage == "not_null") {
				$criteriaFieldLanguage["is_null"] = 1;
			} elseif ($isNullLanguage == "null") {
				$criteriaFieldLanguage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
	$dataTypeCriteria["default"] = R('virgo_search_public');

//			if ($isSet) {
			$criteriaFieldLanguage["value"] = $dataTypeCriteria;
//			}
			$criteriaLanguage["public"] = $criteriaFieldLanguage;
			$criteriaFieldLanguage = array();	
			$isNullLanguage = R('virgo_search_order_is_null');
			
			$criteriaFieldLanguage["is_null"] = 0;
			if ($isNullLanguage == "not_null") {
				$criteriaFieldLanguage["is_null"] = 1;
			} elseif ($isNullLanguage == "null") {
				$criteriaFieldLanguage["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["from"] = R('virgo_search_order_from');
		$dataTypeCriteria["to"] = R('virgo_search_order_to');

//			if ($isSet) {
			$criteriaFieldLanguage["value"] = $dataTypeCriteria;
//			}
			$criteriaLanguage["order"] = $criteriaFieldLanguage;
			self::setCriteria($criteriaLanguage);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_code');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCode', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCode', null);
			}
			$tableFilter = R('virgo_filter_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterName', null);
			}
			$tableFilter = R('virgo_filter_default');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterDefault', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterDefault', null);
			}
			$tableFilter = R('virgo_filter_public');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterPublic', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPublic', null);
			}
			$tableFilter = R('virgo_filter_order');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterOrder', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterOrder', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseLanguage = ' 1 = 1 ';
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
				$eventColumn = "lng_" . P('event_column');
				$whereClauseLanguage = $whereClauseLanguage . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLanguage = $whereClauseLanguage . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaLanguage = self::getCriteria();
			if (isset($criteriaLanguage["code"])) {
				$fieldCriteriaCode = $criteriaLanguage["code"];
				if ($fieldCriteriaCode["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_code IS NOT NULL ';
				} elseif ($fieldCriteriaCode["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCode["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_languages.lng_code like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLanguage["name"])) {
				$fieldCriteriaName = $criteriaLanguage["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_languages.lng_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLanguage["default"])) {
				$fieldCriteriaDefault = $criteriaLanguage["default"];
				if ($fieldCriteriaDefault["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_default IS NOT NULL ';
				} elseif ($fieldCriteriaDefault["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_default IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDefault["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_languages.lng_default = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLanguage["public"])) {
				$fieldCriteriaPublic = $criteriaLanguage["public"];
				if ($fieldCriteriaPublic["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_public IS NOT NULL ';
				} elseif ($fieldCriteriaPublic["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_public IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPublic["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_languages.lng_public = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLanguage["order"])) {
				$fieldCriteriaOrder = $criteriaLanguage["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_languages.lng_order = ? ";
				} else {
					$filter = $filter . " AND prt_languages.lng_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_languages.lng_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			$whereClauseLanguage = $whereClauseLanguage . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLanguage = $whereClauseLanguage . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseLanguage = $whereClauseLanguage . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterCode', null);
				if (S($tableFilter)) {
					$whereClauseLanguage = $whereClauseLanguage . " AND lng_code LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseLanguage = $whereClauseLanguage . " AND lng_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterDefault', null);
				if (S($tableFilter)) {
					$whereClauseLanguage = $whereClauseLanguage . " AND lng_default LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterPublic', null);
				if (S($tableFilter)) {
					$whereClauseLanguage = $whereClauseLanguage . " AND lng_public LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterOrder', null);
				if (S($tableFilter)) {
					$whereClauseLanguage = $whereClauseLanguage . " AND lng_order LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseLanguage;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseLanguage = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_languages.lng_id, prt_languages.lng_virgo_title ";
			$queryString = $queryString . " ,prt_languages.lng_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'lng_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_code', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_code lng_code";
			} else {
				if ($defaultOrderColumn == "lng_code") {
					$orderColumnNotDisplayed = " prt_languages.lng_code ";
				}
			}
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_name lng_name";
			} else {
				if ($defaultOrderColumn == "lng_name") {
					$orderColumnNotDisplayed = " prt_languages.lng_name ";
				}
			}
			if (P('show_table_default', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_default lng_default";
			} else {
				if ($defaultOrderColumn == "lng_default") {
					$orderColumnNotDisplayed = " prt_languages.lng_default ";
				}
			}
			if (P('show_table_public', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_public lng_public";
			} else {
				if ($defaultOrderColumn == "lng_public") {
					$orderColumnNotDisplayed = " prt_languages.lng_public ";
				}
			}
			if (P('show_table_order', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_order lng_order";
			} else {
				if ($defaultOrderColumn == "lng_order") {
					$orderColumnNotDisplayed = " prt_languages.lng_order ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_languages ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseLanguage = $whereClauseLanguage . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseLanguage, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseLanguage,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_languages"
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
				. "\n FROM prt_languages"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_languages ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_languages ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, lng_id $orderMode";
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
				$query = "SELECT COUNT(lng_id) cnt FROM languages";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as languages ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as languages ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoLanguage();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_languages WHERE lng_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->lng_id = $row['lng_id'];
$this->lng_code = $row['lng_code'];
$this->lng_name = $row['lng_name'];
$this->lng_default = $row['lng_default'];
$this->lng_public = $row['lng_public'];
$this->lng_order = $row['lng_order'];
						if ($fetchUsernames) {
							if ($row['lng_date_created']) {
								if ($row['lng_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['lng_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['lng_date_modified']) {
								if ($row['lng_usr_modified_id'] == $row['lng_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['lng_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['lng_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->lng_date_created = $row['lng_date_created'];
						$this->lng_usr_created_id = $fetchUsernames ? $createdBy : $row['lng_usr_created_id'];
						$this->lng_date_modified = $row['lng_date_modified'];
						$this->lng_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['lng_usr_modified_id'];
						$this->lng_virgo_title = $row['lng_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_languages SET lng_usr_created_id = {$userId} WHERE lng_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->lng_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoLanguage::selectAllAsObjectsStatic('lng_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->lng_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->lng_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('lng_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_lng = new virgoLanguage();
				$tmp_lng->load((int)$lookup_id);
				return $tmp_lng->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoLanguage');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" lng_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoLanguage', "10");
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
				$query = $query . " lng_id as id, lng_virgo_title as title ";
			}
			$query = $query . " FROM prt_languages ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			$query = $query . " AND (lng_virgo_deleted IS NULL OR lng_virgo_deleted = 0) ";
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY lng_order ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resLanguage = array();
				foreach ($rows as $row) {
					$resLanguage[$row['id']] = $row['title'];
				}
				return $resLanguage;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticLanguage = new virgoLanguage();
			return $staticLanguage->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getTranslationsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resTranslation = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTranslation'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resTranslation;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resTranslation;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsTranslation = virgoTranslation::selectAll('trn_lng_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsTranslation as $resultTranslation) {
				$tmpTranslation = virgoTranslation::getById($resultTranslation['trn_id']); 
				array_push($resTranslation, $tmpTranslation);
			}
			return $resTranslation;
		}

		function getTranslations($orderBy = '', $extraWhere = null) {
			return virgoLanguage::getTranslationsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getHtmlContentsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resHtmlContent = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoHtmlContent'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resHtmlContent;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resHtmlContent;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsHtmlContent = virgoHtmlContent::selectAll('hcn_lng_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsHtmlContent as $resultHtmlContent) {
				$tmpHtmlContent = virgoHtmlContent::getById($resultHtmlContent['hcn_id']); 
				array_push($resHtmlContent, $tmpHtmlContent);
			}
			return $resHtmlContent;
		}

		function getHtmlContents($orderBy = '', $extraWhere = null) {
			return virgoLanguage::getHtmlContentsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getCode()) || trim($this->getCode()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'CODE');
			}			
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_default_obligatory', "0") == "1") {
				if (
(is_null($this->getDefault()) || trim($this->getDefault()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'DEFAULT');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_public_obligatory', "0") == "1") {
				if (
(is_null($this->getPublic()) || trim($this->getPublic()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'PUBLIC');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_order_obligatory', "0") == "1") {
				if (
(is_null($this->getOrder()) || trim($this->getOrder()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'ORDER');
				}			
			}
 			if (!is_null($this->lng_order) && trim($this->lng_order) != "") {
				if (!is_numeric($this->lng_order)) {
					return T('INCORRECT_NUMBER', 'ORDER', $this->lng_order);
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_languages WHERE lng_id = " . $this->getId();
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
				$colNames = $colNames . ", lng_code";
				$values = $values . ", " . (is_null($objectToStore->getCode()) ? "null" : "'" . QE($objectToStore->getCode()) . "'");
				$colNames = $colNames . ", lng_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", lng_default";
				$values = $values . ", " . (is_null($objectToStore->getDefault()) ? "null" : "'" . QE($objectToStore->getDefault()) . "'");
				$colNames = $colNames . ", lng_public";
				$values = $values . ", " . (is_null($objectToStore->getPublic()) ? "null" : "'" . QE($objectToStore->getPublic()) . "'");
				$colNames = $colNames . ", lng_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				$query = "INSERT INTO prt_history_languages (revision, ip, username, user_id, timestamp, lng_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getCode() != $objectToStore->getCode()) {
				if (is_null($objectToStore->getCode())) {
					$nullifiedProperties = $nullifiedProperties . "code,";
				} else {
				$colNames = $colNames . ", lng_code";
				$values = $values . ", " . (is_null($objectToStore->getCode()) ? "null" : "'" . QE($objectToStore->getCode()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getName() != $objectToStore->getName()) {
				if (is_null($objectToStore->getName())) {
					$nullifiedProperties = $nullifiedProperties . "name,";
				} else {
				$colNames = $colNames . ", lng_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getDefault() != $objectToStore->getDefault()) {
				if (is_null($objectToStore->getDefault())) {
					$nullifiedProperties = $nullifiedProperties . "default,";
				} else {
				$colNames = $colNames . ", lng_default";
				$values = $values . ", " . (is_null($objectToStore->getDefault()) ? "null" : "'" . QE($objectToStore->getDefault()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getPublic() != $objectToStore->getPublic()) {
				if (is_null($objectToStore->getPublic())) {
					$nullifiedProperties = $nullifiedProperties . "public,";
				} else {
				$colNames = $colNames . ", lng_public";
				$values = $values . ", " . (is_null($objectToStore->getPublic()) ? "null" : "'" . QE($objectToStore->getPublic()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getOrder() != $objectToStore->getOrder()) {
				if (is_null($objectToStore->getOrder())) {
					$nullifiedProperties = $nullifiedProperties . "order,";
				} else {
				$colNames = $colNames . ", lng_order";
				$values = $values . ", " . (is_null($objectToStore->getOrder()) ? "null" : "'" . QE($objectToStore->getOrder()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_languages (revision, ip, username, user_id, timestamp, lng_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_languages");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'lng_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_languages ADD COLUMN (lng_virgo_title VARCHAR(255));";
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
			if (isset($this->lng_id) && $this->lng_id != "") {
				$query = "UPDATE prt_languages SET ";
			if (isset($this->lng_code)) {
				$query .= " lng_code = ? ,";
				$types .= "s";
				$values[] = $this->lng_code;
			} else {
				$query .= " lng_code = NULL ,";				
			}
			if (isset($this->lng_name)) {
				$query .= " lng_name = ? ,";
				$types .= "s";
				$values[] = $this->lng_name;
			} else {
				$query .= " lng_name = NULL ,";				
			}
			if (isset($this->lng_default)) {
				$query .= " lng_default = ? ,";
				$types .= "s";
				$values[] = $this->lng_default;
			} else {
				$query .= " lng_default = NULL ,";				
			}
			if (isset($this->lng_public)) {
				$query .= " lng_public = ? ,";
				$types .= "s";
				$values[] = $this->lng_public;
			} else {
				$query .= " lng_public = NULL ,";				
			}
			if (isset($this->lng_order)) {
				$query .= " lng_order = ? ,";
				$types .= "i";
				$values[] = $this->lng_order;
			} else {
				$query .= " lng_order = NULL ,";				
			}
				if (isset($this->lng_virgo_deleted)) {
					$query = $query . " lng_virgo_deleted = ? , ";
					$types = $types . "i";
					$values[] = $this->lng_virgo_deleted;
				} else {
					$query = $query . " lng_virgo_deleted = NULL , ";
				}
				$query = $query . " lng_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " lng_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->lng_date_modified;

				$query = $query . " lng_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->lng_usr_modified_id;

				$query = $query . " WHERE lng_id = ? ";
				$types = $types . "i";
				$values[] = $this->lng_id;
			} else {
				$query = "INSERT INTO prt_languages ( ";
			$query = $query . " lng_code, ";
			$query = $query . " lng_name, ";
			$query = $query . " lng_default, ";
			$query = $query . " lng_public, ";
			$query = $query . " lng_order, ";
				$query = $query . " lng_virgo_title, lng_date_created, lng_usr_created_id) VALUES ( ";
			if (isset($this->lng_code)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lng_code;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lng_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lng_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lng_default)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lng_default;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lng_public)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->lng_public;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->lng_order)) {
				$query .= " ? ,";
				$types .= "i";
				$values[] = $this->lng_order;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->lng_date_created;
				$values[] = $this->lng_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->lng_id) || $this->lng_id == "") {
					$this->lng_id = QID();
				}
				if ($log) {
					L("language stored successfully", "id = {$this->lng_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->lng_id) {
				$virgoOld = new virgoLanguage($this->lng_id);
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
					if ($this->lng_id) {			
						$this->lng_date_modified = date("Y-m-d H:i:s");
						$this->lng_usr_modified_id = $userId;
					} else {
						$this->lng_date_created = date("Y-m-d H:i:s");
						$this->lng_usr_created_id = $userId;
					}
					$this->lng_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "language" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "language" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_languages WHERE lng_id = {$this->lng_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			self::removeFromContext();
			$this->lng_virgo_deleted = true;
			$this->lng_date_modified = date("Y-m-d H:i:s");
			$userId = virgoUser::getUserId();
			$this->lng_usr_modified_id = $userId;
			$this->parentStore(true);
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoLanguage();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT lng_id as id FROM prt_languages";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'lng_order_column')) {
				$orderBy = " ORDER BY lng_order_column ASC ";
			} 
			if (property_exists($this, 'lng_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY lng_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoLanguage();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoLanguage($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_languages SET lng_virgo_title = '$title' WHERE lng_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByCodeStatic($token) {
			$tmpStatic = new virgoLanguage();
			$tmpId = $tmpStatic->getIdByCode($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByCodeStatic($token) {
			$tmpStatic = new virgoLanguage();
			return $tmpStatic->getIdByCode($token);
		}
		
		function getIdByCode($token) {
			$res = $this->selectAll(" lng_code = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['lng_id'];
			}
			return null;
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoLanguage();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoLanguage();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" lng_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['lng_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoLanguage();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" lng_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['lng_id'];
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
			virgoLanguage::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoLanguage::setSessionValue('Portal_Language-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoLanguage::getSessionValue('Portal_Language-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoLanguage::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoLanguage::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoLanguage::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoLanguage::getSessionValue('GLOBAL', $name, $default);
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
			$context['lng_id'] = $id;
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
			$context['lng_id'] = null;
			virgoLanguage::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoLanguage::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoLanguage::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoLanguage::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoLanguage::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoLanguage::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoLanguage::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoLanguage::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoLanguage::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoLanguage::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoLanguage::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoLanguage::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoLanguage::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoLanguage::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoLanguage::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoLanguage::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoLanguage::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column', 'lng_order');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "lng_id";
			}
			return virgoLanguage::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoLanguage::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoLanguage::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoLanguage::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoLanguage::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoLanguage::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoLanguage::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoLanguage::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoLanguage::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoLanguage::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoLanguage::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoLanguage::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoLanguage::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->lng_id) {
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
						L(T('STORED_CORRECTLY', 'LANGUAGE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'code', $this->lng_code);
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->lng_name);
						$fieldValues = $fieldValues . T($fieldValue, 'default', $this->lng_default);
						$fieldValues = $fieldValues . T($fieldValue, 'public', $this->lng_public);
						$fieldValues = $fieldValues . T($fieldValue, 'order', $this->lng_order);
						$username = '';
						if ($this->lng_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->lng_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->lng_date_created);
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
			$instance = new virgoLanguage();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLanguage'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_translations') == "1") {
				$tmpTranslation = new virgoTranslation();
				$deleteTranslation = R('DELETE');
				if (sizeof($deleteTranslation) > 0) {
					$tmpTranslation->multipleDelete($deleteTranslation);
				}
				$resIds = $tmpTranslation->select(null, 'all', null, null, ' trn_lng_id = ' . $instance->getId(), ' SELECT trn_id FROM prt_translations ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->trn_id;
//					JRequest::setVar('trn_language_' . $resId->trn_id, $this->getId());
				} 
//				JRequest::setVar('trn_language_', $instance->getId());
				$tmpTranslation->setRecordSet($resIdsString);
				if (!$tmpTranslation->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_html_contents') == "1") {
				$tmpHtmlContent = new virgoHtmlContent();
				$deleteHtmlContent = R('DELETE');
				if (sizeof($deleteHtmlContent) > 0) {
					$tmpHtmlContent->multipleDelete($deleteHtmlContent);
				}
				$resIds = $tmpHtmlContent->select(null, 'all', null, null, ' hcn_lng_id = ' . $instance->getId(), ' SELECT hcn_id FROM prt_html_contents ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->hcn_id;
//					JRequest::setVar('hcn_language_' . $resId->hcn_id, $this->getId());
				} 
//				JRequest::setVar('hcn_language_', $instance->getId());
				$tmpHtmlContent->setRecordSet($resIdsString);
				if (!$tmpHtmlContent->portletActionStoreSelected()) {
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
			$tmpId = intval(R('lng_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoLanguage::getContextId();
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
			$this->lng_id = null;
			$this->lng_date_created = null;
			$this->lng_usr_created_id = null;
			$this->lng_date_modified = null;
			$this->lng_usr_modified_id = null;
			$this->lng_virgo_title = null;
			$this->lng_virgo_deleted = null;
			
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
//			$ret = new virgoLanguage();
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
				$instance = new virgoLanguage();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoLanguage::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'LANGUAGE'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		static function portletActionVirgoUp() {
			$this->loadFromDB();
			$idToSwapWith = R('virgo_swap_up_with_' . $this->getId());
			$objectToSwapWith = new virgoLanguage($idToSwapWith);
			$val1 = $this->getOrder();
			$val2 = $objectToSwapWith->getOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 + 1;
			}
			$objectToSwapWith->setOrder($val1);
			$this->setOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
		}
		
		static function portletActionVirgoDown() {
			$this->loadFromDB();
			$idToSwapWith = R('virgo_swap_down_with_' . $this->getId());
			$objectToSwapWith = new virgoLanguage($idToSwapWith);
			$val1 = $this->getOrder();
			$val2 = $objectToSwapWith->getOrder();
			if (is_null($val1)) {
				$val1 = 1;
			}
			if (is_null($val2)) {
				$val2 = 1;
			}
			if ($val1 == $val2) {
				$val1 = $val2 - 1;
			}
			$objectToSwapWith->setOrder($val1);
			$this->setOrder($val2);
			$objectToSwapWith->store(false);
			$this->store(false);
			$this->putInContext();
			return 0;
		}
		
		static function portletActionVirgoSetDefaultTrue() {
			$this->loadFromDB();
			$this->setDefault(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetDefaultFalse() {
			$this->loadFromDB();
			$this->setDefault(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isDefault() {
			return $this->getDefault() == 1;
		}
		static function portletActionVirgoSetPublicTrue() {
			$this->loadFromDB();
			$this->setPublic(1);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}
		
		static function portletActionVirgoSetPublicFalse() {
			$this->loadFromDB();
			$this->setPublic(0);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				L($ret, '', 'ERROR');
				return -1;
			}
		}

		function isPublic() {
			return $this->getPublic() == 1;
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
				$resultLanguage = new virgoLanguage();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultLanguage->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultLanguage->load($idToEditInt);
					} else {
						$resultLanguage->lng_id = 0;
					}
				}
				$results[] = $resultLanguage;
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
				$result = new virgoLanguage();
				$result->loadFromRequest($idToStore);
				if ($result->lng_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->lng_id == 0) {
						$result->lng_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->lng_id)) {
							$result->lng_id = 0;
						}
						$idsToCorrect[$result->lng_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'LANGUAGES'), '', 'INFO');
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
			$resultLanguage = new virgoLanguage();
			foreach ($idsToDelete as $idToDelete) {
				$resultLanguage->load((int)trim($idToDelete));
				$res = $resultLanguage->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'LANGUAGES'), '', 'INFO');			
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
		$ret = $this->lng_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoLanguage');
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
				$query = "UPDATE prt_languages SET lng_virgo_title = ? WHERE lng_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT lng_id AS id FROM prt_languages ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoLanguage($row['id']);
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
						$parentInfo['condition'] = 'prt_languages.lng_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_languages.lng_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_languages.lng_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_languages.lng_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoLanguage!', '', 'ERROR');
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
			$pdf->SetTitle('Languages report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('LANGUAGES');
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
			if (P('show_pdf_code', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_name', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_default', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_public', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_order', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultLanguage = new virgoLanguage();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_code', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Code');
				$minWidth['code'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['code']) {
						$minWidth['code'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_name', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Name');
				$minWidth['name'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['name']) {
						$minWidth['name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Default');
				$minWidth['default'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['default']) {
						$minWidth['default'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_public', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Public');
				$minWidth['public'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['public']) {
						$minWidth['public'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Order');
				$minWidth['order'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['order']) {
						$minWidth['order'] = min($tmpLen, $maxWidth);
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
			$whereClauseLanguage = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseLanguage = $whereClauseLanguage . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaLanguage = $resultLanguage->getCriteria();
			$fieldCriteriaCode = $criteriaLanguage["code"];
			if ($fieldCriteriaCode["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Code', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCode["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Code', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaName = $criteriaLanguage["name"];
			if ($fieldCriteriaName["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Name', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaName["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Name', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaDefault = $criteriaLanguage["default"];
			if ($fieldCriteriaDefault["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Default', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaDefault["value"];
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
					$pdf->MultiCell(60, 100, 'Default', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaPublic = $criteriaLanguage["public"];
			if ($fieldCriteriaPublic["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Public', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaPublic["value"];
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
					$pdf->MultiCell(60, 100, 'Public', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaOrder = $criteriaLanguage["order"];
			if ($fieldCriteriaOrder["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Order', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaOrder["value"];
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
					$pdf->MultiCell(60, 100, 'Order', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaLanguage = self::getCriteria();
			if (isset($criteriaLanguage["code"])) {
				$fieldCriteriaCode = $criteriaLanguage["code"];
				if ($fieldCriteriaCode["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_code IS NOT NULL ';
				} elseif ($fieldCriteriaCode["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCode["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_languages.lng_code like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLanguage["name"])) {
				$fieldCriteriaName = $criteriaLanguage["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_languages.lng_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaLanguage["default"])) {
				$fieldCriteriaDefault = $criteriaLanguage["default"];
				if ($fieldCriteriaDefault["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_default IS NOT NULL ';
				} elseif ($fieldCriteriaDefault["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_default IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaDefault["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_languages.lng_default = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLanguage["public"])) {
				$fieldCriteriaPublic = $criteriaLanguage["public"];
				if ($fieldCriteriaPublic["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_public IS NOT NULL ';
				} elseif ($fieldCriteriaPublic["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_public IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaPublic["value"];
		$condition = $dataTypeCriteria["default"];
		if (!is_null($condition) && trim($condition) != "") {
			$filter = $filter . " AND prt_languages.lng_public = ? ";
			$types .= "i";
			$values[] = $condition;							
		}
				}
			}
			if (isset($criteriaLanguage["order"])) {
				$fieldCriteriaOrder = $criteriaLanguage["order"];
				if ($fieldCriteriaOrder["is_null"] == 1) {
$filter = $filter . ' AND prt_languages.lng_order IS NOT NULL ';
				} elseif ($fieldCriteriaOrder["is_null"] == 2) {
$filter = $filter . ' AND prt_languages.lng_order IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaOrder["value"];
			$conditionFrom = $dataTypeCriteria["from"];
			$conditionTo = $dataTypeCriteria["to"];
			if (!is_null($conditionFrom) && trim($conditionFrom) != "") {
				if (is_null($conditionTo) || trim($conditionTo) == "") {
					$filter = $filter . " AND prt_languages.lng_order = ? ";
				} else {
					$filter = $filter . " AND prt_languages.lng_order >= ? ";
				}
				$types .= "i";
				$values[] = $conditionFrom;				
			}
			if (!is_null($conditionTo) && trim($conditionTo) != "") { 
				$filter = $filter . " AND prt_languages.lng_order <= ? ";
				$types .= "i";
				$values[] = $conditionTo;				
			}			
				}
			}
			$whereClauseLanguage = $whereClauseLanguage . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseLanguage = $whereClauseLanguage . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_languages.lng_id, prt_languages.lng_virgo_title ";
			$queryString = $queryString . " ,prt_languages.lng_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'lng_order');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_code', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_code lng_code";
			} else {
				if ($defaultOrderColumn == "lng_code") {
					$orderColumnNotDisplayed = " prt_languages.lng_code ";
				}
			}
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_name lng_name";
			} else {
				if ($defaultOrderColumn == "lng_name") {
					$orderColumnNotDisplayed = " prt_languages.lng_name ";
				}
			}
			if (P('show_pdf_default', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_default lng_default";
			} else {
				if ($defaultOrderColumn == "lng_default") {
					$orderColumnNotDisplayed = " prt_languages.lng_default ";
				}
			}
			if (P('show_pdf_public', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_public lng_public";
			} else {
				if ($defaultOrderColumn == "lng_public") {
					$orderColumnNotDisplayed = " prt_languages.lng_public ";
				}
			}
			if (P('show_pdf_order', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_order lng_order";
			} else {
				if ($defaultOrderColumn == "lng_order") {
					$orderColumnNotDisplayed = " prt_languages.lng_order ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_languages ";

		$resultsLanguage = $resultLanguage->select(
			'', 
			'all', 
			$resultLanguage->getOrderColumn(), 
			$resultLanguage->getOrderMode(), 
			$whereClauseLanguage,
			$queryString);
		
		foreach ($resultsLanguage as $resultLanguage) {

			if (P('show_pdf_code', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLanguage['lng_code'])) + 6;
				if ($tmpLen > $minWidth['code']) {
					$minWidth['code'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLanguage['lng_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_default', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLanguage['lng_default'])) + 6;
				if ($tmpLen > $minWidth['default']) {
					$minWidth['default'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_public', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLanguage['lng_public'])) + 6;
				if ($tmpLen > $minWidth['public']) {
					$minWidth['public'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_order', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultLanguage['lng_order'])) + 6;
				if ($tmpLen > $minWidth['order']) {
					$minWidth['order'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaLanguage = $resultLanguage->getCriteria();
		if (is_null($criteriaLanguage) || sizeof($criteriaLanguage) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																						if (P('show_pdf_code', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['code'], $colHeight, T('CODE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_name', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, T('NAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_default', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['default'], $colHeight, T('DEFAULT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_public', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['public'], $colHeight, T('PUBLIC'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_order', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, T('ORDER'), 'T', 'C', 0, 0);
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
		foreach ($resultsLanguage as $resultLanguage) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_code', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['code'], $colHeight, '' . $resultLanguage['lng_code'], 'T', 'L', 0, 0);
				if (P('show_pdf_code', "1") == "2") {
										if (!is_null($resultLanguage['lng_code'])) {
						$tmpCount = (float)$counts["code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["code"] = $tmpCount;
					}
				}
				if (P('show_pdf_code', "1") == "3") {
										if (!is_null($resultLanguage['lng_code'])) {
						$tmpSum = (float)$sums["code"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_code'];
						}
						$sums["code"] = $tmpSum;
					}
				}
				if (P('show_pdf_code', "1") == "4") {
										if (!is_null($resultLanguage['lng_code'])) {
						$tmpCount = (float)$avgCounts["code"];
						$tmpSum = (float)$avgSums["code"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["code"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_code'];
						}
						$avgSums["code"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultLanguage['lng_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultLanguage['lng_name'])) {
						$tmpCount = (float)$counts["name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["name"] = $tmpCount;
					}
				}
				if (P('show_pdf_name', "1") == "3") {
										if (!is_null($resultLanguage['lng_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultLanguage['lng_name'])) {
						$tmpCount = (float)$avgCounts["name"];
						$tmpSum = (float)$avgSums["name"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["name"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_default', "0") != "0") {
			$renderCriteria = "";
			switch ($resultLanguage['lng_default']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['default'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_default', "1") == "2") {
										if (!is_null($resultLanguage['lng_default'])) {
						$tmpCount = (float)$counts["default"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["default"] = $tmpCount;
					}
				}
				if (P('show_pdf_default', "1") == "3") {
										if (!is_null($resultLanguage['lng_default'])) {
						$tmpSum = (float)$sums["default"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_default'];
						}
						$sums["default"] = $tmpSum;
					}
				}
				if (P('show_pdf_default', "1") == "4") {
										if (!is_null($resultLanguage['lng_default'])) {
						$tmpCount = (float)$avgCounts["default"];
						$tmpSum = (float)$avgSums["default"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["default"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_default'];
						}
						$avgSums["default"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_public', "0") != "0") {
			$renderCriteria = "";
			switch ($resultLanguage['lng_public']) {
				case 0: $renderCriteria = T("NO"); break;
				case 1: $renderCriteria = T("YES"); break;
				case 2: $renderCriteria = T("NO_DATA"); break;
			}			
			$tmpLn = $pdf->MultiCell($minWidth['public'], $colHeight, '' . $renderCriteria, 'T', 'C', 0, 0);
				if (P('show_pdf_public', "1") == "2") {
										if (!is_null($resultLanguage['lng_public'])) {
						$tmpCount = (float)$counts["public"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["public"] = $tmpCount;
					}
				}
				if (P('show_pdf_public', "1") == "3") {
										if (!is_null($resultLanguage['lng_public'])) {
						$tmpSum = (float)$sums["public"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_public'];
						}
						$sums["public"] = $tmpSum;
					}
				}
				if (P('show_pdf_public', "1") == "4") {
										if (!is_null($resultLanguage['lng_public'])) {
						$tmpCount = (float)$avgCounts["public"];
						$tmpSum = (float)$avgSums["public"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["public"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_public'];
						}
						$avgSums["public"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_order', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['order'], $colHeight, '' . $resultLanguage['lng_order'], 'T', 'R', 0, 0);
				if (P('show_pdf_order', "1") == "2") {
										if (!is_null($resultLanguage['lng_order'])) {
						$tmpCount = (float)$counts["order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["order"] = $tmpCount;
					}
				}
				if (P('show_pdf_order', "1") == "3") {
										if (!is_null($resultLanguage['lng_order'])) {
						$tmpSum = (float)$sums["order"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_order'];
						}
						$sums["order"] = $tmpSum;
					}
				}
				if (P('show_pdf_order', "1") == "4") {
										if (!is_null($resultLanguage['lng_order'])) {
						$tmpCount = (float)$avgCounts["order"];
						$tmpSum = (float)$avgSums["order"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["order"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultLanguage['lng_order'];
						}
						$avgSums["order"] = $tmpSum;
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
			if (P('show_pdf_code', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['code'];
				if (P('show_pdf_code', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["code"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["name"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["default"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_public', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['public'];
				if (P('show_pdf_public', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["public"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["order"];
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
			if (P('show_pdf_code', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['code'];
				if (P('show_pdf_code', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["code"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["name"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["default"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_public', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['public'];
				if (P('show_pdf_public', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["public"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["order"], 2, ',', ' ');
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
			if (P('show_pdf_code', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['code'];
				if (P('show_pdf_code', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["code"] == 0 ? "-" : $avgSums["code"] / $avgCounts["code"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_name', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['name'];
				if (P('show_pdf_name', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["name"] == 0 ? "-" : $avgSums["name"] / $avgCounts["name"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_default', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['default'];
				if (P('show_pdf_default', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["default"] == 0 ? "-" : $avgSums["default"] / $avgCounts["default"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_public', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['public'];
				if (P('show_pdf_public', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["public"] == 0 ? "-" : $avgSums["public"] / $avgCounts["public"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_order', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['order'];
				if (P('show_pdf_order', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["order"] == 0 ? "-" : $avgSums["order"] / $avgCounts["order"]);
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
				$reportTitle = T('LANGUAGES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultLanguage = new virgoLanguage();
			$whereClauseLanguage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLanguage = $whereClauseLanguage . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_code', "1") != "0") {
					$data = $data . $stringDelimeter .'Code' . $stringDelimeter . $separator;
				}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_default', "1") != "0") {
					$data = $data . $stringDelimeter .'Default' . $stringDelimeter . $separator;
				}
				if (P('show_export_public', "1") != "0") {
					$data = $data . $stringDelimeter .'Public' . $stringDelimeter . $separator;
				}
				if (P('show_export_order', "1") != "0") {
					$data = $data . $stringDelimeter .'Order' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_languages.lng_id, prt_languages.lng_virgo_title ";
			$queryString = $queryString . " ,prt_languages.lng_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'lng_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_code', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_code lng_code";
			} else {
				if ($defaultOrderColumn == "lng_code") {
					$orderColumnNotDisplayed = " prt_languages.lng_code ";
				}
			}
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_name lng_name";
			} else {
				if ($defaultOrderColumn == "lng_name") {
					$orderColumnNotDisplayed = " prt_languages.lng_name ";
				}
			}
			if (P('show_export_default', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_default lng_default";
			} else {
				if ($defaultOrderColumn == "lng_default") {
					$orderColumnNotDisplayed = " prt_languages.lng_default ";
				}
			}
			if (P('show_export_public', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_public lng_public";
			} else {
				if ($defaultOrderColumn == "lng_public") {
					$orderColumnNotDisplayed = " prt_languages.lng_public ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_order lng_order";
			} else {
				if ($defaultOrderColumn == "lng_order") {
					$orderColumnNotDisplayed = " prt_languages.lng_order ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_languages ";

			$resultsLanguage = $resultLanguage->select(
				'', 
				'all', 
				$resultLanguage->getOrderColumn(), 
				$resultLanguage->getOrderMode(), 
				$whereClauseLanguage,
				$queryString);
			foreach ($resultsLanguage as $resultLanguage) {
				if (P('show_export_code', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLanguage['lng_code'] . $stringDelimeter . $separator;
				}
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultLanguage['lng_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_default', "1") != "0") {
			$data = $data . $resultLanguage['lng_default'] . $separator;
				}
				if (P('show_export_public', "1") != "0") {
			$data = $data . $resultLanguage['lng_public'] . $separator;
				}
				if (P('show_export_order', "1") != "0") {
			$data = $data . $resultLanguage['lng_order'] . $separator;
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
				$reportTitle = T('LANGUAGES');
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
			$resultLanguage = new virgoLanguage();
			$whereClauseLanguage = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseLanguage = $whereClauseLanguage . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_code', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Code');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_default', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Default');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_public', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Public');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Order');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_languages.lng_id, prt_languages.lng_virgo_title ";
			$queryString = $queryString . " ,prt_languages.lng_virgo_deleted ";
			$defaultOrderColumn = P('default_sort_column', 'lng_order');
			$orderColumnNotDisplayed = "";
			if (P('show_export_code', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_code lng_code";
			} else {
				if ($defaultOrderColumn == "lng_code") {
					$orderColumnNotDisplayed = " prt_languages.lng_code ";
				}
			}
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_name lng_name";
			} else {
				if ($defaultOrderColumn == "lng_name") {
					$orderColumnNotDisplayed = " prt_languages.lng_name ";
				}
			}
			if (P('show_export_default', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_default lng_default";
			} else {
				if ($defaultOrderColumn == "lng_default") {
					$orderColumnNotDisplayed = " prt_languages.lng_default ";
				}
			}
			if (P('show_export_public', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_public lng_public";
			} else {
				if ($defaultOrderColumn == "lng_public") {
					$orderColumnNotDisplayed = " prt_languages.lng_public ";
				}
			}
			if (P('show_export_order', "1") != "0") {
				$queryString = $queryString . ", prt_languages.lng_order lng_order";
			} else {
				if ($defaultOrderColumn == "lng_order") {
					$orderColumnNotDisplayed = " prt_languages.lng_order ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_languages ";

			$resultsLanguage = $resultLanguage->select(
				'', 
				'all', 
				$resultLanguage->getOrderColumn(), 
				$resultLanguage->getOrderMode(), 
				$whereClauseLanguage,
				$queryString);
			$index = 1;
			foreach ($resultsLanguage as $resultLanguage) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultLanguage['lng_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_code', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLanguage['lng_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLanguage['lng_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_default', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLanguage['lng_default'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_public', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLanguage['lng_public'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_order', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultLanguage['lng_order'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
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
					$propertyColumnHash['code'] = 'lng_code';
					$propertyColumnHash['code'] = 'lng_code';
					$propertyColumnHash['name'] = 'lng_name';
					$propertyColumnHash['name'] = 'lng_name';
					$propertyColumnHash['default'] = 'lng_default';
					$propertyColumnHash['default'] = 'lng_default';
					$propertyColumnHash['public'] = 'lng_public';
					$propertyColumnHash['public'] = 'lng_public';
					$propertyColumnHash['order'] = 'lng_order';
					$propertyColumnHash['order'] = 'lng_order';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importLanguage = new virgoLanguage();
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
										L(T('PROPERTY_NOT_FOUND', T('LANGUAGE'), $columns[$index]), '', 'ERROR');
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
										$importLanguage->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importLanguage->store();
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
		static function getDefaultLanguage() {
			$query = <<<SQL
SELECT
	lng_id, lng_code
FROM
	prt_languages
WHERE 
	lng_default = 1
SQL;
			$rows = QR($query);
			foreach ($rows as $row) {
				$ret = array();
				$ret[] = $row['lng_id'];
				$ret[] = $row['lng_code'];
				return $ret;
			}
			return null;
		}		
		
		static function getPublicLanguages() {
			$query = <<<SQL
SELECT
	lng_id
FROM
	prt_languages
WHERE 
	lng_public = 1
ORDER BY 
	lng_order
SQL;
			$rows = QR($query);
			$ret = array();
			foreach ($rows as $row) {
				$ret[] = new virgoLanguage($row['lng_id']);
			}
			return $ret;
		}
		
		static function setCurrentLanguage($langInfo) {
			$_SESSION['portal_current_lang_id'] = $langInfo[0];
			$_SESSION['portal_current_lang_code'] = $langInfo[1];
		}		
		
		static function getCurrentLanguage() {
			if (!isset($_SESSION['portal_current_lang_id'])) {
				$langInfo = virgoLanguage::getDefaultLanguage();
				virgoLanguage::setCurrentLanguage($langInfo);
			} else {
				$langInfo = array($_SESSION['portal_current_lang_id'], $_SESSION['portal_current_lang_code']);
			}
			return $langInfo;
		}		

		static function getCurrentLanguageId() {
			$langInfo = virgoLanguage::getCurrentLanguage();
			return $langInfo[0];
		}		
		
		static function getCurrentLanguageCode() {
			$langInfo = virgoLanguage::getCurrentLanguage();
			return $langInfo[1];
		}		


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_languages` (
  `lng_id` bigint(20) unsigned NOT NULL auto_increment,
  `lng_virgo_state` varchar(50) default NULL,
  `lng_virgo_title` varchar(255) default NULL,
  `lng_virgo_deleted` boolean,
  `lng_code` varchar(255), 
  `lng_name` varchar(255), 
  `lng_default` boolean,  
  `lng_public` boolean,  
  `lng_order` integer,  
  `lng_date_created` datetime NOT NULL,
  `lng_date_modified` datetime default NULL,
  `lng_usr_created_id` int(11) NOT NULL,
  `lng_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`lng_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/language.sql 
INSERT INTO `prt_languages` (`lng_virgo_title`, `lng_code`, `lng_name`, `lng_default`, `lng_public`, `lng_order`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_languages table already exists.", '', 'FATAL');
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
			return "lng";
		}
		
		static function getPlural() {
			return "languages";
		}
		
		static function isDictionary() {
			return true;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoTranslation";
			$ret[] = "virgoHtmlContent";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_languages'));
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
			$virgoVersion = virgoLanguage::getVirgoVersion();
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
	
	

