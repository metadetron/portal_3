<?php
/**
* Module Kompletacja
* @package Sealock
* @author Grzegorz Swierczynski
* @copyright METADETRON (C) 2012 All rights reserved.
*/	
	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	
	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php');
	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoKompletacja {

		var $kmp_id = null;

		var $kmp_date_created = null;
		var $kmp_usr_created_id = null;
		var $kmp_date_modified = null;
		var $kmp_usr_modified_id = null;
		var $kmp_virgo_title = null;
		
		var $internalLog = null;		
				
		function __construct($loadId = null) {
			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		public function __clone() {
        	$this->kmp_id = null;
		    $this->kmp_date_created = null;
		    $this->kmp_usr_created_id = null;
		    $this->kmp_date_modified = null;
		    $this->kmp_usr_modified_id = null;
		    $this->kmp_virgo_title = null;
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
			return $this->kmp_id;
		}




		function loadRecordFromRequest($rowId) {
			$this->kmp_id = $rowId;
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('kmp_id_' . $_SESSION['current_portlet_object_id']);
			}
			if (is_null($rowId) || trim($rowId) == "") {
				$rowId = "";
			} else {
				$rowId = intval($rowId);
				$this->load((int)$rowId);
			}
			$this->loadRecordFromRequest($rowId);
		}		

		function loadSearchFromRequest() {
			$criteriaKompletacja = array();	
			$this->setCriteria($criteriaKompletacja);
		}

		function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		function portletActionSetVirgoTableFilter() {
		}

		function showApplicableOnlyRecords(&$filterApplied) {
			$whereClauseKompletacja = ' 1 = 1 ';
			if (P('form_only') == "3") {
				$pob = $this->getMyPortletObject();
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
				$eventColumn = "kmp_" . P('event_column');
				$whereClauseKompletacja = $whereClauseKompletacja . " AND " . $eventColumn . " BETWEEN '" . $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT)) . "' AND '" . $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT)) . "' ";
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseKompletacja = $whereClauseKompletacja . ' AND ' . $parentContextInfo['condition'];
			}
			$filter = "";
			$criteriaKompletacja = $this->getCriteria();
			$whereClauseKompletacja = $whereClauseKompletacja . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseKompletacja = $whereClauseKompletacja . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseKompletacja = $whereClauseKompletacja . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
			}
			return $whereClauseKompletacja;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$filterApplied = false;
			$whereClauseKompletacja = $this->showApplicableOnlyRecords($filterApplied);
			$queryString = " SELECT slk_kompletacje.kmp_id, slk_kompletacje.kmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_kompletacje ";

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseKompletacja = $whereClauseKompletacja . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseKompletacja, $queryString);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseKompletacja,
					$queryString);

		}
		
		function internalSelect($query, $column = null) {
//			$this->logTrace($query); // JError::raiseNotice( 0, "QUERY: " . $query);
			$this->_error = null;
			return QR($query, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '') {
			$query = "SELECT * "
			. "\n FROM slk_kompletacje"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " kmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
			return $this->internalSelect($query);
		}
		
		function select($showPage, $showRows, $orderColumn, $orderMode, $where = '', $queryString = '') {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " kmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
			if ($queryString == '') {
				$query = "SELECT * "
				. "\n FROM slk_kompletacje"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as slk_kompletacje ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as slk_kompletacje ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, kmp_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return $this->internalSelect($query);
		}

		function getAllRecordCount($where = '', $queryString = '') {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " kmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
			if ($queryString == '') {
				$query = "SELECT COUNT(kmp_id) cnt FROM kompletacje";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as kompletacje ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as kompletacje ";
				}
			}
			
			$results = $this->internalSelect($query);
			return $results[0]['cnt'];
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM slk_kompletacje WHERE kmp_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->kmp_id = $row['kmp_id'];
						if ($fetchUsernames) {
							if ($row['kmp_date_created']) {
								if ($row['kmp_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['kmp_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['kmp_date_modified']) {
								if ($row['kmp_usr_modified_id'] == $row['kmp_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['kmp_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['kmp_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->kmp_date_created = $row['kmp_date_created'];
						$this->kmp_usr_created_id = $fetchUsernames ? $createdBy : $row['kmp_usr_created_id'];
						$this->kmp_date_modified = $row['kmp_date_modified'];
						$this->kmp_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['kmp_usr_modified_id'];
						$this->kmp_virgo_title = $row['kmp_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE slk_kompletacje SET kmp_usr_created_id = {$userId} WHERE kmp_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->kmp_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoKompletacja::selectAllAsObjectsStatic('kmp_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->kmp_usr_created_id;
		}

		function getVirgoCreationDate() {
			return $this->kmp_date_created;
		}

		function loadFromDB() {
			$this->loadIdFromRequest();
			$this->load((int)$this->kmp_id);
		}
		
		function loadIdFromRequest($id = null) {
			$this->kmp_id = intval(is_null($id) ? R('kmp_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_kmp = new virgoKompletacja();
				$tmp_kmp->load((int)$lookup_id);
				return $tmp_kmp->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoKompletacja');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" kmp_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoKompletacja', "10");
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
		
		function getVirgoListSize($where = '') {
			return $this->getVirgoList($where = '', true);
		}

		function getVirgoList($where = '', $sizeOnly = false, $hash = false) {
			$query = " SELECT ";
			if ($sizeOnly) {
				$query = $query . " COUNT(*) AS CNT ";
			} else {
				$query = $query . " kmp_id as id, kmp_virgo_title as title ";
			}
			$query = $query . " FROM slk_kompletacje ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoKompletacja', 'sealock') == "1") {
				$privateCondition = " kmp_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY kmp_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resKompletacja = array();
				foreach ($rows as $row) {
					$resKompletacja[$row['id']] = $row['title'];
				}
				return $resKompletacja;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticKompletacja = new virgoKompletacja();
			return $staticKompletacja->getVirgoList($where, $sizeOnly, $hash);
		}
		

		static function getSkladnikiStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resSkladnik = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoSkladnik'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resSkladnik;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resSkladnik;
			}
			$staticSkladnik = new virgoSkladnik();
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsSkladnik = $staticSkladnik->selectAll('skl_kmp_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsSkladnik as $resultSkladnik) {
				$tmpSkladnik = new virgoSkladnik();
				$tmpSkladnik->load($resultSkladnik['skl_id']);
				array_push($resSkladnik, $tmpSkladnik);
			}
			return $resSkladnik;
		}

		function getSkladniki($orderBy = '', $extraWhere = null) {
			return virgoKompletacja::getSkladnikiStatic($this->getId(), $orderBy, $extraWhere);
		}
		static function getTowaryStatic($parentId, $orderBy = '', $extraWhere = null) {
			$resTowar = array();
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoTowar'.DIRECTORY_SEPARATOR.'controller.php')) {
				return $resTowar;
			}
			if (is_null($parentId) || trim($parentId) == "") {
				return $resTowar;
			}
			$staticTowar = new virgoTowar();
			if (isset($extraWhere)) {
				$extraWhere = " AND ($extraWhere) ";
			} else {
				$extraWhere = "";
			}
			$resultsTowar = $staticTowar->selectAll('twr_kmp_id = ' . $parentId . $extraWhere, $orderBy);
			foreach ($resultsTowar as $resultTowar) {
				$tmpTowar = new virgoTowar();
				$tmpTowar->load($resultTowar['twr_id']);
				array_push($resTowar, $tmpTowar);
			}
			return $resTowar;
		}

		function getTowary($orderBy = '', $extraWhere = null) {
			return virgoKompletacja::getTowaryStatic($this->getId(), $orderBy, $extraWhere);
		}

		function validateObject($virgoOld) {
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  slk_history_kompletacje WHERE kmp_id = " . $this->getId();
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
				$query = "INSERT INTO slk_history_kompletacje (revision, ip, username, user_id, timestamp, kmp_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
			$query = "INSERT INTO slk_history_kompletacje (revision, ip, username, user_id, timestamp, kmp_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM slk_kompletacje");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'kmp_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE slk_kompletacje ADD COLUMN (kmp_virgo_title VARCHAR(255));";
			Q($query);
			$this->fillVirgoTitles();
		}
		
		var $_error = null;
		
		function getError() {
			return $this->_error;
		}
		
		function parentStore($updateNulls = false, $log = false) {
			if (isset($this->kmp_id) && $this->kmp_id != "") {
				$query = "UPDATE slk_kompletacje SET ";
				$query = $query . " kmp_virgo_title = '" . (get_magic_quotes_gpc() ? $this->getVirgoTitle() : QE($this->getVirgoTitle())) . "', ";
				$query = $query . " kmp_date_modified = '" . $this->kmp_date_modified . "', ";
				$query = $query . " kmp_usr_modified_id = " . $this->kmp_usr_modified_id . " ";
				$query = $query . " WHERE kmp_id = " . $this->kmp_id;
			} else {
				$query = "INSERT INTO slk_kompletacje ( ";
				$query = $query . " kmp_virgo_title, kmp_date_created, kmp_usr_created_id) VALUES ( ";
				$query = $query . " '" . (get_magic_quotes_gpc() ? $this->getVirgoTitle() : QE($this->getVirgoTitle())) . "', '" . $this->kmp_date_created . "', " . $this->kmp_usr_created_id . ") ";
			}
			$results = Q($query, $log);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->kmp_id) || $this->kmp_id == "") {
					$this->kmp_id = QID();
				}
				if ($log) {
					L("kompletacja stored successfully", "id = {$this->kmp_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = true) {
			$virgoOld = null;
			if ($this->kmp_id) {
				$virgoOld = new virgoKompletacja($this->kmp_id);
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
					if ($this->kmp_id) {			
						$this->kmp_date_modified = date("Y-m-d H:i:s");
						$this->kmp_usr_modified_id = $userId;
					} else {
						$this->kmp_date_created = date("Y-m-d H:i:s");
						$this->kmp_usr_created_id = $userId;
					}
					$this->kmp_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "kompletacja" with id = ' . $this->getId() . ": " . $error);
								return $error;
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "kompletacja" with id = ' . $this->getId() . ": " . $error);
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

		
		function portletActionVirgoDefault() {
			return 0;
		}

		function parentDelete() {
			$query = "DELETE FROM slk_kompletacje WHERE kmp_id = {$this->kmp_id}";
			$results = Q($query);
			if (!$results) {
				L('Invalid query', $query, 'ERROR');
			}
		}

		function delete() {
			$this->beforeDelete();
			$list = $this->getSkladniki();
			if (sizeof($list) > 0) {
				foreach ($list as $childRecord) {
					$childRecord->delete();
				}
			}
			$list = $this->getTowary();
			if (sizeof($list) > 0) {
				$name = $this->getVirgoTitle();
				if (!is_null($name) && trim($name) != "") {
					$name = "'" . $name . "' ";
				}
				return T('CANT_DELETE_PARENT', 'KOMPLETACJA', 'TOWAR', $name);
			}
			$this->removeFromContext();
			$this->parentDelete();
			$this->afterDelete();
			return "";
		}
		
		static public function selectAllAsIdsStatic($where = '', $idsNotArrayOfIds = false) {
			$tmp = new virgoKompletacja();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT kmp_id as id FROM slk_kompletacje";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'kmp_order_column')) {
				$orderBy = " ORDER BY kmp_order_column ASC ";
			} 
			if (property_exists($this, 'kmp_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY kmp_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return $this->internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoKompletacja();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoKompletacja($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE slk_kompletacje SET kmp_virgo_title = '$title' WHERE kmp_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoKompletacja();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" kmp_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['kmp_id'];
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
			virgoKompletacja::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoKompletacja::setSessionValue('Sealock_Kompletacja-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoKompletacja::getSessionValue('Sealock_Kompletacja-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoKompletacja::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoKompletacja::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoKompletacja::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoKompletacja::getSessionValue('GLOBAL', $name, $default);
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
		
				
		function putInContext($verifyToken = true, $pobId = null) {
			$context = virgoKompletacja::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['kmp_id'] = $this->kmp_id;
			virgoKompletacja::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			$this->setContextId($this->kmp_id, $verifyToken, $pobId);
			$query = "SELECT ppr_pob_id, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = 'parent_entity_pob_id' AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = " . (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']);
			$rows = QR($query);
			foreach ($rows as $row) {
				$className = $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$tmpChild = new $className();
	 				$tmpChild->removeFromContext($row['ppr_pob_id']);
	 				$tmpChild->setShowPage(1);
	 				$tmpChild->setDisplayMode("TABLE");
	 			}
			}
		}		
		
		function removeFromContext($pobId = null) {
			$context = virgoKompletacja::getGlobalSessionValue('VIRGO_CONTEXT_usuniete', array());
			$context['kmp_id'] = null;
			virgoKompletacja::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
			if (is_null($pobId)) {
				$this->setContextId(null);
			} else {
				virgoKompletacja::setRemoteContextId(null, $pobId);				
			}
			$query = "SELECT ppr_pob_id, pdf_alias FROM prt_portlet_parameters, prt_portlet_objects, prt_portlet_definitions WHERE ppr_name = 'parent_entity_pob_id' AND pob_id = ppr_pob_id AND pdf_id = pob_pdf_id AND ppr_value = " . (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']);
			$rows = QR($query);
			foreach ($rows as $row) {
				$className = $row['pdf_alias'];
	 			if (class_exists($className)) {
	 				$tmpChild = new $className();
	 				$tmpChild->removeFromContext($row['ppr_pob_id']);
	 				$tmpChild->setShowPage(1);
	 				$tmpChild->setDisplayMode("TABLE");
	 			}
			}
		}
		
		function portletActionRemoveFromContext() {
			$classToRemove = R('virgo_remove_class');			
			$classToRemove = new $classToRemove();
			$classToRemove->removeFromContext();
			return 0;
		}

		static function setRecordSet($criteria) {
			virgoKompletacja::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoKompletacja::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoKompletacja::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoKompletacja::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoKompletacja::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoKompletacja::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoKompletacja::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoKompletacja::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoKompletacja::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoKompletacja::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoKompletacja::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoKompletacja::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoKompletacja::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoKompletacja::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoKompletacja::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoKompletacja::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "kmp_id";
			}
			return virgoKompletacja::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoKompletacja::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoKompletacja::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoKompletacja::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoKompletacja::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoKompletacja::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoKompletacja::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoKompletacja::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoKompletacja::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoKompletacja::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoKompletacja::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoKompletacja::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoKompletacja::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->kmp_id) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
				$creating = true;
			}
			$portletObject = $this->getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
				$errorMessage = $this->store();
				if ($errorMessage == "") {
					if ($showOKMessage) {
						L(T('STORED_CORRECTLY', 'KOMPLETACJA'), '', 'INFO');
					}
					if ($closeForm) {
						$this->setDisplayMode("TABLE");
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
						$username = '';
						if ($this->kmp_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->kmp_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->kmp_date_created);
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
		
		function portletActionStore($showOKMessage = true) {
			$originalDisplayMode = $this->getDisplayMode();
			$this->loadFromRequest();
			$oldId = $this->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'sealock'.DIRECTORY_SEPARATOR.'virgoKompletacja'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
					$showOKMessage = false;
				}
			}
			$errorMessage = $this->internalActionStore(R('keep_form_open', "false") != "true", $showOKMessage);
			if ($errorMessage == "" && !isset($oldId)) {
				$this->putInContext(isset($oldId));
				$masterEntityPobId = P('master_entity_pob_id', '');
				if ($masterEntityPobId != "") {
					$this->putInContext(false, $masterEntityPobId);
				}
			}
			$currentItem = null; //$menu->getActive();
			$ret = null;
			$componentParams = null;
			if ($errorMessage == "") { 				$ret = 0;			
			} else {
				$ret = -1;
			}
			if (false) { //$componentParams->get('show_form_skladniki') == "1") {
				$tmpSkladnik = new virgoSkladnik();
				$deleteSkladnik = R('DELETE');
				if (sizeof($deleteSkladnik) > 0) {
					$tmpSkladnik->multipleDelete($deleteSkladnik);
				}
				$resIds = $tmpSkladnik->select(null, 'all', null, null, ' skl_kmp_id = ' . $this->getId(), ' SELECT skl_id FROM slk_skladniki ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->skl_id;
//					JRequest::setVar('skl_kompletacja_' . $resId->skl_id, $this->getId());
				} 
//				JRequest::setVar('skl_kompletacja_', $this->getId());
				$tmpSkladnik->setRecordSet($resIdsString);
				if (!$tmpSkladnik->portletActionStoreSelected()) {
					$ret = -1;
					$this->setDisplayMode($originalDisplayMode); 
				}
			}
			if (false) { //$componentParams->get('show_form_towary') == "1") {
				$tmpTowar = new virgoTowar();
				$deleteTowar = R('DELETE');
				if (sizeof($deleteTowar) > 0) {
					$tmpTowar->multipleDelete($deleteTowar);
				}
				$resIds = $tmpTowar->select(null, 'all', null, null, ' twr_kmp_id = ' . $this->getId(), ' SELECT twr_id FROM slk_towary ');
				$resIdsString = "";
				foreach ($resIds as $resId) {
					if ($resIdsString != "") {
						$resIdsString = $resIdsString . ",";
					}
					$resIdsString = $resIdsString . $resId->twr_id;
//					JRequest::setVar('twr_kompletacja_' . $resId->twr_id, $this->getId());
				} 
//				JRequest::setVar('twr_kompletacja_', $this->getId());
				$tmpTowar->setRecordSet($resIdsString);
				if (!$tmpTowar->portletActionStoreSelected()) {
					$ret = -1;
					$this->setDisplayMode($originalDisplayMode); 
				}
			}
			if ($ret == -1) {
				$pob = $this->getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			}
			return $ret;
		}
		
		function portletActionStoreAndClear() {
			$originalDisplayMode = $this->getDisplayMode();
			$ret = $this->portletActionStore(true);
			if ($ret == 0) {
				$this->removeFromContext();
				$this->setDisplayMode($originalDisplayMode);
			}
			return $ret;
		}
		
		
		function portletActionApply() {
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
				$this->setDisplayMode("FORM");
			}
			if ($errorMessage == "") {
				return 0;
			} else {
				$pob = $this->getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
				return -1;
			}
		}

		function portletActionSelect($verifyToken = true, $pobId = null) {
			$tmpId = intval(R('kmp_id_' . $_SESSION['current_portlet_object_id']));
			$this->load($tmpId);
			$oldContextId = $this->getContextId();
			if (isset($oldContextId) && $oldContextId == $tmpId) {
				$this->removeFromContext();
			} else {
				$this->putInContext($verifyToken, $pobId);
			}
			return 0;
		}
		

		function portletActionSelectAndSetParent() {
			$parentPobId = R('parent_pob_id');
			$parentPortletObject = new virgoPortletObject($parentPobId);
			$className = $parentPortletObject->getPortletDefinition()->getAlias();
			if (!class_exists($className)) {
				require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getNamespace().DIRECTORY_SEPARATOR.$portletObject->getPortletDefinition()->getAlias().DIRECTORY_SEPARATOR.'controller.php');
			}
			$class = new $className();
			$class->portletActionSelect(false, $parentPobId);
			return $this->portletActionSelect(false);
		}
		
		function portletActionSelectJson() {
			$this->portletActionSelect(false);
			return virgoKompletacja::getContextId();
		}
		
		function portletActionView() {
			$this->loadIdFromRequest();
			$this->putInContext();
			$this->setDisplayMode("VIEW");
			return 0;
		}
		
		function portletActionClearView() {
			$this->setCriteria(array());
			return $this->portletActionView();
		}
		

		function portletActionClose() {
			$this->setDisplayMode("TABLE");
			return 0;
		}
		
		function portletActionForm() {
			$this->loadFromDB();
			if ($this->kmp_id) {
				$permissionToCheck = "form";
			} else {
				$permissionToCheck = "add";
			}
			$portletObject = $this->getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("$permissionToCheck")) {
			$this->putInContext();
			$this->setDisplayMode("FORM");
			}
			return 0;
		}
		
		function portletActionDuplicate() {
			$this->loadIdFromRequest();
			$this->putInContext();
			$this->kmp_id = null;
			$this->kmp_date_created = null;
			$this->kmp_usr_created_id = null;
			$this->kmp_date_modified = null;
			$this->kmp_usr_modified_id = null;
			$this->kmp_virgo_title = null;
			
			$this->setDisplayMode("CREATE");
			return 0;
		}
		
		function portletActionShowHistory() {
			$this->loadIdFromRequest();
			$this->putInContext();
			$this->setDisplayMode("SHOW_HISTORY");
			return 0;
		}
		
		function portletActionShowRevision() {
			$this->setDisplayMode("SHOW_REVISION");
			return 0;
		}
		
		function portletActionCustomMode() {
			$customMode = R('componentName');
			if (!is_null($customMode) && trim($customMode) != "") {			
				$this->loadIdFromRequest();
				$this->putInContext();
				$this->setDisplayMode($customMode);
			}
			return 0;
		}



		function portletActionAdd() {
			$portletObject = $this->getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("add")) {
			$this->removeFromContext();
			$this->setDisplayMode("CREATE");
//			$ret = new virgoKompletacja();
//			return $ret;
			}
			return 0;
		}

		function portletActionSearchForm() {
			$this->setDisplayMode("SEARCH"); 
			$this->setShowPage(1);
			return 0;
		}

		function portletActionSearch() {
			$this->loadSearchFromRequest();
			if (P('filter_mode', '0') == '0') {
				$this->setDisplayMode("TABLE");
			}
			return 0;
		}
		
		function portletActionClear() {
			$this->setCriteria(array());
			// $this->setDisplayMode("TABLE");
			return 0;
		}

		function portletActionRemoveCriterium() { 
			$column = R('virgo_filter_column');
			$criteria = $this->getCriteria();
			unset($criteria[$column]);
			$this->setCriteria($criteria);
			$this->setDisplayMode("TABLE");
			return 0;
		}
		
		function portletActionDelete() {
			$portletObject = $this->getMyPortletObject();
			if (isset($portletObject) && $portletObject->canExecute("delete")) {
				$this->loadFromDB();
				$res = $this->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						$this->setDisplayMode("TABLE");
						virgoKompletacja::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'KOMPLETACJA'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		
		
		function portletActionEditSelected() {
			$idsToDeleteString = R('ids');
			$idsToDeleteString = $idsToDeleteString . ",0";
			$this->setRecordSet($idsToDeleteString);
			$this->setInvalidRecords(array());
			$this->setDisplayMode("TABLE_FORM");
			return 0;
		}		
		
		function getRecordsToEdit() {
			$idsToEditString = $this->getRecordSet();
			$idsToEdit = preg_split("/,/", $idsToEditString);
			$idsToCorrect = $this->getInvalidRecords();
			$results = array();
			foreach ($idsToEdit as $idToEdit) {
				$resultKompletacja = new virgoKompletacja();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultKompletacja->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultKompletacja->load($idToEditInt);
					} else {
						$resultKompletacja->kmp_id = 0;
					}
				}
				$results[] = $resultKompletacja;
			}
			return $results;
		}
		
		function portletActionStoreSelected() {
			$validateNew = R('virgo_validate_new'); 
			$idsToStoreString = $this->getRecordSet();
			$idsToStore = preg_split("/,/", $idsToStoreString);
			$results = array();
			$errors = 0;
			$idsToCorrect = array();
			foreach ($idsToStore as $idToStore) {
				$result = new virgoKompletacja();
				$result->loadFromRequest($idToStore);
				if ($result->kmp_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->kmp_id == 0) {
						$result->kmp_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->kmp_id)) {
							$result->kmp_id = 0;
						}
						$idsToCorrect[$result->kmp_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'KOMPLETACJE'), '', 'INFO');
				}
				$this->setDisplayMode("TABLE");
				return 0;
			} else {
				L(T('INVALID_RECORDS', $errors), '', 'ERROR');
				$this->setInvalidRecords($idsToCorrect);
				return -1;
			}
		}

		function multipleDelete($idsToDelete) {
			$errorOcurred = 0;
			$resultKompletacja = new virgoKompletacja();
			foreach ($idsToDelete as $idToDelete) {
				$resultKompletacja->load((int)trim($idToDelete));
				$res = $resultKompletacja->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'KOMPLETACJE'), '', 'INFO');			
				$this->setDisplayMode("TABLE");
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
		
		function portletActionDeleteSelected() {
			$idsToDelete = $this->getSelectedIds();
			return $this->multipleDelete($idsToDelete);
		}

		function portletActionChangeOrder() {
			$column = R('virgo_order_column');
			$mode = R('virgo_order_mode');
			$this->setOrderColumn($column);
			$this->setOrderMode($mode);
			return 0;
		}
		
		function portletActionChangePaging() {
			$showPage = R('virgo_show_page');
			if(preg_match('/^\d+$/',$showPage)) {
				if ((int)$showPage > 0) {
					$this->setShowPage($showPage);
				}
			}			
			$showRows = R('virgo_show_rows');
			$this->setShowRows($showRows);
			return 0;
		}
				
		function getVirgoTitleNull() {
		$ret = $this->kmp_id;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoKompletacja');
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
				$query = "UPDATE slk_kompletacje SET kmp_virgo_title = '" . QE($val) . "' WHERE kmp_id = " . $this->getId();
				Q($query);
			}
		}
		
		function portletActionUpdateTitle() {
			$query = "SELECT kmp_id AS id FROM slk_kompletacje ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoKompletacja($row['id']);
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

		function getParentsInContext() {
			$ret = array();
			$parentPobIds = PN('parent_entity_pob_id');
			$class2prefix = array();
			$whenNoParentSelected = P("when_no_parent_selected", "E");			
			foreach ($parentPobIds as $parentPobId) {
				$grandparentAdded = false;				
				$parentInfo = $this->getEntityInfoByPobId($parentPobId, $class2prefix);
				if (isset($parentInfo['value'])) {
					$parentInfo['condition'] = 'slk_kompletacje.kmp_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
				} else {
					if ($whenNoParentSelected == "C") {
						$parentInfo['condition'] = 'slk_kompletacje.kmp_' . $parentInfo['prefix'] . '_id IS NULL';
					} elseif ($whenNoParentSelected == "A") {
						$parentInfo['condition'] = ' 1 ';
					} elseif ($whenNoParentSelected == "G") {
						$grandparentPobIds = PN('grandparent_entity_pob_id');
						foreach ($grandparentPobIds as $grandparentPobId) {
							$class2parent2 = $class2parentPrefix[$parentInfo['className']];
							$grandparentInfo = $this->getEntityInfoByPobId($grandparentPobId, $class2parent2);
							if (isset($class2prefix2[$grandparentInfo['className']])) {
								if (isset($grandparentInfo['value'])) {
									$parentClassName = $parentInfo['className'];
									$tmp = new $parentClassName();
									$grandparentInfo['condition'] = 'slk_kompletacje.kmp_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM slk_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
								} else {
									$grandparentInfo['condition'] = ' 1 ';
								}
								$grandparentAdded = true;
								$ret[] = $grandparentInfo;
								break;
							}
						}
						if (!$grandparentAdded) {
							$parentInfo['condition'] = 'slk_kompletacje.kmp_' . $parentInfo['prefix'] . '_id IS NULL';
						}
					} else {
						if ($whenNoParentSelected != "H") {
							L(T('PLEASE_SELECT_PARENT'), '', 'INFO');
						}
						$parentInfo['condition'] = ' 0 ';
					}
				}
				if (!$grandparentAdded) {
					$ret[] = $parentInfo;
				}
			}
			return $ret;
		}
		
		function getEntityInfoByPobId($parentPobId, $class2prefix) {
			$ret = array();
			$portletObject = new virgoPortletObject($parentPobId);
			$ret['name'] = $portletObject->getPortletDefinition()->getName();
			$className = $portletObject->getPortletDefinition()->getAlias();
			if (!isset($class2prefix[$className])) {
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoKompletacja!', '', 'ERROR');
				return array();
			}
			$ret['prefix'] = $class2prefix[$className];
			$ret['className'] = $className;
			$masterObject = new $className();
			$tmpContextId = $masterObject->getRemoteContextId($parentPobId);
			$ret['contextId'] = $tmpContextId;
			if (isset($tmpContextId) && $tmpContextId != "") {
				$ret['value'] =  "" . $masterObject->lookup($tmpContextId);
			}
			return $ret;
		}

		function portletActionReport() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
			ini_set('display_errors', '0');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$user = virgoUser::getUser();
			$pdf->SetCreator(null);
			$pdf->SetTitle('Kompletacje report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = $this->getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('KOMPLETACJE');
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
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultKompletacja = new virgoKompletacja();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			$pdf->SetFont($font, '', $fontSize);
			$pdf->AliasNbPages();
			$orientation = P('pdf_page_orientation', 'P');
			$pdf->AddPage($orientation);
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 4);
			$pdf->MultiCell(0, 1, $reportTitle, '', 'C', 0, 0);
			$pdf->Ln();
			$whereClauseKompletacja = " 1 = 1 ";				
		$parentContextInfos = $this->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseKompletacja = $whereClauseKompletacja . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaKompletacja = $resultKompletacja->getCriteria();
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$filter = "";
			$criteriaKompletacja = $this->getCriteria();
			$whereClauseKompletacja = $whereClauseKompletacja . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseKompletacja = $whereClauseKompletacja . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT slk_kompletacje.kmp_id, slk_kompletacje.kmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_kompletacje ";

		$resultsKompletacja = $resultKompletacja->select(
			'', 
			'all', 
			$resultKompletacja->getOrderColumn(), 
			$resultKompletacja->getOrderMode(), 
			$whereClauseKompletacja,
			$queryString);
		
		foreach ($resultsKompletacja as $resultKompletacja) {
		}
		$maxLn = 1;
//		$criteriaKompletacja = $resultKompletacja->getCriteria();
		if (is_null($criteriaKompletacja) || sizeof($criteriaKompletacja) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
									
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
		foreach ($resultsKompletacja as $resultKompletacja) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
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
		
		function portletActionExport() {
			$data = "";
			$pob = $this->getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('KOMPLETACJE');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultKompletacja = new virgoKompletacja();
			$whereClauseKompletacja = " 1 = 1 ";
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseKompletacja = $whereClauseKompletacja . ' AND ' . $parentContextInfo['condition'];
			}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_kompletacje.kmp_id, slk_kompletacje.kmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_kompletacje ";

			$resultsKompletacja = $resultKompletacja->select(
				'', 
				'all', 
				$resultKompletacja->getOrderColumn(), 
				$resultKompletacja->getOrderMode(), 
				$whereClauseKompletacja,
				$queryString);
			foreach ($resultsKompletacja as $resultKompletacja) {
				$data = $data . "\n"; 
			}
			D($data, $reportTitle, "text/csv"); 
		}
				
		function portletActionOffline() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel.php');		
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel'.DIRECTORY_SEPARATOR.'Writer'.DIRECTORY_SEPARATOR.'Excel2007.php');		
			$pob = $this->getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('KOMPLETACJE');
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("virgo by METADETRON");
			$objPHPExcel->getProperties()->setLastModifiedBy("");
			$objPHPExcel->getProperties()->setTitle($reportTitle);
			$objPHPExcel->getProperties()->setSubject("");
			$objPHPExcel->getProperties()->setDescription("virgo generated Excel Sheet for offline data edition");
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->getProtection()->setPassword('virgo');
			$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
			$objPHPExcel->getActiveSheet()->setTitle($reportTitle);
			$resultKompletacja = new virgoKompletacja();
			$whereClauseKompletacja = " 1 = 1 ";
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseKompletacja = $whereClauseKompletacja . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT slk_kompletacje.kmp_id, slk_kompletacje.kmp_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM slk_kompletacje ";

			$resultsKompletacja = $resultKompletacja->select(
				'', 
				'all', 
				$resultKompletacja->getOrderColumn(), 
				$resultKompletacja->getOrderMode(), 
				$whereClauseKompletacja,
				$queryString);
			$index = 1;
			foreach ($resultsKompletacja as $resultKompletacja) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultKompletacja['kmp_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
			}
		    for($i = 1; $i <= $iloscKolumn; $i++) {
		        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		    }
		    $objPHPExcel->getActiveSheet()->calculateColumnWidths();
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			
			header('Content-Type: application/vnd.ms-excel');
			if (headers_sent()) {
				$this->Error('Some data has already been output to browser');
			}
			header('Content-Disposition: attachment; filename="' . $reportTitle . '.xlsx";');
//			header('Content-Length: '.strlen($data));		
			$objWriter->save("php://output");			
			exit();
		}		
		
		function portletActionUpload() {
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
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importKompletacja = new virgoKompletacja();
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
										L(T('PROPERTY_NOT_FOUND', T('KOMPLETACJA'), $columns[$index]), '', 'ERROR');
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
										$importKompletacja->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
							$errorMessage = $importKompletacja->store();
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
		







		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE `slk_kompletacje` (
  `kmp_id` bigint(20) unsigned NOT NULL auto_increment,
  `kmp_virgo_state` varchar(50) default NULL,
  `kmp_virgo_title` varchar(255) default NULL,
  `kmp_date_created` datetime NOT NULL,
  `kmp_date_modified` datetime default NULL,
  `kmp_usr_created_id` int(11) NOT NULL,
  `kmp_usr_modified_id` int(11) default NULL,
  PRIMARY KEY  (`kmp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

SELECT;
			if (!Q($query)) {
				L("Probably slk_kompletacje table already exists.", '', 'FATAL');
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

		function getMyPortletObject() {
			if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) {
				require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
				$pobId = $_SESSION['current_portlet_object_id'];
				return new virgoPortletObject($pobId);
			}
			return null;
		}
		
		static function getPrefix() {
			return "kmp";
		}
		
		static function getPlural() {
			return "kompletacje";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			return $ret;
		}

		static function getChildren() {
			$ret[] = "virgoSkladnik";
			$ret[] = "virgoTowar";
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = '" . $virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'] . "' AND table_name = 'slk_kompletacje' ";
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row['table_type'];
			}
			return "";
		}
		
		static function getStructureVersion() {
			return "1.1" . 
''
			;
		}
		
		static function getVirgoVersion() {
			return
"2.0.0.0"  
			;
		}
		
		static function checkCompatibility() {
			$virgoVersion = virgoKompletacja::getVirgoVersion();
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

		/****************** database selects ******************/
		
	}
	
	
