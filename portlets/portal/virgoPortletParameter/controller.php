<?php
/**
* Module Portlet parameter
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
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
//	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');

	class virgoPortletParameter {

		 var  $ppr_id = null;
		 var  $ppr_name = null;

		 var  $ppr_value = null;

		 var  $ppr_pob_id = null;
		 var  $ppr_pdf_id = null;
		 var  $ppr_prt_id = null;
		 var  $ppr_tmp_id = null;

		 var   $ppr_date_created = null;
		 var   $ppr_usr_created_id = null;
		 var   $ppr_date_modified = null;
		 var   $ppr_usr_modified_id = null;
		 var   $ppr_virgo_title = null;
		
		 var   $internalLog = null;		
				
		 function __construct($loadId = null) {


			if (!is_null($loadId) && (is_int($loadId) || is_string($loadId))) {
				$this->load($loadId);
			}
		}

		static public function createGuiAware() {
			$ret = new virgoPortletParameter();
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
        	$this->ppr_id = null;
		    $this->ppr_date_created = null;
		    $this->ppr_usr_created_id = null;
		    $this->ppr_date_modified = null;
		    $this->ppr_usr_modified_id = null;
		    $this->ppr_virgo_title = null;
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
			return $this->ppr_id;
		}

		function getName() {
			return $this->ppr_name;
		}
		
		 function setName($val) {
			$this->ppr_name = $val;
		}
		function getValue() {
			return $this->ppr_value;
		}
		
		 function setValue($val) {
			$this->ppr_value = $val;
		}

		function getPortletObjectId() {
			return $this->ppr_pob_id;
		}
		
		 function setPortletObjectId($val) {
			$this->ppr_pob_id = $val;
		}
		function getPortletDefinitionId() {
			return $this->ppr_pdf_id;
		}
		
		 function setPortletDefinitionId($val) {
			$this->ppr_pdf_id = $val;
		}
		function getPortalId() {
			return $this->ppr_prt_id;
		}
		
		 function setPortalId($val) {
			$this->ppr_prt_id = $val;
		}
		function getTemplateId() {
			return $this->ppr_tmp_id;
		}
		
		 function setTemplateId($val) {
			$this->ppr_tmp_id = $val;
		}

		function getDateCreated() {
			return $this->ppr_date_created;
		}
		function getUsrCreatedId() {
			return $this->ppr_usr_created_id;
		}
		function getDateModified() {
			return $this->ppr_date_modified;
		}
		function getUsrModifiedId() {
			return $this->ppr_usr_modified_id;
		}


		function getPobId() {
			return $this->getPortletObjectId();
		}
		
		 function setPobId($val) {
			$this->setPortletObjectId($val);
		}
		function getPdfId() {
			return $this->getPortletDefinitionId();
		}
		
		 function setPdfId($val) {
			$this->setPortletDefinitionId($val);
		}
		function getPrtId() {
			return $this->getPortalId();
		}
		
		 function setPrtId($val) {
			$this->setPortalId($val);
		}
		function getTmpId() {
			return $this->getTemplateId();
		}
		
		 function setTmpId($val) {
			$this->setTemplateId($val);
		}

		function getValueSnippet($wordCount) {
			if (is_null($this->getValue()) || trim($this->getValue()) == "") {
				return "";
			}
		  	return implode( 
			    '', 
		    	array_slice( 
		      		preg_split(
			        	'/([\s,\.;\?\!]+)/', 
		        		$this->getValue(), 
		        		$wordCount*2+1, 
		        		PREG_SPLIT_DELIM_CAPTURE
		      		),
		      		0,
		      		$wordCount*2-1
		    	)
		  	)."...";
		}
		function loadRecordFromRequest($rowId) {
			$this->ppr_id = $rowId;
	$tmpValue = null;
	$tmpValue = R('ppr_name_' . $this->ppr_id);
	if (!is_null($tmpValue)) {
		$tmpValue = trim($tmpValue);
		$tmpValue = preg_replace('/\s+/', ' ', $tmpValue);
		if ($tmpValue == "") {
			$this->ppr_name = null;
		} else {
			$this->ppr_name = $tmpValue;
		}
	}
	$tmpValue = null;
	$tmpValue = R('ppr_value_' . $this->ppr_id);
	if (!is_null($tmpValue)) {
		if ($tmpValue == "") {
			$this->ppr_value = null;
		} else {
			$this->ppr_value = $tmpValue;
		}
	}
			$this->ppr_pob_id = strval(R('ppr_portletObject_' . $this->ppr_id));
			$this->ppr_pdf_id = strval(R('ppr_portletDefinition_' . $this->ppr_id));
			$this->ppr_prt_id = strval(R('ppr_portal_' . $this->ppr_id));
			$this->ppr_tmp_id = strval(R('ppr_template_' . $this->ppr_id));
		}
		
		function loadFromRequest($rowId = null) {
			if (is_null($rowId)) {
				$rowId = R('ppr_id_' . $_SESSION['current_portlet_object_id']);
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
			$criteriaPortletParameter = array();	
			$criteriaFieldPortletParameter = array();	
			$isNullPortletParameter = R('virgo_search_name_is_null');
			
			$criteriaFieldPortletParameter["is_null"] = 0;
			if ($isNullPortletParameter == "not_null") {
				$criteriaFieldPortletParameter["is_null"] = 1;
			} elseif ($isNullPortletParameter == "null") {
				$criteriaFieldPortletParameter["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_name');

//			if ($isSet) {
			$criteriaFieldPortletParameter["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletParameter["name"] = $criteriaFieldPortletParameter;
			$criteriaFieldPortletParameter = array();	
			$isNullPortletParameter = R('virgo_search_value_is_null');
			
			$criteriaFieldPortletParameter["is_null"] = 0;
			if ($isNullPortletParameter == "not_null") {
				$criteriaFieldPortletParameter["is_null"] = 1;
			} elseif ($isNullPortletParameter == "null") {
				$criteriaFieldPortletParameter["is_null"] = 2;
			}
			
			$dataTypeCriteria = array();
			$isSet = false;
		$dataTypeCriteria["default"] = R('virgo_search_value');

//			if ($isSet) {
			$criteriaFieldPortletParameter["value"] = $dataTypeCriteria;
//			}
			$criteriaPortletParameter["value"] = $criteriaFieldPortletParameter;
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
			$criteriaPortletParameter["portlet_object"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portletDefinition_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portletDefinition', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletParameter["portlet_definition"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_portal_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_portal', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletParameter["portal"] = $criteriaParent;
			$criteriaParent = array();	
			$isNull = R('virgo_search_template_is_null');
			$criteriaParent["is_null"] = 0;
			if ($isNull == "not_null") {
				$criteriaParent["is_null"] = 1;
			} elseif ($isNull == "null") {
				$criteriaParent["is_null"] = 2;
			}
			$parent = R('virgo_search_template', null, 'default', 'none');
			if (!is_null($parent) && count($parent) > 0) {
				$criteriaParent["value"] = $parent;
			}
			$criteriaPortletParameter["template"] = $criteriaParent;
			self::setCriteria($criteriaPortletParameter);
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
			$tableFilter = R('virgo_filter_value');
			if (S($tableFilter)) {
				self::setLocalSessionValue('VirgoFilterValue', $tableFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterValue', null);
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
			$parentFilter = R('virgo_filter_portlet_definition');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortletDefinition', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortletDefinition', null);
			}
			$parentFilter = R('virgo_filter_title_portlet_definition');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortletDefinition', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortletDefinition', null);
			}
			$parentFilter = R('virgo_filter_portal');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterPortal', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterPortal', null);
			}
			$parentFilter = R('virgo_filter_title_portal');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitlePortal', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitlePortal', null);
			}
			$parentFilter = R('virgo_filter_template');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTemplate', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTemplate', null);
			}
			$parentFilter = R('virgo_filter_title_template');
			if (S($parentFilter)) {
				self::setLocalSessionValue('VirgoFilterTitleTemplate', $parentFilter);
			} else {
				self::setLocalSessionValue('VirgoFilterTitleTemplate', null);
			}
		}

		function showApplicableOnlyRecords(&$filterApplied, &$types, &$values) {
			$whereClausePortletParameter = ' 1 = 1 ';
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
				$eventColumn = "ppr_" . P('event_column');
				$whereClausePortletParameter = $whereClausePortletParameter . " AND " . $eventColumn . " BETWEEN ? AND ? ";
				$types .= "ss";
				$values[] = $firstDay["year"] . "-" . (str_pad($firstDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($firstDay["mday"], 2, "0", STR_PAD_LEFT));
				$values[] = $lastDay["year"] . "-" . (str_pad($lastDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($lastDay["mday"], 2, "0", STR_PAD_LEFT));
			}
			$parentContextInfos = $this->getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletParameter = $whereClausePortletParameter . ' AND ' . $parentContextInfo['condition'];
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_object');
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
					$inCondition = " prt_portlet_parameters.ppr_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_definition');
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
					$inCondition = " prt_portlet_parameters.ppr_pdf_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_pdf_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
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
					$inCondition = " prt_portlet_parameters.ppr_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_template');
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
					$inCondition = " prt_portlet_parameters.ppr_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletParameter = self::getCriteria();
			if (isset($criteriaPortletParameter["name"])) {
				$fieldCriteriaName = $criteriaPortletParameter["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_parameters.ppr_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletParameter["value"])) {
				$fieldCriteriaValue = $criteriaPortletParameter["value"];
				if ($fieldCriteriaValue["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_value IS NOT NULL ';
				} elseif ($fieldCriteriaValue["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_value IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaValue["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_parameters.ppr_value like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaPortletParameter["portlet_object"])) {
				$parentCriteria = $criteriaPortletParameter["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["portlet_definition"])) {
				$parentCriteria = $criteriaPortletParameter["portlet_definition"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_pdf_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_pdf_id IN (SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["portal"])) {
				$parentCriteria = $criteriaPortletParameter["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["template"])) {
				$parentCriteria = $criteriaPortletParameter["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePortletParameter = $whereClausePortletParameter . " " . $filter . " ";
			$filterApplied = ($filter != "");
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletParameter = $whereClausePortletParameter . " AND " . $customSQL . " ";
			}
			$customParentQuery = P('custom_parent_query');
			if (S($customParentQuery)) {
				$customParentId = self::getLocalSessionValue('CustomParentId', null);
				if (S($customParentId)) {
					$customParentQuery = str_replace("?", $customParentId, $customParentQuery);
					$whereClausePortletParameter = $whereClausePortletParameter . " AND " . $customParentQuery . " ";
				}
			}
			if (P("show_table_filter", '0') == 1) {
				$tableFilter = self::getLocalSessionValue('VirgoFilterName', null);
				if (S($tableFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_name LIKE '%{$tableFilter}%' ";
				}
				$tableFilter = self::getLocalSessionValue('VirgoFilterValue', null);
				if (S($tableFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_value LIKE '%{$tableFilter}%' ";
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletObject', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_pob_id IS NULL ";
					} else {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_pob_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
				if (S($parentFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND prt_portlet_objects_parent.pob_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortletDefinition', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_pdf_id IS NULL ";
					} else {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_pdf_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortletDefinition', null);
				if (S($parentFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND prt_portlet_definitions_parent.pdf_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterPortal', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_prt_id IS NULL ";
					} else {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_prt_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitlePortal', null);
				if (S($parentFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND prt_portals_parent.prt_virgo_title LIKE '%{$parentFilter}%' ";
				}				
				$parentFilter = self::getLocalSessionValue('VirgoFilterTemplate', null);
				if (S($parentFilter)) {
					if ($parentFilter == "empty") {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_tmp_id IS NULL ";
					} else {
						$whereClausePortletParameter = $whereClausePortletParameter . " AND ppr_tmp_id = $parentFilter ";
					}
				}
				$parentFilter = self::getLocalSessionValue('VirgoFilterTitleTemplate', null);
				if (S($parentFilter)) {
					$whereClausePortletParameter = $whereClausePortletParameter . " AND prt_templates_parent.tmp_virgo_title LIKE '%{$parentFilter}%' ";
				}				
			}
			return $whereClausePortletParameter;
		}

		function getTableData(&$resultCount, &$filterApplied) {
			$types = "";
			$values = array();
			$filterApplied = false;
			$whereClausePortletParameter = $this->showApplicableOnlyRecords($filterApplied, $types, $values);
			$queryString = " SELECT prt_portlet_parameters.ppr_id, prt_portlet_parameters.ppr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_table_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_name ppr_name";
			} else {
				if ($defaultOrderColumn == "ppr_name") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_name ";
				}
			}
			if (P('show_table_value', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_value ppr_value";
			} else {
				if ($defaultOrderColumn == "ppr_value") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_value ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pob_id as ppr_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_table_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pdf_id as ppr_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_table_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_prt_id as ppr_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_table_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_tmp_id as ppr_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_parameters ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_parameters.ppr_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_parameters.ppr_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_parameters.ppr_prt_id = prt_portals_parent.prt_id) ";
			}
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portlet_parameters.ppr_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$showPage = $this->getShowPage(); 
			$showRows = $this->getShowRows(); 
			$virgoOrderColumn = $this->getOrderColumn();
			$virgoOrderMode = $this->getOrderMode();

			$extraCondition = "";
			if (trim($extraCondition) != "") {
				$whereClausePortletParameter = $whereClausePortletParameter . " " . $extraCondition;
			}

			$resultCount = $this->getAllRecordCount($whereClausePortletParameter, $queryString, $types, $values);

			return $this->select(
					$showPage, 
					$showRows, 
					$virgoOrderColumn, 
					$virgoOrderMode, 
					$whereClausePortletParameter,
					$queryString,
					$types,
					$values);

		}
		
		static function internalSelect($query, $column = null, $types = null, $values = null) {
			return QPR($query, $types, $values, false, true, $column);
		}
		
		function selectAll($where = '', $orderBy = '', $types = null, $values = null) {
			$query = "SELECT * "
			. "\n FROM prt_portlet_parameters"
			;
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " ppr_usr_created_id = '" . virgoUser::getUserId() . "' ";
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
				$privateCondition = " ppr_usr_created_id = ? ";
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
				. "\n FROM prt_portlet_parameters"
				;
				if ($where != '') { 
					$query = $query . " WHERE " . $where . " ";
				}			
			} else {
				if ($where != '') { 
					$query = "SELECT * FROM ( " . $queryString . (strpos(strtoupper($queryString), "WHERE") === false ? " WHERE " : " AND ") . $where . " ) as prt_portlet_parameters ";
				} else {			
					$query = "SELECT * FROM ( " . $queryString . " ) as prt_portlet_parameters ";
				}
			}
			if ($orderColumn != null) {
				$query = $query . "\n ORDER BY $orderColumn $orderMode, ppr_id $orderMode";
			}
			if ($showRows != 'all') {
				$query = $query . "\n LIMIT " . ($showPage - 1) * $showRows. ", " . $showRows;
			}
			return self::internalSelect($query, null, $types, $values);
		}

		function getAllRecordCount($where = '', $queryString = '', $types = null, $values = null) {
			$componentParams = null;
			if (P('only_private_records', "0") == "1") {
				$privateCondition = " ppr_usr_created_id = ? ";
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
				$query = "SELECT COUNT(ppr_id) cnt FROM portlet_parameters";
				if ($where != '') {
					$query = $query . " WHERE " . $where . " ";
				}	
			} else {
				if ($where != '') {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . " WHERE " . $where . ") as portlet_parameters ";
				} else {
					$query = "SELECT COUNT(*) as cnt FROM (" . $queryString . ") as portlet_parameters ";
				}
			}
			
			$results = self::internalSelect($query, null, $types, $values);
			return $results[0]['cnt'];
		}

		static function getById($id) {
			$instance = new virgoPortletParameter();
			$instance->load($id);
			return $instance;
		}
		
		function load($id, $fetchUsernames = false) {
			if (!is_null($id) && trim($id) != "") {
				$query = "SELECT * FROM prt_portlet_parameters WHERE ppr_id = {$id}";
				$results = QR($query);
				if (!isset($results)) {
					L('Invalid query', $query, 'ERROR');
				} else {
					if (count($results) > 0) {
						$row = $results[0];
						$this->ppr_id = $row['ppr_id'];
$this->ppr_name = $row['ppr_name'];
$this->ppr_value = $row['ppr_value'];
						$this->ppr_pob_id = $row['ppr_pob_id'];
						$this->ppr_pdf_id = $row['ppr_pdf_id'];
						$this->ppr_prt_id = $row['ppr_prt_id'];
						$this->ppr_tmp_id = $row['ppr_tmp_id'];
						if ($fetchUsernames) {
							if ($row['ppr_date_created']) {
								if ($row['ppr_usr_created_id'] == 0) {
									$createdBy = "anonymous";
								} else {
									$createdByUser = new virgoUser((int)$row['ppr_usr_created_id']);
									$createdBy = $createdByUser->getUsername();
								}
							} else {
								$createdBy = "";
							}
							if ($row['ppr_date_modified']) {
								if ($row['ppr_usr_modified_id'] == $row['ppr_usr_created_id']) {
									$modifiedBy = $createdBy;
								} else {
									if ($row['ppr_usr_modified_id'] == 0) {
										$modifiedBy = "anonymous";
									} else {
										$modifiedByUser = new virgoUser((int)$row['ppr_usr_modified_id']);
										$modifiedBy = $modifiedByUser->getUsername();
									}
								}
							} else {
								$modifiedBy = "";
							}
						}
						$this->ppr_date_created = $row['ppr_date_created'];
						$this->ppr_usr_created_id = $fetchUsernames ? $createdBy : $row['ppr_usr_created_id'];
						$this->ppr_date_modified = $row['ppr_date_modified'];
						$this->ppr_usr_modified_id = $fetchUsernames ? $modifiedBy : $row['ppr_usr_modified_id'];
						$this->ppr_virgo_title = $row['ppr_virgo_title'];
					}
				}
			}
		}

		function changeOwnershipAndStore($userId) {
			$query = " UPDATE prt_portlet_parameters SET ppr_usr_created_id = {$userId} WHERE ppr_id = {$this->getId()} ";
			$result = Q($query);
			if (!$result) {
				L(mysqli_error(), $query, 'ERROR');
			}
			$this->ppr_usr_created_id = $userId;
		}
		
		static function getRecordCreatedBy($userId) {
			$rets = virgoPortletParameter::selectAllAsObjectsStatic('ppr_usr_created_id = ' . $userId);
			foreach ($rets as $ret) {
				return $ret;
			}
			return null;
		}

		function getCreatorUserId() {
			return $this->ppr_usr_created_id;
		}

		function getCreatorUsername() {
			$createdByUser = new virgoUser($this->getCreatorUserId());
			return $createdByUser->getUsername();
		}

		function getVirgoCreationDate() {
			return $this->ppr_date_created;
		}

		function loadFromDB() {
			$this->load(self::loadIdFromRequest());
		}
		
		static function loadIdFromRequest($id = null) {
			return intval(is_null($id) ? R('ppr_id_' . $_SESSION['current_portlet_object_id']) : $id);
		}
		
		static function lookup($lookup_id) {
			if ($lookup_id) {
				$tmp_ppr = new virgoPortletParameter();
				$tmp_ppr->load((int)$lookup_id);
				return $tmp_ppr->getVirgoTitle();
			}
		} 
				
		function printVirgoListMatchedInternal($match, $fieldName) {
			if (A(virgoUser::getUserId())) {
				$match = QE($match);
				$extraAjaxFilter = PD('extra_ajax_filter', 'virgoPortletParameter');
				if (S($extraAjaxFilter)) {
					$extraAjaxFilter = " AND ({$extraAjaxFilter}) ";
				} else {
					$extraAjaxFilter = "";
				}
				$resultsLabels = $this->getVirgoList(" ppr_virgo_title LIKE '%{$match}%' {$extraAjaxFilter} ", false, true);
				$sizeOf = sizeof($resultsLabels);
				$maxListLabelSize = PD('ajax_max_label_list_size', 'virgoPortletParameter', "10");
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
				$query = $query . " ppr_id as id, ppr_virgo_title as title ";
			}
			$query = $query . " FROM prt_portlet_parameters ";
			$componentParams = null;
			$tmpQuery = " WHERE 1 = 1 ";
			if (P('only_private_records', "0", 'virgoPortletParameter', 'portal') == "1") {
				$privateCondition = " ppr_usr_created_id = '" . virgoUser::getUserId() . "' ";
				$tmpQuery = " WHERE " . $privateCondition . " ";
			}
			$query = $query . $tmpQuery;
			if ($where != '') {
				$query = $query . " AND " . $where;
			}
			if (!$sizeOnly) {
				$query = $query . " ORDER BY ppr_virgo_title ";
			}
			if ($sizeOnly) {
	$result = QL($query);
				return $result[0];
			} else {						
	$rows = QR($query);
				if ($hash) {
					return $rows;
				}
				$resPortletParameter = array();
				foreach ($rows as $row) {
					$resPortletParameter[$row['id']] = $row['title'];
				}
				return $resPortletParameter;
			}
		}

		static function getVirgoListStatic($where = '', $sizeOnly = false, $hash = false) {
			$staticPortletParameter = new virgoPortletParameter();
			return $staticPortletParameter->getVirgoList($where, $sizeOnly, $hash);
		}
		
		static function getPortletObjectStatic($parentId) {
			return virgoPortletObject::getById($parentId);
		}
		
		function getPortletObject() {
			return virgoPortletParameter::getPortletObjectStatic($this->ppr_pob_id);
		}
		static function getPortletDefinitionStatic($parentId) {
			return virgoPortletDefinition::getById($parentId);
		}
		
		function getPortletDefinition() {
			return virgoPortletParameter::getPortletDefinitionStatic($this->ppr_pdf_id);
		}
		static function getPortalStatic($parentId) {
			return virgoPortal::getById($parentId);
		}
		
		function getPortal() {
			return virgoPortletParameter::getPortalStatic($this->ppr_prt_id);
		}
		static function getTemplateStatic($parentId) {
			return virgoTemplate::getById($parentId);
		}
		
		function getTemplate() {
			return virgoPortletParameter::getTemplateStatic($this->ppr_tmp_id);
		}


		function validateObject($virgoOld) {
			if (
(is_null($this->getName()) || trim($this->getName()) == '')
			) {
				return T('FIELD_OBLIGATORY', 'NAME');
			}			
			$tmpMode = (is_null($this->getId()) || trim($this->getId()) == "" ? "create" : "form");
			if (P('show_'.$tmpMode.'_value_obligatory', "0") == "1") {
				if (
(is_null($this->getValue()) || trim($this->getValue()) == '')
				) {
					return T('FIELD_OBLIGATORY', 'VALUE');
				}			
			}
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portlet_object_obligatory', "0") == "1") {
				if (is_null($this->ppr_pob_id) || trim($this->ppr_pob_id) == "") {
					if (R('create_ppr_portletObject_' . $this->ppr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_OBJECT', '');
					}
				}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portlet_definition_obligatory', "0") == "1") {
				if (is_null($this->ppr_pdf_id) || trim($this->ppr_pdf_id) == "") {
					if (R('create_ppr_portletDefinition_' . $this->ppr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTLET_DEFINITION', '');
					}
				}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_portal_obligatory', "0") == "1") {
				if (is_null($this->ppr_prt_id) || trim($this->ppr_prt_id) == "") {
					if (R('create_ppr_portal_' . $this->ppr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'PORTAL', '');
					}
				}
			}			
			$tmpMode = (is_null($this->getId()) ? "create" : "form");
			if (P('show_'.$tmpMode.'_template_obligatory', "0") == "1") {
				if (is_null($this->ppr_tmp_id) || trim($this->ppr_tmp_id) == "") {
					if (R('create_ppr_template_' . $this->ppr_id) == "1") { 
					} else {
						return T('FIELD_OBLIGATORY', 'TEMPLATE', '');
					}
				}
			}			
 		$types = "";
		$values = array();
		$skipUniquenessCheck = false;
			return "";
		}

				
		function beforeStore($virgoOld) {
		if (!isset($virgoOld)) {
			if ((is_null($this->getPobId()) || $this->getPobId() == "") 
			  && (is_null($this->getPdfId()) || $this->getPdfId() == "") 
			  && (is_null($this->getPrtId()) || $this->getPrtId() == "")
			  && (is_null($this->getTmpId()) || $this->getTmpId() == "")) {
				$this->setPrtId(virgoPortal::getCurrentPortal()->getId());
			}				
		}
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
			$query = "SELECT IFNULL(MAX(revision), 0) as revision FROM  prt_history_portlet_parameters WHERE ppr_id = " . $this->getId();
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
				$colNames = $colNames . ", ppr_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				$colNames = $colNames . ", ppr_value";
				$values = $values . ", " . (is_null($objectToStore->getValue()) ? "null" : "'" . QE($objectToStore->getValue()) . "'");
				$colNames = $colNames . ", ppr_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) || $objectToStore->getPobId() == "" ? "null" : $objectToStore->getPobId());
				$colNames = $colNames . ", ppr_pdf_id";
				$values = $values . ", " . (is_null($objectToStore->getPdfId()) || $objectToStore->getPdfId() == "" ? "null" : $objectToStore->getPdfId());
				$colNames = $colNames . ", ppr_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) || $objectToStore->getPrtId() == "" ? "null" : $objectToStore->getPrtId());
				$colNames = $colNames . ", ppr_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) || $objectToStore->getTmpId() == "" ? "null" : $objectToStore->getTmpId());
				$query = "INSERT INTO prt_history_portlet_parameters (revision, ip, username, user_id, timestamp, ppr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
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
				$colNames = $colNames . ", ppr_name";
				$values = $values . ", " . (is_null($objectToStore->getName()) ? "null" : "'" . QE($objectToStore->getName()) . "'");
				}
			}
			if (is_null($virgoOld) || $virgoOld->getValue() != $objectToStore->getValue()) {
				if (is_null($objectToStore->getValue())) {
					$nullifiedProperties = $nullifiedProperties . "value,";
				} else {
				$colNames = $colNames . ", ppr_value";
				$values = $values . ", " . (is_null($objectToStore->getValue()) ? "null" : "'" . QE($objectToStore->getValue()) . "'");
				}
			}
			if ($nullifiedProperties != "") {
				$colNames = $colNames . ", nullified_properties";
				$values = $values . ", '" . $nullifiedProperties . "'";
			}
			if (is_null($virgoOld) || ($virgoOld->getPobId() != $objectToStore->getPobId() && ($virgoOld->getPobId() != 0 || $objectToStore->getPobId() != ""))) { 
				$colNames = $colNames . ", ppr_pob_id";
				$values = $values . ", " . (is_null($objectToStore->getPobId()) ? "null" : ($objectToStore->getPobId() == "" ? "0" : $objectToStore->getPobId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPdfId() != $objectToStore->getPdfId() && ($virgoOld->getPdfId() != 0 || $objectToStore->getPdfId() != ""))) { 
				$colNames = $colNames . ", ppr_pdf_id";
				$values = $values . ", " . (is_null($objectToStore->getPdfId()) ? "null" : ($objectToStore->getPdfId() == "" ? "0" : $objectToStore->getPdfId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getPrtId() != $objectToStore->getPrtId() && ($virgoOld->getPrtId() != 0 || $objectToStore->getPrtId() != ""))) { 
				$colNames = $colNames . ", ppr_prt_id";
				$values = $values . ", " . (is_null($objectToStore->getPrtId()) ? "null" : ($objectToStore->getPrtId() == "" ? "0" : $objectToStore->getPrtId()));
			}
			if (is_null($virgoOld) || ($virgoOld->getTmpId() != $objectToStore->getTmpId() && ($virgoOld->getTmpId() != 0 || $objectToStore->getTmpId() != ""))) { 
				$colNames = $colNames . ", ppr_tmp_id";
				$values = $values . ", " . (is_null($objectToStore->getTmpId()) ? "null" : ($objectToStore->getTmpId() == "" ? "0" : $objectToStore->getTmpId()));
			}
			$query = "INSERT INTO prt_history_portlet_parameters (revision, ip, username, user_id, timestamp, ppr_id" . $colNames . ") VALUES ($new_revision, '$ip', '$username', $user_id, '" . date('Y-m-d H:i:s') . "', " . $this->getId() . $values . ") ";
			Q($query);
		}
		
		function virgoTitleColumnExists() {
			$exists = false;
			$columns = Q("SHOW COLUMNS FROM prt_portlet_parameters");
			if (isset($columns) && $columns !== false) {
				foreach ($columns as $c){
					if($c['Field'] == 'ppr_virgo_title'){
						return true;
					}
				}
			}
			return false;
		}
		
		function addVirgoTitleColumn() {
			$query = "ALTER TABLE prt_portlet_parameters ADD COLUMN (ppr_virgo_title VARCHAR(255));";
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
			if (isset($this->ppr_id) && $this->ppr_id != "") {
				$query = "UPDATE prt_portlet_parameters SET ";
			if (isset($this->ppr_name)) {
				$query .= " ppr_name = ? ,";
				$types .= "s";
				$values[] = $this->ppr_name;
			} else {
				$query .= " ppr_name = NULL ,";				
			}
			if (isset($this->ppr_value)) {
				$query .= " ppr_value = ? ,";
				$types .= "s";
				$values[] = $this->ppr_value;
			} else {
				$query .= " ppr_value = NULL ,";				
			}
				if (isset($this->ppr_pob_id) && trim($this->ppr_pob_id) != "") {
					$query = $query . " ppr_pob_id = ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_pob_id;
				} else {
					$query = $query . " ppr_pob_id = NULL, ";
				}
				if (isset($this->ppr_pdf_id) && trim($this->ppr_pdf_id) != "") {
					$query = $query . " ppr_pdf_id = ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_pdf_id;
				} else {
					$query = $query . " ppr_pdf_id = NULL, ";
				}
				if (isset($this->ppr_prt_id) && trim($this->ppr_prt_id) != "") {
					$query = $query . " ppr_prt_id = ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_prt_id;
				} else {
					$query = $query . " ppr_prt_id = NULL, ";
				}
				if (isset($this->ppr_tmp_id) && trim($this->ppr_tmp_id) != "") {
					$query = $query . " ppr_tmp_id = ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_tmp_id;
				} else {
					$query = $query . " ppr_tmp_id = NULL, ";
				}
				$query = $query . " ppr_virgo_title = ? , ";
				$types = $types . "s";
				$values[] = $this->getVirgoTitle();

				$query = $query . " ppr_date_modified = ? , ";
				$types = $types . "s";
				$values[] = $this->ppr_date_modified;

				$query = $query . " ppr_usr_modified_id = ? ";
				$types = $types . "i";
				$values[] = $this->ppr_usr_modified_id;

				$query = $query . " WHERE ppr_id = ? ";
				$types = $types . "i";
				$values[] = $this->ppr_id;
			} else {
				$query = "INSERT INTO prt_portlet_parameters ( ";
			$query = $query . " ppr_name, ";
			$query = $query . " ppr_value, ";
				$query = $query . " ppr_pob_id, ";
				$query = $query . " ppr_pdf_id, ";
				$query = $query . " ppr_prt_id, ";
				$query = $query . " ppr_tmp_id, ";
				$query = $query . " ppr_virgo_title, ppr_date_created, ppr_usr_created_id) VALUES ( ";
			if (isset($this->ppr_name)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->ppr_name;
			} else {
				$query .= " NULL ,";				
			}
			if (isset($this->ppr_value)) {
				$query .= " ? ,";
				$types .= "s";
				$values[] = $this->ppr_value;
			} else {
				$query .= " NULL ,";				
			}
				if (isset($this->ppr_pob_id) && trim($this->ppr_pob_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_pob_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->ppr_pdf_id) && trim($this->ppr_pdf_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_pdf_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->ppr_prt_id) && trim($this->ppr_prt_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_prt_id;
				} else {
					$query = $query . " NULL, ";
				}
				if (isset($this->ppr_tmp_id) && trim($this->ppr_tmp_id) != "") {
					$query = $query . " ? , ";
					$types = $types . "i";
					$values[] = $this->ppr_tmp_id;
				} else {
					$query = $query . " NULL, ";
				}
				$query = $query . " ? , ? , ? ) ";
				$types = $types . "ssi";
				$values[] = $this->getVirgoTitle();
				$values[] = $this->ppr_date_created;
				$values[] = $this->ppr_usr_created_id;
			}
			$results = Q($query, $log, true, $types, $values);
			if (!$results) {
				$this->_error = QER();
				L('Invalid query ' . $query, $this->_error, 'FATAL');
				return false;
			} else {
				if (!isset($this->ppr_id) || $this->ppr_id == "") {
					$this->ppr_id = QID();
				}
				if ($log) {
					L("portlet parameter stored successfully", "id = {$this->ppr_id}", "TRACE");
				}
				return true;
			}
		}
		
		
		function store($log = false) {
			$virgoOld = null;
			if ($this->ppr_id) {
				$virgoOld = new virgoPortletParameter($this->ppr_id);
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
					if ($this->ppr_id) {			
						$this->ppr_date_modified = date("Y-m-d H:i:s");
						$this->ppr_usr_modified_id = $userId;
					} else {
						$this->ppr_date_created = date("Y-m-d H:i:s");
						$this->ppr_usr_created_id = $userId;
					}
					$this->ppr_virgo_title = $this->getVirgoTitle(); 
					if (!$this->parentStore(true, $log)) {
						$exists = $this->virgoTitleColumnExists();
						if(!$exists){
							$this->addVirgoTitleColumn();
							if (!$this->parentStore(true, $log)) {
								$error = $this->getError();
								$this->logFatal('Error storing "portlet parameter" with id = ' . $this->getId() . ": " . $error);
							return 'A problem ocurred while saving the record in the database. Please contact site Administrator.';
							}
						} else {
							$error = $this->getError();
							$this->logFatal('Error storing "portlet parameter" with id = ' . $this->getId() . ": " . $error);
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
			$query = "DELETE FROM prt_portlet_parameters WHERE ppr_id = {$this->ppr_id}";
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
			$tmp = new virgoPortletParameter();
			return $tmp->selectAllAsIds($where, $idsNotArrayOfIds);
		}
		
		public function selectAllAsIds($where = '', $idsNotArrayOfIds = false) {
			$query = "SELECT ppr_id as id FROM prt_portlet_parameters";
			if ($where != '') {
				$query = $query . " WHERE $where ";
			}
			$orderBy = "";
			if (property_exists($this, 'ppr_order_column')) {
				$orderBy = " ORDER BY ppr_order_column ASC ";
			} 
			if (property_exists($this, 'ppr_kolejnosc_wyswietlania')) {
				$orderBy = " ORDER BY ppr_kolejnosc_wyswietlania ASC ";
			} 
			$query = $query . $orderBy;
			return self::internalSelect($query, $idsNotArrayOfIds ? 'id' : null);
		}		
		
		static public function selectAllAsObjectsStatic($where = '') {
			$tmp = new virgoPortletParameter();
			return $tmp->selectAllAsObjects($where);
		}
		
		public function selectAllAsObjects($where = '') {
			$results =  $this->selectAllAsIds($where);
			$ret = array(); 
			foreach ($results as $result) {
				$tmpObj = new virgoPortletParameter($result['id']);
				$ret[] = $tmpObj;
			}
			return $ret;
		}
		
		function fillVirgoTitles() {
//			$results = $this->selectAllAsObjects();
//			foreach ($results as $result) {
//				$title = ...getEscaped($result->getVirgoTitle());
//				$id = $result->getId();
//				$query = " UPDATE prt_portlet_parameters SET ppr_virgo_title = '$title' WHERE ppr_id = $id";
//				if (!mysqli_query($query)) {
//					JError::raiseWarning( 0, "FILL VIRGO TITLES: " . mysqli_error() . " QUERY: " . $query);
//				}
//			}
		}
		static function getByNameStatic($token) {
			$tmpStatic = new virgoPortletParameter();
			$tmpId = $tmpStatic->getIdByName($token);
			$tmpStatic->load($tmpId);
			return $tmpStatic;
		}
		
		static function getIdByNameStatic($token) {
			$tmpStatic = new virgoPortletParameter();
			return $tmpStatic->getIdByName($token);
		}
		
		function getIdByName($token) {
			$res = $this->selectAll(" ppr_name = ?", "", "s", array($token));
			foreach ($res as $r) {
				return $r['ppr_id'];
			}
			return null;
		}
		static function getIdByVirgoTitleStatic($token) {
			$tmpStatic = new virgoPortletParameter();
			return $tmpStatic->getIdByVirgoTitle($token);
		}
		
		function getIdByVirgoTitle($token) {
			$res = $this->selectAll(" ppr_virgo_title = '" . $token . "'");
			foreach ($res as $r) {
				return $r['ppr_id'];
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
			virgoPortletParameter::setSessionValue($namespace, $name, $default);
			return $default;
		}
		
		static function setRemoteSessionValue($name, $value, $menuItem) {
			virgoPortletParameter::setSessionValue('Portal_PortletParameter-' . $menuItem, $name, $value);
		}
		
		static function getRemoteSessionValue($name, $default, $menuItem) {
			return virgoPortletParameter::getSessionValue('Portal_PortletParameter-' . $menuItem, $name, $default);
		}
		
		static function setLocalSessionValue($name, $value) {
			virgoPortletParameter::setRemoteSessionValue($name, $value, $_SESSION['current_portlet_object_id']);
		}
		
		static function getLocalSessionValue($name, $default) {
			return virgoPortletParameter::getRemoteSessionValue($name, $default, $_SESSION['current_portlet_object_id']);
		}

		private static function setGlobalSessionValue($name, $value) {
			virgoPortletParameter::setSessionValue('GLOBAL', $name, $value);
		}
		
		private static function getGlobalSessionValue($name, $default) {
			return virgoPortletParameter::getSessionValue('GLOBAL', $name, $default);
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
			$context['ppr_id'] = $id;
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
			$context['ppr_id'] = null;
			virgoPortletParameter::setGlobalSessionValue('VIRGO_CONTEXT_usuniete', $context);
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
			virgoPortletParameter::setLocalSessionValue('VIRGO_RECORD_SET', $criteria);
		}
		
		static function getRecordSet() {
			return virgoPortletParameter::getLocalSessionValue('VIRGO_RECORD_SET', array());
		}		
		
		static function setInvalidRecords($invalidRecords) {
			virgoPortletParameter::setLocalSessionValue('VIRGO_INVALID_RECORDS', $invalidRecords);
		}
		
		static function getInvalidRecords() {
			return virgoPortletParameter::getLocalSessionValue('VIRGO_INVALID_RECORDS', array());
		}
		
		static function setCriteria($criteria) {
			virgoPortletParameter::setLocalSessionValue('VIRGO_CRITERIA', $criteria);
		}
		
		static function getCriteria() {
			if (P('filter_entity_pob_id', '') == '') {
				return virgoPortletParameter::getLocalSessionValue('VIRGO_CRITERIA', null);
			} else {
				$filterPobId = P('filter_entity_pob_id', '');
				return virgoPortletParameter::getRemoteSessionValue('VIRGO_CRITERIA', null, $filterPobId); 
			}
		}		

		static function setDisplayMode($mode) {
			virgoPortletParameter::setLocalSessionValue('DisplayMode', $mode);
		}

		static function setRemoteDisplayMode($mode, $menuItem) { 
			virgoPortletParameter::setRemoteSessionValue('DisplayMode', $mode, $menuItem);
		}
		
		static function setContextId($id, $verifyToken = true, $pobId = null) {
			if ($verifyToken && isset($id)) {
				if (!A($id)) {
					L('Access denied', '', 'ERROR');
					return;
				}
			}
			virgoPortletParameter::setRemoteContextId($id, (isset($pobId) ? $pobId : $_SESSION['current_portlet_object_id']));
		}
		
		static function getContextId() {
			return virgoPortletParameter::getRemoteContextId($_SESSION['current_portlet_object_id']);
		}
		
		static function getRemoteContextId($menuItem) {
			return virgoPortletParameter::getRemoteSessionValue('ContextId', null, $menuItem);
		}
		
		static function clearRemoteContextId($menuItem) {
			virgoPortletParameter::setRemoteContextId(null, $menuItem);
		}
		
		static function setRemoteContextId($contextId, $menuItem) {
			virgoPortletParameter::setRemoteSessionValue('ContextId', $contextId, $menuItem);
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
				return virgoPortletParameter::getLocalSessionValue('DisplayMode', $defaultMode);
			}
		}
		
		static function setOrderColumn($column) {
			virgoPortletParameter::setLocalSessionValue('OrderColumn', $column);
		}

		static function getOrderColumn() {
			$componentParams = null; 
			$defaultOrderColumn = P('default_sort_column');
			if (is_null($defaultOrderColumn) || trim($defaultOrderColumn) == "") {
				$defaultOrderColumn = "ppr_id";
			}
			return virgoPortletParameter::getLocalSessionValue('OrderColumn', $defaultOrderColumn); 
		}		

		static function setOrderMode($mode) {
			virgoPortletParameter::setLocalSessionValue('OrderMode', $mode);
		}

		static function getOrderMode() {
			$componentParams = null; 
			$defaultOrderMode = P('default_sort_mode');
			if (is_null($defaultOrderMode) || trim($defaultOrderMode) == "") {
				$defaultOrderMode = "asc";
			}
			return virgoPortletParameter::getLocalSessionValue('OrderMode', $defaultOrderMode);
		}
		
		static function setShowRows($rows) {
			virgoPortletParameter::setLocalSessionValue('ShowRows', $rows);
		}

		static function getShowRows() {
/*			$systemParameter = new virgoSystemParameter();
			$paramValue = $systemParameter->getValueByName("DEFAULT_PAGE_SIZE");
			if (is_null($paramValue) || trim($paramValue) == "" || ((int)$paramValue) == 0) {
				$paramValue = 20;
			}*/
			$componentParams = null; 
			$paramValue = P('default_page_size', "20");			
			return virgoPortletParameter::getLocalSessionValue('ShowRows', $paramValue); 
		}
		
		static function setRemoteShowPage($param, $menuId) {
			virgoPortletParameter::setRemoteSessionValue('ShowPage', $param, $menuId);
		}

		static function getRemoteShowPage($menuId) {
			return virgoPortletParameter::getRemoteSessionValue('ShowPage', 1, $menuId); 
		}
		
		static function setShowPage($param) {
			virgoPortletParameter::setLocalSessionValue('ShowPage', $param);
		}

		static function getShowPage() {
			return virgoPortletParameter::getLocalSessionValue('ShowPage', 1); 
		}

		static function setRemoteImportFieldSeparator($param, $menuId) {
			virgoPortletParameter::setRemoteSessionValue('ImportFieldSeparator', $param, $menuId);
		}

		static function getRemoteImportFieldSeparator($menuId) {
			return virgoPortletParameter::getRemoteSessionValue('ImportFieldSeparator', null, $menuId); 
		}
		
		static function setImportFieldSeparator($param) {
			virgoPortletParameter::setLocalSessionValue('ImportFieldSeparator', $param);
		}

		static function getImportFieldSeparator() {
			return virgoPortletParameter::getLocalSessionValue('ImportFieldSeparator', null); 
		}
				
		function internalActionStore($closeForm, $showOKMessage = true, $showError = true) {
			$permissionToCheck = "";
			$creating = false;
			if ($this->ppr_id) {
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
						L(T('STORED_CORRECTLY', 'PORTLET_PARAMETER'), '', 'INFO');
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
						$fieldValues = $fieldValues . T($fieldValue, 'name', $this->ppr_name);
						$fieldValues = $fieldValues . T($fieldValue, 'value', $this->ppr_value);
						$parentPortletObject = new virgoPortletObject();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet object', $parentPortletObject->lookup($this->ppr_pob_id));
						$parentPortletDefinition = new virgoPortletDefinition();
						$fieldValues = $fieldValues . T($fieldValue, 'portlet definition', $parentPortletDefinition->lookup($this->ppr_pdf_id));
						$parentPortal = new virgoPortal();
						$fieldValues = $fieldValues . T($fieldValue, 'portal', $parentPortal->lookup($this->ppr_prt_id));
						$parentTemplate = new virgoTemplate();
						$fieldValues = $fieldValues . T($fieldValue, 'template', $parentTemplate->lookup($this->ppr_tmp_id));
						$username = '';
						if ($this->ppr_usr_created_id == 0) {
							$username = "anonymous";
						} else {
							$createdByUser =& JUser::getInstance((int)$this->ppr_usr_created_id);
							$username = $createdByUser->username;
						}						
						$fieldValues = $fieldValues . T($fieldValue, 'User created', $username);
						$fieldValues = $fieldValues . T($fieldValue, 'Creation date', $this->ppr_date_created);
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
			$instance = new virgoPortletParameter();
			$instance->loadFromRequest();
			$oldId = $instance->getId();
			if ($oldId == "") {
				$oldId = null;
			}
			if (is_null($oldId)) {
				if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletParameter'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
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
			$tmpId = intval(R('ppr_id_' . $_SESSION['current_portlet_object_id']));
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
			return virgoPortletParameter::getContextId();
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
			$this->ppr_id = null;
			$this->ppr_date_created = null;
			$this->ppr_usr_created_id = null;
			$this->ppr_date_modified = null;
			$this->ppr_usr_modified_id = null;
			$this->ppr_virgo_title = null;
			
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
		static function portletActionShowForPortletDefinition() {
			$parentId = R('pdf_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortletDefinition($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForPortal() {
			$parentId = R('prt_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoPortal($parentId);
				$parent->setRemoteContextId($parentId, $menuItem);
				self::setShowPage(1);
			}
			self::setDisplayMode("TABLE");
			return 0;
		}
		static function portletActionShowForTemplate() {
			$parentId = R('tmp_id');
			$menuItem = R('virgo_menu_item');
			if (!is_null($parentId) && trim($parentId) != "") {
				$parent = new virgoTemplate($parentId);
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
//			$ret = new virgoPortletParameter();
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
				$instance = new virgoPortletParameter();
				$instance->loadFromDB();
				$res = $instance->delete();
				if ($res == "") {
					$masterEntityPobId = P('master_entity_pob_id', '');
					if ($masterEntityPobId == "") { 						self::setDisplayMode("TABLE");
						virgoPortletParameter::setRemoteContextId(null, $masterEntityPobId);
					}				
					L(T('DELETED_CORRECTLY', 'PORTLET_PARAMETER'), '', 'INFO');
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
				$resultPortletParameter = new virgoPortletParameter();
				if (isset($idsToCorrect[$idToEdit])) {
					$resultPortletParameter->loadRecordFromRequest($idToEdit);
				} else {
					$idToEditInt = (int)trim($idToEdit);
					if ($idToEditInt != 0) {
						$resultPortletParameter->load($idToEditInt);
					} else {
						$resultPortletParameter->ppr_id = 0;
					}
				}
				$results[] = $resultPortletParameter;
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
				$result = new virgoPortletParameter();
				$result->loadFromRequest($idToStore);
				if ($result->ppr_id != 0 || strtoupper($validateNew) == "Y") {
					if ($result->ppr_id == 0) {
						$result->ppr_id = null;
					}
					$errorMessage = $result->internalActionStore(false, false);				
					if ($errorMessage != "") {
						$errors = $errors + 1;
						if (is_null($result->ppr_id)) {
							$result->ppr_id = 0;
						}
						$idsToCorrect[$result->ppr_id] = $errorMessage;
					}
				}
			}
			if ($errors == 0) {
				if (sizeof($idsToStore) > 1 || strtoupper($validateNew) == "Y") {
					L(T('STORED_CORRECTLY', 'PORTLET_PARAMETERS'), '', 'INFO');
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
			$resultPortletParameter = new virgoPortletParameter();
			foreach ($idsToDelete as $idToDelete) {
				$resultPortletParameter->load((int)trim($idToDelete));
				$res = $resultPortletParameter->delete();
				if (!is_null($res) && trim($res) != "") {
					L($res, '', 'ERROR');
					$errorOcurred = 1;
				}
			}
			if ($errorOcurred == 0) {
				L(T('DELETED_CORRECTLY', 'PORTLET_PARAMETERS'), '', 'INFO');			
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
		$ret = $this->ppr_name;
		$len = strlen($ret);
		if ($len > 30) {
			$ret = substr($ret, 0, 20) . "... (" . $len . ") " . substr($ret, $len - 7, 7);
		}
		return $ret;
		}

		function getVirgoTitle() {
			$componentParams = null;
			$paramTitleSource = PD('title_value', 'virgoPortletParameter');
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
    			$ret["beforeStore/portlet_parameter.php"] = "<b>2012-10-05</b> <span style='font-size: 0.78em;'>14:11:09</span>";
			return $ret;
		}
		
		function updateTitle() {
			$val = $this->getVirgoTitle(); 
			if (!is_null($val) && trim($val) != "") {
				$query = "UPDATE prt_portlet_parameters SET ppr_virgo_title = ? WHERE ppr_id = " . $this->getId();
				Q($query, false, true, "s", array($val));
			}
		}
		
		static function portletActionUpdateTitle() {
			$query = "SELECT ppr_id AS id FROM prt_portlet_parameters ";
	$rows = QR($query);
			foreach ($rows as $row) {
				$tmp = new virgoPortletParameter($row['id']);
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
				$class2prefix["portal\\virgoPortletDefinition"] = "pdf";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoPortletDefinition"] = $class2prefix2;
				$class2prefix["portal\\virgoPortal"] = "prt";
				$class2prefix2 = array();
				$class2prefix2["portal\\virgoTemplate"] = "tmp";
				$class2parentPrefix["portal\\virgoPortal"] = $class2prefix2;
				$class2prefix["portal\\virgoTemplate"] = "tmp";
				$class2prefix2 = array();
				$class2parentPrefix["portal\\virgoTemplate"] = $class2prefix2;
				$whenNoParentSelected = P("when_no_parent_selected", "E");			
				foreach ($parentPobIds as $parentPobId) {
					$grandparentAdded = false;				
					$parentInfo = self::getEntityInfoByPobId($parentPobId, $class2prefix);
					if (isset($parentInfo['value'])) {
						$parentInfo['condition'] = 'prt_portlet_parameters.ppr_' . $parentInfo['prefix'] . '_id = ' . $parentInfo['contextId'];
					} else {
						if ($whenNoParentSelected == "C") {
							$parentInfo['condition'] = 'prt_portlet_parameters.ppr_' . $parentInfo['prefix'] . '_id IS NULL';
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
										$grandparentInfo['condition'] = 'prt_portlet_parameters.ppr_' . $parentInfo['prefix'] . '_id IN (SELECT ' . $parentInfo['prefix'] . '_id FROM prt_' . $tmp->getPlural() . ' WHERE ' . $parentInfo['prefix'] . '_' . $grandparentInfo['prefix'] . '_id = ' . $grandparentInfo['contextId'] . ') ';
									} else {
										$grandparentInfo['condition'] = ' 1 ';
									}
									$grandparentAdded = true;
									$ret[$grandparentInfo['className']] = $grandparentInfo;
									break;
								}
							}
							if (!$grandparentAdded) {
								$parentInfo['condition'] = 'prt_portlet_parameters.ppr_' . $parentInfo['prefix'] . '_id IS NULL';
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
				L('Zle skonfigurowany komponent: jego rodzicem jest niby portlet o ID ' . $parentPobId . ' ale on pokazuje klase ' . $className . ', ktora NIE JEST rodzicem klasy virgoPortletParameter!', '', 'ERROR');
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
			$pdf->SetTitle('Portlet parameters report');
			$pdf->SetSubject(null);
			$pdf->SetKeywords(null);
			$pdf->setImageScale(1);

			$pob = self::getMyPortletObject();
			$reportTitle = $pob->getCustomTitle();
			if (is_null($reportTitle)) {
				$reportTitle = T('PORTLET_PARAMETERS');
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
			if (P('show_pdf_value', "0") != "0") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_portal', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			if (P('show_pdf_template', "1") == "1") {
				$columnsNumber = $columnsNumber + 1;
			}
			$colNr = $columnsNumber;
			$colHeight = 5;
			$maxWidth = (int)P('pdf_max_column_width', '70');
			$minWidth = array();
			$resultPortletParameter = new virgoPortletParameter();
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
			if (P('show_pdf_value', "0") != "0") {
				$titleWords = preg_split("/[ ]+/", 'Value');
				$minWidth['value'] = 6;
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['value']) {
						$minWidth['value'] = min($tmpLen, $maxWidth);
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
			if (P('show_pdf_portlet_definition', "1") == "1") {
				$minWidth['portlet definition $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portlet definition $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portlet definition $relation.name']) {
						$minWidth['portlet definition $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_portal', "1") == "1") {
				$minWidth['portal $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'portal $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['portal $relation.name']) {
						$minWidth['portal $relation.name'] = min($tmpLen, $maxWidth);
					}
				}
			}
			if (P('show_pdf_template', "1") == "1") {
				$minWidth['template $relation.name'] = 6; 
				$titleWords = preg_split("/[ ]+/", 'template $relation.name');
				foreach ($titleWords as $titleWord) {
					$tmpLen = $pdf->GetStringWidth($titleWord) + 6;
					if ($tmpLen > $minWidth['template $relation.name']) {
						$minWidth['template $relation.name'] = min($tmpLen, $maxWidth);
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
			$whereClausePortletParameter = " 1 = 1 ";				
		$parentContextInfos = self::getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
			$whereClausePortletParameter = $whereClausePortletParameter . ' AND ' . $parentContextInfo['condition'];
			$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
			$pdf->MultiCell(30, 100, $parentContextInfo['name'] . ":", '', 'R', 0, 0);
			$pdf->SetFont($font, '', $fontSize + 2);
			$pdf->MultiCell(0, 1, $parentContextInfo['value'], '', 'L', 0, 0);
			$pdf->Ln();			
		}
		$pdf->Ln();
			$criteriaPortletParameter = $resultPortletParameter->getCriteria();
			$fieldCriteriaName = $criteriaPortletParameter["name"];
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
			$fieldCriteriaValue = $criteriaPortletParameter["value"];
			if ($fieldCriteriaValue["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Value', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
				$dataTypeCriteria = $fieldCriteriaValue["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Value', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, $renderCriteria, '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletParameter["portlet_object"];
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
			$parentCriteria = $criteriaPortletParameter["portlet_definition"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portlet definition', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortletDefinition::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portlet definition', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletParameter["portal"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Portal', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoPortal::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Portal', '', 'R', 0, 0);
					$pdf->SetFont($font, '', $fontSize + 2);
					$pdf->MultiCell(0, 1, implode(", ", $parentLookups), '', 'L', 0, 0);
					$pdf->Ln();
				}
			}
			$parentCriteria = $criteriaPortletParameter["template"];
			if ($parentCriteria["is_null"] == 1) {
				$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
				$pdf->MultiCell(60, 100, 'Template', '', 'R', 0, 0);
				$pdf->SetFont($font, '', $fontSize + 2);
				$pdf->MultiCell(0, 1, "$messages.EMPTY_VALUE", '', 'L', 0, 0);
				$pdf->Ln();
			} else {
		  		$parentIds = $parentCriteria["ids"];
				if (!is_null($parentIds) && is_array($parentIds)) {
					$parentLookups = array();
					foreach ($parentIds as $parentId) {
						$parentLookups[] = virgoTemplate::lookup($parentId);
					}
					$pdf->SetFont($font, $fontBoldVariant, $fontSize + 2);
					$pdf->MultiCell(60, 100, 'Template', '', 'R', 0, 0);
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
					$inCondition = " prt_portlet_parameters.ppr_pob_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_pob_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portlet_definition');
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
					$inCondition = " prt_portlet_parameters.ppr_pdf_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_pdf_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_portal');
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
					$inCondition = " prt_portlet_parameters.ppr_prt_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_prt_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$includeNulls = false;
			$includeIns = true;
			$limit = P('limit_to_template');
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
					$inCondition = " prt_portlet_parameters.ppr_tmp_id IN (" . $limit . ") ";
				} else {
					$inCondition = " 1 ";
				}
				if ($includeNulls) {
					if ($inCondition == "") {
						$nullCondition = "";
					} else {
						$nullCondition = " OR ";
					}
					$nullCondition = $nullCondition . " prt_portlet_parameters.ppr_tmp_id IS NULL";
				} else {
					$nullCondition = " OR 0 "; 				}
				$whereClausePortletParameter = $whereClausePortletParameter . " AND ({$inCondition} {$nullCondition} )";
			}
			$filter = "";
			$criteriaPortletParameter = self::getCriteria();
			if (isset($criteriaPortletParameter["name"])) {
				$fieldCriteriaName = $criteriaPortletParameter["name"];
				if ($fieldCriteriaName["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_name IS NOT NULL ';
				} elseif ($fieldCriteriaName["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_name IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_parameters.ppr_name like ? ";
				$types .= "s";
				$values[] = $condition;
			}
				}
			}
			if (isset($criteriaPortletParameter["value"])) {
				$fieldCriteriaValue = $criteriaPortletParameter["value"];
				if ($fieldCriteriaValue["is_null"] == 1) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_value IS NOT NULL ';
				} elseif ($fieldCriteriaValue["is_null"] == 2) {
$filter = $filter . ' AND prt_portlet_parameters.ppr_value IS NULL ';
				} else {
					$dataTypeCriteria = $fieldCriteriaValue["value"];
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$filter = $filter . " AND prt_portlet_parameters.ppr_value like ? ";
				$types .= "s";
				$values[] = $condition;				
			}
				}
			}
			if (isset($criteriaPortletParameter["portlet_object"])) {
				$parentCriteria = $criteriaPortletParameter["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_pob_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_pob_id IN (SELECT pob_id FROM prt_portlet_objects WHERE pob_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["portlet_definition"])) {
				$parentCriteria = $criteriaPortletParameter["portlet_definition"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_pdf_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_pdf_id IN (SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["portal"])) {
				$parentCriteria = $criteriaPortletParameter["portal"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_prt_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_prt_id IN (SELECT prt_id FROM prt_portals WHERE prt_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			if (isset($criteriaPortletParameter["template"])) {
				$parentCriteria = $criteriaPortletParameter["template"];
				if ($parentCriteria["is_null"] == 1) {
					$filter = $filter . " AND ppr_tmp_id IS NULL ";
				} else {
					if (isset($parentCriteria["value"]) && trim($parentCriteria["value"]) != "") {
				  		$parent = $parentCriteria["value"];
						$filter = $filter . " AND prt_portlet_parameters.ppr_tmp_id IN (SELECT tmp_id FROM prt_templates WHERE tmp_virgo_title LIKE ?) ";
						$types .= "s";
						$values[] = $parent;
					}
				}
			}
			$whereClausePortletParameter = $whereClausePortletParameter . " " . $filter . " ";
			$customSQL = P('custom_sql_condition');
			$currentUser = virgoUser::getUser();
			$currentPage = virgoPage::getCurrentPage();
			if (isset($customSQL) && trim($customSQL) != '') {
				$user = virgoUser::getUser();
				eval("\$customSQL = \"$customSQL\";");
				$whereClausePortletParameter = $whereClausePortletParameter . " AND " . $customSQL . " ";
			}
			$queryString = " SELECT prt_portlet_parameters.ppr_id, prt_portlet_parameters.ppr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_pdf_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_name ppr_name";
			} else {
				if ($defaultOrderColumn == "ppr_name") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_name ";
				}
			}
			if (P('show_pdf_value', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_value ppr_value";
			} else {
				if ($defaultOrderColumn == "ppr_value") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_value ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_pdf_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pob_id as ppr_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_pdf_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pdf_id as ppr_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_pdf_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_prt_id as ppr_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_pdf_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_tmp_id as ppr_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_parameters ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_parameters.ppr_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_parameters.ppr_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_parameters.ppr_prt_id = prt_portals_parent.prt_id) ";
			}
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portlet_parameters.ppr_tmp_id = prt_templates_parent.tmp_id) ";
			}

		$resultsPortletParameter = $resultPortletParameter->select(
			'', 
			'all', 
			$resultPortletParameter->getOrderColumn(), 
			$resultPortletParameter->getOrderMode(), 
			$whereClausePortletParameter,
			$queryString);
		
		foreach ($resultsPortletParameter as $resultPortletParameter) {

			if (P('show_pdf_name', "1") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletParameter['ppr_name'])) + 6;
				if ($tmpLen > $minWidth['name']) {
					$minWidth['name'] = min($tmpLen, $maxWidth);
				}
			}

			if (P('show_pdf_value', "0") != "0") {
			$tmpLen = $pdf->GetStringWidth(trim('' . $resultPortletParameter['ppr_value'])) + 6;
				if ($tmpLen > $minWidth['value']) {
					$minWidth['value'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = trim(virgoPortletObject::lookup($resultPortletParameter['pprpob__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet object $relation.name']) {
					$minWidth['portlet object $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
			$parentValue = trim(virgoPortletDefinition::lookup($resultPortletParameter['pprpdf__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portlet definition $relation.name']) {
					$minWidth['portlet definition $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = trim(virgoPortal::lookup($resultPortletParameter['pprprt__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['portal $relation.name']) {
					$minWidth['portal $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = trim(virgoTemplate::lookup($resultPortletParameter['pprtmp__id']));
			$tmpLen = $pdf->GetStringWidth(trim($parentValue)) + 6;
				if ($tmpLen > $minWidth['template $relation.name']) {
					$minWidth['template $relation.name'] = min($tmpLen, $maxWidth);
				}
			}
		}
		$maxLn = 1;
//		$criteriaPortletParameter = $resultPortletParameter->getCriteria();
		if (is_null($criteriaPortletParameter) || sizeof($criteriaPortletParameter) == 0 || $countTmp == 0) {
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
			if (P('show_pdf_portlet_definition', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portlet definition $relation.name'], $colHeight, T('PORTLET_DEFINITION') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_portal', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['portal $relation.name'], $colHeight, T('PORTAL') . ' ' . T(''), 'T', 'C', 0, 0); 
		if ($tmpLn > $maxLn) {
			$maxLn = $tmpLn;
		}
			}
			if (P('show_pdf_template', "1") == "1") {
		$tmpLn = $pdf->MultiCell($minWidth['template $relation.name'], $colHeight, T('TEMPLATE') . ' ' . T(''), 'T', 'C', 0, 0); 
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
			if (P('show_pdf_value', "0") != "0") {
		$tmpLn = $pdf->MultiCell($minWidth['value'], $colHeight, T('VALUE'), 'T', 'C', 0, 0);
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
		foreach ($resultsPortletParameter as $resultPortletParameter) {
			$maxLn = 1;
			$pdf->Cell(1, $colHeight, ''); //, 0, 1);
			if (P('show_pdf_portlet_object', "1") == "1") {
			$parentValue = virgoPortletObject::lookup($resultPortletParameter['ppr_pob_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet object $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_portlet_definition', "1") == "1") {
			$parentValue = virgoPortletDefinition::lookup($resultPortletParameter['ppr_pdf_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portlet definition $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_portal', "1") == "1") {
			$parentValue = virgoPortal::lookup($resultPortletParameter['ppr_prt_id']);
			$tmpLn = $pdf->MultiCell($minWidth['portal $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_template', "1") == "1") {
			$parentValue = virgoTemplate::lookup($resultPortletParameter['ppr_tmp_id']);
			$tmpLn = $pdf->MultiCell($minWidth['template $relation.name'], $colHeight, trim($parentValue), 'T', 'L', 0, 0); 
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}
			}
			if (P('show_pdf_name', "1") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['name'], $colHeight, '' . $resultPortletParameter['ppr_name'], 'T', 'L', 0, 0);
				if (P('show_pdf_name', "1") == "2") {
										if (!is_null($resultPortletParameter['ppr_name'])) {
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
										if (!is_null($resultPortletParameter['ppr_name'])) {
						$tmpSum = (float)$sums["name"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletParameter['ppr_name'];
						}
						$sums["name"] = $tmpSum;
					}
				}
				if (P('show_pdf_name', "1") == "4") {
										if (!is_null($resultPortletParameter['ppr_name'])) {
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
							$tmpSum = $tmpSum + $resultPortletParameter['ppr_name'];
						}
						$avgSums["name"] = $tmpSum;
					}
				}
			}
			if ($tmpLn > $maxLn) {
				$maxLn = $tmpLn;
			}			
			if (P('show_pdf_value', "0") != "0") {
			$tmpLn = $pdf->MultiCell($minWidth['value'], $colHeight, '' . $resultPortletParameter['ppr_value'], 'T', 'L', 0, 0);
				if (P('show_pdf_value', "1") == "2") {
										if (!is_null($resultPortletParameter['ppr_value'])) {
						$tmpCount = (float)$counts["value"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$counts["value"] = $tmpCount;
					}
				}
				if (P('show_pdf_value', "1") == "3") {
										if (!is_null($resultPortletParameter['ppr_value'])) {
						$tmpSum = (float)$sums["value"];
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletParameter['ppr_value'];
						}
						$sums["value"] = $tmpSum;
					}
				}
				if (P('show_pdf_value', "1") == "4") {
										if (!is_null($resultPortletParameter['ppr_value'])) {
						$tmpCount = (float)$avgCounts["value"];
						$tmpSum = (float)$avgSums["value"];
						if (is_null($tmpCount)) {
							$tmpCount = 1;
						} else {
							$tmpCount++;
						}
						$avgCounts["value"] = $tmpCount;
						if (is_null($tmpSum)) {
							$tmpSum = 0;
						} else {
							$tmpSum = $tmpSum + $resultPortletParameter['ppr_value'];
						}
						$avgSums["value"] = $tmpSum;
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
			if (P('show_pdf_value', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['value'];
				if (P('show_pdf_value', "1") == "2") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('COUNT') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . $counts["value"];
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
			if (P('show_pdf_value', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['value'];
				if (P('show_pdf_value', "1") == "3") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('SUM') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . number_format($sums["value"], 2, ',', ' ');
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
			if (P('show_pdf_value', "0") != "0") {
				$aggrVal = '';
				$tmpWidth = $tmpWidth + $minWidth['value'];
				if (P('show_pdf_value', "1") == "4") {
					if (!$labelDone) {
						$aggrVal = $aggrVal . T('AVERAGE') . ": ";
						$labelDone = true;
					}
					$aggrVal = $aggrVal . ($avgCounts["value"] == 0 ? "-" : $avgSums["value"] / $avgCounts["value"]);
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
				$reportTitle = T('PORTLET_PARAMETERS');
			}
			$reportTitle = $reportTitle . ".csv";
			$separator = P('export_separator', ",");
			$stringDelimeter = P('export_string_delimeter', "\"");
			$resultPortletParameter = new virgoPortletParameter();
			$whereClausePortletParameter = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletParameter = $whereClausePortletParameter . ' AND ' . $parentContextInfo['condition'];
			}
				if (P('show_export_name', "1") != "0") {
					$data = $data . $stringDelimeter .'Name' . $stringDelimeter . $separator;
				}
				if (P('show_export_value', "1") != "0") {
					$data = $data . $stringDelimeter .'Value' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet object ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_definition', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portlet definition ' . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$data = $data . $stringDelimeter . 'Portal ' . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$data = $data . $stringDelimeter . 'Template ' . $stringDelimeter . $separator;
				}
			$data = $data . "\n";
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_parameters.ppr_id, prt_portlet_parameters.ppr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_name ppr_name";
			} else {
				if ($defaultOrderColumn == "ppr_name") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_name ";
				}
			}
			if (P('show_export_value', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_value ppr_value";
			} else {
				if ($defaultOrderColumn == "ppr_value") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_value ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pob_id as ppr_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_export_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pdf_id as ppr_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_prt_id as ppr_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_tmp_id as ppr_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_parameters ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_parameters.ppr_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_parameters.ppr_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_parameters.ppr_prt_id = prt_portals_parent.prt_id) ";
			}
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portlet_parameters.ppr_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$resultsPortletParameter = $resultPortletParameter->select(
				'', 
				'all', 
				$resultPortletParameter->getOrderColumn(), 
				$resultPortletParameter->getOrderMode(), 
				$whereClausePortletParameter,
				$queryString);
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				if (P('show_export_name', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletParameter['ppr_name'] . $stringDelimeter . $separator;
				}
				if (P('show_export_value', "1") != "0") {
			$data = $data . $stringDelimeter . $resultPortletParameter['ppr_value'] . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_object', "1") != "0") {
					$parentValue = virgoPortletObject::lookup($resultPortletParameter['ppr_pob_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portlet_definition', "1") != "0") {
					$parentValue = virgoPortletDefinition::lookup($resultPortletParameter['ppr_pdf_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_portal', "1") != "0") {
					$parentValue = virgoPortal::lookup($resultPortletParameter['ppr_prt_id']);
					$data = $data . $stringDelimeter . $parentValue . $stringDelimeter . $separator;
				}
				if (P('show_export_template', "1") != "0") {
					$parentValue = virgoTemplate::lookup($resultPortletParameter['ppr_tmp_id']);
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
				$reportTitle = T('PORTLET_PARAMETERS');
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
			$resultPortletParameter = new virgoPortletParameter();
			$whereClausePortletParameter = " 1 = 1 ";
			$parentContextInfos = self::getParentsInContext();
			foreach ($parentContextInfos as $parentContextInfo) {
				$whereClausePortletParameter = $whereClausePortletParameter . ' AND ' . $parentContextInfo['condition'];
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
				if (P('show_export_value', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Value');
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
				if (P('show_export_portlet_definition', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portlet definition ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortletDefinition::getVirgoList();
					$formulaPortletDefinition = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortletDefinition != "") {
							$formulaPortletDefinition = $formulaPortletDefinition . ',';
						}
						$formulaPortletDefinition = $formulaPortletDefinition . $key;
					}
				}
				if (P('show_export_portal', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Portal ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoPortal::getVirgoList();
					$formulaPortal = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaPortal != "") {
							$formulaPortal = $formulaPortal . ',';
						}
						$formulaPortal = $formulaPortal . $key;
					}
				}
				if (P('show_export_template', "1") == "1") {
					$kolumna = $kolumna + 1;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($kolumna, 1, 'Template ');
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, 1)->applyFromArray($headerStyle);					
					
					$parentList = virgoTemplate::getVirgoList();
					$formulaTemplate = ""; 
					foreach ($parentList as $id => $key) {
						if ($formulaTemplate != "") {
							$formulaTemplate = $formulaTemplate . ',';
						}
						$formulaTemplate = $formulaTemplate . $key;
					}
				}
			$iloscKolumn = $kolumna;
			$hideColumnFromContextInTable = array();
			$queryString = " SELECT prt_portlet_parameters.ppr_id, prt_portlet_parameters.ppr_virgo_title ";
			$defaultOrderColumn = P('default_sort_column');
			$orderColumnNotDisplayed = "";
			if (P('show_export_name', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_name ppr_name";
			} else {
				if ($defaultOrderColumn == "ppr_name") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_name ";
				}
			}
			if (P('show_export_value', "1") != "0") {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_value ppr_value";
			} else {
				if ($defaultOrderColumn == "ppr_value") {
					$orderColumnNotDisplayed = " prt_portlet_parameters.ppr_value ";
				}
			}
			if (class_exists('portal\virgoPortletObject') && P('show_export_portlet_object', "1") != "0") { // */ && !in_array("pob", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pob_id as ppr_pob_id ";
				$queryString = $queryString . ", prt_portlet_objects_parent.pob_virgo_title as `portlet_object` ";
			} else {
				if ($defaultOrderColumn == "portlet_object") {
					$orderColumnNotDisplayed = " prt_portlet_objects_parent.pob_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortletDefinition') && P('show_export_portlet_definition', "1") != "0") { // */ && !in_array("pdf", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_pdf_id as ppr_pdf_id ";
				$queryString = $queryString . ", prt_portlet_definitions_parent.pdf_virgo_title as `portlet_definition` ";
			} else {
				if ($defaultOrderColumn == "portlet_definition") {
					$orderColumnNotDisplayed = " prt_portlet_definitions_parent.pdf_virgo_title ";
				}
			}
			if (class_exists('portal\virgoPortal') && P('show_export_portal', "1") != "0") { // */ && !in_array("prt", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_prt_id as ppr_prt_id ";
				$queryString = $queryString . ", prt_portals_parent.prt_virgo_title as `portal` ";
			} else {
				if ($defaultOrderColumn == "portal") {
					$orderColumnNotDisplayed = " prt_portals_parent.prt_virgo_title ";
				}
			}
			if (class_exists('portal\virgoTemplate') && P('show_export_template', "1") != "0") { // */ && !in_array("tmp", $hideColumnFromContextInTable)) {
				$queryString = $queryString . ", prt_portlet_parameters.ppr_tmp_id as ppr_tmp_id ";
				$queryString = $queryString . ", prt_templates_parent.tmp_virgo_title as `template` ";
			} else {
				if ($defaultOrderColumn == "template") {
					$orderColumnNotDisplayed = " prt_templates_parent.tmp_virgo_title ";
				}
			}
			if ($orderColumnNotDisplayed != "") {
				$queryString = $queryString . ", " . $orderColumnNotDisplayed;
			}
			$queryString = $queryString . " FROM prt_portlet_parameters ";
			if (class_exists('portal\virgoPortletObject')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_objects AS prt_portlet_objects_parent ON (prt_portlet_parameters.ppr_pob_id = prt_portlet_objects_parent.pob_id) ";
			}
			if (class_exists('portal\virgoPortletDefinition')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portlet_definitions AS prt_portlet_definitions_parent ON (prt_portlet_parameters.ppr_pdf_id = prt_portlet_definitions_parent.pdf_id) ";
			}
			if (class_exists('portal\virgoPortal')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_portals AS prt_portals_parent ON (prt_portlet_parameters.ppr_prt_id = prt_portals_parent.prt_id) ";
			}
			if (class_exists('portal\virgoTemplate')) {
				$queryString = $queryString . " LEFT OUTER JOIN prt_templates AS prt_templates_parent ON (prt_portlet_parameters.ppr_tmp_id = prt_templates_parent.tmp_id) ";
			}

			$resultsPortletParameter = $resultPortletParameter->select(
				'', 
				'all', 
				$resultPortletParameter->getOrderColumn(), 
				$resultPortletParameter->getOrderMode(), 
				$whereClausePortletParameter,
				$queryString);
			$index = 1;
			foreach ($resultsPortletParameter as $resultPortletParameter) {
				$index = $index + 1;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $index, $resultPortletParameter['ppr_id']);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $index)->getFont()->getColor()->applyFromArray(array("rgb" => 'BBBBBB'));
				$kolumna = 0;
				if (P('show_export_name', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletParameter['ppr_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_value', "1") == "1") {
					$kolumna = $kolumna + 1;
			$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($kolumna, $index, $resultPortletParameter['ppr_value'], \PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($kolumna, $index)->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
				}
				if (P('show_export_portlet_object', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletObject::lookup($resultPortletParameter['ppr_pob_id']);
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
				if (P('show_export_portlet_definition', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortletDefinition::lookup($resultPortletParameter['ppr_pdf_id']);
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
					$objValidation->setFormula1('"' . $formulaPortletDefinition . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_portal', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoPortal::lookup($resultPortletParameter['ppr_prt_id']);
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
					$objValidation->setFormula1('"' . $formulaPortal . '"');
					$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($kolumna, $index)->setDataValidation($objValidation);					
				}
				if (P('show_export_template', "1") == "1") {
					$kolumna = $kolumna + 1;
					$parentValue = virgoTemplate::lookup($resultPortletParameter['ppr_tmp_id']);
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
					$objValidation->setFormula1('"' . $formulaTemplate . '"');
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
					$propertyColumnHash['name'] = 'ppr_name';
					$propertyColumnHash['name'] = 'ppr_name';
					$propertyColumnHash['value'] = 'ppr_value';
					$propertyColumnHash['value'] = 'ppr_value';
					$propertyClassHash['portlet object'] = 'PortletObject';
					$propertyClassHash['portlet_object'] = 'PortletObject';
					$propertyColumnHash['portlet object'] = 'ppr_pob_id';
					$propertyColumnHash['portlet_object'] = 'ppr_pob_id';
					$propertyClassHash['portlet definition'] = 'PortletDefinition';
					$propertyClassHash['portlet_definition'] = 'PortletDefinition';
					$propertyColumnHash['portlet definition'] = 'ppr_pdf_id';
					$propertyColumnHash['portlet_definition'] = 'ppr_pdf_id';
					$propertyClassHash['portal'] = 'Portal';
					$propertyClassHash['portal'] = 'Portal';
					$propertyColumnHash['portal'] = 'ppr_prt_id';
					$propertyColumnHash['portal'] = 'ppr_prt_id';
					$propertyClassHash['template'] = 'Template';
					$propertyClassHash['template'] = 'Template';
					$propertyColumnHash['template'] = 'ppr_tmp_id';
					$propertyColumnHash['template'] = 'ppr_tmp_id';
					$importMode = P('import_mode', 'T');
					$recordsOK = 0;
					$recordsError = 0;
					while(!feof($fh)) {
						$importPortletParameter = new virgoPortletParameter();
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
										L(T('PROPERTY_NOT_FOUND', T('PORTLET_PARAMETER'), $columns[$index]), '', 'ERROR');
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
										$importPortletParameter->$fieldName = $value;
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
	$importPortletParameter->setPobId($defaultValue);
}
$defaultValue = P('import_default_value_portlet_definition');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortletDefinition::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortletDefinition::token2Id($tmpToken);
	}
	$importPortletParameter->setPdfId($defaultValue);
}
$defaultValue = P('import_default_value_portal');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoPortal::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoPortal::token2Id($tmpToken);
	}
	$importPortletParameter->setPrtId($defaultValue);
}
$defaultValue = P('import_default_value_template');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoTemplate::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoTemplate::token2Id($tmpToken);
	}
	$importPortletParameter->setTmpId($defaultValue);
}
							$errorMessage = $importPortletParameter->store();
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
		




		static function portletActionVirgoSetPortletObject() {
			$this->loadFromDB();
			$parentId = R('ppr_PortletObject_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPobId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortletDefinition() {
			$this->loadFromDB();
			$parentId = R('ppr_PortletDefinition_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPdfId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetPortal() {
			$this->loadFromDB();
			$parentId = R('ppr_Portal_id_' . $_SESSION['current_portlet_object_id']);
			$this->setPrtId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
			}
		}
		static function portletActionVirgoSetTemplate() {
			$this->loadFromDB();
			$parentId = R('ppr_Template_id_' . $_SESSION['current_portlet_object_id']);
			$this->setTmpId($parentId);
			$ret = $this->store();
			if ($ret == "") {
				return 0;
			} else {
				return -1;
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
CREATE TABLE IF NOT EXISTS `prt_portlet_parameters` (
  `ppr_id` bigint(20) unsigned NOT NULL auto_increment,
  `ppr_virgo_state` varchar(50) default NULL,
  `ppr_virgo_title` varchar(255) default NULL,
	`ppr_pob_id` int(11) default NULL,
	`ppr_pdf_id` int(11) default NULL,
	`ppr_prt_id` int(11) default NULL,
	`ppr_tmp_id` int(11) default NULL,
  `ppr_name` varchar(255), 
  `ppr_value` longtext, 
  `ppr_date_created` datetime NOT NULL,
  `ppr_date_modified` datetime default NULL,
  `ppr_usr_created_id` int(11) NOT NULL,
  `ppr_usr_modified_id` int(11) default NULL,
  KEY `ppr_pob_fk` (`ppr_pob_id`),
  KEY `ppr_pdf_fk` (`ppr_pdf_id`),
  KEY `ppr_prt_fk` (`ppr_prt_id`),
  KEY `ppr_tmp_fk` (`ppr_tmp_id`),
  PRIMARY KEY  (`ppr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/* 
	Example row to put in modules_project/initData/portlet_parameter.sql 
INSERT INTO `prt_portlet_parameters` (`ppr_virgo_title`, `ppr_name`, `ppr_value`) 
VALUES (title, some_value, some_value);
*/
SELECT;
			if (!Q($query)) {
				L("Probably prt_portlet_parameters table already exists.", '', 'FATAL');
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
			return "ppr";
		}
		
		static function getPlural() {
			return "portlet_parameters";
		}
		
		static function isDictionary() {
			return false;
		}

		static function getParents() {
			$ret = array();
			$ret[] = "virgoPortletObject";
			$ret[] = "virgoPortletDefinition";
			$ret[] = "virgoPortal";
			$ret[] = "virgoTemplate";
			return $ret;
		}

		static function getChildren() {
		}
		
		static function getVirgoTableType() {
			global $virgoConfig;
			$query = " SELECT table_type FROM information_schema.tables WHERE table_schema = ? AND table_name = ? ";
			$rows = QPR($query, "ss", array($virgoConfig[VIRGO_PORTAL_INSTANCE]['database_name'], 'prt_portlet_parameters'));
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
			$virgoVersion = virgoPortletParameter::getVirgoVersion();
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
	
	

