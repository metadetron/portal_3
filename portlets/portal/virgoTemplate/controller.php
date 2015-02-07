<?php
/**
* Module Template
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoTemplate {

		 var  $tmp_id = null;
		 var  $tmp_name = null;

		 var  $tmp_code = null;

		 var  $tmp_css = null;


		 var   $tmp_date_created = null;
		 var   $tmp_usr_created_id = null;
		 var   $tmp_date_modified = null;
		 var   $tmp_usr_modified_id = null;
		 var   $tmp_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoTemplate();
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
        	$this->tmp_id = null;
		    $this->tmp_date_created = null;
		    $this->tmp_usr_created_id = null;
		    $this->tmp_date_modified = null;
		    $this->tmp_usr_modified_id = null;
		    $this->tmp_virgo_title = null;
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
			return $this->tmp_id;
		}

		function getName() {
			return $this->tmp_name;
		}
		
		 function setName($val) {
			$this->tmp_name = $val;
		}
		function getCode() {
			return $this->tmp_code;
		}
		
		 function setCode($val) {
			$this->tmp_code = $val;
		}
		function getCss() {
			return $this->tmp_css;
		}
		
		 function setCss($val) {
			$this->tmp_css = $val;
		}


		function getDateCreated() {
			return $this->tmp_date_created;
		}
		function getUsrCreatedId() {
			return $this->tmp_usr_created_id;
		}
		function getDateModified() {
			return $this->tmp_date_modified;
		}
		function getUsrModifiedId() {
			return $this->tmp_usr_modified_id;
		}



		function loadRecordFromRequest($rowId) {
			$this->tmp_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('tmp_name_' . $this->tmp_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->tmp_name = null;
		} else {
			$this->tmp_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('tmp_code_' . $this->tmp_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->tmp_code = null;
		} else {
			$this->tmp_code = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('tmp_css_' . $this->tmp_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->tmp_css = null;
		} else {
			$this->tmp_css = $tmpValue;
		}
	}
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('tmp_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaTemplate = array();	
			$criteriaFieldTemplate = array();	
			$isNullTemplate = R('virgo_search_name_is_null');
			
			$criteriaFieldTemplate["is_null"] = 0;
			if ($isNullTemplate == "not_null") {
				$criteriaFieldTemplate["is_null"] = 1;
			} elseif ($isNullTemplate == "null") {
				$criteriaFieldTemplate["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldTemplate["value"] = $dataTypeCriteria;
//			}
			$criteriaTemplate["name"] = $criteriaFieldTemplate;
			$criteriaFieldTemplate = array();	
			$isNullTemplate = R('virgo_search_code_is_null');
			
			$criteriaFieldTemplate["is_null"] = 0;
			if ($isNullTemplate == "not_null") {
				$criteriaFieldTemplate["is_null"] = 1;
			} elseif ($isNullTemplate == "null") {
				$criteriaFieldTemplate["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldTemplate["value"] = $dataTypeCriteria;
//			}
			$criteriaTemplate["code"] = $criteriaFieldTemplate;
			$criteriaFieldTemplate = array();	
			$isNullTemplate = R('virgo_search_css_is_null');
			
			$criteriaFieldTemplate["is_null"] = 0;
			if ($isNullTemplate == "not_null") {
				$criteriaFieldTemplate["is_null"] = 1;
			} elseif ($isNullTemplate == "null") {
				$criteriaFieldTemplate["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldTemplate["value"] = $dataTypeCriteria;
//			}
			$criteriaTemplate["css"] = $criteriaFieldTemplate;
			self::setCriteria($criteriaTemplate);
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
			$tableFilter = R('virgo_filter_code');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCode', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCode', null);
			}
			$tableFilter = R('virgo_filter_css');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterCss', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterCss', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseTemplate = ' 1 = 1 ';
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
				$eventColumn = "tmp_" . P('event_column');
				$whereClauseTemplate = $whereClauseTemplate . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTemplate = $whereClauseTemplate . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaTemplate = self::getCriteria();
			if (isset($criteriaTemplate["name"])) {
				$fieldCriteriaName = $criteriaTemplate["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_templates.tmp_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTemplate["code"])) {
				$fieldCriteriaCode = $criteriaTemplate["code"];
				if ($fieldCriteriaCode["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_code IS NOT NULL ';
				} elseif ($fieldCriteriaCode["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCode["value"];
				}
			}
			if (isset($criteriaTemplate["css"])) {
				$fieldCriteriaCss = $criteriaTemplate["css"];
				if ($fieldCriteriaCss["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_css IS NOT NULL ';
				} elseif ($fieldCriteriaCss["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_css IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCss["value"];
				}
			}
			$whereClauseTemplate = $whereClauseTemplate . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseTemplate = $whereClauseTemplate . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseTemplate = $whereClauseTemplate . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClauseTemplate = $whereClauseTemplate . " AND tmp_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCode', null);
				if (S($tableFilter)) {
					$whereClauseTemplate = $whereClauseTemplate . " AND tmp_code LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterCss', null);
				if (S($tableFilter)) {
					$whereClauseTemplate = $whereClauseTemplate . " AND tmp_css LIKE '%{$tableFilter}%' ";
				}
			}
			return $whereClauseTemplate;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseTemplate = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_templates.tmp_id, prt_templates.tmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_name tmp_name";
			} else {
				if ($defaultOrderColumn == "tmp_name") {
					$orderColumnNotDisplayed = " prt_templates.tmp_name ";
				}
			}
			if (P('show_table_code', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_code tmp_code";
			} else {
				if ($defaultOrderColumn == "tmp_code") {
					$orderColumnNotDisplayed = " prt_templates.tmp_code ";
				}
			}
			if (P('show_table_css', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_css tmp_css";
			} else {
				if ($defaultOrderColumn == "tmp_css") {
					$orderColumnNotDisplayed = " prt_templates.tmp_css ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_templates ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseTemplate = $whereClauseTemplate . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseTemplate, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseTemplate,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_templates"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " tmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " tmp_usr_created_id = ? ";
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
				. "\n FROM prt_templates"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_templates ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_templates ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, tmp_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " tmp_usr_created_id = ? ";
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
				$query = "SELECT COUNT(tmp_id) cnt FROM templates";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as templates ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as templates ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoTemplate();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_templates WHERE tmp_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->tmp_id = $row['tmp_id'];
$this->tmp_name = $row['tmp_name'];
$this->tmp_code = $row['tmp_code'];
$this->tmp_css = $row['tmp_css'];
						if ($fetchUsernames) {
							if ($row['tmp_date_created']) {
								if ($row['tmp_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['tmp_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['tmp_date_modified']) {
								if ($row['tmp_usr_modified_id'] == $row['tmp_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['tmp_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['tmp_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->tmp_date_created = $row['tmp_date_created'];
						$this->tmp_usr_created_id = $fetchUsernames ? $createdBy : $row['tmp_usr_created_id'];
						$this->tmp_date_modified = $row['tmp_date_modified'];
						$this->tmp_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['tmp_usr_modified_id'];
						$this->tmp_virgo_title = $row['tmp_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_templates SET tmp_usr_created_id = {$userId} WHERE tmp_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->tmp_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoTemplate::selectAllAsObjectsStatic('tmp_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->tmp_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->tmp_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('tmp_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_tmp = new virgoTemplate();
				$tmp_tmp->load((int)$lookup_id);
				return $tmp_tmp->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoTemplate');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" tmp_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoTemplate', "10");
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
				$query = $query . " tmp_id as id, tmp_virgo_title as title ";
			}
			$query = $query . " FROM prt_templates ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoTemplate', 'portal') == "1") {
				$privateCondition = " tmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY tmp_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resTemplate = array();
				foreach ($rows as $row) {
					$resTemplate[$row['id']] = $row['title'];
				}
				return $resTemplate;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticTemplate = new virgoTemplate();
			return $staticTemplate->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getPagesStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPage = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPage;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPage;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPage = virgoPage::selectAll('pge_tmp_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPage as $resultPage) {
				$tmpPage = virgoPage::getById($resultPage['pge_id']); 
				array_push($resPage, $tmpPage);
			}
			return $resPage;
		}

		function getPages($orderBy = '', $extraWhere = null) {
			return virgoTemplate::getPagesStatic($this->getId(), $orderBy, $extraWhere);
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
			$resultsPortletParameter = virgoPortletParameter::selectAll('ppr_tmp_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				$tmpPortletParameter = virgoPortletParameter::getById($resultPortletParameter['ppr_id']); 
				array_push($resPortletParameter, $tmpPortletParameter);
			}
			return $resPortletParameter;
		}

		function getPortletParameters($orderBy = '', $extraWhere = null) {
			return virgoTemplate::getPortletParametersStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getPortalsStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resPortal = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resPortal;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resPortal;
			}
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsPortal = virgoPortal::selectAll('prt_tmp_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsPortal as $resultPortal) {
				$tmpPortal = virgoPortal::getById($resultPortal['prt_id']); 
				array_push($resPortal, $tmpPortal);
			}
			return $resPortal;
		}

		function getPortals($orderBy = '', $extraWhere = null) {
			return virgoTemplate::getPortalsStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_code_obligatory', "0") == "1") {
				if (
(is_null($this->getCode()) || trim($this->getCode()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CODE');
				}			
			}
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_css_obligatory', "0") == "1") {
				if (
(is_null($this->getCss()) || trim($this->getCss()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CSS');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_templates WHERE tmp_id = " . $this->getId();
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
				$colNames = $colNames . ", tmp_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", tmp_code";
				$values = $values . ", " . (is_null($objectToStore->getCode()) ? "null" : "'" . QE($objectToStore->getCode()) . "'");
				$colNames = $colNames . ", tmp_css";
				$values = $values . ", " . (is_null($objectToStore->getCss()) ? "null" : "'" . QE($objectToStore->getCss()) . "'");
				$query = "INSERT INTO prt_history_templates (revision, ip, username, user_id, timestamp, tmp_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", tmp_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCode() != $objectToStore->getCode()) {
				if (is_null($objectToStore->getCode())) {
					$nullifiedProperties = $nullifiedProperties . "code,";
				} else {
				$colNames = $colNames . ", tmp_code";
				$values = $values . ", " . (is_null($objectToStore->getCode()) ? "null" : "'" . QE($objectToStore->getCode()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getCss() != $objectToStore->getCss()) {
				if (is_null($objectToStore->getCss())) {
					$nullifiedProperties = $nullifiedProperties . "css,";
				} else {
				$colNames = $colNames . ", tmp_css";
				$values = $values . ", " . (is_null($objectToStore->getCss()) ? "null" : "'" . QE($objectToStore->getCss()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			$query = "INSERT INTO prt_history_templates (revision, ip, username, user_id, timestamp, tmp_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_templates");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'tmp_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_templates ADD COLUMN (tmp_virgo_title VARCHAR(255));";
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
			if (isset($this->tmp_id) && $this->tmp_id != "") {
				$query = "UPDATE prt_templates SET ";
			if (isset($this->tmp_name)) {
				$query .= " tmp_name = ? ,";
				$types .= "s";
				$values[] = $this->tmp_name;
			} else {
				$query .= " tmp_name = NULL ,";				
			}
			if (isset($this->tmp_code)) {
				$query .= " tmp_code = ? ,";
				$types .= "s";
				$values[] = $this->tmp_code;
			} else {
				$query .= " tmp_code = NULL ,";				
			}
			if (isset($this->tmp_css)) {
				$query .= " tmp_css = ? ,";
				$types .= "s";
				$values[] = $this->tmp_css;
			} else {
				$query .= " tmp_css = NULL ,";				
			}
				$query = $query . " tmp_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " tmp_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->tmp_date_modified;

				$query = $query . " tmp_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->tmp_usr_modified_id;

				$query = $query . " WHERE tmp_id = ? ";
				$types = $types . "i";
				$values[] = $this->tmp_id;
			} else {
				$query = "INSERT INTO prt_templates ( ";
			$query = $query . " tmp_name, ";
			$query = $query . " tmp_code, ";
			$query = $query . " tmp_css, ";
				$query = $query . " tmp_virgo_title, tmp_date_created, tmp_usr_created_id) VALUES ( ";
			if (isset($this->tmp_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->tmp_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->tmp_code)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->tmp_code;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->tmp_css)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->tmp_css;
			} else {
				$query .= " NULL ,";				
			}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->tmp_date_created;
				$values[] = $this->tmp_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->tmp_id) || $this->tmp_id == "") {
					$this->tmp_id = QID();
				}
				if ($log) {
					L("template stored successfully", "id = {$this->tmp_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->tmp_id) {
				$virgoOld = new virgoTemplate($this->tmp_id);
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
					if ($this->tmp_id) {			
						$this->tmp_date_modified = date("Y-m-d H:i:s");
						$this->tmp_usr_modified_id = $userId;
					} else {
						$this->tmp_date_created = date("Y-m-d H:i:s");
						$this->tmp_usr_created_id = $userId;
					}
					$this->tmp_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "template" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "template" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_templates WHERE tmp_id = {$this->tmp_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getPages();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'TEMPLATE', 'PAGE', $name);
			}
			$list = $this->getPortletParameters();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getPortals();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'TEMPLATE', 'PORTAL', $name);
			}
			self::removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoTemplate();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT tmp_id as id FROM prt_templates";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'tmp_order_column')) {
				$orderBy = " ORDER BY tmp_order_column ASC ";
			} 
			if (property_exists($this, 'tmp_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY tmp_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoTemplate();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoTemplate($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_templates SET tmp_virgo_title = '$title' WHERE tmp_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoTemplate();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoTemplate();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" tmp_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['tmp_id'];
			}
			return null;
		}
		static function getByCodeStatic($token) {
			$tmpStatic = new virgoTemplate();
			$tmpId = $tmpStatic->getIdByCode($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByCodeStatic($token) {
			$tmpStatic = new virgoTemplate();
			return $tmpStatic->getIdByCode($token);
		}
		
		function getIdByCode($token) {
			$res = $this->selectAll(" tmp_code = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['tmp_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoTemplate();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" tmp_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['tmp_id'];
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
			virgoTemplate::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoTemplate::setSessionValue('Portal_Template-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoTemplate::getSessionValue('Portal_Template-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoTemplate::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoTemplate::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoTemplate::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoTemplate::getSessionValue('GLOBAL', $name, $default);
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
			$context['tmp_id'] = $id;
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
			$context['tmp_id'] = null;
			virgoTemplate::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoTemplate::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoTemplate::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoTemplate::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoTemplate::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoTemplate::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoTemplate::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoTemplate::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoTemplate::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoTemplate::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoTemplate::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoTemplate::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoTemplate::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoTemplate::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoTemplate::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoTemplate::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoTemplate::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "tmp_id";
			}
			return virgoTemplate::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoTemplate::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoTemplate::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoTemplate::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoTemplate::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoTemplate::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoTemplate::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoTemplate::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoTemplate::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoTemplate::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoTemplate::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoTemplate::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoTemplate::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->tmp_id) {
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
						L(T('STORED_CORRECTLY', 'TEMPLATE'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->tmp_name);
						$fieldValues = $fieldValues . T($fieldValue, 'code', $this->tmp_code);
						$fieldValues = $fieldValues . T($fieldValue, 'css', $this->tmp_css);
						$username = '';
						if ($this->tmp_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->tmp_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->tmp_date_created);
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
			$instance = new virgoTemplate();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			if (false) { //$componentParams->get('show_form_pages') == "1") {
				$tmpPage = new virgoPage();
				$deletePage = R('DELETE');
				if (sizeof($deletePage) > 0) {
					$tmpPage->multipleDelete($deletePage);
				}
				$resIds = $tmpPage->select(null, 'all', null, null, ' pge_tmp_id = ' . $instance->getId(), ' SELECT pge_id FROM prt_pages ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->pge_id;
//					JRequest::setVar('pge_template_' . $resId->pge_id, $this->getId());
				} 
//				JRequest::setVar('pge_template_', $instance->getId());
				$tmpPage->setRecordSet($resIdsString);
				if (!$tmpPage->portletActionStoreSelected()) {
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
				$resIds = $tmpPortletParameter->select(null, 'all', null, null, ' ppr_tmp_id = ' . $instance->getId(), ' SELECT ppr_id FROM prt_portlet_parameters ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->ppr_id;
//					JRequest::setVar('ppr_template_' . $resId->ppr_id, $this->getId());
				} 
//				JRequest::setVar('ppr_template_', $instance->getId());
				$tmpPortletParameter->setRecordSet($resIdsString);
				if (!$tmpPortletParameter->portletActionStoreSelected()) {
					$ret = -1;
					self::setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_portals') == "1") {
				$tmpPortal = new virgoPortal();
				$deletePortal = R('DELETE');
				if (sizeof($deletePortal) > 0) {
					$tmpPortal->multipleDelete($deletePortal);
				}
				$resIds = $tmpPortal->select(null, 'all', null, null, ' prt_tmp_id = ' . $instance->getId(), ' SELECT prt_id FROM prt_portals ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->prt_id;
//					JRequest::setVar('prt_template_' . $resId->prt_id, $this->getId());
				} 
//				JRequest::setVar('prt_template_', $instance->getId());
				$tmpPortal->setRecordSet($resIdsString);
				if (!$tmpPortal->portletActionStoreSelected()) {
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
			$tmpId = intval(R('tmp_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoTemplate::getContextId();
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
			$this->tmp_id = null;
			$this->tmp_date_created = null;
			$this->tmp_usr_created_id = null;
			$this->tmp_date_modified = null;
			$this->tmp_usr_modified_id = null;
			$this->tmp_virgo_title = null;
			
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
//			$ret = new virgoTemplate();
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
				$instance = new virgoTemplate();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoTemplate::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'TEMPLATE'), '', 'INFO');
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
				$resultTemplate = new virgoTemplate();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultTemplate->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultTemplate->load($idToEditInt);
					} else {
						$resultTemplate->tmp_id = 0;
					}
				}
				$results[] = $resultTemplate;
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
				$result = new virgoTemplate();
				$result->loadFromRequest($idToStore);
				if ($result->tmp_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->tmp_id == 0) {
						$result->tmp_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->tmp_id)) {
							$result->tmp_id = 0;
						}
						$idsToCorrect[$result->tmp_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'TEMPLATES'), '', 'INFO');
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
			$resultTemplate = new virgoTemplate();
			foreach ($idsToDelete as $idToDelete) {
				$resultTemplate->load((int)trim($idToDelete));
				$res = $resultTemplate->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'TEMPLATES'), '', 'INFO');			
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
		$ret = $this->tmp_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoTemplate');
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
				$query = "UPDATE prt_templates SET tmp_virgo_title = ? WHERE tmp_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT tmp_id AS id FROM prt_templates ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoTemplate($row['id']);
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
						$parentInfo['condition'] = 'prt_templates.tmp_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_templates.tmp_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_templates.tmp_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_templates.tmp_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoTemplate!', '', 'ERROR');
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
			$pdf->SetTitle('Templates report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('TEMPLATES');
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
			if (P('show_pdf_code', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_css', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultTemplate = new virgoTemplate();
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
			if (P('show_pdf_code', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Code');
				$minWidth['code'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['code']) {
						$minWidth['code'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_css', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Css');
				$minWidth['css'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['css']) {
						$minWidth['css'] = min($tmpLen, $maxWidth);
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
			$whereClauseTemplate = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseTemplate = $whereClauseTemplate . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaTemplate = $resultTemplate->getCriteria();
			$fieldCriteriaName = $criteriaTemplate["name"];
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
			$fieldCriteriaCode = $criteriaTemplate["code"];
			if ($fieldCriteriaCode["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Code', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Code', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$fieldCriteriaCss = $criteriaTemplate["css"];
			if ($fieldCriteriaCss["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Css', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaCss["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Css', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaTemplate = self::getCriteria();
			if (isset($criteriaTemplate["name"])) {
				$fieldCriteriaName = $criteriaTemplate["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_templates.tmp_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaTemplate["code"])) {
				$fieldCriteriaCode = $criteriaTemplate["code"];
				if ($fieldCriteriaCode["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_code IS NOT NULL ';
				} elseif ($fieldCriteriaCode["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_code IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCode["value"];
				}
			}
			if (isset($criteriaTemplate["css"])) {
				$fieldCriteriaCss = $criteriaTemplate["css"];
				if ($fieldCriteriaCss["is_null"] == 1) {
$filter = $filter . ' AND prt_templates.tmp_css IS NOT NULL ';
				} elseif ($fieldCriteriaCss["is_null"] == 2) {
$filter = $filter . ' AND prt_templates.tmp_css IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaCss["value"];
				}
			}
			$whereClauseTemplate = $whereClauseTemplate . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseTemplate = $whereClauseTemplate . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_templates.tmp_id, prt_templates.tmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_name tmp_name";
			} else {
				if ($defaultOrderColumn == "tmp_name") {
					$orderColumnNotDisplayed = " prt_templates.tmp_name ";
				}
			}
			if (P('show_pdf_code', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_code tmp_code";
			} else {
				if ($defaultOrderColumn == "tmp_code") {
					$orderColumnNotDisplayed = " prt_templates.tmp_code ";
				}
			}
			if (P('show_pdf_css', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_css tmp_css";
			} else {
				if ($defaultOrderColumn == "tmp_css") {
					$orderColumnNotDisplayed = " prt_templates.tmp_css ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_templates ";

		$resultsTemplate = $resultTemplate->select(
			'', 
			'all', 
			$resultTemplate->getOrderColumn(), 
			$resultTemplate->getOrderMode(), 
			$whereClauseTemplate,
			$queryString);
		
		foreach ($resultsTemplate as $resultTemplate) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTemplate['tmp_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_code', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTemplate['tmp_code'])) + 6;
				if ($tmpLen > $minWidth['code']) {
					$minWidth['code'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_css', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultTemplate['tmp_css'])) + 6;
				if ($tmpLen > $minWidth['css']) {
					$minWidth['css'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaTemplate = $resultTemplate->getCriteria();
		if (is_null($criteriaTemplate) || sizeof($criteriaTemplate) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_code', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['code'], $colHeight, T('CODE'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_css', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['css'], $colHeight, T('CSS'), 'T', 'C', 0, 0);
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
		foreach ($resultsTemplate as $resultTemplate) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultTemplate['tmp_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultTemplate['tmp_name'])) {
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
										if (!is_null($resultTemplate['tmp_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTemplate['tmp_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultTemplate['tmp_name'])) {
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
							$tmpSum = $tmpSum + $resultTemplate['tmp_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_code', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['code'], $colHeight, '' . $resultTemplate['tmp_code'], 'T', 'L', 0, 0);
				if (P('show_pdf_code', "1") == "2") {
										if (!is_null($resultTemplate['tmp_code'])) {
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
										if (!is_null($resultTemplate['tmp_code'])) {
						$tmpSum = (float)$sums["code"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTemplate['tmp_code'];
						}
						$sums["code"] = $tmpSum;
					}
				}
				if (P('show_pdf_code', "1") == "4") {
										if (!is_null($resultTemplate['tmp_code'])) {
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
							$tmpSum = $tmpSum + $resultTemplate['tmp_code'];
						}
						$avgSums["code"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_css', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['css'], $colHeight, '' . $resultTemplate['tmp_css'], 'T', 'L', 0, 0);
				if (P('show_pdf_css', "1") == "2") {
										if (!is_null($resultTemplate['tmp_css'])) {
						$tmpCount = (float)$counts["css"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["css"] = $tmpCount;
					}
				}
				if (P('show_pdf_css', "1") == "3") {
										if (!is_null($resultTemplate['tmp_css'])) {
						$tmpSum = (float)$sums["css"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTemplate['tmp_css'];
						}
						$sums["css"] = $tmpSum;
					}
				}
				if (P('show_pdf_css', "1") == "4") {
										if (!is_null($resultTemplate['tmp_css'])) {
						$tmpCount = (float)$avgCounts["css"];
						$tmpSum = (float)$avgSums["css"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["css"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultTemplate['tmp_css'];
						}
						$avgSums["css"] = $tmpSum;
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
			if (P('show_pdf_code', "0") != "0") {
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
			if (P('show_pdf_css', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['css'];
				if (P('show_pdf_css', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["css"];
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
			if (P('show_pdf_code', "0") != "0") {
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
			if (P('show_pdf_css', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['css'];
				if (P('show_pdf_css', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["css"], 2, ',', ' ');
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
			if (P('show_pdf_code', "0") != "0") {
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
			if (P('show_pdf_css', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['css'];
				if (P('show_pdf_css', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["css"] == 0 ? "-" : $avgSums["css"] / $avgCounts["css"]);
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
				$reportTitle = T('TEMPLATES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultTemplate = new virgoTemplate();
			$whereClauseTemplate = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTemplate = $whereClauseTemplate . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_code', "1") != "0") {
					$data = $data . $stringDelimeter .'Code' . $stringDelimeter . $separator;
				}
				if (P('show_export_css', "1") != "0") {
					$data = $data . $stringDelimeter .'Css' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_templates.tmp_id, prt_templates.tmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_name tmp_name";
			} else {
				if ($defaultOrderColumn == "tmp_name") {
					$orderColumnNotDisplayed = " prt_templates.tmp_name ";
				}
			}
			if (P('show_export_code', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_code tmp_code";
			} else {
				if ($defaultOrderColumn == "tmp_code") {
					$orderColumnNotDisplayed = " prt_templates.tmp_code ";
				}
			}
			if (P('show_export_css', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_css tmp_css";
			} else {
				if ($defaultOrderColumn == "tmp_css") {
					$orderColumnNotDisplayed = " prt_templates.tmp_css ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_templates ";

			$resultsTemplate = $resultTemplate->select(
				'', 
				'all', 
				$resultTemplate->getOrderColumn(), 
				$resultTemplate->getOrderMode(), 
				$whereClauseTemplate,
				$queryString);
			foreach ($resultsTemplate as $resultTemplate) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultTemplate['tmp_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_code', "1") != "0") {
			$data = $data . $resultTemplate['tmp_code'] . $separator;
				}
				if (P('show_export_css', "1") != "0") {
			$data = $data . $resultTemplate['tmp_css'] . $separator;
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
				$reportTitle = T('TEMPLATES');
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
			$resultTemplate = new virgoTemplate();
			$whereClauseTemplate = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseTemplate = $whereClauseTemplate . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_code', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Code');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_css', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Css');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_templates.tmp_id, prt_templates.tmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_name tmp_name";
			} else {
				if ($defaultOrderColumn == "tmp_name") {
					$orderColumnNotDisplayed = " prt_templates.tmp_name ";
				}
			}
			if (P('show_export_code', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_code tmp_code";
			} else {
				if ($defaultOrderColumn == "tmp_code") {
					$orderColumnNotDisplayed = " prt_templates.tmp_code ";
				}
			}
			if (P('show_export_css', "1") != "0") {
				$queryString = $queryString . ", prt_templates.tmp_css tmp_css";
			} else {
				if ($defaultOrderColumn == "tmp_css") {
					$orderColumnNotDisplayed = " prt_templates.tmp_css ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_templates ";

			$resultsTemplate = $resultTemplate->select(
				'', 
				'all', 
				$resultTemplate->getOrderColumn(), 
				$resultTemplate->getOrderMode(), 
				$whereClauseTemplate,
				$queryString);
			$index = 1;
			foreach ($resultsTemplate as $resultTemplate) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultTemplate['tmp_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTemplate['tmp_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_code', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTemplate['tmp_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_css', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultTemplate['tmp_css'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
					$propertyColumnHash['name'] = 'tmp_name';
					$propertyColumnHash['name'] = 'tmp_name';
					$propertyColumnHash['code'] = 'tmp_code';
					$propertyColumnHash['code'] = 'tmp_code';
					$propertyColumnHash['css'] = 'tmp_css';
					$propertyColumnHash['css'] = 'tmp_css';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importTemplate = new virgoTemplate();
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
										L(T('PROPERTY_NOT_FOUND', T('TEMPLATE'), $columns[$index]), '', 'ERROR');
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
										$importTemplate->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importTemplate->store();
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
		static function hsl2rgb($h, $s, $l) {
		  $h = (float)$h / 360.0;
		  $s = (float)$s / 100.0;
		  $l = (float)$l / 100.0;
		  $m2 = ($l <= 0.5) ? $l * ($s + 1) : $l + $s - $l*$s;
		  $m1 = $l * 2 - $m2;
		  return str_pad(dechex(virgoTemplate::_color_hue2rgb($m1, $m2, $h + 0.33333) * 255), 2, "0", STR_PAD_LEFT) . 
					str_pad(dechex(virgoTemplate::_color_hue2rgb($m1, $m2, $h) * 255), 2, "0", STR_PAD_LEFT) . 
					str_pad(dechex(virgoTemplate::_color_hue2rgb($m1, $m2, $h - 0.33333) * 255), 2, "0", STR_PAD_LEFT);
		}

		static function _color_hue2rgb($m1, $m2, $h) {
		  $h = ($h < 0) ? $h + 1 : (($h > 1) ? $h - 1 : $h);
		  if ($h * 6 < 1) return $m1 + ($m2 - $m1) * $h * 6;
		  if ($h * 2 < 1) return $m2;
		  if ($h * 3 < 2) return $m1 + ($m2 - $m1) * (0.66666 - $h) * 6;
		  return $m1;
		}
		
		function normalize($value) {
			if (is_null($value) || trim($value) == "") {
				return 0;
			}
			if ($value <= -50) {
				return -49;
			}
			if ($value >= 50) {
				return 49;
			}
			return $value;
		}
		



		function calculateLightnessStatic($normalizedValue, $kontrast, $jasnosc) {
			$ret = (((50 + $kontrast)/(50 - $kontrast)) * ($normalizedValue - 50) + $jasnosc) + 50;
			if ($ret > 100) return 100;
			if ($ret < 0) return 0;
			return $ret;
		}

		function calculateLigntness($normalizedValue) {
			$kontrast = $this->normalize($this->getParameterValue('virgo_contrast', 0));
			$jasnosc = $this->normalize($this->getParameterValue('virgo_lightness', 0));
			return virgoTemplate::calculateLightnessStatic($normalizedValue, $kontrast, $jasnosc);
		}
		
		function mainColor($s, $l) {
			return $this->hsl2rgb($this->getParameterValue('virgo_main_hue', 0), $this->getParameterValue('virgo_saturation', 100) * $s / 100, $this->calculateLigntness($l));
		}

		function mainColorAbsolute($s, $l) {
			return $this->hsl2rgb($this->getParameterValue('virgo_main_hue', 0), $s, $l);			
		}

		function contrastColor($s, $l) {
			if (!isset($_SESSION['virgo_main_hue'])) {
				$this->getParameterValue('virgo_main_hue', 0);
			}
			$h = $_SESSION['virgo_main_hue'];
			$h = $h + 180;
			if ($h > 360) {
				$h = $h - 360;
			}
			return $this->hsl2rgb($h, $s, $l);
		}

		function getParameterName($paramName) {
			return "template-" . $this->getId() . "-" . $paramName;
		}
		
		function getParameterValue($paramName, $default = null) {
			if (isset($_SESSION[$this->getParameterName($paramName)])) {
				return $_SESSION[$this->getParameterName($paramName)];
			}
			foreach ($this->getPortletParameters() as $parameter) {
				if ('virgo_' . $parameter->getName() == $paramName) {
					$_SESSION[$this->getParameterName($paramName)] = $parameter->getValue();
					return $parameter->getValue();
				}
			}
			$_SESSION[$this->getParameterName($paramName)] = $default;
			return $default;
		}

		function getMainHueDefault() {
			return $this->getParameterValue("virgo_main_hue");
		}
		
		function getMainHueCustom() {
			$file = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', 'main_hue.php', $_SERVER['SCRIPT_NAME']);
			if (file_exists($file)) {				
				require_once($file);
				$className = 'MainHue';
				if (class_exists($className)) {
					if (method_exists($className, 'getValue')) {
						$class = new $className();
						return $class->getValue();
					}
				}
			} else {
				return null;
			}
		}
		
		function getMainHue() {
			$ret = $this->getMainHueCustom();
			if (is_null($ret)) {
				$ret = $this->getMainHueDefault();
			}
			return $ret;
		}
		
		function getParametrizedCss() {
			$css = addcslashes($this->getCss(), '"\\');
			$param = array();
			$tilesUsed = false;
			foreach ($this->getPortletParameters() as $parameter) {
				$param[$parameter->getName()] = $parameter->getValue();
				if ($parameter->getName() == "pattern_col1_sat") {
					$tilesUsed = true;
				}
			}
			eval("\$css = \"$css\";");
			if ($tilesUsed) {
				$c1 = $this->mainColorAbsolute($param['pattern_col1_sat'], $param['pattern_col1_light']);
				$c2 = $this->mainColorAbsolute($param['pattern_col2_sat'], $param['pattern_col2_light']);
				$type = $param['pattern_style'];
				$step = $param['stripes_step'];
				$size = $param['stripes_size'];
				$style = $param['stripes_style'];
				$grade = $param['noise_grade'];
				$full = $param['full_count'];
				$faded = $param['faded_count'];
				$repeat = $param['repeat'];
				$color = $this->mainColorAbsolute($param['pattern_col1_sat'], $param['pattern_col1_light']);
				$tiles = "background: url('/libraries/tiles/index.php?c1={$c1}&c2={$c2}&type={$type}&step={$step}&size={$size}&orient={$style}&grade={$grade}&gradient_full_count={$full}&gradient_faded_count={$faded}') repeat{$repeat} #{$color} !important;";
				$css = str_replace('__TILES__', $tiles, $css);			
			}
			return $css;
		}
		
		function setParameterValue($name, $value) {
			foreach ($this->getPortletParameters() as $parameter) {
				if ($parameter->getName() == $name) {
					$parameter->setValue($value);
					echo $parameter->store();
					return;
				}
			}
			$parameter = new virgoPortletParameter();
			$parameter->setTemplateId($this->getId());
			$parameter->setName($name);
			$parameter->setValue($value);
			echo $parameter->store();
		}
		
		function getCachedFileName() {
			$templateTimestamp = $this->tmp_date_modified;
			$query = " SELECT MAX(ppr_date_modified) FROM prt_portlet_parameters WHERE ppr_tmp_id = {$this->getId()} ";
			$parametersTimestamp = Q1($query);
			$timestamp = max($templateTimestamp, $parametersTimestamp);
			$timestamp = str_replace(array("-", ":", " "), "", $timestamp);
			$cssFileName = "{$this->getId()}_{$this->getMainHue()}_{$timestamp}";
			$cssFilePath = PORTAL_PATH.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$cssFileName.'.css';
			if (!file_exists($cssFilePath)) {
				$fh = fopen($cssFilePath, 'w');
				fwrite($fh, $this->getParametrizedCss());
				fclose($fh);
			}
			if (!is_dir(APP_ROOT.DIRECTORY_SEPARATOR.'cache')) {
				symlink(PORTAL_PATH.DIRECTORY_SEPARATOR.'cache', APP_ROOT.DIRECTORY_SEPARATOR.'cache');
			}			
			return $cssFileName;
		}



		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_templates` (
  `tmp_id` bigint(20) unsigned NOT NULL auto_increment,
  `tmp_virgo_state` varchar(50) default NULL,
  `tmp_virgo_title` varchar(255) default NULL,
  `tmp_name` varchar(255), 
  `tmp_code` longtext, 
  `tmp_css` longtext, 
  `tmp_date_created` datetime NOT NULL,
  `tmp_date_modified` datetime default NULL,
  `tmp_usr_created_id` int(11) NOT NULL,
  `tmp_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`tmp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/template.sql 
INSERT INTO `prt_templates` (`tmp_virgo_title`, `tmp_name`, `tmp_code`, `tmp_css`) 
VALUES (title, some_value, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_templates table already exists.", '', 'FATAL');
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
			return "tmp";
		}
		
		static function getPlural() {
			return "templates";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoPage";
			$ret[] = "virgoPortletParameter";
			$ret[] = "virgoPortal";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_templates'));
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
			$virgoVersion = virgoTemplate::getVirgoVersion();
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
	
	

