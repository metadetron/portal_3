<?php
/**
* Module User role
* @package Portal
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	namespace portal;	
	use portal\virgoUser;
	use portal\virgoPage;
	use portal\virgoPortletObject;

	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoUserRole {

		 var  $url_id = null;
		 var  $url_rle_id = null;
		 var  $url_usr_id = null;

		 var   $url_date_created = null;
		 var   $url_usr_created_id = null;
		 var   $url_date_modified = null;
		 var   $url_usr_modified_id = null;
		 var   $url_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoUserRole();
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
        	$this->url_id = null;
		    $this->url_date_created = null;
		    $this->url_usr_created_id = null;
		    $this->url_date_modified = null;
		    $this->url_usr_modified_id = null;
		    $this->url_virgo_title = null;
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
			return $this->url_id;
		}


		function getRoleId() {
			return $this->url_rle_id;
		}
		
		 function setRoleId($val) {
			$this->url_rle_id = $val;
		}
		function getUserId() {
			return $this->url_usr_id;
		}
		
		 function setUserId($val) {
			$this->url_usr_id = $val;
		}

		function getDateCreated() {
			return $this->url_date_created;
		}
		function getUsrCreatedId() {
			return $this->url_usr_created_id;
		}
		function getDateModified() {
			return $this->url_date_modified;
		}
		function getUsrModifiedId() {
			return $this->url_usr_modified_id;
		}


		function getRleId() {
			return $this->getRoleId();
		}
		
		 function setRleId($val) {
			$this->setRoleId($val);
		}
		function getUsrId() {
			return $this->getUserId();
		}
		
		 function setUsrId($val) {
			$this->setUserId($val);
		}

		function loadRecordFromRequest($rowId) {
			$this->url_id = $rowId;
			$this->url_rle_id = strval(R('url_role_' . $this->url_id));
			$this->url_usr_id = strval(R('url_user_' . $this->url_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('url_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaUserRole = array();	
			$criteriaParent = array();	
			$isNull = R('virgo_search_role_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_role', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaUserRole["role"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_user_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_user', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaUserRole["user"] = $criteriaParent;
			self::setCriteria($criteriaUserRole);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$parentFilter = R('virgo_filter_role');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterRole', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterRole', null);
			}
			$parentFilter = R('virgo_filter_title_role');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleRole', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleRole', null);
			}
			$parentFilter = R('virgo_filter_user');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterUser', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterUser', null);
			}
			$parentFilter = R('virgo_filter_title_user');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleUser', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleUser', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseUserRole = ' 1 = 1 ';
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
				$eventColumn = "url_" . P('event_column');
				$whereClauseUserRole = $whereClauseUserRole . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUserRole = $whereClauseUserRole . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_role');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_user_roles.url_rle_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_user_roles.url_rle_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUserRole = $whereClauseUserRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_user');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_user_roles.url_usr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_user_roles.url_usr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUserRole = $whereClauseUserRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaUserRole = self::getCriteria();
			if (isset($criteriaUserRole["role"])) {
				$parentCriteria = $criteriaUserRole["role"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND url_rle_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_user_roles.url_rle_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaUserRole["user"])) {
				$parentCriteria = $criteriaUserRole["user"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND url_usr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_user_roles.url_usr_id IN (SELECT usr_id FROM prt_users WHERE usr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseUserRole = $whereClauseUserRole . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUserRole = $whereClauseUserRole . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseUserRole = $whereClauseUserRole . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$parentFilter = self::getLocalSessionValue('VirgoFilterRole', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseUserRole = $whereClauseUserRole . " AND url_rle_id IS NULL ";
					} else {
						$whereClauseUserRole = $whereClauseUserRole . " AND url_rle_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleRole', null);
				if (S($parentFilter)) {
					$whereClauseUserRole = $whereClauseUserRole . " AND prt_roles_parent.rle_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterUser', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseUserRole = $whereClauseUserRole . " AND url_usr_id IS NULL ";
					} else {
						$whereClauseUserRole = $whereClauseUserRole . " AND url_usr_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleUser', null);
				if (S($parentFilter)) {
					$whereClauseUserRole = $whereClauseUserRole . " AND prt_users_parent.usr_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseUserRole;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseUserRole = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_user_roles.url_id, prt_user_roles.url_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('portal\virgoRole') && P('show_table_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_rle_id as url_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_table_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_usr_id as url_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_user_roles ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_user_roles.url_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_user_roles.url_usr_id = prt_users_parent.usr_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseUserRole = $whereClauseUserRole . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseUserRole, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseUserRole,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_user_roles"
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
				. "\n FROM prt_user_roles"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_user_roles ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_user_roles ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, url_id $orderMode";
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
				$query = "SELECT COUNT(url_id) cnt FROM user_roles";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as user_roles ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as user_roles ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoUserRole();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_user_roles WHERE url_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->url_id = $row['url_id'];
						$this->url_rle_id = $row['url_rle_id'];
						$this->url_usr_id = $row['url_usr_id'];
						if ($fetchUsernames) {
							if ($row['url_date_created']) {
								if ($row['url_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['url_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['url_date_modified']) {
								if ($row['url_usr_modified_id'] == $row['url_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['url_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['url_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->url_date_created = $row['url_date_created'];
						$this->url_usr_created_id = $fetchUsernames ? $createdBy : $row['url_usr_created_id'];
						$this->url_date_modified = $row['url_date_modified'];
						$this->url_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['url_usr_modified_id'];
						$this->url_virgo_title = $row['url_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_user_roles SET url_usr_created_id = {$userId} WHERE url_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->url_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoUserRole::selectAllAsObjectsStatic('url_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->url_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->url_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('url_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_url = new virgoUserRole();
				$tmp_url->load((int)$lookup_id);
				return $tmp_url->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoUserRole');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" url_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoUserRole', "10");
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
				$query = $query . " url_id as id, url_virgo_title as title ";
			}
			$query = $query . " FROM prt_user_roles ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY url_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resUserRole = array();
				foreach ($rows as $row) {
					$resUserRole[$row['id']] = $row['title'];
				}
				return $resUserRole;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticUserRole = new virgoUserRole();
			return $staticUserRole->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getRoleStatic($parentId) {
			return virgoRole::getById($parentId);
		}
		
		function getRole() {
			return virgoUserRole::getRoleStatic($this->url_rle_id);
		}
		static function getUserStatic($parentId) {
			return virgoUser::getById($parentId);
		}
		
		function getUser() {
			return virgoUserRole::getUserStatic($this->url_usr_id);
		}


		function validateObject($virgoOld) {
				if (is_null($this->url_rle_id) || trim($this->url_rle_id) == "") {
					if (R('create_url_role_' . $this->url_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'ROLE', '');
					}
			}			
				if (is_null($this->url_usr_id) || trim($this->url_usr_id) == "") {
					if (R('create_url_user_' . $this->url_id) == "1") { 
						$parent = new virgoUser();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->url_usr_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'USER', '');
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_user_roles WHERE url_id = " . $this->getId();
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
				$colNames = $colNames . ", url_rle_id";
				$values = $values . ", " . (is_null($objectToStore->getRleId()) || $objectToStore->getRleId() == "" ? "null" : $objectToStore->getRleId());
				$colNames = $colNames . ", url_usr_id";
				$values = $values . ", " . (is_null($objectToStore->getUsrId()) || $objectToStore->getUsrId() == "" ? "null" : $objectToStore->getUsrId());
				$query = "INSERT INTO prt_history_user_roles (revision, ip, username, user_id, timestamp, url_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getRleId() != $objectToStore->getRleId() && ($virgoOld->getRleId() != 0 || $objectToStore->getRleId() != ""))) { 
				$colNames = $colNames . ", url_rle_id";
				$values = $values . ", " . (is_null($objectToStore->getRleId()) ? "null" : ($objectToStore->getRleId() == "" ? "0" : $objectToStore->getRleId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getUsrId() != $objectToStore->getUsrId() && ($virgoOld->getUsrId() != 0 || $objectToStore->getUsrId() != ""))) { 
				$colNames = $colNames . ", url_usr_id";
				$values = $values . ", " . (is_null($objectToStore->getUsrId()) ? "null" : ($objectToStore->getUsrId() == "" ? "0" : $objectToStore->getUsrId()));
			}
			$query = "INSERT INTO prt_history_user_roles (revision, ip, username, user_id, timestamp, url_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_user_roles");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'url_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_user_roles ADD COLUMN (url_virgo_title VARCHAR(255));";
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
			if (isset($this->url_id) && $this->url_id != "") {
				$query = "UPDATE prt_user_roles SET ";
				if (isset($this->url_rle_id) && trim($this->url_rle_id) != "") {
					$query = $query . " url_rle_id = ? , ";
					$types = $types . "i";
					$values[] = $this->url_rle_id;
				} else {
					$query = $query . " url_rle_id = NULL, ";
				}
				if (isset($this->url_usr_id) && trim($this->url_usr_id) != "") {
					$query = $query . " url_usr_id = ? , ";
					$types = $types . "i";
					$values[] = $this->url_usr_id;
				} else {
					$query = $query . " url_usr_id = NULL, ";
				}
				$query = $query . " url_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " url_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->url_date_modified;

				$query = $query . " url_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->url_usr_modified_id;

				$query = $query . " WHERE url_id = ? ";
				$types = $types . "i";
				$values[] = $this->url_id;
			} else {
				$query = "INSERT INTO prt_user_roles ( ";
				$query = $query . " url_rle_id, ";
				$query = $query . " url_usr_id, ";
				$query = $query . " url_virgo_title, url_date_created, url_usr_created_id) VALUES ( ";
				if (isset($this->url_rle_id) && trim($this->url_rle_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->url_rle_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->url_usr_id) && trim($this->url_usr_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->url_usr_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->url_date_created;
				$values[] = $this->url_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->url_id) || $this->url_id == "") {
					$this->url_id = QID();
				}
				if ($log) {
					L("user role stored successfully", "id = {$this->url_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->url_id) {
				$virgoOld = new virgoUserRole($this->url_id);
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
					if ($this->url_id) {			
						$this->url_date_modified = date("Y-m-d H:i:s");
						$this->url_usr_modified_id = $userId;
					} else {
						$this->url_date_created = date("Y-m-d H:i:s");
						$this->url_usr_created_id = $userId;
					}
					$this->url_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "user role" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "user role" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_user_roles WHERE url_id = {$this->url_id}";
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
			$tmp = new virgoUserRole();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT url_id as id FROM prt_user_roles";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'url_order_column')) {
				$orderBy = " ORDER BY url_order_column ASC ";
			} 
			if (property_exists($this, 'url_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY url_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoUserRole();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoUserRole($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_user_roles SET url_virgo_title = '$title' WHERE url_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoUserRole();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" url_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['url_id'];
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
			virgoUserRole::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoUserRole::setSessionValue('Portal_UserRole-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoUserRole::getSessionValue('Portal_UserRole-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoUserRole::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoUserRole::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoUserRole::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoUserRole::getSessionValue('GLOBAL', $name, $default);
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
			$context['url_id'] = $id;
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
			$context['url_id'] = null;
			virgoUserRole::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoUserRole::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoUserRole::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoUserRole::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoUserRole::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoUserRole::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoUserRole::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoUserRole::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoUserRole::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoUserRole::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoUserRole::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoUserRole::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoUserRole::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoUserRole::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoUserRole::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoUserRole::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoUserRole::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "url_id";
			}
			return virgoUserRole::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoUserRole::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoUserRole::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoUserRole::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoUserRole::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoUserRole::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoUserRole::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoUserRole::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoUserRole::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoUserRole::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoUserRole::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoUserRole::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoUserRole::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->url_id) {
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
						L(T('STORED_CORRECTLY', 'USER_ROLE'), '', 'INFO');
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
						$parentRole = new virgoRole();
						$fieldValues = $fieldValues . T($fieldValue, 'role', $parentRole->lookup($this->url_rle_id));
						$parentUser = new virgoUser();
						$fieldValues = $fieldValues . T($fieldValue, 'user', $parentUser->lookup($this->url_usr_id));
						$username = '';
						if ($this->url_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->url_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->url_date_created);
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
			$instance = new virgoUserRole();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUserRole'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('url_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoUserRole::getContextId();
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
			$this->url_id = null;
			$this->url_date_created = null;
			$this->url_usr_created_id = null;
			$this->url_date_modified = null;
			$this->url_usr_modified_id = null;
			$this->url_virgo_title = null;
			
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

		static function portletActionShowForRole() {
			$parentId = R('rle_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoRole($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForUser() {
			$parentId = R('usr_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoUser($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}

		function existingConnections() {
			$where = "";
			if (is_null($this->getRoleId())) {
				L('Missing RoleId', '', 'ERROR');
			}
			$where = $where . " url_rle_id = {$this->getRoleId()}";

			if (is_null($this->getUserId())) {
				L('Missing UserId', '', 'ERROR');
			}
			$where = $where . " AND url_usr_id = {$this->getUserId()}";

			return virgoUserRole::selectAllAsObjectsStatic($where);
		}

		function storeIfNotExists() {
			$res = $this->existingConnections();
			if (count($res) == 0) {
				LE($this->store());
				return $this;
			}
			return $res[0];
		}

		static function portletActionAdd() {
			$portletObject = self::getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			self::removeFromContext();
			self::setDisplayMode("CREATE");
//			$ret = new virgoUserRole();
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
				$instance = new virgoUserRole();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoUserRole::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'USER_ROLE'), '', 'INFO');
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
				$resultUserRole = new virgoUserRole();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultUserRole->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultUserRole->load($idToEditInt);
					} else {
						$resultUserRole->url_id = 0;
					}
				}
				$results[] = $resultUserRole;
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
				$result = new virgoUserRole();
				$result->loadFromRequest($idToStore);
				if ($result->url_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->url_id == 0) {
						$result->url_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->url_id)) {
							$result->url_id = 0;
						}
						$idsToCorrect[$result->url_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'USER_ROLES'), '', 'INFO');
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
			$resultUserRole = new virgoUserRole();
			foreach ($idsToDelete as $idToDelete) {
				$resultUserRole->load((int)trim($idToDelete));
				$res = $resultUserRole->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'USER_ROLES'), '', 'INFO');			
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
		$ret = $this->url_id;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoUserRole');
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
				$query = "UPDATE prt_user_roles SET url_virgo_title = ? WHERE url_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT url_id AS id FROM prt_user_roles ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoUserRole($row['id']);
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
				$class2prefix["portal\\virgoRole"] = "rle";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2parentPrefix["portal\\virgoRole"] = $class2prefix2;
				$class2prefix["portal\\virgoUser"] = "usr";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPage"] = "pge";
				$class2parentPrefix["portal\\virgoUser"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_user_roles.url_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_user_roles.url_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_user_roles.url_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_user_roles.url_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoUserRole!', '', 'ERROR');
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
			$pdf->SetTitle('User roles report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('USER_ROLES');
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
			if (P('show_pdf_role', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_user', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultUserRole = new virgoUserRole();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_role', "1") == "1") {
				$minWidth['role $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'role $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['role $relation.name']) {
						$minWidth['role $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_user', "1") == "1") {
				$minWidth['user $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'user $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['user $relation.name']) {
						$minWidth['user $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseUserRole = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseUserRole = $whereClauseUserRole . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaUserRole = $resultUserRole->getCriteria();
			$parentCriteria = $criteriaUserRole["role"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Role', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoRole::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Role', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaUserRole["user"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'User', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoUser::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'User', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_role');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_user_roles.url_rle_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_user_roles.url_rle_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUserRole = $whereClauseUserRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_user');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_user_roles.url_usr_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_user_roles.url_usr_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseUserRole = $whereClauseUserRole . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaUserRole = self::getCriteria();
			if (isset($criteriaUserRole["role"])) {
				$parentCriteria = $criteriaUserRole["role"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND url_rle_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_user_roles.url_rle_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			if (isset($criteriaUserRole["user"])) {
				$parentCriteria = $criteriaUserRole["user"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND url_usr_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_user_roles.url_usr_id IN (SELECT usr_id FROM prt_users WHERE usr_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClauseUserRole = $whereClauseUserRole . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseUserRole = $whereClauseUserRole . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_user_roles.url_id, prt_user_roles.url_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('portal\virgoRole') && P('show_pdf_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_rle_id as url_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_pdf_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_usr_id as url_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_user_roles ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_user_roles.url_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_user_roles.url_usr_id = prt_users_parent.usr_id) ";
			}

		$resultsUserRole = $resultUserRole->select(
			'', 
			'all', 
			$resultUserRole->getOrderColumn(), 
			$resultUserRole->getOrderMode(), 
			$whereClauseUserRole,
			$queryString);
		
		foreach ($resultsUserRole as $resultUserRole) {
			if (P('show_pdf_role', "1") == "1") {
			$parentValue = trim(virgoRole::lookup($resultUserRole['urlrle__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['role $relation.name']) {
					$minWidth['role $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_user', "1") == "1") {
			$parentValue = trim(virgoUser::lookup($resultUserRole['urlusr__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['user $relation.name']) {
					$minWidth['user $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaUserRole = $resultUserRole->getCriteria();
		if (is_null($criteriaUserRole) || sizeof($criteriaUserRole) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																						if (P('show_pdf_role', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['role $relation.name'], $colHeight, T('ROLE') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_user', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['user $relation.name'], $colHeight, T('USER') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsUserRole as $resultUserRole) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_role', "1") == "1") {
			$parentValue = virgoRole::lookup($resultUserRole['url_rle_id']);
			$tmpLn = $pdf->MultiCell($minWidth['role $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_user', "1") == "1") {
			$parentValue = virgoUser::lookup($resultUserRole['url_usr_id']);
			$tmpLn = $pdf->MultiCell($minWidth['user $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
		}
		$pdf->Ln();
		if (sizeof($sums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
		}
		$pdf->Ln();
		if (sizeof($avgCounts) > 0 && sizeof($avgSums) > 0) {
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			$tmpWidth = 0;
			$labelDone = false;
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
				$reportTitle = T('USER_ROLES');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultUserRole = new virgoUserRole();
			$whereClauseUserRole = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUserRole = $whereClauseUserRole . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_role', "1") != "0") {
					$data = $data . $stringDelimeter . 'Role ' . $stringDelimeter . $separator;
				}
				if (P('show_export_user', "1") != "0") {
					$data = $data . $stringDelimeter . 'User ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_user_roles.url_id, prt_user_roles.url_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('portal\virgoRole') && P('show_export_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_rle_id as url_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_export_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_usr_id as url_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_user_roles ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_user_roles.url_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_user_roles.url_usr_id = prt_users_parent.usr_id) ";
			}

			$resultsUserRole = $resultUserRole->select(
				'', 
				'all', 
				$resultUserRole->getOrderColumn(), 
				$resultUserRole->getOrderMode(), 
				$whereClauseUserRole,
				$queryString);
			foreach ($resultsUserRole as $resultUserRole) {
				if (P('show_export_role', "1") != "0") {
					$parentValue = virgoRole::lookup($resultUserRole['url_rle_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_user', "1") != "0") {
					$parentValue = virgoUser::lookup($resultUserRole['url_usr_id']);
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
				$reportTitle = T('USER_ROLES');
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
			$resultUserRole = new virgoUserRole();
			$whereClauseUserRole = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseUserRole = $whereClauseUserRole . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_role', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Role ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoRole::getVirgoList();
					$formulaRole = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaRole != "") {
							$formulaRole = $formulaRole . ',';
						}
						$formulaRole = $formulaRole . $key;
					}
				}
				if (P('show_export_user', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'User ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoUser::getVirgoList();
					$formulaUser = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaUser != "") {
							$formulaUser = $formulaUser . ',';
						}
						$formulaUser = $formulaUser . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_user_roles.url_id, prt_user_roles.url_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (class_exists('portal\virgoRole') && P('show_export_role', "1") != "0") { // */ && !in_array("rle", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_rle_id as url_rle_id ";
				$queryString = $queryString . ", prt_roles_parent.rle_virgo_title as `role` ";
			} else {
				if ($defaultOrderColumn == "role") {
					$orderColumnNotDisplayed = " prt_roles_parent.rle_virgo_title ";
				}
			}
			if (class_exists('portal\virgoUser') && P('show_export_user', "1") != "0") { // */ && !in_array("usr", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_user_roles.url_usr_id as url_usr_id ";
				$queryString = $queryString . ", prt_users_parent.usr_virgo_title as `user` ";
			} else {
				if ($defaultOrderColumn == "user") {
					$orderColumnNotDisplayed = " prt_users_parent.usr_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_user_roles ";
			if (class_exists('portal\virgoRole')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_roles AS prt_roles_parent ON (prt_user_roles.url_rle_id = prt_roles_parent.rle_id) ";
			}
			if (class_exists('portal\virgoUser')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_users AS prt_users_parent ON (prt_user_roles.url_usr_id = prt_users_parent.usr_id) ";
			}

			$resultsUserRole = $resultUserRole->select(
				'', 
				'all', 
				$resultUserRole->getOrderColumn(), 
				$resultUserRole->getOrderMode(), 
				$whereClauseUserRole,
				$queryString);
			$index = 1;
			foreach ($resultsUserRole as $resultUserRole) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultUserRole['url_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_role', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoRole::lookup($resultUserRole['url_rle_id']);
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
					$objValidation->setFormula1('"' . $formulaRole . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_user', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoUser::lookup($resultUserRole['url_usr_id']);
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
					$objValidation->setFormula1('"' . $formulaUser . '"');
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
					$propertyClassHash['role'] = 'Role';
					$propertyClassHash['role'] = 'Role';
					$propertyColumnHash['role'] = 'url_rle_id';
					$propertyColumnHash['role'] = 'url_rle_id';
					$propertyClassHash['user'] = 'User';
					$propertyClassHash['user'] = 'User';
					$propertyColumnHash['user'] = 'url_usr_id';
					$propertyColumnHash['user'] = 'url_usr_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importUserRole = new virgoUserRole();
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
										L(T('PROPERTY_NOT_FOUND', T('USER_ROLE'), $columns[$index]), '', 'ERROR');
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
										$importUserRole->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_role');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoRole::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoRole::token2Id($tmpToken);
	}
	$importUserRole->setRleId($defaultValue);
}
$defaultValue = P('import_default_value_user');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoUser::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoUser::token2Id($tmpToken);
	}
	$importUserRole->setUsrId($defaultValue);
}
							$errorMessage = $importUserRole->store();
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
		

		static function portletActionVirgoChangeRole() {
			$instance = new virgoUserRole();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoRole::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setRleId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('ROLE'), $title), '', 'INFO');
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



		static function portletActionVirgoSetRole() {
			$this->loadFromDB();
			$parentId = R('url_Role_id_' . $_SESSION['current_portlet_object_id']);
			$this->setRleId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetUser() {
			$this->loadFromDB();
			$parentId = R('url_User_id_' . $_SESSION['current_portlet_object_id']);
			$this->setUsrId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddUser() {
			self::setDisplayMode("ADD_NEW_PARENT_USER");
		}

		static function portletActionStoreNewUser() {
			$id = -1;
			if (virgoUser::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_USER");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['url_user_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
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
CREATE TABLE IF NOT EXISTS `prt_user_roles` (
  `url_id` bigint(20) unsigned NOT NULL auto_increment,
  `url_virgo_state` varchar(50) default NULL,
  `url_virgo_title` varchar(255) default NULL,
	`url_rle_id` int(11) default NULL,
	`url_usr_id` int(11) default NULL,
  `url_date_created` datetime NOT NULL,
  `url_date_modified` datetime default NULL,
  `url_usr_created_id` int(11) NOT NULL,
  `url_usr_modified_id` int(11) default NULL,
  KEY `url_rle_fk` (`url_rle_id`),
  KEY `url_usr_fk` (`url_usr_id`),
  PRIMARY KEY  (`url_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/user_role.sql 
INSERT INTO `prt_user_roles` (`url_virgo_title`) 
VALUES (title);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_user_roles table already exists.", '', 'FATAL');
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
			return "url";
		}
		
		static function getPlural() {
			return "user_roles";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoRole";
			$ret[] = "virgoUser";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_user_roles'));
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
			$virgoVersion = virgoUserRole::getVirgoVersion();
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
	
	

