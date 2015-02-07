<?php
/**
* Module Html content
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
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLanguage'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoHtmlContent {

		 var  $hcn_id = null;
		 var  $hcn_content = null;

		 var  $hcn_pob_id = null;
		 var  $hcn_lng_id = null;

		 var   $hcn_date_created = null;
		 var   $hcn_usr_created_id = null;
		 var   $hcn_date_modified = null;
		 var   $hcn_usr_modified_id = null;
		 var   $hcn_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoHtmlContent();
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
        	$this->hcn_id = null;
		    $this->hcn_date_created = null;
		    $this->hcn_usr_created_id = null;
		    $this->hcn_date_modified = null;
		    $this->hcn_usr_modified_id = null;
		    $this->hcn_virgo_title = null;
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
			return $this->hcn_id;
		}

		function getContent() {
			return $this->hcn_content;
		}
		
		 function setContent($val) {
			$this->hcn_content = $val;
		}

		function getPortletObjectId() {
			return $this->hcn_pob_id;
		}
		
		 function setPortletObjectId($val) {
			$this->hcn_pob_id = $val;
		}
		function getLanguageId() {
			return $this->hcn_lng_id;
		}
		
		 function setLanguageId($val) {
			$this->hcn_lng_id = $val;
		}

		function getDateCreated() {
			return $this->hcn_date_created;
		}
		function getUsrCreatedId() {
			return $this->hcn_usr_created_id;
		}
		function getDateModified() {
			return $this->hcn_date_modified;
		}
		function getUsrModifiedId() {
			return $this->hcn_usr_modified_id;
		}


		function getPobId() {
			return $this->getPortletObjectId();
		}
		
		 function setPobId($val) {
			$this->setPortletObjectId($val);
		}
		function getLngId() {
			return $this->getLanguageId();
		}
		
		 function setLngId($val) {
			$this->setLanguageId($val);
		}

		static function getContentPdfUrlStatic($tmpId) {
			$ret = "";
			$ret .= $_SESSION['portal_url'];
			$ret .= "?virgo_media=true";
			$ret .= "&virgo_media_type=html2pdf";
			$ret .= "&virgo_media_table_name=prt_html_contents";
			$ret .= "&virgo_media_table_prefix=hcn";
			$ret .= "&virgo_media_property_name=content";
			$ret .= "&virgo_media_row_id=" . $tmpId;
			$ret .= "&" . getTokenName($tmpId) . "=" . getTokenValue($tmpId);
			return $ret;
		}
		function getContentPdfUrl() {
			if (!is_null($this->getId())) {
				if (!is_null($this->hcn_content)) {
					return virgoHtmlContent::getContentPdfUrlStatic($this->hcn_id);
				}
			}
			return "";
		}
		function loadRecordFromRequest($rowId) {
			$this->hcn_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('hcn_content_' . $this->hcn_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		if ($tmpValue == "") {
			$this->hcn_content = null;
		} else {
			$this->hcn_content = $tmpValue;
		}
	}
			$this->hcn_pob_id = strval(R('hcn_portletObject_' . $this->hcn_id));
			$this->hcn_lng_id = strval(R('hcn_language_' . $this->hcn_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('hcn_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaHtmlContent = array();	
			$criteriaFieldHtmlContent = array();	
			$isNullHtmlContent = R('virgo_search_content_is_null');
			
			$criteriaFieldHtmlContent["is_null"] = 0;
			if ($isNullHtmlContent == "not_null") {
				$criteriaFieldHtmlContent["is_null"] = 1;
			} elseif ($isNullHtmlContent == "null") {
				$criteriaFieldHtmlContent["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
//			if ($isSet) {
			$criteriaFieldHtmlContent["value"] = $dataTypeCriteria;
//			}
			$criteriaHtmlContent["content"] = $criteriaFieldHtmlContent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portletObject_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portletObject', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaHtmlContent["portlet_object"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_language_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_language', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["ids"] = $parent;
			}
			$criteriaHtmlContent["language"] = $criteriaParent;
			self::setCriteria($criteriaHtmlContent);
		}

		static function portletActionSetCustomParent() {
			$customParentId = R('virgo_parent_id');
			self::setLocalSessionValue('CustomParentId', $customParentId);
			return 0;
		}

		static function portletActionSetVirgoTableFilter() {
			$tableFilter = R('virgo_filter_content');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterContent', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterContent', null);
			}
			$parentFilter = R('virgo_filter_portlet_object');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortletObject', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortletObject', null);
			}
			$parentFilter = R('virgo_filter_title_portlet_object');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortletObject', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortletObject', null);
			}
			$parentFilter = R('virgo_filter_language');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterLanguage', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterLanguage', null);
			}
			$parentFilter = R('virgo_filter_title_language');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleLanguage', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleLanguage', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClauseHtmlContent = ' 1 = 1 ';
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
				$eventColumn = "hcn_" . P('event_column');
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseHtmlContent = $whereClauseHtmlContent . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_html_contents.hcn_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_html_contents.hcn_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_language');
			if (isset($limit) && trim($limit) != '') {
				if (strrpos($limit, "empty") !== false) {
					if (strrpos($limit, "empty,") === false) {
						$toRemove = "empty";
					} else {
						$toRemove = "empty,";
					}
					$limit = str_replace($toRemove, "", $limit);
					$includeNulls = true;
					$includeIns = (isset($limit) && trim($limit) != '');
				}
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_html_contents.hcn_lng_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_html_contents.hcn_lng_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaHtmlContent = self::getCriteria();
			if (isset($criteriaHtmlContent["content"])) {
				$fieldCriteriaContent = $criteriaHtmlContent["content"];
				if ($fieldCriteriaContent["is_null"] == 1) {
$filter = $filter . ' AND prt_html_contents.hcn_content IS NOT NULL ';
				} elseif ($fieldCriteriaContent["is_null"] == 2) {
$filter = $filter . ' AND prt_html_contents.hcn_content IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaContent["value"];
				}
			}
			if (isset($criteriaHtmlContent["portlet_object"])) {
				$parentCriteria = $criteriaHtmlContent["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND hcn_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_html_contents.hcn_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaHtmlContent["language"])) {
				$parentCriteria = $criteriaHtmlContent["language"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND hcn_lng_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_html_contents.hcn_lng_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseHtmlContent = $whereClauseHtmlContent . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClauseHtmlContent = $whereClauseHtmlContent . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterContent', null);
				if (S($tableFilter)) {
					$whereClauseHtmlContent = $whereClauseHtmlContent . " AND hcn_content LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletObject', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseHtmlContent = $whereClauseHtmlContent . " AND hcn_pob_id IS NULL ";
					} else {
						$whereClauseHtmlContent = $whereClauseHtmlContent . " AND hcn_pob_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
				if (S($parentFilter)) {
					$whereClauseHtmlContent = $whereClauseHtmlContent . " AND prt_portlet_objects_parent.pob_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterLanguage', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClauseHtmlContent = $whereClauseHtmlContent . " AND hcn_lng_id IS NULL ";
					} else {
						$whereClauseHtmlContent = $whereClauseHtmlContent . " AND hcn_lng_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleLanguage', null);
				if (S($parentFilter)) {
					$whereClauseHtmlContent = $whereClauseHtmlContent . " AND prt_languages_parent.lng_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClauseHtmlContent;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClauseHtmlContent = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_html_contents.hcn_id, prt_html_contents.hcn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column', 'hcn_order');
			$orderColumnNotDisplayed = "";
			if (P('show_table_content', "1") != "0") {
				$queryString = $queryString . ", prt_html_contents.hcn_content hcn_content";
			} else {
				if ($defaultOrderColumn == "hcn_content") {
					$orderColumnNotDisplayed = " prt_html_contents.hcn_content ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_pob_id as hcn_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLanguage') && P('show_table_language', "1") != "0") { // */ && !in_array("lng", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_lng_id as hcn_lng_id ";
				$queryString = $queryString . ", prt_languages_parent.lng_virgo_title as `language` ";
			} else {
				if ($defaultOrderColumn == "language") {
					$orderColumnNotDisplayed = " prt_languages_parent.lng_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_html_contents ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_html_contents.hcn_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoLanguage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_languages AS prt_languages_parent ON (prt_html_contents.hcn_lng_id = prt_languages_parent.lng_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClauseHtmlContent = $whereClauseHtmlContent . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClauseHtmlContent, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClauseHtmlContent,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_html_contents"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " hcn_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " hcn_usr_created_id = ? ";
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
				. "\n FROM prt_html_contents"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_html_contents ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_html_contents ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, hcn_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " hcn_usr_created_id = ? ";
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
				$query = "SELECT COUNT(hcn_id) cnt FROM html_contents";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as html_contents ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as html_contents ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoHtmlContent();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_html_contents WHERE hcn_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->hcn_id = $row['hcn_id'];
$this->hcn_content = $row['hcn_content'];
						$this->hcn_pob_id = $row['hcn_pob_id'];
						$this->hcn_lng_id = $row['hcn_lng_id'];
						if ($fetchUsernames) {
							if ($row['hcn_date_created']) {
								if ($row['hcn_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['hcn_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['hcn_date_modified']) {
								if ($row['hcn_usr_modified_id'] == $row['hcn_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['hcn_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['hcn_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->hcn_date_created = $row['hcn_date_created'];
						$this->hcn_usr_created_id = $fetchUsernames ? $createdBy : $row['hcn_usr_created_id'];
						$this->hcn_date_modified = $row['hcn_date_modified'];
						$this->hcn_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['hcn_usr_modified_id'];
						$this->hcn_virgo_title = $row['hcn_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_html_contents SET hcn_usr_created_id = {$userId} WHERE hcn_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->hcn_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoHtmlContent::selectAllAsObjectsStatic('hcn_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->hcn_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->hcn_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('hcn_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_hcn = new virgoHtmlContent();
				$tmp_hcn->load((int)$lookup_id);
				return $tmp_hcn->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoHtmlContent');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" hcn_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoHtmlContent', "10");
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
				$query = $query . " hcn_id as id, hcn_virgo_title as title ";
			}
			$query = $query . " FROM prt_html_contents ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoHtmlContent', 'portal') == "1") {
				$privateCondition = " hcn_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY hcn_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resHtmlContent = array();
				foreach ($rows as $row) {
					$resHtmlContent[$row['id']] = $row['title'];
				}
				return $resHtmlContent;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticHtmlContent = new virgoHtmlContent();
			return $staticHtmlContent->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPortletObjectStatic($parentId) {
			return virgoPortletObject::getById($parentId);
		}
		
		function getPortletObject() {
			return virgoHtmlContent::getPortletObjectStatic($this->hcn_pob_id);
		}
		static function getLanguageStatic($parentId) {
			return virgoLanguage::getById($parentId);
		}
		
		function getLanguage() {
			return virgoHtmlContent::getLanguageStatic($this->hcn_lng_id);
		}


		function validateObject($virgoOld) {
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_content_obligatory', "0") == "1") {
				if (
(is_null($this->getContent()) || trim($this->getContent()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'CONTENT');
				}			
			}
				if (is_null($this->hcn_pob_id) || trim($this->hcn_pob_id) == "") {
					if (R('create_hcn_portletObject_' . $this->hcn_id) == "1") { 
						$parent = new virgoPortletObject();
						$parent->loadFromRequest();
						$res = $parent->store();
						if ($res != "") {
							return $res;
						} else {
							$this->hcn_pob_id = $parent->getId();
						}
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_OBJECT', '');
					}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_language_obligatory', "0") == "1") {
				if (is_null($this->hcn_lng_id) || trim($this->hcn_lng_id) == "") {
					if (R('create_hcn_language_' . $this->hcn_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'LANGUAGE', '');
					}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_html_contents WHERE hcn_id = " . $this->getId();
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
				$colNames = $colNames . ", hcn_content";
				$values = $values . ", " . (is_null($objectToStore->getContent()) ? "null" : "'" . QE($objectToStore->getContent()) . "'");
				$colNames = $colNames . ", hcn_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) || $objectToStore->getPobId() == "" ? "null" : $objectToStore->getPobId());
				$colNames = $colNames . ", hcn_lng_id";
				$values = $values . ", " . (is_null($objectToStore->getLngId()) || $objectToStore->getLngId() == "" ? "null" : $objectToStore->getLngId());
				$query = "INSERT INTO prt_history_html_contents (revision, ip, username, user_id, timestamp, hcn_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
				Q($query);
				$new_revision = 2;
			}
			$colNames = "";
			$values = "";
			$objectToStore = $this;
			$nullifiedProperties = "";
			if (is_null($virgoOld) || $virgoOld->getContent() != $objectToStore->getContent()) {
				if (is_null($objectToStore->getContent())) {
					$nullifiedProperties = $nullifiedProperties . "content,";
				} else {
				$colNames = $colNames . ", hcn_content";
				$values = $values . ", " . (is_null($objectToStore->getContent()) ? "null" : "'" . QE($objectToStore->getContent()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPobId() != $objectToStore->getPobId() && ($virgoOld->getPobId() != 0 || $objectToStore->getPobId() != ""))) { 
				$colNames = $colNames . ", hcn_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) ? "null" : ($objectToStore->getPobId() == "" ? "0" : $objectToStore->getPobId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getLngId() != $objectToStore->getLngId() && ($virgoOld->getLngId() != 0 || $objectToStore->getLngId() != ""))) { 
				$colNames = $colNames . ", hcn_lng_id";
				$values = $values . ", " . (is_null($objectToStore->getLngId()) ? "null" : ($objectToStore->getLngId() == "" ? "0" : $objectToStore->getLngId()));
			}
			$query = "INSERT INTO prt_history_html_contents (revision, ip, username, user_id, timestamp, hcn_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_html_contents");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'hcn_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_html_contents ADD COLUMN (hcn_virgo_title VARCHAR(255));";
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
			if (isset($this->hcn_id) && $this->hcn_id != "") {
				$query = "UPDATE prt_html_contents SET ";
			if (isset($this->hcn_content)) {
				$query .= " hcn_content = ? ,";
				$types .= "s";
				$values[] = $this->hcn_content;
			} else {
				$query .= " hcn_content = NULL ,";				
			}
				if (isset($this->hcn_pob_id) && trim($this->hcn_pob_id) != "") {
					$query = $query . " hcn_pob_id = ? , ";
					$types = $types . "i";
					$values[] = $this->hcn_pob_id;
				} else {
					$query = $query . " hcn_pob_id = NULL, ";
				}
				if (isset($this->hcn_lng_id) && trim($this->hcn_lng_id) != "") {
					$query = $query . " hcn_lng_id = ? , ";
					$types = $types . "i";
					$values[] = $this->hcn_lng_id;
				} else {
					$query = $query . " hcn_lng_id = NULL, ";
				}
				$query = $query . " hcn_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " hcn_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->hcn_date_modified;

				$query = $query . " hcn_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->hcn_usr_modified_id;

				$query = $query . " WHERE hcn_id = ? ";
				$types = $types . "i";
				$values[] = $this->hcn_id;
			} else {
				$query = "INSERT INTO prt_html_contents ( ";
			$query = $query . " hcn_content, ";
				$query = $query . " hcn_pob_id, ";
				$query = $query . " hcn_lng_id, ";
				$query = $query . " hcn_virgo_title, hcn_date_created, hcn_usr_created_id) VALUES ( ";
			if (isset($this->hcn_content)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->hcn_content;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->hcn_pob_id) && trim($this->hcn_pob_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->hcn_pob_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->hcn_lng_id) && trim($this->hcn_lng_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->hcn_lng_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->hcn_date_created;
				$values[] = $this->hcn_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->hcn_id) || $this->hcn_id == "") {
					$this->hcn_id = QID();
				}
				if ($log) {
					L("html content stored successfully", "id = {$this->hcn_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->hcn_id) {
				$virgoOld = new virgoHtmlContent($this->hcn_id);
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
					if ($this->hcn_id) {			
						$this->hcn_date_modified = date("Y-m-d H:i:s");
						$this->hcn_usr_modified_id = $userId;
					} else {
						$this->hcn_date_created = date("Y-m-d H:i:s");
						$this->hcn_usr_created_id = $userId;
					}
					$this->hcn_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "html content" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "html content" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_html_contents WHERE hcn_id = {$this->hcn_id}";
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
			$tmp = new virgoHtmlContent();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT hcn_id as id FROM prt_html_contents";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'hcn_order_column')) {
				$orderBy = " ORDER BY hcn_order_column ASC ";
			} 
			if (property_exists($this, 'hcn_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY hcn_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoHtmlContent();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoHtmlContent($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_html_contents SET hcn_virgo_title = '$title' WHERE hcn_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoHtmlContent();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" hcn_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['hcn_id'];
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
			virgoHtmlContent::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoHtmlContent::setSessionValue('Portal_HtmlContent-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoHtmlContent::getSessionValue('Portal_HtmlContent-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoHtmlContent::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoHtmlContent::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoHtmlContent::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoHtmlContent::getSessionValue('GLOBAL', $name, $default);
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
			$context['hcn_id'] = $id;
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
			$context['hcn_id'] = null;
			virgoHtmlContent::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoHtmlContent::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoHtmlContent::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoHtmlContent::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoHtmlContent::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoHtmlContent::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoHtmlContent::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoHtmlContent::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoHtmlContent::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoHtmlContent::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoHtmlContent::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoHtmlContent::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoHtmlContent::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoHtmlContent::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoHtmlContent::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoHtmlContent::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoHtmlContent::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "hcn_id";
			}
			return virgoHtmlContent::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoHtmlContent::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoHtmlContent::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoHtmlContent::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoHtmlContent::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoHtmlContent::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoHtmlContent::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoHtmlContent::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoHtmlContent::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoHtmlContent::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoHtmlContent::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoHtmlContent::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoHtmlContent::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->hcn_id) {
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
						L(T('STORED_CORRECTLY', 'HTML_CONTENT'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'content', $this->hcn_content);
						$parentPortletObject = new virgoPortletObject();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet object', $parentPortletObject->lookup($this->hcn_pob_id));
						$parentLanguage = new virgoLanguage();
						$fieldValues = $fieldValues . T($fieldValue, 'language', $parentLanguage->lookup($this->hcn_lng_id));
						$username = '';
						if ($this->hcn_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->hcn_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->hcn_date_created);
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
			$instance = new virgoHtmlContent();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoHtmlContent'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('hcn_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoHtmlContent::getContextId();
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
			$this->hcn_id = null;
			$this->hcn_date_created = null;
			$this->hcn_usr_created_id = null;
			$this->hcn_date_modified = null;
			$this->hcn_usr_modified_id = null;
			$this->hcn_virgo_title = null;
			
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

		static function portletActionShowForPortletObject() {
			$parentId = R('pob_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortletObject($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForLanguage() {
			$parentId = R('lng_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoLanguage($parentId);
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
//			$ret = new virgoHtmlContent();
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
				$instance = new virgoHtmlContent();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoHtmlContent::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'HTML_CONTENT'), '', 'INFO');
					return 0;
					
				} else {
					L($res, '', 'ERROR');
					return -1;
				}
			}
		}
		
		
		static function portletActionVirgoContentAsPdf() {
			$this->loadFromDB();
			$this->generateContentAsPdf();
		}
		function generateContentAsPdf() {
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'eng.php');
			require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'tcpdf'.DIRECTORY_SEPARATOR.'tcpdf.php');
			ini_set('display_errors', '0');
			$pdf = new FOOTEREDPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(null);
			$pdf->SetTitle('');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);
			$font = 'freeserif';
			$fontBoldVariant = 'B';
			$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
			$pdf->SetFont($font, '', 10);
			$pdf->SetFont('freeserif', '', 13);
			$pdf->AddPage();
			$pdf->writeHTML($this->getContent(), true, false, true, false, '');
			$pdf->Output('HtmlContent_Content_' . $this->getId() . '.pdf', 'I'); 			ini_set('display_errors', '1');
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
				$resultHtmlContent = new virgoHtmlContent();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultHtmlContent->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultHtmlContent->load($idToEditInt);
					} else {
						$resultHtmlContent->hcn_id = 0;
					}
				}
				$results[] = $resultHtmlContent;
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
				$result = new virgoHtmlContent();
				$result->loadFromRequest($idToStore);
				if ($result->hcn_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->hcn_id == 0) {
						$result->hcn_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->hcn_id)) {
							$result->hcn_id = 0;
						}
						$idsToCorrect[$result->hcn_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'HTML_CONTENTS'), '', 'INFO');
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
			$resultHtmlContent = new virgoHtmlContent();
			foreach ($idsToDelete as $idToDelete) {
				$resultHtmlContent->load((int)trim($idToDelete));
				$res = $resultHtmlContent->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'HTML_CONTENTS'), '', 'INFO');			
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
		$ret = $this->hcn_content;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoHtmlContent');
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
				$query = "UPDATE prt_html_contents SET hcn_virgo_title = ? WHERE hcn_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT hcn_id AS id FROM prt_html_contents ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoHtmlContent($row['id']);
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
				$class2prefix["portal\\virgoPortletObject"] = "pob";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoPortletDefinition"] = "pdf";
				$class2prefix2["portal\\virgoPortletObject"] = "pob";
				$class2parentPrefix["portal\\virgoPortletObject"] = $class2prefix2;
				$class2prefix["portal\\virgoLanguage"] = "lng";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoLanguage"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_html_contents.hcn_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_html_contents.hcn_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_html_contents.hcn_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_html_contents.hcn_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoHtmlContent!', '', 'ERROR');
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
			$pdf->SetTitle('Html contents report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('HTML_CONTENTS');
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
			if (P('show_pdf_content', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_language', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultHtmlContent = new virgoHtmlContent();
			$pdf->SetFont($font, $fontBoldVariant, $fontSize);
			if (P('show_pdf_content', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Content');
				$minWidth['content'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['content']) {
						$minWidth['content'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$minWidth['portlet object $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portlet object $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portlet object $relation.name']) {
						$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_language', "1") == "1") {
				$minWidth['language $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'language $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['language $relation.name']) {
						$minWidth['language $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClauseHtmlContent = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClauseHtmlContent = $whereClauseHtmlContent . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaHtmlContent = $resultHtmlContent->getCriteria();
			$fieldCriteriaContent = $criteriaHtmlContent["content"];
			if ($fieldCriteriaContent["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Content', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaContent["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Content', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaHtmlContent["portlet_object"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portlet object', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortletObject::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portlet object', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaHtmlContent["language"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Language', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoLanguage::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Language', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$pdf->Ln();
			$hideColumnFromContextInTable = array();
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
			if (isset($limit) && trim($limit) != '') {
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_html_contents.hcn_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_html_contents.hcn_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_language');
			if (isset($limit) && trim($limit) != '') {
				if (strrpos($limit, "empty") !== false) {
					if (strrpos($limit, "empty,") === false) {
						$toRemove = "empty";
					} else {
						$toRemove = "empty,";
					}
					$limit = str_replace($toRemove, "", $limit);
					$includeNulls = true;
					$includeIns = (isset($limit) && trim($limit) != '');
				}
				if ($includeIns) {
					eval("\$limit = \"$limit\";");
					$inCondition = " prt_html_contents.hcn_lng_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_html_contents.hcn_lng_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaHtmlContent = self::getCriteria();
			if (isset($criteriaHtmlContent["content"])) {
				$fieldCriteriaContent = $criteriaHtmlContent["content"];
				if ($fieldCriteriaContent["is_null"] == 1) {
$filter = $filter . ' AND prt_html_contents.hcn_content IS NOT NULL ';
				} elseif ($fieldCriteriaContent["is_null"] == 2) {
$filter = $filter . ' AND prt_html_contents.hcn_content IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaContent["value"];
				}
			}
			if (isset($criteriaHtmlContent["portlet_object"])) {
				$parentCriteria = $criteriaHtmlContent["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND hcn_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_html_contents.hcn_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaHtmlContent["language"])) {
				$parentCriteria = $criteriaHtmlContent["language"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND hcn_lng_id IS NULL ";
				} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$filter = $filter . " AND prt_html_contents.hcn_lng_id IN (" . implode(", ", $parentIds) . ") ";
					}
				}
			}
			$whereClauseHtmlContent = $whereClauseHtmlContent . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClauseHtmlContent = $whereClauseHtmlContent . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_html_contents.hcn_id, prt_html_contents.hcn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_content', "1") != "0") {
				$queryString = $queryString . ", prt_html_contents.hcn_content hcn_content";
			} else {
				if ($defaultOrderColumn == "hcn_content") {
					$orderColumnNotDisplayed = " prt_html_contents.hcn_content ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_pdf_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_pob_id as hcn_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLanguage') && P('show_pdf_language', "1") != "0") { // */ && !in_array("lng", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_lng_id as hcn_lng_id ";
				$queryString = $queryString . ", prt_languages_parent.lng_virgo_title as `language` ";
			} else {
				if ($defaultOrderColumn == "language") {
					$orderColumnNotDisplayed = " prt_languages_parent.lng_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_html_contents ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_html_contents.hcn_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoLanguage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_languages AS prt_languages_parent ON (prt_html_contents.hcn_lng_id = prt_languages_parent.lng_id) ";
			}

		$resultsHtmlContent = $resultHtmlContent->select(
			'', 
			'all', 
			$resultHtmlContent->getOrderColumn(), 
			$resultHtmlContent->getOrderMode(), 
			$whereClauseHtmlContent,
			$queryString);
		
		foreach ($resultsHtmlContent as $resultHtmlContent) {

			if (P('show_pdf_content', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultHtmlContent['hcn_content'])) + 6;
				if ($tmpLen > $minWidth['content']) {
					$minWidth['content'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = trim(virgoPortletObject::lookup($resultHtmlContent['hcnpob__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet object $relation.name']) {
					$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_language', "1") == "1") {
			$parentValue = trim(virgoLanguage::lookup($resultHtmlContent['hcnlng__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['language $relation.name']) {
					$minWidth['language $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaHtmlContent = $resultHtmlContent->getCriteria();
		if (is_null($criteriaHtmlContent) || sizeof($criteriaHtmlContent) == 0 || $countTmp == 0) {
		} else {
			
		}

		$pdf->SetFont($font, $fontBoldVariant, $fontSize);
		$pdf->Cell(1, $colHeight, '');
																																								if (P('show_pdf_portlet_object', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, T('PORTLET_OBJECT') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_content', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['content'], $colHeight, T('CONTENT'), 'T', 'C', 0, 0);
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_language', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['language $relation.name'], $colHeight, T('LANGUAGE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
		foreach ($resultsHtmlContent as $resultHtmlContent) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = virgoPortletObject::lookup($resultHtmlContent['hcn_pob_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_content', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['content'], $colHeight, '' . $resultHtmlContent['hcn_content'], 'T', 'L', 0, 0);
				if (P('show_pdf_content', "1") == "2") {
										if (!is_null($resultHtmlContent['hcn_content'])) {
						$tmpCount = (float)$counts["content"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["content"] = $tmpCount;
					}
				}
				if (P('show_pdf_content', "1") == "3") {
										if (!is_null($resultHtmlContent['hcn_content'])) {
						$tmpSum = (float)$sums["content"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultHtmlContent['hcn_content'];
						}
						$sums["content"] = $tmpSum;
					}
				}
				if (P('show_pdf_content', "1") == "4") {
										if (!is_null($resultHtmlContent['hcn_content'])) {
						$tmpCount = (float)$avgCounts["content"];
						$tmpSum = (float)$avgSums["content"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["content"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultHtmlContent['hcn_content'];
						}
						$avgSums["content"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_language', "1") == "1") {
			$parentValue = virgoLanguage::lookup($resultHtmlContent['hcn_lng_id']);
			$tmpLn = $pdf->MultiCell($minWidth['language $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
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
			if (P('show_pdf_content', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['content'];
				if (P('show_pdf_content', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["content"];
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
			if (P('show_pdf_content', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['content'];
				if (P('show_pdf_content', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["content"], 2, ',', ' ');
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
			if (P('show_pdf_content', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['content'];
				if (P('show_pdf_content', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["content"] == 0 ? "-" : $avgSums["content"] / $avgCounts["content"]);
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
				$reportTitle = T('HTML_CONTENTS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultHtmlContent = new virgoHtmlContent();
			$whereClauseHtmlContent = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseHtmlContent = $whereClauseHtmlContent . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_content', "1") != "0") {
					$data = $data . $stringDelimeter .'Content' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet object ' . $stringDelimeter . $separator;
				}
				if (P('show_export_language', "1") != "0") {
					$data = $data . $stringDelimeter . 'Language ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_html_contents.hcn_id, prt_html_contents.hcn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_content', "1") != "0") {
				$queryString = $queryString . ", prt_html_contents.hcn_content hcn_content";
			} else {
				if ($defaultOrderColumn == "hcn_content") {
					$orderColumnNotDisplayed = " prt_html_contents.hcn_content ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_pob_id as hcn_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLanguage') && P('show_export_language', "1") != "0") { // */ && !in_array("lng", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_lng_id as hcn_lng_id ";
				$queryString = $queryString . ", prt_languages_parent.lng_virgo_title as `language` ";
			} else {
				if ($defaultOrderColumn == "language") {
					$orderColumnNotDisplayed = " prt_languages_parent.lng_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_html_contents ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_html_contents.hcn_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoLanguage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_languages AS prt_languages_parent ON (prt_html_contents.hcn_lng_id = prt_languages_parent.lng_id) ";
			}

			$resultsHtmlContent = $resultHtmlContent->select(
				'', 
				'all', 
				$resultHtmlContent->getOrderColumn(), 
				$resultHtmlContent->getOrderMode(), 
				$whereClauseHtmlContent,
				$queryString);
			foreach ($resultsHtmlContent as $resultHtmlContent) {
				if (P('show_export_content', "1") != "0") {
			$data = $data . $resultHtmlContent['hcn_content'] . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$parentValue = virgoPortletObject::lookup($resultHtmlContent['hcn_pob_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_language', "1") != "0") {
					$parentValue = virgoLanguage::lookup($resultHtmlContent['hcn_lng_id']);
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
				$reportTitle = T('HTML_CONTENTS');
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
			$resultHtmlContent = new virgoHtmlContent();
			$whereClauseHtmlContent = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClauseHtmlContent = $whereClauseHtmlContent . ' AND ' . $parentContextInfo['condition'];
			}
				$headerStyle = array('font' => array('bold' => true));
				$idStyle = array('font' => array('bold' => true));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ID');
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 1)->applyFromArray($headerStyle);
				$kolumna = 0;
				if (P('show_export_content', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Content');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portlet object ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortletObject::getVirgoList();
					$formulaPortletObject = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortletObject != "") {
							$formulaPortletObject = $formulaPortletObject . ',';
						}
						$formulaPortletObject = $formulaPortletObject . $key;
					}
				}
				if (P('show_export_language', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Language ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoLanguage::getVirgoList();
					$formulaLanguage = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaLanguage != "") {
							$formulaLanguage = $formulaLanguage . ',';
						}
						$formulaLanguage = $formulaLanguage . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_html_contents.hcn_id, prt_html_contents.hcn_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_content', "1") != "0") {
				$queryString = $queryString . ", prt_html_contents.hcn_content hcn_content";
			} else {
				if ($defaultOrderColumn == "hcn_content") {
					$orderColumnNotDisplayed = " prt_html_contents.hcn_content ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_pob_id as hcn_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoLanguage') && P('show_export_language', "1") != "0") { // */ && !in_array("lng", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_html_contents.hcn_lng_id as hcn_lng_id ";
				$queryString = $queryString . ", prt_languages_parent.lng_virgo_title as `language` ";
			} else {
				if ($defaultOrderColumn == "language") {
					$orderColumnNotDisplayed = " prt_languages_parent.lng_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_html_contents ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_html_contents.hcn_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoLanguage')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_languages AS prt_languages_parent ON (prt_html_contents.hcn_lng_id = prt_languages_parent.lng_id) ";
			}

			$resultsHtmlContent = $resultHtmlContent->select(
				'', 
				'all', 
				$resultHtmlContent->getOrderColumn(), 
				$resultHtmlContent->getOrderMode(), 
				$whereClauseHtmlContent,
				$queryString);
			$index = 1;
			foreach ($resultsHtmlContent as $resultHtmlContent) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultHtmlContent['hcn_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_content', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultHtmlContent['hcn_content'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletObject::lookup($resultHtmlContent['hcn_pob_id']);
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
					$objValidation->setFormula1('"' . $formulaPortletObject . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_language', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoLanguage::lookup($resultHtmlContent['hcn_lng_id']);
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
					$objValidation->setFormula1('"' . $formulaLanguage . '"');
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
					$propertyColumnHash['content'] = 'hcn_content';
					$propertyColumnHash['content'] = 'hcn_content';
					$propertyClassHash['portlet object'] = 'PortletObject';
					$propertyClassHash['portlet_object'] = 'PortletObject';
					$propertyColumnHash['portlet object'] = 'hcn_pob_id';
					$propertyColumnHash['portlet_object'] = 'hcn_pob_id';
					$propertyClassHash['language'] = 'Language';
					$propertyClassHash['language'] = 'Language';
					$propertyColumnHash['language'] = 'hcn_lng_id';
					$propertyColumnHash['language'] = 'hcn_lng_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importHtmlContent = new virgoHtmlContent();
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
										L(T('PROPERTY_NOT_FOUND', T('HTML_CONTENT'), $columns[$index]), '', 'ERROR');
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
										$importHtmlContent->$fieldName = $value;
									}
								}
								$index = $index + 1;
							}
$defaultValue = P('import_default_value_portlet_object');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortletObject::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortletObject::token2Id($tmpToken);
	}
	$importHtmlContent->setPobId($defaultValue);
}
$defaultValue = P('import_default_value_language');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoLanguage::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoLanguage::token2Id($tmpToken);
	}
	$importHtmlContent->setLngId($defaultValue);
}
							$errorMessage = $importHtmlContent->store();
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
		

		static function portletActionVirgoChangeLanguage() {
			$instance = new virgoHtmlContent();
			$instance->loadFromDB();
			self::portletActionSelect(true, $instance->getId());
			$parentId = R('virgo_parent_id');
			$parent = virgoLanguage::getById($parentId);
			$title = $parent->getVirgoTitle();
			if (!is_null($title) && trim($title) != "") {
				$instance->setLngId($parentId);
				$errorMessage = $instance->store();
				if ($errorMessage == "") {
					L(T('PARENT_SET', T('LANGUAGE'), $title), '', 'INFO');
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



		static function portletActionVirgoSetPortletObject() {
			$this->loadFromDB();
			$parentId = R('hcn_PortletObject_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPobId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetLanguage() {
			$this->loadFromDB();
			$parentId = R('hcn_Language_id_' . $_SESSION['current_portlet_object_id']);
			$this->setLngId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}

		static function portletActionAddPortletObject() {
			self::setDisplayMode("ADD_NEW_PARENT_PORTLET_OBJECT");
		}

		static function portletActionStoreNewPortletObject() {
			$id = -1;
			if (virgoPortletObject::portletActionStore(true, $id) == -1) {
				self::setDisplayMode("ADD_NEW_PARENT_PORTLET_OBJECT");
				$pob = self::getMyPortletObject();
				$pob->setPortletSessionValue('reload_from_request', '1');				
			} else {
				$tmpId = self::loadIdFromRequest();
				$_POST['hcn_portletObject_' . ($tmpId == 0 ? '' : $tmpId)] = $id;
				self::portletActionBackFromParent();
			}
		}

		static function portletActionBackFromParent() {
			$calligView = strtoupper(R('calling_view'));
			self::setDisplayMode($calligView);
			$pob = self::getMyPortletObject();
			$pob->setPortletSessionValue('reload_from_request', '1');				
		}
		static private function getRowByPob($pobId) {
			if (!isset($pobId)) {
				return null;
			}
			I('Language');
			$langInfo = virgoLanguage::getCurrentLanguage();
			$langCondition = "";
			if (isset($langInfo)) {
				if (isset($langInfo[0])) {
					$langCondition = " AND hcn_lng_id = " . $langInfo[0] . " ";
				}
			}
			$query = <<<SQL
SELECT
	hcn_id,
	hcn_content
FROM
	prt_html_contents
WHERE 
	hcn_pob_id = {$pobId}
	{$langCondition}	
SQL;
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row;
			}
			$query = <<<SQL
SELECT
	hcn_id,
	hcn_content
FROM
	prt_html_contents
WHERE 
	hcn_pob_id = {$pobId}
	AND hcn_lng_id IS NULL	
SQL;
			$rows = QR($query);
			foreach ($rows as $row) {
				return $row;
			}
			return null;
		}

		static function getHtmlContent($pobId) {
			$row = virgoHtmlContent::getRowByPob($pobId);
			if (isset($row)) {
				return $row['hcn_content'];
			} else {
				return '';
			}
		}
		
		static function getByPortletObject($pobId) {
			$row = virgoHtmlContent::getRowByPob($pobId);
			if (isset($row)) {
				return new virgoHtmlContent($row['hcn_id']);
			} else {
				return null;
			}
		}


		static function createTable() {
			$query =  <<<SELECT
CREATE TABLE IF NOT EXISTS `prt_html_contents` (
  `hcn_id` bigint(20) unsigned NOT NULL auto_increment,
  `hcn_virgo_state` varchar(50) default NULL,
  `hcn_virgo_title` varchar(255) default NULL,
	`hcn_pob_id` int(11) default NULL,
	`hcn_lng_id` int(11) default NULL,
  `hcn_content` longtext, 
  `hcn_date_created` datetime NOT NULL,
  `hcn_date_modified` datetime default NULL,
  `hcn_usr_created_id` int(11) NOT NULL,
  `hcn_usr_modified_id` int(11) default NULL,
  KEY `hcn_pob_fk` (`hcn_pob_id`),
  KEY `hcn_lng_fk` (`hcn_lng_id`),
  PRIMARY KEY  (`hcn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/html_content.sql 
INSERT INTO `prt_html_contents` (`hcn_virgo_title`, `hcn_content`) 
VALUES (title, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_html_contents table already exists.", '', 'FATAL');
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
			return "hcn";
		}
		
		static function getPlural() {
			return "html_contents";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPortletObject";
			$ret[] = "virgoLanguage";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_html_contents'));
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
			$virgoVersion = virgoHtmlContent::getVirgoVersion();
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
	
	

