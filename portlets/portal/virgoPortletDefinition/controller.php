<?php
/**
* Module Portlet definition
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPortletDefinition {

		 var  $pdf_id = null;
		 var  $pdf_name = null;

		 var  $pdf_namespace = null;

		 var  $pdf_alias = null;

		 var  $pdf_author = null;

		 var  $pdf_version = null;


		 var   $pdf_date_created = null;
		 var   $pdf_usr_created_id = null;
		 var   $pdf_date_modified = null;
		 var   $pdf_usr_modified_id = null;
		 var   $pdf_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPortletDefinition();
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
        	$this->pdf_id = null;
		    $this->pdf_date_created = null;
		    $this->pdf_usr_created_id = null;
		    $this->pdf_date_modified = null;
		    $this->pdf_usr_modified_id = null;
		    $this->pdf_virgo_title = null;
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
			return $this->pdf_id;
		}

		function getName() {
			return $this->pdf_name;
		}
		
		 function setName($val) {
			$this->pdf_name = $val;
		}
		function getNamespace() {
			return $this->pdf_namespace;
		}
		
		 function setNamespace($val) {
			$this->pdf_namespace = $val;
		}
		function getAlias() {
			return $this->pdf_alias;
		}
		
		 function setAlias($val) {
			$this->pdf_alias = $val;
		}
		function getAuthor() {
			return $this->pdf_author;
		}
		
		 function setAuthor($val) {
			$this->pdf_author = $val;
		}
		function getVersion() {
			return $this->pdf_version;
		}
		
		 function setVersion($val) {
			$this->pdf_version = $val;
		}


		function getDateCreated() {
			return $this->pdf_date_created;
		}
		function getUsrCreatedId() {
			return $this->pdf_usr_created_id;
		}
		function getDateModified() {
			return $this->pdf_date_modified;
		}
		function getUsrModifiedId() {
			return $this->pdf_usr_modified_id;
		}



		function loadRecordFromRequest($rowId) {
			$this->pdf_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('pdf_name_' . $this->pdf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pdf_name = null;
		} else {
			$this->pdf_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pdf_namespace_' . $this->pdf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pdf_namespace = null;
		} else {
			$this->pdf_namespace = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pdf_alias_' . $this->pdf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pdf_alias = null;
		} else {
			$this->pdf_alias = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pdf_author_' . $this->pdf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pdf_author = null;
		} else {
			$this->pdf_author = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('pdf_version_' . $this->pdf_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->pdf_version = null;
		} else {
			$this->pdf_version = $tmpValue;
		}
	}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('pdf_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPortletDefinition = array();	
			$criteriaFieldPortletDefinition = array();	
			$isNullPortletDefinition = R('virgo_search_name_is_null');
			
			$criteriaFieldPortletDefinition["is_null"] = 0;
			if ($isNullPortletDefinition == "not_null") {
				$criteriaFieldPortletDefinition["is_null"] = 1;
			} elseif ($isNullPortletDefinition == "null") {
				$criteriaFieldPortletDefinition["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldPortletDefinition["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletDefinition["name"] = $criteriaFieldPortletDefinition;
			$criteriaFieldPortletDefinition = array();	
			$isNullPortletDefinition = R('virgo_search_namespace_is_null');
			
			$criteriaFieldPortletDefinition["is_null"] = 0;
			if ($isNullPortletDefinition == "not_null") {
				$criteriaFieldPortletDefinition["is_null"] = 1;
			} elseif ($isNullPortletDefinition == "null") {
				$criteriaFieldPortletDefinition["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_namespace');

//			if ($isSet) {
			$criteriaFieldPortletDefinition["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletDefinition["namespace"] = $criteriaFieldPortletDefinition;
			$criteriaFieldPortletDefinition = array();	
			$isNullPortletDefinition = R('virgo_search_alias_is_null');
			
			$criteriaFieldPortletDefinition["is_null"] = 0;
			if ($isNullPortletDefinition == "not_null") {
				$criteriaFieldPortletDefinition["is_null"] = 1;
			} elseif ($isNullPortletDefinition == "null") {
				$criteriaFieldPortletDefinition["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_alias');

//			if ($isSet) {
			$criteriaFieldPortletDefinition["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletDefinition["alias"] = $criteriaFieldPortletDefinition;
			$criteriaFieldPortletDefinition = array();	
			$isNullPortletDefinition = R('virgo_search_author_is_null');
			
			$criteriaFieldPortletDefinition["is_null"] = 0;
			if ($isNullPortletDefinition == "not_null") {
				$criteriaFieldPortletDefinition["is_null"] = 1;
			} elseif ($isNullPortletDefinition == "null") {
				$criteriaFieldPortletDefinition["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_author');

//			if ($isSet) {
			$criteriaFieldPortletDefinition["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletDefinition["author"] = $criteriaFieldPortletDefinition;
			$criteriaFieldPortletDefinition = array();	
			$isNullPortletDefinition = R('virgo_search_version_is_null');
			
			$criteriaFieldPortletDefinition["is_null"] = 0;
			if ($isNullPortletDefinition == "not_null") {
				$criteriaFieldPortletDefinition["is_null"] = 1;
			} elseif ($isNullPortletDefinition == "null") {
				$criteriaFieldPortletDefinition["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_version');

//			if ($isSet) {
			$criteriaFieldPortletDefinition["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletDefinition["version"] = $criteriaFieldPortletDefinition;
			self::setCriteria($criteriaPortletDefinition);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_name');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterName', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterName', null);
			}
			$tableFilter = R('virgo_filter_namespace');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterNamespace', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterNamespace', null);
			}
			$tableFilter = R('virgo_filter_alias');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAlias', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAlias', null);
			}
			$tableFilter = R('virgo_filter_author');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterAuthor', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterAuthor', null);
			}
			$tableFilter = R('virgo_filter_version');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterVersion', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterVersion', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePortletDefinition = ' 1 = 1 ';
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
				$eventColumn = "pdf_" . P('event_column');
				$whereClausePortletDefinition = $whereClausePortletDefinition . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletDefinition = $whereClausePortletDefinition . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaPortletDefinition = self::getCriteria();
			if (isset($criteriaPortletDefinition["name"])) {
				$fieldCriteriaName = $criteriaPortletDefinition["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["namespace"])) {
				$fieldCriteriaNamespace = $criteriaPortletDefinition["namespace"];
				if ($fieldCriteriaNamespace["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_namespace IS NOT NULL ';
				} elseif ($fieldCriteriaNamespace["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_namespace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNamespace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_namespace like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["alias"])) {
				$fieldCriteriaAlias = $criteriaPortletDefinition["alias"];
				if ($fieldCriteriaAlias["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_alias IS NOT NULL ';
				} elseif ($fieldCriteriaAlias["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_alias IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAlias["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_alias like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["author"])) {
				$fieldCriteriaAuthor = $criteriaPortletDefinition["author"];
				if ($fieldCriteriaAuthor["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_author IS NOT NULL ';
				} elseif ($fieldCriteriaAuthor["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_author IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAuthor["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_author like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["version"])) {
				$fieldCriteriaVersion = $criteriaPortletDefinition["version"];
				if ($fieldCriteriaVersion["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_version IS NOT NULL ';
				} elseif ($fieldCriteriaVersion["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_version IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaVersion["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_version like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			$whereClausePortletDefinition = $whereClausePortletDefinition . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletDefinition = $whereClausePortletDefinition . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND pdf_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterNamespace', null);
				if (S($tableFilter)) {
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND pdf_namespace LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAlias', null);
				if (S($tableFilter)) {
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND pdf_alias LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterAuthor', null);
				if (S($tableFilter)) {
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND pdf_author LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterVersion', null);
				if (S($tableFilter)) {
					$whereClausePortletDefinition = $whereClausePortletDefinition . " AND pdf_version LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClausePortletDefinition;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePortletDefinition = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_portlet_definitions.pdf_id, prt_portlet_definitions.pdf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_name pdf_name";
			} else {
				if ($defaultOrderColumn == "pdf_name") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_name ";
				}
			}
			if (P('show_table_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_namespace pdf_namespace";
			} else {
				if ($defaultOrderColumn == "pdf_namespace") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_namespace ";
				}
			}
			if (P('show_table_alias', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_alias pdf_alias";
			} else {
				if ($defaultOrderColumn == "pdf_alias") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_alias ";
				}
			}
			if (P('show_table_author', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_author pdf_author";
			} else {
				if ($defaultOrderColumn == "pdf_author") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_author ";
				}
			}
			if (P('show_table_version', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_version pdf_version";
			} else {
				if ($defaultOrderColumn == "pdf_version") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_version ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_definitions ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePortletDefinition = $whereClausePortletDefinition . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePortletDefinition, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePortletDefinition,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_portlet_definitions"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pdf_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " pdf_usr_created_id = ? ";
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
				. "\n FROM prt_portlet_definitions"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_portlet_definitions ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_portlet_definitions ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, pdf_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " pdf_usr_created_id = ? ";
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
				$query = "SELECT COUNT(pdf_id) cnt FROM portlet_definitions";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as portlet_definitions ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as portlet_definitions ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPortletDefinition();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_portlet_definitions WHERE pdf_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->pdf_id = $row['pdf_id'];
$this->pdf_name = $row['pdf_name'];
$this->pdf_namespace = $row['pdf_namespace'];
$this->pdf_alias = $row['pdf_alias'];
$this->pdf_author = $row['pdf_author'];
$this->pdf_version = $row['pdf_version'];
						if ($fetchUsernames) {
							if ($row['pdf_date_created']) {
								if ($row['pdf_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['pdf_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['pdf_date_modified']) {
								if ($row['pdf_usr_modified_id'] == $row['pdf_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['pdf_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['pdf_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->pdf_date_created = $row['pdf_date_created'];
						$this->pdf_usr_created_id = $fetchUsernames ? $createdBy : $row['pdf_usr_created_id'];
						$this->pdf_date_modified = $row['pdf_date_modified'];
						$this->pdf_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['pdf_usr_modified_id'];
						$this->pdf_virgo_title = $row['pdf_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_portlet_definitions SET pdf_usr_created_id = {$userId} WHERE pdf_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->pdf_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPortletDefinition::selectAllAsObjectsStatic('pdf_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->pdf_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->pdf_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('pdf_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_pdf = new virgoPortletDefinition();
				$tmp_pdf->load((int)$lookup_id);
				return $tmp_pdf->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPortletDefinition');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" pdf_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPortletDefinition', "10");
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
				$query = $query . " pdf_id as id, pdf_virgo_title as title ";
			}
			$query = $query . " FROM prt_portlet_definitions ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPortletDefinition', 'portal') == "1") {
				$privateCondition = " pdf_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY pdf_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPortletDefinition = array();
				foreach ($rows as $row) {
					$resPortletDefinition[$row['id']] = $row['title'];
				}
				return $resPortletDefinition;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPortletDefinition = new virgoPortletDefinition();
			return $staticPortletDefinition->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getPortletObjectsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortletObject = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortletObject;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortletObject;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortletObject = virgoPortletObject::selectAll('pob_pdf_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletObject as $resultPortletObject) {
				$tmpPortletObject = virgoPortletObject::getById($resultPortletObject['pob_id']); 
				array_push($resPortletObject, $tmpPortletObject);
			}
			return $resPortletObject;
		}

		function getPortletObjects($orderBy = '', $extraWhere = null) {
			return virgoPortletDefinition::getPortletObjectsStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPortletParametersStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortletParameter = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortletParameter;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortletParameter;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortletParameter = virgoPortletParameter::selectAll('ppr_pdf_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				$tmpPortletParameter = virgoPortletParameter::getById($resultPortletParameter['ppr_id']); 
				array_push($resPortletParameter, $tmpPortletParameter);
			}
			return $resPortletParameter;
		}

		function getPortletParameters($orderBy = '', $extraWhere = null) {
			return virgoPortletDefinition::getPortletParametersStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			if (
(is_null($this->getNamespace()) || trim($this->getNamespace()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAMESPACE');
			}			
			if (
(is_null($this->getAlias()) || trim($this->getAlias()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'ALIAS');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_author_obligatory', "0") == "1") {
				if (
(is_null($this->getAuthor()) || trim($this->getAuthor()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'AUTHOR');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_version_obligatory', "0") == "1") {
				if (
(is_null($this->getVersion()) || trim($this->getVersion()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'VERSION');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_portlet_definitions WHERE pdf_id = " . $this->getId();
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
				$colNames = $colNames . ", pdf_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", pdf_namespace";
				$values = $values . ", " . (is_null($objectToStore->getNamespace()) ? "null" : "'" . QE($objectToStore->getNamespace()) . "'");
				$colNames = $colNames . ", pdf_alias";
				$values = $values . ", " . (is_null($objectToStore->getAlias()) ? "null" : "'" . QE($objectToStore->getAlias()) . "'");
				$colNames = $colNames . ", pdf_author";
				$values = $values . ", " . (is_null($objectToStore->getAuthor()) ? "null" : "'" . QE($objectToStore->getAuthor()) . "'");
				$colNames = $colNames . ", pdf_version";
				$values = $values . ", " . (is_null($objectToStore->getVersion()) ? "null" : "'" . QE($objectToStore->getVersion()) . "'");
				$query = "INSERT INTO prt_history_portlet_definitions (revision, ip, username, user_id, timestamp, pdf_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getName() != $objectToStore->getName()) {
				if (is_null($objectToStore->getName())) {
					$nullifiedProperties = $nullifiedProperties . "name,";
				} else {
				$colNames = $colNames . ", pdf_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getNamespace() != $objectToStore->getNamespace()) {
				if (is_null($objectToStore->getNamespace())) {
					$nullifiedProperties = $nullifiedProperties . "namespace,";
				} else {
				$colNames = $colNames . ", pdf_namespace";
				$values = $values . ", " . (is_null($objectToStore->getNamespace()) ? "null" : "'" . QE($objectToStore->getNamespace()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAlias() != $objectToStore->getAlias()) {
				if (is_null($objectToStore->getAlias())) {
					$nullifiedProperties = $nullifiedProperties . "alias,";
				} else {
				$colNames = $colNames . ", pdf_alias";
				$values = $values . ", " . (is_null($objectToStore->getAlias()) ? "null" : "'" . QE($objectToStore->getAlias()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getAuthor() != $objectToStore->getAuthor()) {
				if (is_null($objectToStore->getAuthor())) {
					$nullifiedProperties = $nullifiedProperties . "author,";
				} else {
				$colNames = $colNames . ", pdf_author";
				$values = $values . ", " . (is_null($objectToStore->getAuthor()) ? "null" : "'" . QE($objectToStore->getAuthor()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getVersion() != $objectToStore->getVersion()) {
				if (is_null($objectToStore->getVersion())) {
					$nullifiedProperties = $nullifiedProperties . "version,";
				} else {
				$colNames = $colNames . ", pdf_version";
				$values = $values . ", " . (is_null($objectToStore->getVersion()) ? "null" : "'" . QE($objectToStore->getVersion()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_portlet_definitions (revision, ip, username, user_id, timestamp, pdf_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_portlet_definitions");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'pdf_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_portlet_definitions ADD COLUMN (pdf_virgo_title VARCHAR(255));";
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
			if (isset($this->pdf_id) && $this->pdf_id != "") {
				$query = "UPDATE prt_portlet_definitions SET ";
			if (isset($this->pdf_name)) {
				$query .= " pdf_name = ? ,";
				$types .= "s";
				$values[] = $this->pdf_name;
			} else {
				$query .= " pdf_name = NULL ,";				
			}
			if (isset($this->pdf_namespace)) {
				$query .= " pdf_namespace = ? ,";
				$types .= "s";
				$values[] = $this->pdf_namespace;
			} else {
				$query .= " pdf_namespace = NULL ,";				
			}
			if (isset($this->pdf_alias)) {
				$query .= " pdf_alias = ? ,";
				$types .= "s";
				$values[] = $this->pdf_alias;
			} else {
				$query .= " pdf_alias = NULL ,";				
			}
			if (isset($this->pdf_author)) {
				$query .= " pdf_author = ? ,";
				$types .= "s";
				$values[] = $this->pdf_author;
			} else {
				$query .= " pdf_author = NULL ,";				
			}
			if (isset($this->pdf_version)) {
				$query .= " pdf_version = ? ,";
				$types .= "s";
				$values[] = $this->pdf_version;
			} else {
				$query .= " pdf_version = NULL ,";				
			}
				$query = $query . " pdf_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " pdf_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->pdf_date_modified;

				$query = $query . " pdf_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->pdf_usr_modified_id;

				$query = $query . " WHERE pdf_id = ? ";
				$types = $types . "i";
				$values[] = $this->pdf_id;
			} else {
				$query = "INSERT INTO prt_portlet_definitions ( ";
			$query = $query . " pdf_name, ";
			$query = $query . " pdf_namespace, ";
			$query = $query . " pdf_alias, ";
			$query = $query . " pdf_author, ";
			$query = $query . " pdf_version, ";
				$query = $query . " pdf_virgo_title, pdf_date_created, pdf_usr_created_id) VALUES ( ";
			if (isset($this->pdf_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pdf_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pdf_namespace)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pdf_namespace;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pdf_alias)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pdf_alias;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pdf_author)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pdf_author;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->pdf_version)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->pdf_version;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->pdf_date_created;
				$values[] = $this->pdf_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->pdf_id) || $this->pdf_id == "") {
					$this->pdf_id = QID();
				}
				if ($log) {
					L("portlet definition stored successfully", "id = {$this->pdf_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->pdf_id) {
				$virgoOld = new virgoPortletDefinition($this->pdf_id);
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
					if ($this->pdf_id) {			
						$this->pdf_date_modified = date("Y-m-d H:i:s");
						$this->pdf_usr_modified_id = $userId;
					} else {
						$this->pdf_date_created = date("Y-m-d H:i:s");
						$this->pdf_usr_created_id = $userId;
					}
					$this->pdf_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "portlet definition" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "portlet definition" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_portlet_definitions WHERE pdf_id = {$this->pdf_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPortletObjects();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortletParameters();
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
			$tmp = new virgoPortletDefinition();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT pdf_id as id FROM prt_portlet_definitions";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'pdf_order_column')) {
				$orderBy = " ORDER BY pdf_order_column ASC ";
			} 
			if (property_exists($this, 'pdf_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY pdf_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPortletDefinition();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPortletDefinition($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_portlet_definitions SET pdf_virgo_title = '$title' WHERE pdf_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoPortletDefinition();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoPortletDefinition();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" pdf_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['pdf_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPortletDefinition();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" pdf_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['pdf_id'];
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
			virgoPortletDefinition::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPortletDefinition::setSessionValue('Portal_PortletDefinition-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPortletDefinition::getSessionValue('Portal_PortletDefinition-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPortletDefinition::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPortletDefinition::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPortletDefinition::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPortletDefinition::getSessionValue('GLOBAL', $name, $default);
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
			$context['pdf_id'] = $id;
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
			$context['pdf_id'] = null;
			virgoPortletDefinition::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPortletDefinition::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPortletDefinition::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPortletDefinition::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPortletDefinition::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPortletDefinition::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPortletDefinition::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPortletDefinition::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPortletDefinition::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPortletDefinition::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPortletDefinition::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPortletDefinition::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPortletDefinition::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPortletDefinition::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPortletDefinition::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPortletDefinition::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPortletDefinition::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "pdf_id";
			}
			return virgoPortletDefinition::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPortletDefinition::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPortletDefinition::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPortletDefinition::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPortletDefinition::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPortletDefinition::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPortletDefinition::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPortletDefinition::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPortletDefinition::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPortletDefinition::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPortletDefinition::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPortletDefinition::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPortletDefinition::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->pdf_id) {
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
						L(T('STORED_CORRECTLY', 'PORTLET_DEFINITION'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->pdf_name);
						$fieldValues = $fieldValues . T($fieldValue, 'namespace', $this->pdf_namespace);
						$fieldValues = $fieldValues . T($fieldValue, 'alias', $this->pdf_alias);
						$fieldValues = $fieldValues . T($fieldValue, 'author', $this->pdf_author);
						$fieldValues = $fieldValues . T($fieldValue, 'version', $this->pdf_version);
						$username = '';
						if ($this->pdf_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->pdf_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->pdf_date_created);
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
			$instance = new virgoPortletDefinition();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_portlet_objects') == "1") {
				$tmpPortletObject = new virgoPortletObject();
				$deletePortletObject = R('DELETE');
				if (sizeof($deletePortletObject) > 0) {
					$tmpPortletObject->multipleDelete($deletePortletObject);
				}
				$resIds = $tmpPortletObject->select(null, 'all', null, null, ' pob_pdf_id = ' . $instance->getId(), ' SELECT pob_id FROM prt_portlet_objects ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pob_id;
//					JRequest::setVar('pob_portlet_definition_' . $resId->pob_id, $this->getId());
				} 
//				JRequest::setVar('pob_portlet_definition_', $instance->getId());
				$tmpPortletObject->setRecordSet($resIdsString);
				if (!$tmpPortletObject->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_portlet_parameters') == "1") {
				$tmpPortletParameter = new virgoPortletParameter();
				$deletePortletParameter = R('DELETE');
				if (sizeof($deletePortletParameter) > 0) {
					$tmpPortletParameter->multipleDelete($deletePortletParameter);
				}
				$resIds = $tmpPortletParameter->select(null, 'all', null, null, ' ppr_pdf_id = ' . $instance->getId(), ' SELECT ppr_id FROM prt_portlet_parameters ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->ppr_id;
//					JRequest::setVar('ppr_portlet_definition_' . $resId->ppr_id, $this->getId());
				} 
//				JRequest::setVar('ppr_portlet_definition_', $instance->getId());
				$tmpPortletParameter->setRecordSet($resIdsString);
				if (!$tmpPortletParameter->portletActionStoreSelected()) {
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
			$tmpId = intval(R('pdf_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPortletDefinition::getContextId();
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
			$this->pdf_id = null;
			$this->pdf_date_created = null;
			$this->pdf_usr_created_id = null;
			$this->pdf_date_modified = null;
			$this->pdf_usr_modified_id = null;
			$this->pdf_virgo_title = null;
			
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
//			$ret = new virgoPortletDefinition();
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
				$instance = new virgoPortletDefinition();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPortletDefinition::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PORTLET_DEFINITION'), '', 'INFO');
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
				$resultPortletDefinition = new virgoPortletDefinition();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPortletDefinition->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPortletDefinition->load($idToEditInt);
					} else {
						$resultPortletDefinition->pdf_id = 0;
					}
				}
				$results[] = $resultPortletDefinition;
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
				$result = new virgoPortletDefinition();
				$result->loadFromRequest($idToStore);
				if ($result->pdf_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->pdf_id == 0) {
						$result->pdf_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->pdf_id)) {
							$result->pdf_id = 0;
						}
						$idsToCorrect[$result->pdf_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PORTLET_DEFINITIONS'), '', 'INFO');
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
			$resultPortletDefinition = new virgoPortletDefinition();
			foreach ($idsToDelete as $idToDelete) {
				$resultPortletDefinition->load((int)trim($idToDelete));
				$res = $resultPortletDefinition->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PORTLET_DEFINITIONS'), '', 'INFO');			
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
		$ret = $this->pdf_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPortletDefinition');
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
				$query = "UPDATE prt_portlet_definitions SET pdf_virgo_title = ? WHERE pdf_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT pdf_id AS id FROM prt_portlet_definitions ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPortletDefinition($row['id']);
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
						$parentInfo['condition'] = 'prt_portlet_definitions.pdf_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_portlet_definitions.pdf_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_portlet_definitions.pdf_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_portlet_definitions.pdf_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPortletDefinition!', '', 'ERROR');
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
			$pdf->SetTitle('Portlet definitions report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_DEFINITIONS');
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
			if (P('show_pdf_name', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_namespace', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_alias', "1") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_author', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_version', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPortletDefinition = new virgoPortletDefinition();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
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
			if (P('show_pdf_namespace', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Namespace');
				$minWidth['namespace'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['namespace']) {
						$minWidth['namespace'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Alias');
				$minWidth['alias'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['alias']) {
						$minWidth['alias'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_author', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Author');
				$minWidth['author'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['author']) {
						$minWidth['author'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Version');
				$minWidth['version'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['version']) {
						$minWidth['version'] = min($tmpLen, $maxWidth);
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
			$whereClausePortletDefinition = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePortletDefinition = $whereClausePortletDefinition . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPortletDefinition = $resultPortletDefinition->getCriteria();
			$fieldCriteriaName = $criteriaPortletDefinition["name"];
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
			$fieldCriteriaNamespace = $criteriaPortletDefinition["namespace"];
			if ($fieldCriteriaNamespace["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Namespace', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaNamespace["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Namespace', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAlias = $criteriaPortletDefinition["alias"];
			if ($fieldCriteriaAlias["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Alias', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAlias["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Alias', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaAuthor = $criteriaPortletDefinition["author"];
			if ($fieldCriteriaAuthor["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Author', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaAuthor["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Author', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaVersion = $criteriaPortletDefinition["version"];
			if ($fieldCriteriaVersion["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Version', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaVersion["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Version', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaPortletDefinition = self::getCriteria();
			if (isset($criteriaPortletDefinition["name"])) {
				$fieldCriteriaName = $criteriaPortletDefinition["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["namespace"])) {
				$fieldCriteriaNamespace = $criteriaPortletDefinition["namespace"];
				if ($fieldCriteriaNamespace["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_namespace IS NOT NULL ';
				} elseif ($fieldCriteriaNamespace["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_namespace IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaNamespace["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_namespace like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["alias"])) {
				$fieldCriteriaAlias = $criteriaPortletDefinition["alias"];
				if ($fieldCriteriaAlias["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_alias IS NOT NULL ';
				} elseif ($fieldCriteriaAlias["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_alias IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAlias["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_alias like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["author"])) {
				$fieldCriteriaAuthor = $criteriaPortletDefinition["author"];
				if ($fieldCriteriaAuthor["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_author IS NOT NULL ';
				} elseif ($fieldCriteriaAuthor["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_author IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaAuthor["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_author like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletDefinition["version"])) {
				$fieldCriteriaVersion = $criteriaPortletDefinition["version"];
				if ($fieldCriteriaVersion["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_version IS NOT NULL ';
				} elseif ($fieldCriteriaVersion["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_definitions.pdf_version IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaVersion["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_definitions.pdf_version like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			$whereClausePortletDefinition = $whereClausePortletDefinition . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletDefinition = $whereClausePortletDefinition . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_portlet_definitions.pdf_id, prt_portlet_definitions.pdf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_name pdf_name";
			} else {
				if ($defaultOrderColumn == "pdf_name") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_name ";
				}
			}
			if (P('show_pdf_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_namespace pdf_namespace";
			} else {
				if ($defaultOrderColumn == "pdf_namespace") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_namespace ";
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_alias pdf_alias";
			} else {
				if ($defaultOrderColumn == "pdf_alias") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_alias ";
				}
			}
			if (P('show_pdf_author', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_author pdf_author";
			} else {
				if ($defaultOrderColumn == "pdf_author") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_author ";
				}
			}
			if (P('show_pdf_version', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_version pdf_version";
			} else {
				if ($defaultOrderColumn == "pdf_version") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_version ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_definitions ";

		$resultsPortletDefinition = $resultPortletDefinition->select(
			'', 
			'all', 
			$resultPortletDefinition->getOrderColumn(), 
			$resultPortletDefinition->getOrderMode(), 
			$whereClausePortletDefinition,
			$queryString);
		
		foreach ($resultsPortletDefinition as $resultPortletDefinition) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletDefinition['pdf_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_namespace', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletDefinition['pdf_namespace'])) + 6;
				if ($tmpLen > $minWidth['namespace']) {
					$minWidth['namespace'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_alias', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletDefinition['pdf_alias'])) + 6;
				if ($tmpLen > $minWidth['alias']) {
					$minWidth['alias'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_author', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletDefinition['pdf_author'])) + 6;
				if ($tmpLen > $minWidth['author']) {
					$minWidth['author'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_version', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletDefinition['pdf_version'])) + 6;
				if ($tmpLen > $minWidth['version']) {
					$minWidth['version'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPortletDefinition = $resultPortletDefinition->getCriteria();
		if (is_null($criteriaPortletDefinition) || sizeof($criteriaPortletDefinition) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																						if (P('show_pdf_name', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, T('NAME'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_namespace', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['namespace'], $colHeight, T('NAMESPACE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_alias', "1") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['alias'], $colHeight, T('ALIAS'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_author', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['author'], $colHeight, T('AUTHOR'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_version', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['version'], $colHeight, T('VERSION'), 'T', 'C', 0, 0);
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
		foreach ($resultsPortletDefinition as $resultPortletDefinition) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultPortletDefinition['pdf_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultPortletDefinition['pdf_name'])) {
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
										if (!is_null($resultPortletDefinition['pdf_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultPortletDefinition['pdf_name'])) {
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
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_namespace', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['namespace'], $colHeight, '' . $resultPortletDefinition['pdf_namespace'], 'T', 'L', 0, 0);
				if (P('show_pdf_namespace', "1") == "2") {
										if (!is_null($resultPortletDefinition['pdf_namespace'])) {
						$tmpCount = (float)$counts["namespace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["namespace"] = $tmpCount;
					}
				}
				if (P('show_pdf_namespace', "1") == "3") {
										if (!is_null($resultPortletDefinition['pdf_namespace'])) {
						$tmpSum = (float)$sums["namespace"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_namespace'];
						}
						$sums["namespace"] = $tmpSum;
					}
				}
				if (P('show_pdf_namespace', "1") == "4") {
										if (!is_null($resultPortletDefinition['pdf_namespace'])) {
						$tmpCount = (float)$avgCounts["namespace"];
						$tmpSum = (float)$avgSums["namespace"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["namespace"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_namespace'];
						}
						$avgSums["namespace"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_alias', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['alias'], $colHeight, '' . $resultPortletDefinition['pdf_alias'], 'T', 'L', 0, 0);
				if (P('show_pdf_alias', "1") == "2") {
										if (!is_null($resultPortletDefinition['pdf_alias'])) {
						$tmpCount = (float)$counts["alias"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["alias"] = $tmpCount;
					}
				}
				if (P('show_pdf_alias', "1") == "3") {
										if (!is_null($resultPortletDefinition['pdf_alias'])) {
						$tmpSum = (float)$sums["alias"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_alias'];
						}
						$sums["alias"] = $tmpSum;
					}
				}
				if (P('show_pdf_alias', "1") == "4") {
										if (!is_null($resultPortletDefinition['pdf_alias'])) {
						$tmpCount = (float)$avgCounts["alias"];
						$tmpSum = (float)$avgSums["alias"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["alias"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_alias'];
						}
						$avgSums["alias"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_author', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['author'], $colHeight, '' . $resultPortletDefinition['pdf_author'], 'T', 'L', 0, 0);
				if (P('show_pdf_author', "1") == "2") {
										if (!is_null($resultPortletDefinition['pdf_author'])) {
						$tmpCount = (float)$counts["author"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["author"] = $tmpCount;
					}
				}
				if (P('show_pdf_author', "1") == "3") {
										if (!is_null($resultPortletDefinition['pdf_author'])) {
						$tmpSum = (float)$sums["author"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_author'];
						}
						$sums["author"] = $tmpSum;
					}
				}
				if (P('show_pdf_author', "1") == "4") {
										if (!is_null($resultPortletDefinition['pdf_author'])) {
						$tmpCount = (float)$avgCounts["author"];
						$tmpSum = (float)$avgSums["author"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["author"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_author'];
						}
						$avgSums["author"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_version', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['version'], $colHeight, '' . $resultPortletDefinition['pdf_version'], 'T', 'L', 0, 0);
				if (P('show_pdf_version', "1") == "2") {
										if (!is_null($resultPortletDefinition['pdf_version'])) {
						$tmpCount = (float)$counts["version"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["version"] = $tmpCount;
					}
				}
				if (P('show_pdf_version', "1") == "3") {
										if (!is_null($resultPortletDefinition['pdf_version'])) {
						$tmpSum = (float)$sums["version"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_version'];
						}
						$sums["version"] = $tmpSum;
					}
				}
				if (P('show_pdf_version', "1") == "4") {
										if (!is_null($resultPortletDefinition['pdf_version'])) {
						$tmpCount = (float)$avgCounts["version"];
						$tmpSum = (float)$avgSums["version"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["version"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletDefinition['pdf_version'];
						}
						$avgSums["version"] = $tmpSum;
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
			if (P('show_pdf_namespace', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['namespace'];
				if (P('show_pdf_namespace', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["namespace"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["alias"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_author', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['author'];
				if (P('show_pdf_author', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["author"];
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["version"];
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
			if (P('show_pdf_namespace', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['namespace'];
				if (P('show_pdf_namespace', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["namespace"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["alias"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_author', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['author'];
				if (P('show_pdf_author', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["author"], 2, ',', ' ');
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;
				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["version"], 2, ',', ' ');
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
			if (P('show_pdf_namespace', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['namespace'];
				if (P('show_pdf_namespace', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["namespace"] == 0 ? "-" : $avgSums["namespace"] / $avgCounts["namespace"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_alias', "1") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['alias'];
				if (P('show_pdf_alias', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["alias"] == 0 ? "-" : $avgSums["alias"] / $avgCounts["alias"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_author', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['author'];
				if (P('show_pdf_author', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["author"] == 0 ? "-" : $avgSums["author"] / $avgCounts["author"]);
					$pdf->MultiCell($tmpWidth, $colHeight, $aggrVal, 0, 'R', 0, 0);
					$tmpWidth = 0;

				}
			}
			if (P('show_pdf_version', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['version'];
				if (P('show_pdf_version', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["version"] == 0 ? "-" : $avgSums["version"] / $avgCounts["version"]);
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
				$reportTitle = T('PORTLET_DEFINITIONS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPortletDefinition = new virgoPortletDefinition();
			$whereClausePortletDefinition = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletDefinition = $whereClausePortletDefinition . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_namespace', "1") != "0") {
					$data = $data . $stringDelimeter .'Namespace' . $stringDelimeter . $separator;
				}
				if (P('show_export_alias', "1") != "0") {
					$data = $data . $stringDelimeter .'Alias' . $stringDelimeter . $separator;
				}
				if (P('show_export_author', "1") != "0") {
					$data = $data . $stringDelimeter .'Author' . $stringDelimeter . $separator;
				}
				if (P('show_export_version', "1") != "0") {
					$data = $data . $stringDelimeter .'Version' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_definitions.pdf_id, prt_portlet_definitions.pdf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_name pdf_name";
			} else {
				if ($defaultOrderColumn == "pdf_name") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_name ";
				}
			}
			if (P('show_export_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_namespace pdf_namespace";
			} else {
				if ($defaultOrderColumn == "pdf_namespace") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_namespace ";
				}
			}
			if (P('show_export_alias', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_alias pdf_alias";
			} else {
				if ($defaultOrderColumn == "pdf_alias") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_alias ";
				}
			}
			if (P('show_export_author', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_author pdf_author";
			} else {
				if ($defaultOrderColumn == "pdf_author") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_author ";
				}
			}
			if (P('show_export_version', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_version pdf_version";
			} else {
				if ($defaultOrderColumn == "pdf_version") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_version ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_definitions ";

			$resultsPortletDefinition = $resultPortletDefinition->select(
				'', 
				'all', 
				$resultPortletDefinition->getOrderColumn(), 
				$resultPortletDefinition->getOrderMode(), 
				$whereClausePortletDefinition,
				$queryString);
			foreach ($resultsPortletDefinition as $resultPortletDefinition) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletDefinition['pdf_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_namespace', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletDefinition['pdf_namespace'] . $stringDelimeter . $separator;
				}
				if (P('show_export_alias', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletDefinition['pdf_alias'] . $stringDelimeter . $separator;
				}
				if (P('show_export_author', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletDefinition['pdf_author'] . $stringDelimeter . $separator;
				}
				if (P('show_export_version', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletDefinition['pdf_version'] . $stringDelimeter . $separator;
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
				$reportTitle = T('PORTLET_DEFINITIONS');
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
			$resultPortletDefinition = new virgoPortletDefinition();
			$whereClausePortletDefinition = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletDefinition = $whereClausePortletDefinition . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Name');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_namespace', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Namespace');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_alias', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Alias');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_author', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Author');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_version', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Version');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_definitions.pdf_id, prt_portlet_definitions.pdf_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_name pdf_name";
			} else {
				if ($defaultOrderColumn == "pdf_name") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_name ";
				}
			}
			if (P('show_export_namespace', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_namespace pdf_namespace";
			} else {
				if ($defaultOrderColumn == "pdf_namespace") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_namespace ";
				}
			}
			if (P('show_export_alias', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_alias pdf_alias";
			} else {
				if ($defaultOrderColumn == "pdf_alias") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_alias ";
				}
			}
			if (P('show_export_author', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_author pdf_author";
			} else {
				if ($defaultOrderColumn == "pdf_author") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_author ";
				}
			}
			if (P('show_export_version', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_definitions.pdf_version pdf_version";
			} else {
				if ($defaultOrderColumn == "pdf_version") {
					$orderColumnNotDisplayed = " prt_portlet_definitions.pdf_version ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_definitions ";

			$resultsPortletDefinition = $resultPortletDefinition->select(
				'', 
				'all', 
				$resultPortletDefinition->getOrderColumn(), 
				$resultPortletDefinition->getOrderMode(), 
				$whereClausePortletDefinition,
				$queryString);
			$index = 1;
			foreach ($resultsPortletDefinition as $resultPortletDefinition) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPortletDefinition['pdf_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletDefinition['pdf_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_namespace', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletDefinition['pdf_namespace'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_alias', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletDefinition['pdf_alias'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_author', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletDefinition['pdf_author'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_version', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletDefinition['pdf_version'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['name'] = 'pdf_name';
					$propertyColumnHash['name'] = 'pdf_name';
					$propertyColumnHash['namespace'] = 'pdf_namespace';
					$propertyColumnHash['namespace'] = 'pdf_namespace';
					$propertyColumnHash['alias'] = 'pdf_alias';
					$propertyColumnHash['alias'] = 'pdf_alias';
					$propertyColumnHash['author'] = 'pdf_author';
					$propertyColumnHash['author'] = 'pdf_author';
					$propertyColumnHash['version'] = 'pdf_version';
					$propertyColumnHash['version'] = 'pdf_version';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPortletDefinition = new virgoPortletDefinition();
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
										L(T('PROPERTY_NOT_FOUND', T('PORTLET_DEFINITION'), $columns[$index]), '', 'ERROR');
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
										$importPortletDefinition->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importPortletDefinition->store();
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
		static function getParameterValue($name, $pdfAlias, $pdfNamespace = null) {
			if (S($pdfNamespace)) {
				$namespaceCondition = " AND pdf_namespace = ? ";
				$namespaceType = "s";
				$namespaceValue = array($pdfNamespace);
			} else {
				$namespaceCondition = " ";
				$namespaceType = "";
				$namespaceValue = array();
			}
			$query = <<<SQL
SELECT
	ppr_value
FROM
	prt_portlet_definitions,
	prt_portlet_parameters
WHERE 
	pdf_alias = ?
	AND ppr_pdf_id = pdf_id
	AND ppr_name = ?
	{$namespaceCondition}
ORDER BY 
	ppr_pdf_id
SQL;
			return QP1($query, "ss".$namespaceType, array_merge(array($pdfAlias, $name), $namespaceValue));
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_portlet_definitions` (
  `pdf_id` bigint(20) unsigned NOT NULL auto_increment,
  `pdf_virgo_state` varchar(50) default NULL,
  `pdf_virgo_title` varchar(255) default NULL,
  `pdf_name` varchar(255), 
  `pdf_namespace` varchar(255), 
  `pdf_alias` varchar(255), 
  `pdf_author` varchar(255), 
  `pdf_version` varchar(255), 
  `pdf_date_created` datetime NOT NULL,
  `pdf_date_modified` datetime default NULL,
  `pdf_usr_created_id` int(11) NOT NULL,
  `pdf_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`pdf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/portlet_definition.sql 
INSERT INTO `prt_portlet_definitions` (`pdf_virgo_title`, `pdf_name`, `pdf_namespace`, `pdf_alias`, `pdf_author`, `pdf_version`) 
VALUES (title, some_value, some_value, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_portlet_definitions table already exists.", '', 'FATAL');
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
			return "pdf";
		}
		
		static function getPlural() {
			return "portlet_definitions";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPortletObject";
			$ret[] = "virgoPortletParameter";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_portlet_definitions'));
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
			$virgoVersion = virgoPortletDefinition::getVirgoVersion();
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
	
	

