<?php
	defined( '_INDEX_PORTAL' ) or die( 'Access denied.' );
	if (preg_match("/.*.metadetron.com/i", $_SERVER["SERVER_NAME"])) {
	    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	} 
	ini_set('display_errors', 1);

	use portal\virgoRole;
	use portal\virgoPage;
	use portal\virgoUser;
	use portal\virgoPortletObject;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_portlet_object');
	$underConstruction = false; //$componentParams->get('under_construction');
	$underConstructionAllowedUser = ''; //$componentParams->get('under_construction_allowed_user');
	$context = array();

	if (false) { //$underConstruction == "1" && (is_null($user) || ($user->username != "metaadmin" && $user->username != $underConstructionAllowedUser))) {
?>
		<div style="color: #FF6666; font-size: 2em; margin: 100px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	} else {
		if (false) { //$underConstruction == "1" && !is_null($user) && ($user->username == "metaadmin" || $user->username == $underConstructionAllowedUser)) {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
		}
?>
<?php
?>
<?php
?>
<?php
	$live_site = "localhost";
	if (false) { //$componentParams->get('css_usage') == "virgo" || $componentParams->get('css_usage') == "") {
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_portlet_object/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'prt_pob.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoPortletObject/prt_pob.css" type="text/css" /> 
<?php
	}
?>
<style>

td#component {
    background-color: inherit !important;
    border: inherit !important;
    color: inherit !important;
    padding: inherit !important;
    text-shadow: inherit !important;
    font-size: inherit !important;
  }
</style>
<div class="virgo_container_portal virgo_container_entity_portlet_object" style="border: none;">
	<div class="virgo_scrollable">
<?php
			}
		$tablePrefixes = array();
//		$classNames = array();
		$etityNames = array();		
		$parents = array();
		$tablePrefixes["user"] = "usr";
//		$classNames["user"] = "virgoUser";
		$entityNames["user"] = "User";
		$tmpParents = array();
		$tmpParents[] = "page";
		$parents["user"] = $tmpParents;
		$tablePrefixes["role"] = "rle";
//		$classNames["role"] = "virgoRole";
		$entityNames["role"] = "Role";
		$tmpParents = array();
		$tmpParents[] = "page";
		$parents["role"] = $tmpParents;
		$tablePrefixes["user_role"] = "url";
//		$classNames["user_role"] = "virgoUserRole";
		$entityNames["user_role"] = "UserRole";
		$tmpParents = array();
		$tmpParents[] = "role";
		$tmpParents[] = "user";
		$parents["user_role"] = $tmpParents;
		$tablePrefixes["page"] = "pge";
//		$classNames["page"] = "virgoPage";
		$entityNames["page"] = "Page";
		$tmpParents = array();
		$tmpParents[] = "template";
		$tmpParents[] = "page";
		$tmpParents[] = "portal";
		$parents["page"] = $tmpParents;
		$tablePrefixes["permission"] = "prm";
//		$classNames["permission"] = "virgoPermission";
		$entityNames["permission"] = "Permission";
		$tmpParents = array();
		$tmpParents[] = "role";
		$tmpParents[] = "page";
		$tmpParents[] = "portlet_object";
		$parents["permission"] = $tmpParents;
		$tablePrefixes["template"] = "tmp";
//		$classNames["template"] = "virgoTemplate";
		$entityNames["template"] = "Template";
		$tmpParents = array();
		$parents["template"] = $tmpParents;
		$tablePrefixes["portlet_definition"] = "pdf";
//		$classNames["portlet_definition"] = "virgoPortletDefinition";
		$entityNames["portlet_definition"] = "PortletDefinition";
		$tmpParents = array();
		$parents["portlet_definition"] = $tmpParents;
		$tablePrefixes["portlet_object"] = "pob";
//		$classNames["portlet_object"] = "virgoPortletObject";
		$entityNames["portlet_object"] = "PortletObject";
		$tmpParents = array();
		$tmpParents[] = "portlet_definition";
		$tmpParents[] = "portlet_object";
		$parents["portlet_object"] = $tmpParents;
		$tablePrefixes["portlet_location"] = "plc";
//		$classNames["portlet_location"] = "virgoPortletLocation";
		$entityNames["portlet_location"] = "PortletLocation";
		$tmpParents = array();
		$tmpParents[] = "page";
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "portal";
		$parents["portlet_location"] = $tmpParents;
		$tablePrefixes["html_content"] = "hcn";
//		$classNames["html_content"] = "virgoHtmlContent";
		$entityNames["html_content"] = "HtmlContent";
		$tmpParents = array();
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "language";
		$parents["html_content"] = $tmpParents;
		$tablePrefixes["language"] = "lng";
//		$classNames["language"] = "virgoLanguage";
		$entityNames["language"] = "Language";
		$tmpParents = array();
		$parents["language"] = $tmpParents;
		$tablePrefixes["translation"] = "trn";
//		$classNames["translation"] = "virgoTranslation";
		$entityNames["translation"] = "Translation";
		$tmpParents = array();
		$tmpParents[] = "language";
		$parents["translation"] = $tmpParents;
		$tablePrefixes["log_level"] = "llv";
//		$classNames["log_level"] = "virgoLogLevel";
		$entityNames["log_level"] = "LogLevel";
		$tmpParents = array();
		$parents["log_level"] = $tmpParents;
		$tablePrefixes["log_channel"] = "lch";
//		$classNames["log_channel"] = "virgoLogChannel";
		$entityNames["log_channel"] = "LogChannel";
		$tmpParents = array();
		$parents["log_channel"] = $tmpParents;
		$tablePrefixes["system_message"] = "sms";
//		$classNames["system_message"] = "virgoSystemMessage";
		$entityNames["system_message"] = "SystemMessage";
		$tmpParents = array();
		$tmpParents[] = "user";
		$tmpParents[] = "log_level";
		$tmpParents[] = "execution";
		$parents["system_message"] = $tmpParents;
		$tablePrefixes["channel_level"] = "clv";
//		$classNames["channel_level"] = "virgoChannelLevel";
		$entityNames["channel_level"] = "ChannelLevel";
		$tmpParents = array();
		$tmpParents[] = "log_level";
		$tmpParents[] = "log_channel";
		$parents["channel_level"] = $tmpParents;
		$tablePrefixes["portlet_parameter"] = "ppr";
//		$classNames["portlet_parameter"] = "virgoPortletParameter";
		$entityNames["portlet_parameter"] = "PortletParameter";
		$tmpParents = array();
		$tmpParents[] = "portlet_object";
		$tmpParents[] = "portlet_definition";
		$tmpParents[] = "portal";
		$tmpParents[] = "template";
		$parents["portlet_parameter"] = $tmpParents;
		$tablePrefixes["portal"] = "prt";
//		$classNames["portal"] = "virgoPortal";
		$entityNames["portal"] = "Portal";
		$tmpParents = array();
		$tmpParents[] = "template";
		$parents["portal"] = $tmpParents;
		$tablePrefixes["process"] = "prc";
//		$classNames["process"] = "virgoProcess";
		$entityNames["process"] = "Process";
		$tmpParents = array();
		$parents["process"] = $tmpParents;
		$tablePrefixes["execution"] = "exc";
//		$classNames["execution"] = "virgoExecution";
		$entityNames["execution"] = "Execution";
		$tmpParents = array();
		$tmpParents[] = "process";
		$parents["execution"] = $tmpParents;
		$tablePrefixes["element"] = "elm";
//		$classNames["element"] = "virgoElement";
		$entityNames["element"] = "Element";
		$tmpParents = array();
		$tmpParents[] = "execution";
		$parents["element"] = $tmpParents;
		$tablePrefixes["execution_parameter"] = "epr";
//		$classNames["execution_parameter"] = "virgoExecutionParameter";
		$entityNames["execution_parameter"] = "ExecutionParameter";
		$tmpParents = array();
		$tmpParents[] = "execution";
		$parents["execution_parameter"] = $tmpParents;
		$tablePrefixes["unique_visit"] = "uvs";
//		$classNames["unique_visit"] = "virgoUniqueVisit";
		$entityNames["unique_visit"] = "UniqueVisit";
		$tmpParents = array();
		$parents["unique_visit"] = $tmpParents;
		$ancestors = array();
		$ancestors["portlet_object"] = "TRUE";
		$ancestors["portlet_definition"] = "TRUE";
		$contextId = null;		
			$resultPortletObject = virgoPortletObject::createGuiAware();
			$contextId = $resultPortletObject->getContextId();
			if (isset($contextId)) {
				if (virgoPortletObject::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultPortletObject->load($contextId);
				}
			}
?>
<?php
			if (false) { //$componentParams->get('show_project_name') == "1") {
?>
		<div id="virgo_project">
<?php
  $parentMenu = null; //$menu->getItem($menuItem->parent);
?>
			portal: <?php echo is_null($parentMenu) ? $mainframe->getPageTitle() : $parentMenu->name . " -> " . $mainframe->getPageTitle() ?>
			<span id="virgo_project_version">
				1.5 
			</span>
<!--

-->
<span 
	title="header=[<?php echo JText::_('VERSIONS') ?>]cssheader=[tooltip_header]cssbody=[tooltip_body]body=
[
0.1.2 -
Minor features added
<br>
0.1.1 -
Binary bool added
<br>
0.1.0 -
<b>
beta
</b>
<br>
]">0.1.2</span>
			<span class="virgo_connected_as">
<?php
				if (is_null($user->username)) {
?>
<?php echo T('NOT_LOGGED_IN') ?><?php
				} else {
?>
<?php echo T('LOGGED_IN_AS') ?>					<span class="virgo_username"><?php echo $user->username ?></span>.
<?php
				}
?>
			</span>
		</div>
<?php
			}
	$masterPobId = P('master_entity_pob_id');
	if (isset($masterPobId)) {
		$portletObject = new virgoPortletObject($masterPobId);
		$className = $portletObject->getPortletDefinition()->getAlias();
		if ($className == "virgoPortletObject") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultPortletObject = new virgoPortletObject($tmpId);
				virgoPortletObject::setDisplayMode("FORM");
			} else {
				$resultPortletObject = new virgoPortletObject();
				virgoPortletObject::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultPortletObject->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultPortletObject->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultPortletObject = new virgoPortletObject($allPrivateRecords[0]['pob_id']);
						$resultPortletObject->putInContext(false);
					} else {
						$resultPortletObject = new virgoPortletObject();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultPortletObject->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultPortletObject = new virgoPortletObject($records[0]['pob_id']);
							$resultPortletObject->putInContext(false);
						} else {
							$resultPortletObject = new virgoPortletObject();
						}
					} else {
						$resultPortletObject = new virgoPortletObject();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultPortletObject = new virgoPortletObject(virgoUser::getUserId());
			$resultPortletObject->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultPortletObject = new virgoPortletObject();
		}
?>
<?php
	$portletObjectDisplayMode = virgoPortletObject::getDisplayMode();
//	if ($portletObjectDisplayMode == "" || $portletObjectDisplayMode == "TABLE") {
//		$resultPortletObject = $resultPortletObject->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultPortletObject->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClausePortletObject = $whereClausePortletObject . ' AND ' . $parentContextInfo['condition'];
			if (isset($parentContextInfo['value'])) {
?>		
			<table class="db_context_record">
				<tr>
					<td class="db_context_label">
						<?php echo $parentContextInfo['name'] ?>
					</td>
					<td class="db_context_value">
						<?php echo $parentContextInfo['value'] ?>
					</td>
				</tr>
			</table>
<?php
			}
		}
		if (P('filter_entity_pob_id', '') == '' && P('filter_mode', '0') == '0') {
?>		
<?php
		$criteriaPortletObject = $resultPortletObject->getCriteria();
		$countTmp = 0;
		if (isset($criteriaPortletObject["show_title"])) {
			$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
			if ($fieldCriteriaShowTitle["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["custom_title"])) {
			$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
			if ($fieldCriteriaCustomTitle["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["left"])) {
			$fieldCriteriaLeft = $criteriaPortletObject["left"];
			if ($fieldCriteriaLeft["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaLeft["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["top"])) {
			$fieldCriteriaTop = $criteriaPortletObject["top"];
			if ($fieldCriteriaTop["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaTop["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["width"])) {
			$fieldCriteriaWidth = $criteriaPortletObject["width"];
			if ($fieldCriteriaWidth["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaWidth["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["height"])) {
			$fieldCriteriaHeight = $criteriaPortletObject["height"];
			if ($fieldCriteriaHeight["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaHeight["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["inline"])) {
			$fieldCriteriaInline = $criteriaPortletObject["inline"];
			if ($fieldCriteriaInline["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaInline["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["ajax"])) {
			$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
			if ($fieldCriteriaAjax["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaAjax["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["render_condition"])) {
			$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
			if ($fieldCriteriaRenderCondition["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
				$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["autorefresh"])) {
			$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
			if ($fieldCriteriaAutorefresh["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["portlet_definition"])) {
			$parentCriteria = $criteriaPortletObject["portlet_definition"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["portlet_object"])) {
			$parentCriteria = $criteriaPortletObject["portlet_object"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaPortletObject["page"])) {
			$countTmp = $countTmp + 1;
		}
		if (is_null($criteriaPortletObject) || sizeof($criteriaPortletObject) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaPortletObject["show_title"])) {
				$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
				if ($fieldCriteriaShowTitle["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Show title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaShowTitle["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaShowTitle["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='show_title';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Show title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='show_title';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["custom_title"])) {
				$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
				if ($fieldCriteriaCustomTitle["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Custom title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaCustomTitle["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaCustomTitle["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='custom_title';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Custom title') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='custom_title';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["left"])) {
				$fieldCriteriaLeft = $criteriaPortletObject["left"];
				if ($fieldCriteriaLeft["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Left') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLeft["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLeft["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='left';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaLeft["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Left') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='left';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["top"])) {
				$fieldCriteriaTop = $criteriaPortletObject["top"];
				if ($fieldCriteriaTop["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Top') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaTop["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaTop["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='top';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaTop["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Top') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='top';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["width"])) {
				$fieldCriteriaWidth = $criteriaPortletObject["width"];
				if ($fieldCriteriaWidth["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Width') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaWidth["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaWidth["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='width';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaWidth["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Width') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='width';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["height"])) {
				$fieldCriteriaHeight = $criteriaPortletObject["height"];
				if ($fieldCriteriaHeight["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Height') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaHeight["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaHeight["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='height';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaHeight["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Height') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='height';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["inline"])) {
				$fieldCriteriaInline = $criteriaPortletObject["inline"];
				if ($fieldCriteriaInline["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Inline') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaInline["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaInline["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='inline';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaInline["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Inline') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='inline';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["ajax"])) {
				$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
				if ($fieldCriteriaAjax["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ajax') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaAjax["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaAjax["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ajax';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaAjax["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ajax') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ajax';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["render_condition"])) {
				$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
				if ($fieldCriteriaRenderCondition["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Render condition') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaRenderCondition["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaRenderCondition["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='render_condition';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Render condition') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='render_condition';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["autorefresh"])) {
				$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
				if ($fieldCriteriaAutorefresh["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Autorefresh') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaAutorefresh["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaAutorefresh["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='autorefresh';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Autorefresh') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='autorefresh';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["portlet_definition"])) {
				$parentCriteria = $criteriaPortletObject["portlet_definition"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Portlet definition') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portlet_definition';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('portlet_definition') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portlet_definition';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
			if (isset($criteriaPortletObject["portlet_object"])) {
				$parentCriteria = $criteriaPortletObject["portlet_object"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Portlet object') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portlet_object';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					$renderCriteria = $parentCriteria["value"];
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('portlet_object') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portlet_object';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
					}
				}
			}
		if (isset($criteriaPortletObject["page"])) {
			$parentIds = $criteriaPortletObject["page"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
			$renderCriteria = "";
			foreach ($selectedIds as $id) {
				$obj = new portal\virgoPage($id['id']);
				$renderCriteria = ($renderCriteria == "" ? "" : $renderCriteria . ", ") . $obj->getVirgoTitle();
			}
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Pages') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='page';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
		}
?>
			</table>
<?php
		}
?>
<?php
		}
?>
<?php
PROFILE('token');
	if (isset($resultPortletObject)) {
		$tmpId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($portletObjectDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
			|| $tmpAction == "StoreNewPortletDefinition"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultPortletObject->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultPortletObject->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$portletObjectDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultPortletObject->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($portletObjectDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_portlet_object") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('PORTLET_OBJECT') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul <?php echo $floatingGridFields ? "class='float_grid_fields'" : "" ?>>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$editForm = P('edit_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
																																																							<?php
	if (class_exists('portal\virgoPortletDefinition') && ((P('show_form_portlet_definition', "1") == "1" || P('show_form_portlet_definition', "1") == "2" || P('show_form_portlet_definition', "1") == "3") && !isset($context["pdf"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="pob_portletDefinition_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
 *
<?php echo T('PORTLET_DEFINITION') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pdf"])) {
		$parentValue = $context["pdf"];
	} else {
		$parentValue = $resultPortletObject->pob_pdf_id;
	}
	
?>
				<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_form_show_title', "1") == "1" || P('show_form_show_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_show_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   show_title bool" 
						for="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_show_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SHOW_TITLE') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_show_title', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="showTitle"
>
<?php
	if (is_null($resultPortletObject->pob_show_title) || $resultPortletObject->pob_show_title == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_show_title == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_show_title === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_custom_title', "1") == "1" || P('show_form_custom_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   custom_title varchar" 
						for="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CUSTOM_TITLE') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_custom_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="customTitle" name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_left', "1") == "1" || P('show_form_left', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   left integer" 
						for="pob_left_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_left_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LEFT') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_left', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="left" name="pob_left_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_top', "1") == "1" || P('show_form_top', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   top integer" 
						for="pob_top_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_top_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOP') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_top', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="top" name="pob_top_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_width', "1") == "1" || P('show_form_width', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   width integer" 
						for="pob_width_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_width_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WIDTH') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_width', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="width" name="pob_width_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_height', "1") == "1" || P('show_form_height', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   height integer" 
						for="pob_height_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_height_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('HEIGHT') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_height', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="height" name="pob_height_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_inline', "1") == "1" || P('show_form_inline', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_inline_obligatory', "0") == "1" ? " obligatory " : "" ?>   inline bool" 
						for="pob_inline_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_inline_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INLINE') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_inline', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="inline"
>
<?php
	if (is_null($resultPortletObject->pob_inline) || $resultPortletObject->pob_inline == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_inline == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_inline === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_ajax', "1") == "1" || P('show_form_ajax', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_ajax_obligatory', "0") == "1" ? " obligatory " : "" ?>   ajax bool" 
						for="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_ajax_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AJAX') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_ajax', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="ajax"
>
<?php
	if (is_null($resultPortletObject->pob_ajax) || $resultPortletObject->pob_ajax == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_ajax == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_ajax === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_render_condition', "1") == "1" || P('show_form_render_condition', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_render_condition_obligatory', "0") == "1" ? " obligatory " : "" ?>   render_condition text" 
						for="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_render_condition_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RENDER_CONDITION') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_render_condition', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly render_condition" 
	id="renderCondition" 
><?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_form_autorefresh', "1") == "1" || P('show_form_autorefresh', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label 
						nowrap="nowrap"
						class="fieldlabel  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   autorefresh integer" 
						for="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
					> <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AUTOREFRESH') ?>
</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	if (P('show_form_autorefresh', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="autorefresh" name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPortletObject') && ((P('show_form_portlet_object', "1") == "1" || P('show_form_portlet_object', "1") == "2" || P('show_form_portlet_object', "1") == "3"))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " for="pob_portletObject_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
<?php echo P('show_form_portlet_object_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PORTLET_OBJECT') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPobId())) {
				$parentId = $resultPortletObject->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPobId()) && $id == $resultPortletObject->getPobId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_object_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pob"])) {
		$parentValue = $context["pob"];
	} else {
		$parentValue = $resultPortletObject->pob_pob_id;
	}
	
?>
				<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_form_portlet_locations', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel portletLocation" for="pob_portletLocation_<?php echo $resultPortletObject->getId() ?>[]">
Portlet locations 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentPage = new portal\virgoPage();
			$whereList = "";
			$resultsPage = $parentPage->getVirgoList($whereList);
			$currentConnections = $resultPortletObject->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPageId();
			}
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPage) > 10 ? 10 : sizeof($resultsPage) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPage)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsPage);
			while (list($id, $label) = each($resultsPage)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
					<input 
						type="hidden" 
						id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>" 
						name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>" 
						value="VIRGO_DONT_DELETE_N_M_CHILDREN"
					/>


<?php					
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_form_html_contents', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_form_portlet_parameters', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_form_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_form_portlet_objects', '1') == "1") {
?>
<?php
	} else {
	}
?>

<?php
	} elseif ($editForm == "virgo_entity") {
?>
<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_html_contents') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsHtmlContent = &JComponentHelper::getParams('com_prt_html_content');
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_content') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Content
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_language') == "1" && ($masterComponentName != "language" || is_null($contextId))) {
?>
				<td align="center" nowrap>Language </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpHtmlContent = new portal\virgoHtmlContent();
				$resultsHtmlContent = $tmpHtmlContent->selectAll(' hcn_pob_id = ' . $resultPortletObject->pob_id);
				$idsToCorrect = $tmpHtmlContent->getInvalidRecords();
				$index = 0;
				foreach ($resultsHtmlContent as $resultHtmlContent) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultHtmlContent->hcn_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultHtmlContent->hcn_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultHtmlContent->hcn_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultHtmlContent->hcn_id) ? 0 : $resultHtmlContent->hcn_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultHtmlContent->hcn_id;
		$resultHtmlContent = new virgoHtmlContent;
		$resultHtmlContent->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_content') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultHtmlContent)) {
		$resultHtmlContent = new portal\virgoHtmlContent();
	}
?>
<script type="text/javascript">
var CKEDITOR_BASEPATH = "<?php echo $_SESSION['portal_url'] ?>/libraries/ckeditor/";
</script>
<script type="text/javascript" src="<?php echo $_SESSION['portal_url'] ?>/libraries/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo $_SESSION['portal_url'] ?>/libraries/ckeditor/adapters/jquery.js"></script>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox" 
	id="hcn_content_<?php echo $resultHtmlContent->getId() ?>" 
	name="hcn_content_<?php echo $resultHtmlContent->getId() ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
><?php echo htmlentities($resultHtmlContent->getContent(), ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
		var editor = CKEDITOR.instances['hcn_content_<?php echo $resultHtmlContent->getId() ?>'];
		if (editor) { 
			editor.destroy(true); 
		}
  $('#hcn_content_<?php echo $resultHtmlContent->getId() ?>').ckeditor({
		filebrowserUploadUrl: '<?php echo $_SESSION['portal_url'] ?>/?virgo_upload=true'
<?php
		if (P('show_toolbar_content', '1') == '0') {
?>
		,toolbarStartupExpanded: false
<?php
		}
?>
  });
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="content_<?php echo $resultPortletObject->pob_id ?>" 
							name="content_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_content, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_language') == "1" && ($masterComponentName != "language" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsHtmlContent) * 1;
?>
<?php
//		$limit_language = $componentParams->get('limit_to_language');
		$limit_language = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoLanguage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_language', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultHtmlContent->hcn_lng__id = $tmpId;
//			}
			if (!is_null($resultHtmlContent->getLngId())) {
				$parentId = $resultHtmlContent->getLngId();
				$parentValue = portal\virgoLanguage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="hcn_language_<?php echo $resultHtmlContent->getId() ?>" name="hcn_language_<?php echo $resultHtmlContent->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_HTML_CONTENT_LANGUAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_language) && trim($limit_language) != "") {
		$whereList = $whereList . " lng_id ";
		if (trim($limit_language) == "page_title") {
			$limit_language = "SELECT lng_id FROM prt_languages WHERE lng_" . $limit_language . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_language = \"$limit_language\";");
		$whereList = $whereList . " IN (" . $limit_language . ") ";
	}						
	$parentCount = portal\virgoLanguage::getVirgoListSize($whereList);
	$showAjaxhcn = P('show_form_language', "1") == "3" || $parentCount > 100;
	if (!$showAjaxhcn) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_language_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="hcn_language_<?php echo !is_null($resultHtmlContent->getId()) ? $resultHtmlContent->getId() : '' ?>" 
							name="hcn_language_<?php echo !is_null($resultHtmlContent->getId()) ? $resultHtmlContent->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_language) || trim($limit_language) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLanguage = portal\virgoLanguage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLanguage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultHtmlContent->getLngId()) && $id == $resultHtmlContent->getLngId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultHtmlContent->getLngId();
				$parentLanguage = new portal\virgoLanguage();
				$parentValue = $parentLanguage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="hcn_language_<?php echo $resultHtmlContent->getId() ?>" name="hcn_language_<?php echo $resultHtmlContent->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Language",
			virgo_field_name: "language",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#hcn_language_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.value);
				  	$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.label);
				  	$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#hcn_language_<?php echo $resultHtmlContent->getId() ?>').val('');
				$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_language_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultHtmlContent = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultHtmlContent->hcn_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultHtmlContent->hcn_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultHtmlContent->hcn_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultHtmlContent->hcn_id) ? 0 : $resultHtmlContent->hcn_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultHtmlContent->hcn_id;
		$resultHtmlContent = new virgoHtmlContent;
		$resultHtmlContent->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_content') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultHtmlContent)) {
		$resultHtmlContent = new portal\virgoHtmlContent();
	}
?>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox" 
	id="hcn_content_<?php echo $resultHtmlContent->getId() ?>" 
	name="hcn_content_<?php echo $resultHtmlContent->getId() ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
><?php echo htmlentities($resultHtmlContent->getContent(), ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
		var editor = CKEDITOR.instances['hcn_content_<?php echo $resultHtmlContent->getId() ?>'];
		if (editor) { 
			editor.destroy(true); 
		}
  $('#hcn_content_<?php echo $resultHtmlContent->getId() ?>').ckeditor({
		filebrowserUploadUrl: '<?php echo $_SESSION['portal_url'] ?>/?virgo_upload=true'
<?php
		if (P('show_toolbar_content', '1') == '0') {
?>
		,toolbarStartupExpanded: false
<?php
		}
?>
  });
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="content_<?php echo $resultPortletObject->pob_id ?>" 
							name="content_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_content, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsHtmlContent->get('show_table_language') == "1" && ($masterComponentName != "language" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsHtmlContent) * 1;
?>
<?php
//		$limit_language = $componentParams->get('limit_to_language');
		$limit_language = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoLanguage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_language', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultHtmlContent->hcn_lng__id = $tmpId;
//			}
			if (!is_null($resultHtmlContent->getLngId())) {
				$parentId = $resultHtmlContent->getLngId();
				$parentValue = portal\virgoLanguage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="hcn_language_<?php echo $resultHtmlContent->getId() ?>" name="hcn_language_<?php echo $resultHtmlContent->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_HTML_CONTENT_LANGUAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_language) && trim($limit_language) != "") {
		$whereList = $whereList . " lng_id ";
		if (trim($limit_language) == "page_title") {
			$limit_language = "SELECT lng_id FROM prt_languages WHERE lng_" . $limit_language . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_language = \"$limit_language\";");
		$whereList = $whereList . " IN (" . $limit_language . ") ";
	}						
	$parentCount = portal\virgoLanguage::getVirgoListSize($whereList);
	$showAjaxhcn = P('show_form_language', "1") == "3" || $parentCount > 100;
	if (!$showAjaxhcn) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_language_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="hcn_language_<?php echo !is_null($resultHtmlContent->getId()) ? $resultHtmlContent->getId() : '' ?>" 
							name="hcn_language_<?php echo !is_null($resultHtmlContent->getId()) ? $resultHtmlContent->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_language) || trim($limit_language) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLanguage = portal\virgoLanguage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLanguage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultHtmlContent->getLngId()) && $id == $resultHtmlContent->getLngId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultHtmlContent->getLngId();
				$parentLanguage = new portal\virgoLanguage();
				$parentValue = $parentLanguage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="hcn_language_<?php echo $resultHtmlContent->getId() ?>" name="hcn_language_<?php echo $resultHtmlContent->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Language",
			virgo_field_name: "language",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#hcn_language_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.value);
				  	$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.label);
				  	$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#hcn_language_<?php echo $resultHtmlContent->getId() ?>').val('');
				$('#hcn_language_dropdown_<?php echo $resultHtmlContent->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_language_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpHtmlContent->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_portlet_parameters') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsPortletParameter = &JComponentHelper::getParams('com_prt_portlet_parameter');
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_name') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Name
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_value') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Value
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portlet definition </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portal </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td align="center" nowrap>Template </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPortletParameter = new portal\virgoPortletParameter();
				$resultsPortletParameter = $tmpPortletParameter->selectAll(' ppr_pob_id = ' . $resultPortletObject->pob_id);
				$idsToCorrect = $tmpPortletParameter->getInvalidRecords();
				$index = 0;
				foreach ($resultsPortletParameter as $resultPortletParameter) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPortletParameter->ppr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortletParameter->ppr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortletParameter->ppr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortletParameter->ppr_id) ? 0 : $resultPortletParameter->ppr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortletParameter->ppr_id;
		$resultPortletParameter = new virgoPortletParameter;
		$resultPortletParameter->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPortletParameter)) {
		$resultPortletParameter = new portal\virgoPortletParameter();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="ppr_name_<?php echo $resultPortletParameter->getId() ?>" 
							name="ppr_name_<?php echo $resultPortletParameter->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletParameter->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_PARAMETER_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#ppr_name_<?php echo $resultPortletParameter->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="name_<?php echo $resultPortletObject->pob_id ?>" 
							name="name_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPortletParameter)) {
		$resultPortletParameter = new portal\virgoPortletParameter();
	}
?>
<textarea 
	class="inputbox value" 
	id="ppr_value_<?php echo $resultPortletParameter->getId() ?>" 
	name="ppr_value_<?php echo $resultPortletParameter->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_PARAMETER_VALUE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletParameter->getValue(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#ppr_value_<?php echo $resultPortletParameter->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="value_<?php echo $resultPortletObject->pob_id ?>" 
							name="value_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_value, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 2;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPdfId())) {
				$parentId = $resultPortletParameter->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayPortletDefinition2PortletObject = new Array();

<?php
	$query = " SELECT DISTINCT pob_pdf_id AS parent_id FROM prt_portlet_objects "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT pob_id AS id, pob_virgo_title AS value FROM prt_portlet_objects WHERE pob_pdf_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayPortletDefinition2PortletObject[<?php echo $rowParent['parent_id'] ?>] = arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortletObject(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortletObject(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortletObject(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortletObject(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortletObject(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayPortletDefinition2PortletObject[parentId];
			displayArrayPortletObject(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_definition_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portletDefinition_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portletDefinition_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portlet_object', "1") == "1") {
?>
								updatePortletObject(this.options[this.selectedIndex].value, 'ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>', <?php echo is_null($resultPortletParameter->getPortletObjectId()) ? "null" : $resultPortletParameter->getPobId() ?>);
<?php
	}
?>
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getPdfId()) && $id == $resultPortletParameter->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 3;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_prt__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPrtId())) {
				$parentId = $resultPortletParameter->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portal_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portal_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portal_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getPrtId()) && $id == $resultPortletParameter->getPrtId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portal_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portal_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portal_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 4;
?>
<?php
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_tmp__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getTmpId())) {
				$parentId = $resultPortletParameter->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_template_<?php echo $resultPortletParameter->getId() ?>" name="ppr_template_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_template_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_template_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'ppr_portal_<?php echo $resultPortletParameter->getId() ?>', <?php echo is_null($resultPortletParameter->getPortalId()) ? "null" : $resultPortletParameter->getPrtId() ?>);
<?php
	}
?>
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getTmpId()) && $id == $resultPortletParameter->getTmpId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_template_<?php echo $resultPortletParameter->getId() ?>" name="ppr_template_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_template_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_template_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_template_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultPortletParameter = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPortletParameter->ppr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortletParameter->ppr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortletParameter->ppr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortletParameter->ppr_id) ? 0 : $resultPortletParameter->ppr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortletParameter->ppr_id;
		$resultPortletParameter = new virgoPortletParameter;
		$resultPortletParameter->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPortletParameter)) {
		$resultPortletParameter = new portal\virgoPortletParameter();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="ppr_name_<?php echo $resultPortletParameter->getId() ?>" 
							name="ppr_name_<?php echo $resultPortletParameter->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletParameter->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_PARAMETER_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#ppr_name_<?php echo $resultPortletParameter->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="name_<?php echo $resultPortletObject->pob_id ?>" 
							name="name_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPortletParameter)) {
		$resultPortletParameter = new portal\virgoPortletParameter();
	}
?>
<textarea 
	class="inputbox value" 
	id="ppr_value_<?php echo $resultPortletParameter->getId() ?>" 
	name="ppr_value_<?php echo $resultPortletParameter->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_PARAMETER_VALUE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletParameter->getValue(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#ppr_value_<?php echo $resultPortletParameter->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="value_<?php echo $resultPortletObject->pob_id ?>" 
							name="value_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_value, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 2;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPdfId())) {
				$parentId = $resultPortletParameter->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayPortletDefinition2PortletObject = new Array();

<?php
	$query = " SELECT DISTINCT pob_pdf_id AS parent_id FROM prt_portlet_objects "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT pob_id AS id, pob_virgo_title AS value FROM prt_portlet_objects WHERE pob_pdf_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayPortletDefinition2PortletObject[<?php echo $rowParent['parent_id'] ?>] = arrayPortletDefinition<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortletObject(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortletObject(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortletObject(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortletObject(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortletObject(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayPortletDefinition2PortletObject[parentId];
			displayArrayPortletObject(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_definition_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portletDefinition_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portletDefinition_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portlet_object', "1") == "1") {
?>
								updatePortletObject(this.options[this.selectedIndex].value, 'ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>', <?php echo is_null($resultPortletParameter->getPortletObjectId()) ? "null" : $resultPortletParameter->getPobId() ?>);
<?php
	}
?>
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getPdfId()) && $id == $resultPortletParameter->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletDefinition_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portlet_definition_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portlet_definition_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 3;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_prt__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPrtId())) {
				$parentId = $resultPortletParameter->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTAL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portal) && trim($limit_portal) != "") {
		$whereList = $whereList . " prt_id ";
		if (trim($limit_portal) == "page_title") {
			$limit_portal = "SELECT prt_id FROM prt_portals WHERE prt_" . $limit_portal . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portal = \"$limit_portal\";");
		$whereList = $whereList . " IN (" . $limit_portal . ") ";
	}						
	$parentCount = portal\virgoPortal::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portal_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portal_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portal_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portal) || trim($limit_portal) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortal = portal\virgoPortal::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortal)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getPrtId()) && $id == $resultPortletParameter->getPrtId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getPrtId();
				$parentPortal = new portal\virgoPortal();
				$parentValue = $parentPortal->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portal_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Portal",
			virgo_field_name: "portal",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portal_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portal_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portal_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portal_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_template') == "1" && ($masterComponentName != "template" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 4;
?>
<?php
//		$limit_template = $componentParams->get('limit_to_template');
		$limit_template = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoTemplate");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_template', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_tmp__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getTmpId())) {
				$parentId = $resultPortletParameter->getTmpId();
				$parentValue = portal\virgoTemplate::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_template_<?php echo $resultPortletParameter->getId() ?>" name="ppr_template_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<script type="text/javascript">
var arrayTemplate2Portal = new Array();

<?php
	$query = " SELECT DISTINCT prt_tmp_id AS parent_id FROM prt_portals "; // plus ograniczenia skonfigurowane
	$rows = QR($query);
	$rowsParent = $rows;
	foreach ($rowsParent as $rowParent) {
		if (!is_null($rowParent['parent_id'])) {
?>
	var arrayTemplate<?php echo $rowParent['parent_id'] ?>= new Array();	
<?php
			$query = " SELECT prt_id AS id, prt_virgo_title AS value FROM prt_portals WHERE prt_tmp_id = " . $rowParent['parent_id']; // plus ograniczenia skonfigurowane
	$rows = QR($query);
			foreach ($rows as $row) {
?>
	arrayTemplate<?php echo $rowParent['parent_id'] ?>['<?php echo $row["id"] ?>'] = '<?php echo $row["value"] ?>';	
<?php
			}
?>
	arrayTemplate2Portal[<?php echo $rowParent['parent_id'] ?>] = arrayTemplate<?php echo $rowParent['parent_id'] ?>;
		
<?php
		}
	}
?>

function addOptionPortal(select, optionText, optionValue, selectedValue) {
	var newOption = document.createElement('option');
	newOption.text = optionText;
	newOption.value = optionValue;
	if (optionValue == selectedValue) {
		newOption.selected = true;
	}
	try {
		select.add(newOption, null);
	} catch (ex) {
		select.add(newOption);
	}
}

function displayArrayPortal(select, arrayToShow, selectedValue) {
	select.length = 0;
	addOptionPortal(select, '', '', selectedValue);
	for (var id in arrayToShow){ 
		addOptionPortal(select, arrayToShow[id], id, selectedValue);
	} 
}

function updatePortal(parentId, childrenListId, selectedValue) {
	// alert('test: ' + parentId + ' '  + childrenListId);
	var childrenList = document.getElementById(childrenListId);
	if (childrenList.tagName.toUpperCase() == "SELECT") {
		if (childrenList) {
			var arrayToShow = arrayTemplate2Portal[parentId];
			displayArrayPortal(childrenList, arrayToShow, selectedValue);
		}
	}
}
</script>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_TEMPLATE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_template) && trim($limit_template) != "") {
		$whereList = $whereList . " tmp_id ";
		if (trim($limit_template) == "page_title") {
			$limit_template = "SELECT tmp_id FROM prt_templates WHERE tmp_" . $limit_template . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_template = \"$limit_template\";");
		$whereList = $whereList . " IN (" . $limit_template . ") ";
	}						
	$parentCount = portal\virgoTemplate::getVirgoListSize($whereList);
	$showAjaxppr = P('show_form_template', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_template_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_template_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_template_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
<?php
	if (P('show_form_portal', "1") == "1") {
?>
								updatePortal(this.options[this.selectedIndex].value, 'ppr_portal_<?php echo $resultPortletParameter->getId() ?>', <?php echo is_null($resultPortletParameter->getPortalId()) ? "null" : $resultPortletParameter->getPrtId() ?>);
<?php
	}
?>
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_template) || trim($limit_template) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsTemplate = portal\virgoTemplate::getVirgoList($whereList);
			while(list($id, $label)=each($resultsTemplate)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletParameter->getTmpId()) && $id == $resultPortletParameter->getTmpId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletParameter->getTmpId();
				$parentTemplate = new portal\virgoTemplate();
				$parentValue = $parentTemplate->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="ppr_template_<?php echo $resultPortletParameter->getId() ?>" name="ppr_template_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Template",
			virgo_field_name: "template",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_template_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_template_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_template_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_template_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpPortletParameter->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_permissions') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsPermission = &JComponentHelper::getParams('com_prt_permission');
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							View
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Edit
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Configure
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Action
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Execute
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td align="center" nowrap>Role </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td align="center" nowrap>Page </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPermission = new portal\virgoPermission();
				$resultsPermission = $tmpPermission->selectAll(' prm_pob_id = ' . $resultPortletObject->pob_id);
				$idsToCorrect = $tmpPermission->getInvalidRecords();
				$index = 0;
				foreach ($resultsPermission as $resultPermission) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPermission->prm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPermission->prm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPermission->prm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPermission->prm_id) ? 0 : $resultPermission->prm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPermission->prm_id;
		$resultPermission = new virgoPermission;
		$resultPermission->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_view_<?php echo $resultPermission->getId() ?>" name="prm_view_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_VIEW');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getView() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getView() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getView()) || $resultPermission->getView() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_view_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="view_<?php echo $resultPortletObject->pob_id ?>" 
							name="view_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_edit_<?php echo $resultPermission->getId() ?>" name="prm_edit_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EDIT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getEdit() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getEdit() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getEdit()) || $resultPermission->getEdit() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_edit_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="edit_<?php echo $resultPortletObject->pob_id ?>" 
							name="edit_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 2;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_configure_<?php echo $resultPermission->getId() ?>" name="prm_configure_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_CONFIGURE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getConfigure() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getConfigure() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getConfigure()) || $resultPermission->getConfigure() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_configure_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="configure_<?php echo $resultPortletObject->pob_id ?>" 
							name="configure_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 3;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_action_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prm_action_<?php echo $resultPermission->getId() ?>" 
							name="prm_action_<?php echo $resultPermission->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPermission->getAction(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_ACTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_action_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="action_<?php echo $resultPortletObject->pob_id ?>" 
							name="action_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 4;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_execute_<?php echo $resultPermission->getId() ?>" name="prm_execute_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EXECUTE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getExecute() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getExecute() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getExecute()) || $resultPermission->getExecute() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_execute_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="execute_<?php echo $resultPortletObject->pob_id ?>" 
							name="execute_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_role = $componentParams->get('limit_to_role');
		$limit_role = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoRole");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_role', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_rle__id = $tmpId;
//			}
			if (!is_null($resultPermission->getRleId())) {
				$parentId = $resultPermission->getRleId();
				$parentValue = portal\virgoRole::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_ROLE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_role) && trim($limit_role) != "") {
		$whereList = $whereList . " rle_id ";
		if (trim($limit_role) == "page_title") {
			$limit_role = "SELECT rle_id FROM prt_roles WHERE rle_" . $limit_role . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_role = \"$limit_role\";");
		$whereList = $whereList . " IN (" . $limit_role . ") ";
	}						
	$parentCount = portal\virgoRole::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_role', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_role) || trim($limit_role) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsRole = portal\virgoRole::getVirgoList($whereList);
			while(list($id, $label)=each($resultsRole)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getRleId()) && $id == $resultPermission->getRleId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPermission->getRleId();
				$parentRole = new portal\virgoRole();
				$parentValue = $parentRole->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="prm_role_dropdown_<?php echo $resultPermission->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#prm_role_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Role",
			virgo_field_name: "role",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_role_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_role_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 6;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pge__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPgeId())) {
				$parentId = $resultPermission->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getPgeId()) && $id == $resultPermission->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPermission->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_page_dropdown_<?php echo $resultPermission->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#prm_page_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_page_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_page_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultPermission = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPermission->prm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPermission->prm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPermission->prm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPermission->prm_id) ? 0 : $resultPermission->prm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPermission->prm_id;
		$resultPermission = new virgoPermission;
		$resultPermission->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPermission->get('show_table_view') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_view_<?php echo $resultPermission->getId() ?>" name="prm_view_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_VIEW');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getView() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getView() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getView()) || $resultPermission->getView() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_view_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="view_<?php echo $resultPortletObject->pob_id ?>" 
							name="view_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_view, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_edit') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_edit_<?php echo $resultPermission->getId() ?>" name="prm_edit_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EDIT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getEdit() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getEdit() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getEdit()) || $resultPermission->getEdit() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_edit_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="edit_<?php echo $resultPortletObject->pob_id ?>" 
							name="edit_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_edit, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_configure') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 2;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_configure_<?php echo $resultPermission->getId() ?>" name="prm_configure_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_CONFIGURE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getConfigure() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getConfigure() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getConfigure()) || $resultPermission->getConfigure() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_configure_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="configure_<?php echo $resultPortletObject->pob_id ?>" 
							name="configure_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_configure, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_action') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 3;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_action_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prm_action_<?php echo $resultPermission->getId() ?>" 
							name="prm_action_<?php echo $resultPermission->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPermission->getAction(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_ACTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_action_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="action_<?php echo $resultPortletObject->pob_id ?>" 
							name="action_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_action, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_execute') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 4;
?>
<?php
	if (!isset($resultPermission)) {
		$resultPermission = new portal\virgoPermission();
	}
?>
<select class="inputbox" id="prm_execute_<?php echo $resultPermission->getId() ?>" name="prm_execute_<?php echo $resultPermission->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PERMISSION_EXECUTE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPermission->getExecute() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPermission->getExecute() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPermission->getExecute()) || $resultPermission->getExecute() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prm_execute_<?php echo $resultPermission->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="execute_<?php echo $resultPortletObject->pob_id ?>" 
							name="execute_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_execute, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_role') == "1" && ($masterComponentName != "role" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 5;
?>
<?php
//		$limit_role = $componentParams->get('limit_to_role');
		$limit_role = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoRole");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_role', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_rle__id = $tmpId;
//			}
			if (!is_null($resultPermission->getRleId())) {
				$parentId = $resultPermission->getRleId();
				$parentValue = portal\virgoRole::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_ROLE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_role) && trim($limit_role) != "") {
		$whereList = $whereList . " rle_id ";
		if (trim($limit_role) == "page_title") {
			$limit_role = "SELECT rle_id FROM prt_roles WHERE rle_" . $limit_role . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_role = \"$limit_role\";");
		$whereList = $whereList . " IN (" . $limit_role . ") ";
	}						
	$parentCount = portal\virgoRole::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_role', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_role_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_role) || trim($limit_role) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsRole = portal\virgoRole::getVirgoList($whereList);
			while(list($id, $label)=each($resultsRole)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getRleId()) && $id == $resultPermission->getRleId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPermission->getRleId();
				$parentRole = new portal\virgoRole();
				$parentValue = $parentRole->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="prm_role_<?php echo $resultPermission->getId() ?>" name="prm_role_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="prm_role_dropdown_<?php echo $resultPermission->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#prm_role_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Role",
			virgo_field_name: "role",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_role_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_role_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_role_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
<?php
	if (false) { //$componentParamsPermission->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPermission) * 6;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPage");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPermission->prm_pge__id = $tmpId;
//			}
			if (!is_null($resultPermission->getPgeId())) {
				$parentId = $resultPermission->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PERMISSION_PAGE');
?>
<?php
	$whereList = "";
	if (!is_null($limit_page) && trim($limit_page) != "") {
		$whereList = $whereList . " pge_id ";
		if (trim($limit_page) == "page_title") {
			$limit_page = "SELECT pge_id FROM prt_pages WHERE pge_" . $limit_page . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_page = \"$limit_page\";");
		$whereList = $whereList . " IN (" . $limit_page . ") ";
	}						
	$parentCount = portal\virgoPage::getVirgoListSize($whereList);
	$showAjaxprm = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxprm) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
							name="prm_page_<?php echo !is_null($resultPermission->getId()) ? $resultPermission->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_page) || trim($limit_page) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPage = portal\virgoPage::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPage)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPermission->getPgeId()) && $id == $resultPermission->getPgeId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPermission->getPgeId();
				$parentPage = new portal\virgoPage();
				$parentValue = $parentPage->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="prm_page_<?php echo $resultPermission->getId() ?>" name="prm_page_<?php echo $resultPermission->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="prm_page_dropdown_<?php echo $resultPermission->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#prm_page_dropdown_<?php echo $resultPermission->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Page",
			virgo_field_name: "page",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_<?php echo $resultPermission->getId() ?>').val(ui.item.value);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				  	$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#prm_page_<?php echo $resultPermission->getId() ?>').val('');
				$('#prm_page_dropdown_<?php echo $resultPermission->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_page_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpPermission->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_portlet_objects') == "1") {
?>
		<script type="text/javascript">
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

<?php
//	$componentParamsPortletObject = &JComponentHelper::getParams('com_prt_portlet_object');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_definition/prt_portlet_definition_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_object/prt_portlet_object_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_definition/prt_portlet_definition_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_object/prt_portlet_object_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_definition/prt_portlet_definition_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_object/prt_portlet_object_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_definition/prt_portlet_definition_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_object/prt_portlet_object_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_definition/prt_portlet_definition_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portlet_object/prt_portlet_object_class.php");
?>
		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
				<td>
					
				</td>
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_show_title') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Show title
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_custom_title') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Custom title
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_left') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Left
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_top') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Top
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_width') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Width
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_height') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Height
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_inline') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Inline
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_ajax') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ajax
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_render_condition') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Render condition
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_autorefresh') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Autorefresh
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portlet definition </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPortletObject = new portal\virgoPortletObject();
				$resultsPortletObject = $tmpPortletObject->selectAll(' pob_pob_id = ' . $resultPortletObject->pob_id);
				$idsToCorrect = $tmpPortletObject->getInvalidRecords();
				$index = 0;
				foreach ($resultsPortletObject as $resultPortletObject) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPortletObject->pob_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortletObject->pob_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortletObject->pob_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortletObject->pob_id) ? 0 : $resultPortletObject->pob_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortletObject->pob_id;
		$resultPortletObject = new virgoPortletObject;
		$resultPortletObject->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_show_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="showTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="showTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_show_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_custom_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="customTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="customTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_custom_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_left') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 2;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="left_<?php echo $resultPortletObject->pob_id ?>" 
							name="left_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_left, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_top') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 3;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="top_<?php echo $resultPortletObject->pob_id ?>" 
							name="top_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_top, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_width') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 4;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="width_<?php echo $resultPortletObject->pob_id ?>" 
							name="width_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_width, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_height') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 5;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="height_<?php echo $resultPortletObject->pob_id ?>" 
							name="height_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_height, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_inline') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 6;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="inline_<?php echo $resultPortletObject->pob_id ?>" 
							name="inline_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_inline, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_ajax') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 7;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ajax_<?php echo $resultPortletObject->pob_id ?>" 
							name="ajax_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_ajax, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_render_condition') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 8;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="renderCondition_<?php echo $resultPortletObject->pob_id ?>" 
							name="renderCondition_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_autorefresh') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 9;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="autorefresh_<?php echo $resultPortletObject->pob_id ?>" 
							name="autorefresh_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_autorefresh, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 10;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

<?php
				}
				$resultPortletObject = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPortletObject->pob_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortletObject->pob_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortletObject->pob_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortletObject->pob_id) ? 0 : $resultPortletObject->pob_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortletObject->pob_id;
		$resultPortletObject = new virgoPortletObject;
		$resultPortletObject->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_show_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="showTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="showTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_show_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_custom_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="customTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="customTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_custom_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_left') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 2;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="left_<?php echo $resultPortletObject->pob_id ?>" 
							name="left_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_left, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_top') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 3;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="top_<?php echo $resultPortletObject->pob_id ?>" 
							name="top_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_top, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_width') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 4;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="width_<?php echo $resultPortletObject->pob_id ?>" 
							name="width_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_width, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_height') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 5;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="height_<?php echo $resultPortletObject->pob_id ?>" 
							name="height_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_height, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_inline') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 6;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="inline_<?php echo $resultPortletObject->pob_id ?>" 
							name="inline_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_inline, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_ajax') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 7;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="ajax_<?php echo $resultPortletObject->pob_id ?>" 
							name="ajax_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_ajax, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_render_condition') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 8;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="renderCondition_<?php echo $resultPortletObject->pob_id ?>" 
							name="renderCondition_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_autorefresh') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 9;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="autorefresh_<?php echo $resultPortletObject->pob_id ?>" 
							name="autorefresh_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_autorefresh, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletObject->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 10;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	} 
?>
				<td>
<?php
	if (!is_null($errorMessage)) {
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">
				</td>
			</tr>

			</table>
<?php
				$tmpPortletObject->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPortletObject->getDateCreated()) {
		if ($resultPortletObject->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPortletObject->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPortletObject->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPortletObject->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPortletObject->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPortletObject->getDateModified()) {
		if ($resultPortletObject->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPortletObject->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPortletObject->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPortletObject->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPortletObject->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
	if (!isset($masterPobId) && P('form_only', "0") != "1" && P('form_only', "0") != "5" && P('form_only', "0") != "6") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PORTLET_OBJECT"), "\\'".rawurlencode($resultPortletObject->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (!isset($masterPobId) && P('form_only') != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($portletObjectDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_portlet_object") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
	<div class="form_edit">
			<fieldset class="form">
				<legend>
<?php echo T('PORTLET_OBJECT') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<table>
<?php
	}
?>
<?php
	$createForm = P('create_form', "virgo_default");
	if (is_null($createForm) || trim($createForm) == "" || $createForm == "virgo_default") {
?>
<?php
		if (isset($resultPortletObject->pob_id)) {
			$resultPortletObject->pob_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_portlet_definition');
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
	$resultPortletObject->setPdfId($defaultValue);
}
$defaultValue = P('create_default_value_portlet_object');
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
	$resultPortletObject->setPobId($defaultValue);
}
	}
?>
																																																							<?php
	if (class_exists('portal\virgoPortletDefinition') && ((P('show_create_portlet_definition', "1") == "1" || P('show_create_portlet_definition', "1") == "2" || P('show_create_portlet_definition', "1") == "3") && !isset($context["pdf"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="pob_portletDefinition_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
 *
<?php echo T('PORTLET_DEFINITION') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_create_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pdf"])) {
		$parentValue = $context["pdf"];
	} else {
		$parentValue = $resultPortletObject->pob_pdf_id;
	}
	
?>
				<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_create_show_title', "1") == "1" || P('show_create_show_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_show_title_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_showTitle_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_show_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SHOW_TITLE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "show_title") {
				$resultPortletObject->setShowTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_show_title', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="showTitle"
>
<?php
	if (is_null($resultPortletObject->pob_show_title) || $resultPortletObject->pob_show_title == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_show_title == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_show_title === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_custom_title', "1") == "1" || P('show_create_custom_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_customTitle_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_custom_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CUSTOM_TITLE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "custom_title") {
				$resultPortletObject->setCustomTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_custom_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="customTitle" name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_left', "1") == "1" || P('show_create_left', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_left_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_left_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_left_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LEFT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "left") {
				$resultPortletObject->setLeft($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_left', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="left" name="pob_left_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_top', "1") == "1" || P('show_create_top', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_top_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_top_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_top_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOP') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "top") {
				$resultPortletObject->setTop($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_top', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="top" name="pob_top_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_width', "1") == "1" || P('show_create_width', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_width_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_width_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_width_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WIDTH') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "width") {
				$resultPortletObject->setWidth($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_width', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="width" name="pob_width_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_height', "1") == "1" || P('show_create_height', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_height_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_height_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_height_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('HEIGHT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "height") {
				$resultPortletObject->setHeight($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_height', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="height" name="pob_height_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_inline', "1") == "1" || P('show_create_inline', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_inline_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_inline_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_inline_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INLINE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "inline") {
				$resultPortletObject->setInline($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_inline', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="inline"
>
<?php
	if (is_null($resultPortletObject->pob_inline) || $resultPortletObject->pob_inline == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_inline == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_inline === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_ajax', "1") == "1" || P('show_create_ajax', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_ajax_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_ajax_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_ajax_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AJAX') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ajax") {
				$resultPortletObject->setAjax($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ajax', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="ajax"
>
<?php
	if (is_null($resultPortletObject->pob_ajax) || $resultPortletObject->pob_ajax == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_ajax == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_ajax === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_render_condition', "1") == "1" || P('show_create_render_condition', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_render_condition_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_render_condition_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RENDER_CONDITION') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "render_condition") {
				$resultPortletObject->setRenderCondition($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_render_condition', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly render_condition" 
	id="renderCondition" 
><?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_autorefresh', "1") == "1" || P('show_create_autorefresh', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_autorefresh_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AUTOREFRESH') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "autorefresh") {
				$resultPortletObject->setAutorefresh($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_autorefresh', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="autorefresh" name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPortletObject') && ((P('show_create_portlet_object', "1") == "1" || P('show_create_portlet_object', "1") == "2" || P('show_create_portlet_object', "1") == "3"))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " for="pob_portletObject_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
<?php echo P('show_create_portlet_object_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PORTLET_OBJECT') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPobId())) {
				$parentId = $resultPortletObject->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxpob = P('show_create_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPobId()) && $id == $resultPortletObject->getPobId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_object_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pob"])) {
		$parentValue = $context["pob"];
	} else {
		$parentValue = $resultPortletObject->pob_pob_id;
	}
	
?>
				<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_create_portlet_locations', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel portletLocation" for="pob_portletLocation_<?php echo $resultPortletObject->getId() ?>[]">
Portlet locations 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentPage = new portal\virgoPage();
			$whereList = "";
			$resultsPage = $parentPage->getVirgoList($whereList);
			$currentConnections = $resultPortletObject->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPageId();
			}
			$defaultParents = PN('create_default_values_pages');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPage) > 10 ? 10 : sizeof($resultsPage) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPage)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsPage);
			while (list($id, $label) = each($resultsPage)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
	$defaultParents = PN('create_default_values_pages');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="pob_portletLocation_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_create_html_contents', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_create_portlet_parameters', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_create_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_create_portlet_objects', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultPortletObject->pob_id)) {
			$resultPortletObject->pob_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_portlet_definition');
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
	$resultPortletObject->setPdfId($defaultValue);
}
$defaultValue = P('create_default_value_portlet_object');
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
	$resultPortletObject->setPobId($defaultValue);
}
	}
?>
																																																							<?php
	if (class_exists('portal\virgoPortletDefinition') && ((P('show_create_portlet_definition', "1") == "1" || P('show_create_portlet_definition', "1") == "2" || P('show_create_portlet_definition', "1") == "3") && !isset($context["pdf"]))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  obligatory " for="pob_portletDefinition_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
 *
<?php echo T('PORTLET_DEFINITION') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_create_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="create">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pdf"])) {
		$parentValue = $context["pdf"];
	} else {
		$parentValue = $resultPortletObject->pob_pdf_id;
	}
	
?>
				<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_create_show_title', "1") == "1" || P('show_create_show_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_show_title_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_showTitle_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_show_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SHOW_TITLE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "show_title") {
				$resultPortletObject->setShowTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_show_title', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="showTitle"
>
<?php
	if (is_null($resultPortletObject->pob_show_title) || $resultPortletObject->pob_show_title == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_show_title == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_show_title === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_custom_title', "1") == "1" || P('show_create_custom_title', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_customTitle_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_custom_title_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CUSTOM_TITLE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "custom_title") {
				$resultPortletObject->setCustomTitle($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_custom_title', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="customTitle" name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_left', "1") == "1" || P('show_create_left', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_left_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_left_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_left_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LEFT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "left") {
				$resultPortletObject->setLeft($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_left', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="left" name="pob_left_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_top', "1") == "1" || P('show_create_top', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_top_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_top_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_top_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('TOP') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "top") {
				$resultPortletObject->setTop($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_top', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="top" name="pob_top_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_width', "1") == "1" || P('show_create_width', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_width_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_width_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_width_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('WIDTH') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "width") {
				$resultPortletObject->setWidth($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_width', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="width" name="pob_width_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_height', "1") == "1" || P('show_create_height', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_height_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_height_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_height_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('HEIGHT') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "height") {
				$resultPortletObject->setHeight($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_height', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="height" name="pob_height_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_inline', "1") == "1" || P('show_create_inline', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_inline_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_inline_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_inline_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INLINE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "inline") {
				$resultPortletObject->setInline($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_inline', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="inline"
>
<?php
	if (is_null($resultPortletObject->pob_inline) || $resultPortletObject->pob_inline == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_inline == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_inline === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_ajax', "1") == "1" || P('show_create_ajax', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_ajax_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_ajax_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_ajax_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AJAX') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "ajax") {
				$resultPortletObject->setAjax($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ajax', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="ajax"
>
<?php
	if (is_null($resultPortletObject->pob_ajax) || $resultPortletObject->pob_ajax == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_ajax == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_ajax === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_render_condition', "1") == "1" || P('show_create_render_condition', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_render_condition_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_render_condition_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RENDER_CONDITION') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "render_condition") {
				$resultPortletObject->setRenderCondition($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_render_condition', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly render_condition" 
	id="renderCondition" 
><?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_autorefresh', "1") == "1" || P('show_create_autorefresh', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>">
 <?php echo P('show_create_autorefresh_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AUTOREFRESH') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "autorefresh") {
				$resultPortletObject->setAutorefresh($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_autorefresh', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="autorefresh" name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (class_exists('portal\virgoPortletObject') && ((P('show_create_portlet_object', "1") == "1" || P('show_create_portlet_object', "1") == "2" || P('show_create_portlet_object', "1") == "3"))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " for="pob_portletObject_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>">
<?php echo P('show_create_portlet_object_obligatory') == "1" ? " * " : "" ?>
<?php echo T('PORTLET_OBJECT') ?> <?php echo T('') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_create_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPobId())) {
				$parentId = $resultPortletObject->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxpob = P('show_create_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPobId()) && $id == $resultPortletObject->getPobId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_object_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
?>
<?php
	if (isset($context["pob"])) {
		$parentValue = $context["pob"];
	} else {
		$parentValue = $resultPortletObject->pob_pob_id;
	}
	
?>
				<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_create_portlet_locations', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel portletLocation" for="pob_portletLocation_<?php echo $resultPortletObject->getId() ?>[]">
Portlet locations 
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
			$parentPage = new portal\virgoPage();
			$whereList = "";
			$resultsPage = $parentPage->getVirgoList($whereList);
			$currentConnections = $resultPortletObject->getPortletLocations();
			$currentIds = array();
			foreach ($currentConnections as $currentConnection) {
				$currentIds[] = $currentConnection->getPageId();
			}
			$defaultParents = PN('create_default_values_pages');
			$currentIds = array_merge($currentIds, $defaultParents);
?>
<?php
	$inputMethod = P('n_m_children_input_portlet_location_', "select");
	if (is_null($inputMethod) || trim($inputMethod) == "") {
		$inputMethod = "select";
	}
	if ($inputMethod == "select") {
?>
						<select 
							class="inputbox" 
							id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
							multiple 
							size=<?php echo sizeof($resultsPage) > 10 ? 10 : sizeof($resultsPage) ?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>
						>
<?php
			while (list($id, $label) = each($resultsPage)) {
?>
							<option 
								value="<?php echo $id ?>"
								<?php echo in_array($id, $currentIds) ? "selected" : "" ?> 
							><?php echo $label ?></option>
<?php
			}
?>
						</select>
<?php
	} elseif ($inputMethod == "checkbox") {
?>
						<ul>
<?php
			reset($resultsPage);
			while (list($id, $label) = each($resultsPage)) {
?>
							<li class="parent_selection">
								<input 
									type="checkbox"
									class="inputbox checkbox"
									id="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									name="pob_portletLocation_<?php echo $resultPortletObject->pob_id ?>[]" 
									value="<?php echo $id ?>"
									<?php echo in_array($id, $currentIds) ? "checked" : "" ?>
								>
								<span class="multilabel"><?php echo $label ?></span>
							</li>
<?php
			}
?>
						</ul>
<?php
	} 
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	} else {
	$defaultParents = PN('create_default_values_pages');
	foreach ($defaultParents as $defaultParent) {
?>
		<input type="hidden" name="pob_portletLocation_[]" value="<?php echo $defaultParent ?>"/>
<?php	
	}
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_create_html_contents', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_create_portlet_parameters', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_create_permissions', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_create_portlet_objects', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	}
?>
<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</table>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPortletObject->getDateCreated()) {
		if ($resultPortletObject->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPortletObject->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPortletObject->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPortletObject->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPortletObject->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPortletObject->getDateModified()) {
		if ($resultPortletObject->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPortletObject->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPortletObject->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPortletObject->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPortletObject->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

						<input type="hidden" name="virgo_changed" value="N">
<?php
	$actions = virgoRole::getExtraActions('IC');
	if (isset($actions) && count($actions) > 0) {
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	} else {
?>
 <div class="button_wrapper button_wrapper_store inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Store';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php						
		if ((!isset($masterPobId) || trim($masterPobId) == "") && P('form_only', "0") != "1" && P('form_only') != "5") {
?>
 <div class="button_wrapper button_wrapper_storeandclear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndClear';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE_AND_CLEAR') ?>"
						/><div class="button_right"></div></div><?php 
	if ($this->canExecute("Form")) {
?>
 <div class="button_wrapper button_wrapper_apply inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Apply';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('APPLY') ?>"
						/><div class="button_right"></div></div><?php 
	}
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!(this.form.virgo_changed.value == 'T')) {
								} else {
									var alertText = '<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
		}
		$actions = virgoRole::getExtraActions('EC');
		foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
		}
	}
?>

				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($portletObjectDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('PORTLET_OBJECT') ?>:</legend>
				<ul>
<?php
	$criteriaPortletObject = $resultPortletObject->getCriteria();
?>
<?php
	if (P('show_search_show_title', "1") == "1") {

		if (isset($criteriaPortletObject["show_title"])) {
			$fieldCriteriaShowTitle = $criteriaPortletObject["show_title"];
			$dataTypeCriteria = $fieldCriteriaShowTitle["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('SHOW_TITLE') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_showTitle" name="virgo_search_showTitle">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_showTitle_is_null" 
				name="virgo_search_showTitle_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaShowTitle) && $fieldCriteriaShowTitle["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaShowTitle) && $fieldCriteriaShowTitle["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaShowTitle) && $fieldCriteriaShowTitle["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_custom_title', "1") == "1") {

		if (isset($criteriaPortletObject["custom_title"])) {
			$fieldCriteriaCustomTitle = $criteriaPortletObject["custom_title"];
			$dataTypeCriteria = $fieldCriteriaCustomTitle["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CUSTOM_TITLE') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_customTitle" 
							name="virgo_search_customTitle"
							style="border: yellow 1 solid;" 
							maxlength="255"
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_customTitle_is_null" 
				name="virgo_search_customTitle_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaCustomTitle) && $fieldCriteriaCustomTitle["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaCustomTitle) && $fieldCriteriaCustomTitle["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaCustomTitle) && $fieldCriteriaCustomTitle["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_left', "1") == "1") {

		if (isset($criteriaPortletObject["left"])) {
			$fieldCriteriaLeft = $criteriaPortletObject["left"];
			$dataTypeCriteria = $fieldCriteriaLeft["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LEFT') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_left_from" 
							name="virgo_search_left_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_left_to" 
							name="virgo_search_left_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_left_is_null" 
				name="virgo_search_left_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLeft) && $fieldCriteriaLeft["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLeft) && $fieldCriteriaLeft["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLeft) && $fieldCriteriaLeft["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_top', "1") == "1") {

		if (isset($criteriaPortletObject["top"])) {
			$fieldCriteriaTop = $criteriaPortletObject["top"];
			$dataTypeCriteria = $fieldCriteriaTop["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('TOP') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_top_from" 
							name="virgo_search_top_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_top_to" 
							name="virgo_search_top_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_top_is_null" 
				name="virgo_search_top_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaTop) && $fieldCriteriaTop["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaTop) && $fieldCriteriaTop["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaTop) && $fieldCriteriaTop["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_width', "1") == "1") {

		if (isset($criteriaPortletObject["width"])) {
			$fieldCriteriaWidth = $criteriaPortletObject["width"];
			$dataTypeCriteria = $fieldCriteriaWidth["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('WIDTH') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_width_from" 
							name="virgo_search_width_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_width_to" 
							name="virgo_search_width_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_width_is_null" 
				name="virgo_search_width_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaWidth) && $fieldCriteriaWidth["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaWidth) && $fieldCriteriaWidth["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaWidth) && $fieldCriteriaWidth["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_height', "1") == "1") {

		if (isset($criteriaPortletObject["height"])) {
			$fieldCriteriaHeight = $criteriaPortletObject["height"];
			$dataTypeCriteria = $fieldCriteriaHeight["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('HEIGHT') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_height_from" 
							name="virgo_search_height_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_height_to" 
							name="virgo_search_height_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_height_is_null" 
				name="virgo_search_height_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaHeight) && $fieldCriteriaHeight["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaHeight) && $fieldCriteriaHeight["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaHeight) && $fieldCriteriaHeight["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_inline', "1") == "1") {

		if (isset($criteriaPortletObject["inline"])) {
			$fieldCriteriaInline = $criteriaPortletObject["inline"];
			$dataTypeCriteria = $fieldCriteriaInline["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('INLINE') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_inline" name="virgo_search_inline">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_inline_is_null" 
				name="virgo_search_inline_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaInline) && $fieldCriteriaInline["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaInline) && $fieldCriteriaInline["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaInline) && $fieldCriteriaInline["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_ajax', "1") == "1") {

		if (isset($criteriaPortletObject["ajax"])) {
			$fieldCriteriaAjax = $criteriaPortletObject["ajax"];
			$dataTypeCriteria = $fieldCriteriaAjax["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('AJAX') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_ajax" name="virgo_search_ajax">
	<option value="" <?php echo !isset($dataTypeCriteria) ? "selected='selected'" : "" ?>></option>
	<option value="1" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] === 0 ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (isset($dataTypeCriteria) && isset($dataTypeCriteria["default"]) && $dataTypeCriteria["default"] == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_ajax_is_null" 
				name="virgo_search_ajax_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaAjax) && $fieldCriteriaAjax["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaAjax) && $fieldCriteriaAjax["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaAjax) && $fieldCriteriaAjax["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_render_condition', "1") == "1") {

		if (isset($criteriaPortletObject["render_condition"])) {
			$fieldCriteriaRenderCondition = $criteriaPortletObject["render_condition"];
			$dataTypeCriteria = $fieldCriteriaRenderCondition["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('RENDER_CONDITION') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_renderCondition" 
							name="virgo_search_renderCondition"
							style="border: yellow 1 solid;" 
							size="50" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_renderCondition_is_null" 
				name="virgo_search_renderCondition_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaRenderCondition) && $fieldCriteriaRenderCondition["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaRenderCondition) && $fieldCriteriaRenderCondition["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaRenderCondition) && $fieldCriteriaRenderCondition["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	if (P('show_search_autorefresh', "1") == "1") {

		if (isset($criteriaPortletObject["autorefresh"])) {
			$fieldCriteriaAutorefresh = $criteriaPortletObject["autorefresh"];
			$dataTypeCriteria = $fieldCriteriaAutorefresh["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('AUTOREFRESH') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_autorefresh_from" 
							name="virgo_search_autorefresh_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_autorefresh_to" 
							name="virgo_search_autorefresh_to"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["to"]) ? htmlentities($dataTypeCriteria["to"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_autorefresh_is_null" 
				name="virgo_search_autorefresh_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaAutorefresh) && $fieldCriteriaAutorefresh["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaAutorefresh) && $fieldCriteriaAutorefresh["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaAutorefresh) && $fieldCriteriaAutorefresh["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>
		</span>
<?php
	}
?>
	</li>
<?php
	}
?>
<?php
	$context = null; //$session->get('GLOBAL-VIRGO_CONTEXT_usuniete');
?>	
<?php
	if (P('show_search_portlet_definition', '1') == "1") {
		if (isset($criteriaPortletObject["portlet_definition"])) {
			$fieldCriteriaPortletDefinition = $criteriaPortletObject["portlet_definition"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('PORTLET_DEFINITION') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaPortletDefinition["value"]) ? $fieldCriteriaPortletDefinition["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_portletDefinition" name="virgo_search_portletDefinition" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_accepted_is_null" 
				name="virgo_search_accepted_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPortletDefinition) && $fieldCriteriaPortletDefinition["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPortletDefinition) && $fieldCriteriaPortletDefinition["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPortletDefinition) && $fieldCriteriaPortletDefinition["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_portlet_object', '1') == "1") {
		if (isset($criteriaPortletObject["portlet_object"])) {
			$fieldCriteriaPortletObject = $criteriaPortletObject["portlet_object"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('PORTLET_OBJECT') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaPortletObject["value"]) ? $fieldCriteriaPortletObject["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_portletObject" name="virgo_search_portletObject" value="<?php echo $value ?>">
</span>
<?php
	if (P('empty_values_search', '0') == "1") {
?>
					<span align="left" nowrap>
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_accepted_is_null" 
				name="virgo_search_accepted_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPortletObject) && $fieldCriteriaPortletObject["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPortletObject) && $fieldCriteriaPortletObject["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPortletObject) && $fieldCriteriaPortletObject["is_null"] == 2) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('EMPTY_VALUE') ?></option>
			</select>						
					</span>
<?php
	}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_portlet_locations') == "1") {
		if (isset($criteriaPortletObject["page"])) {
			$parentIds = $criteriaPortletObject["page"];
		}
		if (isset($parentIds) && isset($parentIds['ids'])) {
			$selectedIds = $parentIds['ids'];
		}
?>
				<li
					style="vertical-align: top;
					<?php echo (!$formsInTable && $floatingFields) ? "display: inline-block; float: left;" : '' ?>
					"
				>
					<label align="right" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
					>Pages</label>
<?php
		$ids = virgoPage::selectAllAsIdsStatic();
		if (count($ids) < 50) {
			$idAndName = "virgo_search_page[]";
?>
					<select class="inputbox " multiple='multiple' id="<?php echo $idAndName ?>" name="<?php echo $idAndName ?>">
<?php
			foreach ($ids as $id) {
				$obj = new virgoPage($id['id']);
?>
					<option value="<?php echo $obj->getId() ?>"
<?php
						echo (isset($selectedIds) && is_array($selectedIds) && in_array($obj->getId(), $selectedIds) ? "selected='selected'" : "");
?>
					><?php echo $obj->getVirgoTitle() ?></option>
<?php
			}
?>
					</select>
<?php
		} else {
?>
			Too many rows: <?php echo count($ids) ?> 
<?php
		}
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_html_contents') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsHtmlContents = $record->getHtmlContents();
	$sizeHtmlContents = count($subrecordsHtmlContents);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Html contents
					</label>
<?php
	if ($sizeHtmlContents == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsHtmlContents as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeHtmlContents) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_portlet_parameters') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletParameters = $record->getPortletParameters();
	$sizePortletParameters = count($subrecordsPortletParameters);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Portlet parameters
					</label>
<?php
	if ($sizePortletParameters == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletParameters as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletParameters) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_permissions') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPermissions = $record->getPermissions();
	$sizePermissions = count($subrecordsPermissions);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Permissions
					</label>
<?php
	if ($sizePermissions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPermissions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePermissions) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	if (P('show_search_portlet_objects') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletObjects = $record->getPortletObjects();
	$sizePortletObjects = count($subrecordsPortletObjects);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Portlet objects
					</label>
<?php
	if ($sizePortletObjects == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletObjects as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletObjects) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
				</li>
<?php
	}
?>
<?php
	unset($criteriaPortletObject);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div> <div class="button_wrapper button_wrapper_clear inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Clear';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLEAR') ?>"
						/><div class="button_right"></div></div><?php						
	if (P('form_only', "0") != "2") {
?> <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
	</div>
<?php
/* MILESTONE 1.4 View */
	} elseif ($portletObjectDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('PORTLET_OBJECT') ?>:</legend>
<?php
	if (!$formsInTable) {
?>
				<ul>
<?php
	} else {
?>
				<dl class="dl-horizontal">
<?php
	}
?>
																																																							<?php
	if (class_exists('portal\virgoPortletDefinition') && P('show_view_portlet_definition', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_definition"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Portlet definition </span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
			$tmpId = null;
			if (!is_null($context) && isset($context['pdf_id'])) {
				$tmpId = $context['pdf_id'];
			}
			$readOnly = "";
			if ($resultPortletObject->getId() == 0) {
// przesuac do createforgui				$resultPortletObject->pob_pdf__id = $tmpId;
			}
			$parentId = $resultPortletObject->getPortletDefinitionId();
			$parentValue = portal\virgoPortletDefinition::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pob_portletDefinition_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>" 
						name="pob_portletDefinition_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_show_title', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="show_title"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('SHOW_TITLE') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="showTitle"
>
<?php
	if (is_null($resultPortletObject->pob_show_title) || $resultPortletObject->pob_show_title == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_show_title == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_show_title === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_custom_title', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="custom_title"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('CUSTOM_TITLE') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="customTitle" name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_left', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="left"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('LEFT') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="left" name="pob_left_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_top', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="top"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('TOP') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="top" name="pob_top_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_width', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="width"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('WIDTH') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="width" name="pob_width_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_height', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="height"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('HEIGHT') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="height" name="pob_height_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_inline', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="inline"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('INLINE') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="inline"
>
<?php
	if (is_null($resultPortletObject->pob_inline) || $resultPortletObject->pob_inline == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_inline == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_inline === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_ajax', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="ajax"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('AJAX') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>


<span 
	class="inputbox readonly" 
	id="ajax"
>
<?php
	if (is_null($resultPortletObject->pob_ajax) || $resultPortletObject->pob_ajax == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultPortletObject->pob_ajax == 1) {
		$booleanValue = T("YES");
	} elseif ($resultPortletObject->pob_ajax === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_render_condition', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="render_condition"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('RENDER_CONDITION') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly render_condition" 
	id="renderCondition" 
><?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?></div>

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (P('show_view_autorefresh', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="autorefresh"
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<dt>
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
<?php echo T('AUTOREFRESH') ?>
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</dt><dd>
<?php
	}
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="autorefresh" name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</dd>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_view_portlet_object', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "portlet_object" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Portlet object </span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
<?php
			$tmpId = null;
			if (!is_null($context) && isset($context['pob_id'])) {
				$tmpId = $context['pob_id'];
			}
			$readOnly = "";
			if ($resultPortletObject->getId() == 0) {
// przesuac do createforgui				$resultPortletObject->pob_pob__id = $tmpId;
			}
			$parentId = $resultPortletObject->getPortletObjectId();
			$parentValue = portal\virgoPortletObject::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="pob_portletObject_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>" 
						name="pob_portletObject_<?php echo isset($resultPortletObject->pob_id) ? $resultPortletObject->pob_id : '' ?>" 						
						value="<?php echo $parentId ?>"
					/>
					<span class="inputbox readonly"><?php echo $parentValue ?></span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_view_portlet_locations', '0') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Portlet locations 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPage = new portal\virgoPage($subrecord->getPgeId());
			echo htmlentities($parentPage->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_view_html_contents', '0') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsHtmlContents = $record->getHtmlContents();
	$sizeHtmlContents = count($subrecordsHtmlContents);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Html contents 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizeHtmlContents == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsHtmlContents as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeHtmlContents) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_view_portlet_parameters', '0') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletParameters = $record->getPortletParameters();
	$sizePortletParameters = count($subrecordsPortletParameters);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Portlet parameters 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizePortletParameters == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletParameters as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletParameters) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_view_permissions', '0') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPermissions = $record->getPermissions();
	$sizePermissions = count($subrecordsPermissions);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Permissions 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizePermissions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPermissions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePermissions) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_view_portlet_objects', '0') == "1") {
?>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletObjects = $record->getPortletObjects();
	$sizePortletObjects = count($subrecordsPortletObjects);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="portlet_object"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">
						Portlet objects 
					</span>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span class="inputbox readonly">
<?php
	if ($sizePortletObjects == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletObjects as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletObjects) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php
	}
?>

<?php
	if (!$formsInTable) {
?>
				</ul>
<?php
	} else {
?>
				</dl>
<?php
	}
?>
			</fieldset>
<?php
	} elseif ($editForm == "virgo_entity") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('PORTLET_OBJECT') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultPortletObject->getDateCreated()) {
		if ($resultPortletObject->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultPortletObject->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultPortletObject->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultPortletObject->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultPortletObject->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultPortletObject->getDateModified()) {
		if ($resultPortletObject->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultPortletObject->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultPortletObject->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultPortletObject->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultPortletObject->getDateModified() ?>"	>
				</li>
<?php
	}
	if ($showFieldset == 1) {
?>
		</ul>
</fieldset>
<?php
	}
}
?>

				<div class="buttons form-actions">
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PORTLET_OBJECT"), "\\'".$resultPortletObject->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php						
	if (P('form_only') != "1" && P('form_only') != "7") {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>

				</div>
	</div>
<?php
/* MILESTONE 1.5 Table */
	} elseif ($portletObjectDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "pob_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultPortletObject->setShowPage(1); 
	$resultPortletObject->setShowRows('all'); 	
	$resultsPortletObject = $resultPortletObject->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsPortletObject as $resultPortletObject) {
		if (isset($resultPortletObject[$eventColumn]) && isset($events[substr($resultPortletObject[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultPortletObject[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoPortletObject($resultPortletObject['pob_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultPortletObject[$eventColumn], 0, 10)] = $eventsInDay;
	}
?>
<style type="text/css">
table.virgo_calendar_month {
	margin: 10px;
}

tr.virgo_calendar_week {
}

td.virgo_calendar_day, td.virgo_calendar_day:hover {
	border:1px solid #CCCCCC;
	font-size:20px;
	height:120px;
	padding:5px 0px;
	text-align:center;
	vertical-align:top;
	width:150px;
	color: black;
}

td.virgo_calendar_header {
	font-size:22px;
	padding: 0px 0px 10px 0px;
}

td.virgo_calendar_day {
	background-color: #FFFFFF;
}

td.virgo_calendar_day:hover {
	background-color: #FFFACD;
}

td.virgo_calendar_sunday:hover {
	background-color: #FFFACD;
	color: red !important;
}

td.virgo_calendar_day_empty {
	background: inherit;
	border: none;
}

td.virgo_calendar_sunday, td.virgo_calendar_holiday {
	color: red !important;
}
td.virgo_calendar_holiday div.holiday_name {
	font-size: 10px;
}

span.virgo_calendar_event, span.virgo_calendar_event:hover {
	font-size: 9px;
	cursor: pointer;
}

span.virgo_calendar_event_action, span.virgo_calendar_event_action:hover {
	border:1px dotted #999999;
	color:#999999;
	cursor:pointer;
	font-size:7px;
	margin:0 1px;
	padding:0 1px;
}

span.virgo_calendar_event:hover, span.virgo_calendar_event_action:hover {
	color: blue;
}

div.virgo_calendar_day_number {
}

td.virgo_calendar_weekday {
}

td.virgo_calendar_sunday {
	color: red;
}

td.virgo_calendar_today {
	background-color: #FFEEEE;
	border: 2px solid red;
}
td.virgo_calendar_today:hover {
	border: 2px solid grey;
}
td.virgo_calendar_day input.btn {
  background-color: khaki;
  background-image: none;
  border: medium none;
  border-radius: 0 0 0 0;
  color: blue;
  text-shadow: none;
  display: block !important;
  font-family: Comic Sans MS;
  font-size: 10px;
  line-height: 10px;
  margin-top: 1px;
  padding: 3px;
  width: 100%;
}
td.virgo_calendar_day div.inlineBlock {
  display: block !important;
}
td.virgo_calendar_day {
  cursor: default !important;
}
td.virgo_calendar_day div.virgo_calendar_day_number input.btn {
  display: inline;
  width: inherit;
  background-color: transparent;
  font-size: 20px;
  color: inherit;
  font-family: inherit;
  margin: auto;
  padding: 0px;
  box-shadow: none;
}
td.virgo_calendar_day div {
  text-align: center;
}
</style>
		<input
			type="hidden"
			id="<?php echo $eventColumn ?>_0" 
			name="<?php echo $eventColumn ?>_0"
			value=""
		>
		<table class='virgo_calendar_month' cellspacing="0" cellpadding="0">
			<tr>
<?php
	$tmpMonthDateTime = strtotime($selectedYear . "-" . $selectedMonth . "-01");
	$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
				<td colspan="7" align="center" class='virgo_calendar_header'><?php echo $tmpMonthDateString . " " . $selectedYear?></td>
			<tr>
			<tr class='virgo_calendar_weekdays'>
<?php
	$tmpMonthDateTime = strtotime("2010-07-26");
	for ($weekDay = 0; $weekDay <7; $weekDay++) {
		$tmpWeekDateString = strftime("%A", $tmpMonthDateTime + $weekDay * 24 * 60 * 60);
?>
				<td align="center" class='virgo_calendar_weekday <?php echo $weekDay == 6 ? "virgo_calendar_sunday" : "" ?>'><?php echo $tmpWeekDateString ?></td>
<?php
	}
?>			
			</tr>
			<tr class='virgo_calendar_week'>
				<input type='hidden' name='virgo_selected_day' value=''/>
				<input type='hidden' name='pob_id_<?php echo $this->getId() ?>' value=''/>
<?php
	$tmpWeekDay = 1;
	$safety = 0;
	if ($tmpDay["wday"] > 0) {
		while ($tmpWeekDay != ((int)$tmpDay["wday"]) && $safety < 8) {
			echo "<td class='virgo_calendar_day_empty'></td>";
			$tmpWeekDay = $tmpWeekDay + 1;
			$safety = $safety + 1;
		}
	} else {
		for ($tmp=0; $tmp<6;$tmp++) {
			echo "<td class='virgo_calendar_day_empty'></td>";
		}
	}
	$safety = 0;
	while (((int)$tmpDay["mon"]) == ((int)$selectedMonth) && $safety < 31) {
		$tmpStringDay = $tmpDay["year"] . "-" . (str_pad($tmpDay["mon"], 2, "0", STR_PAD_LEFT)) . "-" . (str_pad($tmpDay["mday"], 2, "0", STR_PAD_LEFT));
		echo "<td class='virgo_calendar_day " . (((int)$tmpDay["wday"]) == 0 ? "virgo_calendar_sunday" : "") . " " . ($tmpStringDay == date("Y-m-d") ? "virgo_calendar_today" : "") . "'>";
		echo "<div class='virgo_calendar_day_number' >";		
		if ($this->canExecute("Add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_selected_day.value='<?php echo $tmpStringDay ?>';
 								form.target = '';
							" 
							value="<?php echo T($tmpDay['mday']) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		} else {
		echo $tmpDay["mday"];			
		}
		echo "</div>";
		if (isset($events[$tmpStringDay])) {
			$eventsInDay = $events[$tmpStringDay];
			foreach ($eventsInDay as $resultPortletObject) {
?>
<?php
PROFILE('token');
	if (isset($resultPortletObject)) {
		$tmpId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultPortletObject->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.pob_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
			}
		}
		echo "</td>";
		if (((int)$tmpDay["wday"]) == 0) {
			echo "</tr><tr class='virgo_calendar_week'>";
		}
		$tmpDay = getdate(strtotime($tmpDay["year"] . "-" .  $tmpDay["mon"] . "-" . (((int)$tmpDay["mday"])+1)));
		$safety = $safety + 1;
	}
?>
			</tr>
			<tr class="data_table_header">
								<td nowrap="nowrap" width="100%" align="center" colspan="7">
									<?php AB('PreviousYear', '&lArr;') ?>
									<?php AB('PreviousMonth', '&larr;') ?>
									<?php AB('CurrentMonth', T('CURRENT_MONTH')) ?>
									<select name="virgo_cal_selected_month" onChange="this.form.portlet_action.value='SetMonth';<?php echo JSFS() ?>" class="inputbox">
<?php
	for ($month = 1; $month <13; $month++) {
		$tmpMonthDateTime = strtotime("1970-" . $month . "-01");
		$tmpMonthDateString = strftime("%B", $tmpMonthDateTime);
?>
										<option value="<?php echo $month ?>" <?php echo $month == $selectedMonth ? "selected='selected'" : "" ?>><?php echo $tmpMonthDateString ?></option>
<?php
	}
?>
									</select>
									<select name="virgo_cal_selected_year" onChange="this.form.portlet_action.value='SetYear';<?php echo JSFS() ?>" class="inputbox">
<?php
	/* 
		The last date/time that is working on 32-Bit machines:
		19.01.2038 03:14:07 ( =2147480047 )
	*/
	for ($tmpYear = 1970; $tmpYear < 2037; $tmpYear++) {
?>
										<option value="<?php echo $tmpYear ?>" <?php echo $tmpYear == $selectedYear ? "selected='selected'" : "" ?>><?php echo $tmpYear ?></option>
<?php
	}
?>
									</select>
									<?php AB('NextMonth', '&rarr;') ?>
									<?php AB('NextYear', '&rArr;') ?>
								</td>
			</tr>
		</table>
<?php
?>
<?php
		} else {
?>
<?php
PROFILE('table_01');
?>
		<script type="text/javascript">
			var portletObjectChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == portletObjectChildrenDivOpen) {
					div.style.display = 'none';
					portletObjectChildrenDivOpen = '';
				} else {
					if (portletObjectChildrenDivOpen != '') {
						document.getElementById(portletObjectChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					portletObjectChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				ids.value = '';
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(chcks[i].name.lastIndexOf("_")+1);
						}
					}
				}
			}
			
			function isOurCheckbox(name, pobId) {
				return name.match("^DELETE_" + pobId + "_\d*");
			}
			
			function nothingSelected(form, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value, pobId) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (isOurCheckbox(chcks[i].name, pobId)) {
						chcks[i].checked = value;
					}
				}
			}
			
			if (typeof portletCurrentTab === 'undefined') {
				var portletCurrentTab = new Array();
				function showOperations(tab, pobId) {
					var div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					var span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'none';
					span.className = 'operations_tab';
					portletCurrentTab[pobId] = tab;
					div = document.getElementById("operations_" + portletCurrentTab[pobId] + "_" + pobId);
					span = document.getElementById("control_" + portletCurrentTab[pobId] + "_" + pobId);
					div.style.display = 'block';
					span.className = 'operations_tab_current';
				}
				function changeDisplay(id) {
					var div = document.getElementById(id);
					div.style.display = div.style.display == "none" ? "inline-block" : "none";
				}
			}
			portletCurrentTab[<?php echo $this->getId() ?>] = "basic";
			
		</script>
<?php		
PROFILE('table_01');
PROFILE('table_02');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLanguage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLanguage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultPortletObject->getShowPage(); 
			$showRows = $resultPortletObject->getShowRows(); 
?>
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<input type="hidden" name="virgo_parent_id" id="virgo_parent_id"/>
<?php
			$actionOnRowClick = P('action_on_row_click', 'Select');
			if ($actionOnRowClick == "Custom") {
				$actionOnRowClick = P('action_on_row_click_custom', 'Select');
			}
			$actionOnRowDoubleClick = P('action_on_row_double_click', 'View');
			if ($actionOnRowDoubleClick == "Custom") {
				$actionOnRowDoubleClick = P('action_on_row_click_custom', 'View');
			}
			$hint = TE('HINT_USER');
			if (isset($hint)) {
?>
				<p><br/><?php echo $hint ?><br/><br/></p>
<?php
			}

?>
<?php echo P('master_mode', "0") == "1" ? "<div class='well sidebar-nav'>" : "" ?>
		<table class="data_table table table-striped table-hover table-condensed <?php echo P('form_only') == "4" ? "chessboard" : "" ?> <?php echo P('master_mode', "0") == "1" ? "nav nav-list" : "" ?>" cellpadding="0" cellspacing="<?php echo P('form_only') == "4"  ? "5" : "0" ?>" border="0">
<?php
			if (P('master_mode', "0") == "1") {
?>			
				<tr><td colspan="99" class="nav-header"><?php echo T('Portlet objects') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultPortletObject->getOrderColumn();
			$virgoOrderMode = $resultPortletObject->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsPortletObject = $resultPortletObject->getTableData($resultCount, $filterApplied);
PROFILE('main select');
PROFILE('table_03');

			if (P('form_only') != "4") {
?>		
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
			if ($this->canExecute("delete")) {
?>
			<th rowspan="2">
			</th>
<?php
			}
?>
																																																							<?php
	if (!isset($parentsInContext)) {
		$parentsInContext = array();
		$parentPobIds = PN('parent_entity_pob_id');
		foreach ($parentPobIds as $parentPobId) {
			$portletObject = new portal\virgoPortletObject($parentPobId);
			$className = $portletObject->getPortletDefinition()->getNamespace().'\\'.$portletObject->getPortletDefinition()->getAlias();
			$tmp2Id = $className::getRemoteContextId($parentPobId);
			if (isset($tmp2Id)) {
				$parentsInContext[$className] = $tmp2Id;
			}
		}
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_portlet_definition', "1") != "0"  && !isset($parentsInContext['portal\\virgoPortletDefinition'])  ) {
	if (P('show_table_portlet_definition', "1") == "2") {
		$tmpLookupPortletDefinition = virgoPortletDefinition::getVirgoListStatic();
?>
<input name='pob_PortletDefinition_id_<?php echo $this->getId() ?>' id='pob_PortletDefinition_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'portlet_definition');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PORTLET_DEFINITION') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "portlet_definition" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoPortletDefinition::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoPortletDefinition::getVirgoListStatic();
			$parentFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterPortletDefinition', null);
?>
						<select 
							name="virgo_filter_portlet_definition"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterTitlePortletDefinition', null);
?>
						<input
							name="virgo_filter_title_portlet_definition"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
<?php
	}
?>
<?php
	if (P('show_table_show_title', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_show_title');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('SHOW_TITLE') ?>							<?php echo ($oc == "pob_show_title" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterShowTitle', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_custom_title', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_custom_title');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CUSTOM_TITLE') ?>							<?php echo ($oc == "pob_custom_title" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterCustomTitle', null);
?>
						<input
							name="virgo_filter_custom_title"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_left', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_left');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LEFT') ?>							<?php echo ($oc == "pob_left" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterLeft', null);
?>
						<input
							name="virgo_filter_left"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_top', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_top');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('TOP') ?>							<?php echo ($oc == "pob_top" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterTop', null);
?>
						<input
							name="virgo_filter_top"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_width', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_width');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('WIDTH') ?>							<?php echo ($oc == "pob_width" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterWidth', null);
?>
						<input
							name="virgo_filter_width"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_height', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_height');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('HEIGHT') ?>							<?php echo ($oc == "pob_height" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterHeight', null);
?>
						<input
							name="virgo_filter_height"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_inline', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_inline');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('INLINE') ?>							<?php echo ($oc == "pob_inline" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterInline', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_ajax', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_ajax');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('AJAX') ?>							<?php echo ($oc == "pob_ajax" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterAjax', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_render_condition', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_render_condition');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('RENDER_CONDITION') ?>							<?php echo ($oc == "pob_render_condition" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterRenderCondition', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_autorefresh', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'pob_autorefresh');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('AUTOREFRESH') ?>							<?php echo ($oc == "pob_autorefresh" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterAutorefresh', null);
?>
						<input
							name="virgo_filter_autorefresh"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $tableFilter ?>"
							style="margin-left: auto; width: 40px; text-align: right;"
						/>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_portlet_object', "1") != "0"  && !isset($parentsInContext['portal\\virgoPortletObject'])  ) {
	if (P('show_table_portlet_object', "1") == "2") {
		$tmpLookupPortletObject = virgoPortletObject::getVirgoListStatic();
?>
<input name='pob_PortletObject_id_<?php echo $this->getId() ?>' id='pob_PortletObject_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultPortletObject->getOrderColumn(); 
	$om = $resultPortletObject->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'portlet_object');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PORTLET_OBJECT') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "portlet_object" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoPortletObject::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoPortletObject::getVirgoListStatic();
			$parentFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterPortletObject', null);
?>
						<select 
							name="virgo_filter_portlet_object"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
						>
							<option value=""></option>
							<option value="empty" <?php echo $parentFilter == "empty" ? " selected='selected' " : "" ?>>(empty)</option>
<?php
			foreach ($parents as $key => $value) {
?>							
							<option value="<?php echo $key ?>" <?php echo $parentFilter == $key ? " selected='selected' " : "" ?>><?php echo $value ?></option>
<?php
			}
?>							
						</select>
<?php		
		} else {
			$parentFilter = virgoPortletObject::getLocalSessionValue('VirgoFilterTitlePortletObject', null);
?>
						<input
							name="virgo_filter_title_portlet_object"
							class="virgo_filter"
							onChange="<?php echo JSFS(null, "Submit", true, array(), false, "SetVirgoTableFilter") ?>"
							value="<?php echo $parentFilter ?>"
						/>
<?php			
		}
	}
?>

				</th>
			
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
						<span style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PORTLET_OBJECT') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "portlet_object" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
				</th>			
<?php
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_table_html_contents', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_table_portlet_parameters', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_objects', '0') == "1") {
?>
<?php
	}
?>
				<th rowspan="2"></th>
			</tr>
			<tr class="data_table_header">
																																																
			</tr>

<?php
			}
			if ($resultCount != 0) {
				if (((int)$showRows) * (((int)$showPage)-1) == $resultCount ) {
					$showPage = ((int)$showPage)-1;
					$resultPortletObject->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsPortletObject as $resultPortletObject) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoPortletObject/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultPortletObject['pob_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoPortletObject::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoPortletObject::setContextId($resultPortletObject['pob_id'], false);
						$tmpContextId = $resultPortletObject['pob_id'];
					}
				}
				if (isset($tmpContextId) && $resultPortletObject['pob_id'] == $tmpContextId) {
					if (P('form_only') != "4") {
						$contextClass = ' contextClass ';
					} else {
						$contextClass = '';
					}
					$contextRowIdInTable = $tmpContextId;
				} else {
					$contextClass = '';
				}
?>
			<tr 
				id="<?php echo $this->getId() ?>_<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
			" 
			>
<?php
			} 
?>
<?php
			if (P('form_only') == "4") {
				$width = P('chessboard_cell_width');
				$height = P('chessboard_cell_height');
				if ($width != "0") {
					$styleWidth = " width: " . $width . "px; ";
				}
				if ($height != "0") {
					$styleHeight = " height: " . $height . "px; ";
				}
				$style = "";
				if (!is_null($styleWidth) || !is_null($styleHeight)) {
					$style = " style='" . $styleWidth . $styleHeight . "' ";
				}
?>
				<td 
					class="chessboard" 
					valign="top" 
					<?php echo $style ?>
				>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPortletObject['pob_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPortletObject['pob_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
	if (class_exists('portal\virgoPortletDefinition') && P('show_table_portlet_definition', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortletDefinition"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portlet_definition', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portlet_definition">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_portlet_definition', "1") == "1") {
		if (isset($resultPortletObject['portlet_definition'])) {
			echo $resultPortletObject['portlet_definition'];
		}
	} else {
//		echo $resultPortletObject['pob_pdf_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
	_pSF(form, 'pob_PortletDefinition_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupPortletDefinition as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPortletObject['pob_pdf_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
PROFILE('show title');
	if (P('show_table_show_title', "0") == "1") {
PROFILE('render_data_table_show_title');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="show_title">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_show_title', "1") == "1");
	if ($resultPortletObject['pob_show_title'] == 2 || is_null($resultPortletObject['pob_show_title'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_show_title']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_show_title'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_show_title'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_show_title');
	}
PROFILE('show title');
?>
<?php
PROFILE('custom title');
	if (P('show_table_custom_title', "0") == "1") {
PROFILE('render_data_table_custom_title');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="custom_title">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultPortletObject['pob_custom_title'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_custom_title');
	}
PROFILE('custom title');
?>
<?php
PROFILE('left');
	if (P('show_table_left', "0") == "1") {
PROFILE('render_data_table_left');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="left">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_left'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_left');
	}
PROFILE('left');
?>
<?php
PROFILE('top');
	if (P('show_table_top', "0") == "1") {
PROFILE('render_data_table_top');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="top">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_top'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_top');
	}
PROFILE('top');
?>
<?php
PROFILE('width');
	if (P('show_table_width', "0") == "1") {
PROFILE('render_data_table_width');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="width">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_width'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_width');
	}
PROFILE('width');
?>
<?php
PROFILE('height');
	if (P('show_table_height', "0") == "1") {
PROFILE('render_data_table_height');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="height">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_height'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_height');
	}
PROFILE('height');
?>
<?php
PROFILE('inline');
	if (P('show_table_inline', "0") == "1") {
PROFILE('render_data_table_inline');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="inline">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_inline', "1") == "1");
	if ($resultPortletObject['pob_inline'] == 2 || is_null($resultPortletObject['pob_inline'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_inline']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_inline'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_inline'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_inline');
	}
PROFILE('inline');
?>
<?php
PROFILE('ajax');
	if (P('show_table_ajax', "0") == "1") {
PROFILE('render_data_table_ajax');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="ajax">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_ajax', "1") == "1");
	if ($resultPortletObject['pob_ajax'] == 2 || is_null($resultPortletObject['pob_ajax'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_ajax']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_ajax'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_ajax'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_ajax');
	}
PROFILE('ajax');
?>
<?php
PROFILE('render condition');
	if (P('show_table_render_condition', "0") == "1") {
PROFILE('render_data_table_render_condition');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="render_condition">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<?php
			$len = strlen($resultPortletObject['pob_render_condition']);
			$shortTextSize = P('short_text_size_render_condition', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultPortletObject['pob_render_condition'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultPortletObject['pob_render_condition'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultPortletObject['pob_render_condition'], ENT_QUOTES, "UTF-8");
					if ($shortTextSize == 0) {
						echo "</pre>";
					}
				}				 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_render_condition');
	}
PROFILE('render condition');
?>
<?php
PROFILE('autorefresh');
	if (P('show_table_autorefresh', "0") == "1") {
PROFILE('render_data_table_autorefresh');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="autorefresh">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_autorefresh'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_autorefresh');
	}
PROFILE('autorefresh');
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortletObject"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portlet_object', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portlet_object">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_portlet_object', "1") == "1") {
		if (isset($resultPortletObject['portlet_object'])) {
			echo $resultPortletObject['portlet_object'];
		}
	} else {
//		echo $resultPortletObject['pob_pob_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortletObject';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
	_pSF(form, 'pob_PortletObject_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
			<option></option>
<?php
		foreach ($tmpLookupPortletObject as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPortletObject['pob_pob_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
?>
<?php
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPage = new portal\virgoPage($subrecord->getPgeId());
			echo htmlentities($parentPage->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
</td>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_table_html_contents', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_table_portlet_parameters', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_objects', '0') == "1") {
?>
<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>

<?php
PROFILE('token');
	if (isset($resultPortletObject)) {
		$tmpId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PORTLET_OBJECT"), "\\'".rawurlencode($resultPortletObject['pob_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

				</td>
<?php
			} else {
?>
<?php
			if (P('form_only') == "4") {
?>
					<ul> 
<?php
			}
?>
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("delete")) {
$showSelectAll = TRUE;
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPortletObject['pob_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php
			if (P('form_only') != "4") {
?>
			<td>
<?php
			} else {
?>
			<li>
<?php
			}
?>
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultPortletObject['pob_id'] ?>">
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>
<?php
			}
}
?>
<?php
	if (class_exists('portal\virgoPortletDefinition') && P('show_table_portlet_definition', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortletDefinition"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portlet_definition', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portlet_definition">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_portlet_definition', "1") == "1") {
		if (isset($resultPortletObject['portlet_definition'])) {
			echo $resultPortletObject['portlet_definition'];
		}
	} else {
//		echo $resultPortletObject['pob_pdf_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
	_pSF(form, 'pob_PortletDefinition_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
<?php
		foreach ($tmpLookupPortletDefinition as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPortletObject['pob_pdf_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
PROFILE('show title');
	if (P('show_table_show_title', "0") == "1") {
PROFILE('render_data_table_show_title');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="show_title">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_show_title', "1") == "1");
	if ($resultPortletObject['pob_show_title'] == 2 || is_null($resultPortletObject['pob_show_title'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_show_title']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_show_title'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_show_title'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_show_title_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetShowTitleTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_show_title');
	}
PROFILE('show title');
?>
<?php
PROFILE('custom title');
	if (P('show_table_custom_title', "0") == "1") {
PROFILE('render_data_table_custom_title');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="custom_title">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span 
			class="<?php echo 'displayClass' ?>">
				<?php echo htmlentities($resultPortletObject['pob_custom_title'], ENT_QUOTES, "UTF-8") ?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_custom_title');
	}
PROFILE('custom title');
?>
<?php
PROFILE('left');
	if (P('show_table_left', "0") == "1") {
PROFILE('render_data_table_left');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="left">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_left'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_left');
	}
PROFILE('left');
?>
<?php
PROFILE('top');
	if (P('show_table_top', "0") == "1") {
PROFILE('render_data_table_top');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="top">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_top'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_top');
	}
PROFILE('top');
?>
<?php
PROFILE('width');
	if (P('show_table_width', "0") == "1") {
PROFILE('render_data_table_width');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="width">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_width'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_width');
	}
PROFILE('width');
?>
<?php
PROFILE('height');
	if (P('show_table_height', "0") == "1") {
PROFILE('render_data_table_height');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="height">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_height'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_height');
	}
PROFILE('height');
?>
<?php
PROFILE('inline');
	if (P('show_table_inline', "0") == "1") {
PROFILE('render_data_table_inline');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="inline">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_inline', "1") == "1");
	if ($resultPortletObject['pob_inline'] == 2 || is_null($resultPortletObject['pob_inline'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_inline']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_inline'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_inline'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_inline_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetInlineTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_inline');
	}
PROFILE('inline');
?>
<?php
PROFILE('ajax');
	if (P('show_table_ajax', "0") == "1") {
PROFILE('render_data_table_ajax');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> "
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="ajax">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php
	$canEditBoolean = ($this->canEdit() && P('show_form_ajax', "1") == "1");
	if ($resultPortletObject['pob_ajax'] == 2 || is_null($resultPortletObject['pob_ajax'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo is_null($resultPortletObject['pob_ajax']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultPortletObject['pob_ajax'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxFalse';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultPortletObject['pob_ajax'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_ajax_<?php echo $resultPortletObject['pob_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetAjaxTrue';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO')
;			
		}
	} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_ajax');
	}
PROFILE('ajax');
?>
<?php
PROFILE('render condition');
	if (P('show_table_render_condition', "0") == "1") {
PROFILE('render_data_table_render_condition');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="left" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: left;"
			>
<?php
			} else {
?>
			<li class="render_condition">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<?php
			$len = strlen($resultPortletObject['pob_render_condition']);
			$shortTextSize = P('short_text_size_render_condition', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultPortletObject['pob_render_condition'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultPortletObject['pob_render_condition'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultPortletObject['pob_render_condition'], ENT_QUOTES, "UTF-8");
					if ($shortTextSize == 0) {
						echo "</pre>";
					}
				}				 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_render_condition');
	}
PROFILE('render condition');
?>
<?php
PROFILE('autorefresh');
	if (P('show_table_autorefresh', "0") == "1") {
PROFILE('render_data_table_autorefresh');
?>
<?php
			if (P('form_only') != "4") {
?>
			<td 
				align="right" 
				class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?> selectable"
				style="cursor: pointer; text-align: right;"
			>
<?php
			} else {
?>
			<li class="autorefresh">
<?php
			} 
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
		<span style="white-space: nowrap;" class="<?php echo 'displayClass' ?>">
			<?php echo 
				$resultPortletObject['pob_autorefresh'] 
			?>
		</span>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
<?php
			if (P('form_only') != "4") {
?>
			</td>
<?php
			} else {
?>
			</li>
<?php
			}
?>

<?php
PROFILE('render_data_table_autorefresh');
	}
PROFILE('autorefresh');
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_object', "1") != "0"  && !isset($parentsInContext["portal\\virgoPortletObject"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_portlet_object', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="portlet_object">
<?php
			} 
?>
    <span 
    	class="<?php echo $displayClass ?>"
    >
<?php
	if (P('show_details_method') == "1") { 
?>
			<a  
				style="cursor: pointer;" 
				onclick="
					var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
					form.portlet_action.value='View'; 
					form.pob_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultPortletObject['pob_id']) ? $resultPortletObject['pob_id'] : '' ?>'; 
					form.target = ''; 
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
				"
			> 
<?php
	} 
?>
<?php 
	if (P('show_table_portlet_object', "1") == "1") {
		if (isset($resultPortletObject['portlet_object'])) {
			echo $resultPortletObject['portlet_object'];
		}
	} else {
//		echo $resultPortletObject['pob_pob_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetPortletObject';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo $resultPortletObject['pob_id'] ?>');
	_pSF(form, 'pob_PortletObject_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
<?php
					if (isset($ajax) && !$ajax) {
?>					
						form.submit();
<?php
					} else {
						echo JSFS(null, 'Submit', true, array());
					}
?>					
		">
			<option></option>
<?php
		foreach ($tmpLookupPortletObject as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultPortletObject['pob_pob_id'] ? " selected " : "" ?>><?php echo $label ?></option>
<?php			
		}
?>
		</select>
<?php
	}
?>
<?php
	if (P('show_details_method') == "1") { 
?>
			</a> 
<?php
	} 
?>
    </span>
<?php
			if (P('form_only') != "4") {
?>
				</td>    
<?php
			} else {
?>
				</li>    
<?php
			}
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletLocation') && P('show_table_portlet_locations', '0') == "1") {
?>
<td>
<?php
	$record = new portal\virgoPortletObject();
	$recordId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->pob_id;
	$record->load($recordId);
	$subrecordsPortletLocations = $record->getPortletLocations();
	$sizePortletLocations = count($subrecordsPortletLocations);
?>
<?php
	if ($sizePortletLocations == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortletLocations as $subrecord) {
			$subrecordIndex++;
			$parentPage = new portal\virgoPage($subrecord->getPgeId());
			echo htmlentities($parentPage->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortletLocations) {
				echo ", ";
			}
		}	
?>
<?php
	}	
?>
</td>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoHtmlContent') && P('show_table_html_contents', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletParameter') && P('show_table_portlet_parameters', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPermission') && P('show_table_permissions', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoPortletObject') && P('show_table_portlet_objects', '0') == "1") {
?>
<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
			if (P('form_only') != "4") {
?>
				<td nowrap class="actions" align="left">
<?php
			} else {
?>
				<li>
<?php
			}
?>

<?php
PROFILE('token');
	if (isset($resultPortletObject)) {
		$tmpId = is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if (P('master_mode', "0") == "0") {
			if ($this->canExecute("view")) {
?>
<?php						
		if (P('show_details_method') != "1") {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('View')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_view inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='View';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('VIEW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}
?>
<?php
			}
		if ($this->canEdit()) {
?>
<?php
			if ($this->canExecute("form")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Form')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_form inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Form';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EDIT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
?>
<?php
			}
?>
<?php
			if ($this->canExecute("delete")) {
?> 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Delete')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_delete inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PORTLET_OBJECT"), "\\'".rawurlencode($resultPortletObject['pob_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DELETE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
?>
<?php 
		} 	} 
		if ($this->canEdit()) {
?>
<?php
	if (P('enable_record_duplication', "0") == "1") {
			if ($this->canExecute("add")) {
?> <div class="button_wrapper button_wrapper_duplicate inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Duplicate';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('DUPLICATE') ?>"
						/><div class="button_right"></div></div><?php			
	}
?>
<?php
			}
?>
<?php
			$actions = virgoRole::getExtraActions('ER');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
		} ?>
<?php
			if (P('form_only') != "4") {
?>
				</td>
<?php
			} else {
?>
				</li>
<?php
			}
?>
<?php
			if (P('form_only') == "4") {
?>
					</ul> 
<?php
			}
?>

<?php
			}
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 0)) {
?>
			</tr>
<?php
			} 
?>

<?php
} else {
	include($fileNameToInclude);
}
?>
<?php
				}
	if (is_null($contextRowIdInTable)) {
		$forceContextOnFirstRow = P('force_context_on_first_row', "1");
		if ($forceContextOnFirstRow == "1") {
			virgoPortletObject::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultPortletObject);
				unset($resultsPortletObject);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpPortletObject = new virgoPortletObject();
						$tmpCount = $tmpPortletObject->getAllRecordCount(' pob_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoPortletObject::clearRemoteContextId($tabModeEditMenu);
						}
					}
				}
PROFILE('rows rendering');
?>			
<?php
PROFILE('table_05');
				if ($showRows == 'all') {
					$pageCount = 1;
				} else {
					$pageCount = (int)($resultCount / $showRows) + 1;
					if ($resultCount % $showRows == 0) {
						$pageCount = $pageCount - 1;
					}
				}
PROFILE('table_05');
PROFILE('table_06_1');
?>
<?php
	if (P('master_mode', "0") != "1") {
?>
<?php
		if (P('default_page_size', "20") != 'all' || P('available_page_sizes', "5,10,20,50,all") != "all") {
?>
			<tr class="table_footer">
				<td colspan="99" nowrap="nowrap">
						<table cellspacing="0" cellpadding="0" width="100%">
							<tr class="table_footer">
<?php
$showSelectAll = FALSE;
			if ($this->canExecute("form")) {
$showSelectAll = TRUE;
?>
								<td nowrap="nowrap" width="33%" align="left" class="select_all">
<?php echo T('SELECT_ALL') ?>									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
?>
<?php
if (! $showSelectAll) {
			if ($this->canExecute("delete")) {
?>
<?php echo T('SELECT_ALL') ?>								<td nowrap="nowrap" width="33%" align="left" class="select_all">
									<input type="checkbox" class="checkbox" onclick="checkAll(this.checked, <?php echo $this->getId() ?>)">
								</td>
<?php
			}
}
?>
								<td nowrap="nowrap" width="34%" align="center" class="select_page">
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-first.png" type="image" value="&#x21E4" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == 1 ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-previous.png" type="image" value="&#x2190" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage - 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == 1 ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
<?php echo T('PAGE') ?><?php
PROFILE('table_06_1');
PROFILE('table_06_2');
	if ($pageCount > 100) {
?>
		<input class="inputbox" size="5" value="<?php echo $showPage ?>" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
	} else {
?>
									<select class="inputbox" name="showPageGui" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value=this.value; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>">
<?php
				$tmpPageIndex = 1;
				while ($tmpPageIndex <= $pageCount) {
		
?>
										<option value="<?php echo ($tmpPageIndex) ?>" <?php echo ($tmpPageIndex == $showPage ? "selected='selected'" : "") ?>><?php echo ($tmpPageIndex) ?></option>
<?php
					$tmpPageIndex = $tmpPageIndex + 1;
				}
?>
									</select>
<?php
	}
?>
<?php echo T('OF') ?>									<?php echo ($pageCount) ?>
									<input type="hidden" name="virgo_show_page" value="<?php echo ($showPage) ?>">
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-next.png" type="image" value="&#x2192" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($showPage + 1) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
									<input class="button_paging<?php echo ($showPage == $pageCount ? '_disabled' : '') ?>" src="<?php echo $_SESSION['portal_url'] ?>/media/icons/go-last.png" type="image" value="&#x21E5" onClick="this.form.action='';this.form.target='';this.form.virgo_show_page.value='<?php echo ($pageCount) ?>'; this.form.portlet_action.value='ChangePaging'; <?php echo JSFS() ?>" <?php echo ($showPage == $pageCount ? 'disabled="disabled"' : '') ?><?php echo ($showPage > 1 ? ' onmousedown="this.className=\'button_paging_pressed\'" onmouseup="this.className=\'button_paging\'" onmouseout="this.className=\'button_paging\'"' : '') ?>>
								</td>
								<td width="33%" nowrap="nowrap" align="right" class="show_rows"><?php echo T('SHOW_ROWS') ?> (<?php echo $resultCount ?>):&nbsp;<select class="inputbox" name="virgo_show_rows" onChange="this.form.action='';this.form.target='';this.form.virgo_show_page.value='1'; this.form.portlet_action.value='ChangePaging';
<?php echo JSFS() ?>									
">
<?php
										$paramValue = P('available_page_sizes', "5,10,20,50,all");
										$pageSizes = preg_split("/,/", $paramValue);
										foreach ($pageSizes as $pageSize) {
?>
										<option value="<?php echo $pageSize ?>" <?php echo ($showRows == $pageSize ? "selected='selected'" : "") ?>><?php echo ($pageSize == 'all' ? T('ALL')
 : $pageSize) ?></option>
<?php											
										}
?>
									</select>
								</td>
							</tr>
						</table>
				</td>
			</tr>
<?php
		}
?>
<?php
	}
PROFILE('table_06_2');
PROFILE('table_07');
?>
<?php
			} else {
?>
				<tr>
					<td colspan="99">
						<div class="message"><?php echo ($filterApplied ? T('NO_RESULTS')
 : T('NO_DATA_TO_SHOW')
) ?></div>
					</td>
				</tr>
<?php
			}
?>
		</table>
<?php echo P('master_mode', "0") == "1" ? "</div>" : "" ?>		
<script type='text/javascript'>
	var timer = null;
	var clicks<?php echo $this->getId() ?> = 0;
	var clicked<?php echo $this->getId() ?> = null;
$(document).ready(function() {
    $('form#portlet_form_<?php echo $this->getId() ?> table.data_table td.selectable')
    .on('click', function(e){
    	clicked<?php echo $this->getId() ?> = $(this);
        clicks<?php echo $this->getId() ?> = clicks<?php echo $this->getId() ?> + 1;
        if(clicks<?php echo $this->getId() ?> === 1) {
            var rowId = $(this).parent().attr('id');
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
            timer = setTimeout(function() {
            	clicked<?php echo $this->getId() ?>.css('cursor','progress');
<?php
		$ajax = $this->getAjax();;
		if ($actionOnRowClick == "Select" && isset($ajax) && $ajax) {
			$page = virgoPage::getCurrentPage();
?>
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&pob_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
<?php
			if (P('form_only') != "4") {
?>
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr.contextClass').removeClass("contextClass");
<?php
			}			
			$childrenToSubmit = array();
			$childrenToSubmit[$this->getId()] = prepareChildrenToSubmit($this->getId());
			$childrenToSubmitJSString = str_replace("\"", "'", json_encode($childrenToSubmit/*, JSON_FORCE_OBJECT*/));					
?>			
			var childrenToSubmit = <?php echo $childrenToSubmitJSString ?>;
			var pobId = <?php echo $this->getId() ?>;
		    	if (childrenToSubmit.hasOwnProperty(pobId)) {
			    	var currentChildrenToSubmit = childrenToSubmit[pobId];
			    	if (typeof(currentChildrenToSubmit) !== 'undefined') {
				    	if (/* mode == "Submit" && */ Object.keys(currentChildrenToSubmit).length > 0) {
							for (var child in currentChildrenToSubmit) {
							    if (currentChildrenToSubmit.hasOwnProperty(child)) {
							    	jsfs(child, "Submit", currentChildrenToSubmit[child]);
							   }
							}
				    	}
				    }
				}
<?php
		if (P('form_only') != "4") {
?>
		if (data) {
			$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#' + rowId).addClass("contextClass");
		}
<?php
		}
?>		
		clicked<?php echo $this->getId() ?>.css('cursor','pointer');        
		});
<?php
		} else {
?>
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowClick ?>'; 
		form.pob_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
			if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
			} else {
?>					
		<?php echo JSFS(null, "Submit", true, array()) ?>
<?php
			}
		}
?>					
                clicks<?php echo $this->getId() ?> = 0;
            }, 300);
        } else {
            clearTimeout(timer);
            var rowId = $(this).parent().attr('id');            
	    var virgoId = rowId.substring(rowId.indexOf("_")+1);
		var form=document.getElementById('portlet_form_<?php echo $this->getId() ?>'); 
		form.portlet_action.value='<?php echo $actionOnRowDoubleClick ?>'; 
		form.pob_id_<?php echo $this->getId() ?>.value=virgoId; 
		form.target = ''; 
<?php
	global $ajax;
	if (is_null($ajax) || (isset($ajax) && !$ajax)) {
?>					
		form.submit();
<?php
	} else {
?>					
		<?php echo JSFS() ?>
<?php
	}
?>					
            clicks<?php echo $this->getId() ?> = 0;
        }
    })
    .on('dblclick', function(e){
        e.preventDefault();
    });
});
</script>		
<?php
PROFILE('table_07');
PROFILE('table_08');
?>
<?php
	$showBasic = false;
	$showImport = false;
	$showSelected = false;
	$anythingRendered = false;
?>
		<span class="operations_tabs"><span id="table_operations" style="text-align: center;" class="table_footer_buttons"<?php echo P('form_only') == "4" ? " style='background-color: #FFFFFF;'" : "" ?>>
					<span id="control_basic_<?php echo $this->getId() ?>" class="operations_tab_current" onclick="showOperations('basic', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_BASIC') ?></span>
					<span id="control_import_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('import', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_IMPORT') ?></span>
					<span id="control_selected_<?php echo $this->getId() ?>" class="operations_tab" onclick="showOperations('selected', <?php echo $this->getId() ?>);"><?php echo T('OPERATIONS_SELECTED') ?></span>
					<div id="operations_basic_<?php echo $this->getId() ?>" class="operations">
		</span>
<?php
PROFILE('TABLE_ACTIONS_ADD');
			if ($this->canExecute("add")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Add')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_add inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Add';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('ADD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_ADD');
PROFILE('TABLE_ACTIONS_SEARCH');
			if ($this->canExecute("SearchForm")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('SearchForm')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_searchform inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='SearchForm';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('SEARCH') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_SEARCH');
?>
<?php
PROFILE('TABLE_ACTIONS_REPORT');
			if ($this->canExecute("report")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Report')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_report inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'pob_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pob_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('REPORT') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_REPORT');
PROFILE('TABLE_ACTIONS_EXPORT');
			if ($this->canExecute("export")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Export')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_export inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'pob_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pob_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('CSV') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
			if ($this->canExecute("add")) {
			if ($this->canExecute("form")) {
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Offline')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_offline inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'pob_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'pob_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('EXCEL') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
			}
			}
			}
PROFILE('TABLE_ACTIONS_EXPORT_WUT?');
?>
<?php
	if (true) { //$user->username == "metaadmin" && $user->get( 'gid' ) == 25) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('UpdateTitle')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_updatetitle inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='UpdateTitle';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPDATE_TITLE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	}
			$actions = virgoRole::getExtraActions('ET');
PROFILE('TABLE_ACTIONS_ET');
			foreach ($actions as $action) {
?>

<?php
	$buttonRendered = false;
	if ($this->canExecute($action)) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_<?php echo $action ?> inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='<?php echo $action ?>';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T($action) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php						
			}
PROFILE('TABLE_ACTIONS_ET');
?>
					</div>
					<div id="operations_import_<?php echo $this->getId() ?>" style="display: none;" class="operations">
<?php
			if ($this->canExecute("upload")) {
?>
			<input type="file" name="virgo_upload_file">
<?php
PROFILE('TABLE_ACTIONS_UPLOAD');
				$separatorString = ","; //$componentParams->get('import_separator');
				if ($separatorString == "") {
?>
			<input name="field_separator_in_import" size="1"
<?php
					$sessionSeparator = virgoPortletObject::getImportFieldSeparator();
					if (!is_null($sessionSeparator)) {
?>
						value="<?php $sessionSeparator ?>"
<?php
					}
?>
			>
<?php
				} else {
					$separators = preg_split("/X/", $separatorString);
					if (sizeof($separators) == 1) {
?>
			<input type="hidden" name="field_separator_in_import" value="<?php echo $separators[0] ?>">
<?php
					} else {
?>
			<select name="field_separator_in_import">
<?php
						$sessionSeparator = virgoPortletObject::getImportFieldSeparator();
						foreach ($separators as $separator) {
?>
				<option value="<?php echo $separator ?>" 
<?php
							if ($sessionSeparator == $separator) {
?>
					selected="selected"
<?php
							}
?>
				><?php echo $separator ?></option>
<?php
						}
?>
			</select>
<?php						
					}
				}
PROFILE('TABLE_ACTIONS_UPLOAD');				
PROFILE('TABLE_ACTIONS_RESZTA');
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('Upload')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_upload inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Upload';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('UPLOAD') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showImport = true;
	}
			}
?>
					</div>
<?php
	if (!$showImport) {
?>
<script type="text/javascript">
	document.getElementById('control_import_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
					<div id="operations_selected_<?php echo $this->getId() ?>" style="display: none;"  class="operations">
			<input type="hidden" name="ids" value="">
<?php
			if ($this->canExecute("edit")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('EditSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_editselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='EditSelected';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('EDIT_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
			if ($this->canExecute("delete")) {
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('DeleteSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_deleteselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								if (!nothingSelected(this.form, <?php echo $this->getId() ?>)) {
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('PORTLET_OBJECTS'), "") ?>'))) return false;
								} else {
									var alertText = '<?php echo T('NOTHING_SELECTED') ?>';
									if (alertText.charAt(alertText.length-1)=='?') {
										if (!confirm(alertText)) return false;
									} else {
										alert(alertText); return false;
									}
								}
								var form = this.form;
								form.action = '';
								form.portlet_action.value='DeleteSelected';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
copyIds(form, <?php echo $this->getId() ?>);
 								form.target = '';
							" 
							value="<?php echo T('DELETE_SELECTED') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
	if ($buttonRendered) {
		$showSelected = true;
	}
			}
?>





					</div>
		</span>
<?php
	if (!$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_selected_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
?>
<?php
	if (!$showImport && !$showSelected) {
?>
<script type="text/javascript">
	document.getElementById('control_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php
	}
	if (!$anythingRendered) {
?>
<script type="text/javascript">
	document.getElementById('operations_basic_<?php echo $this->getId() ?>').style.display='none';
</script>
<?php		
	}
PROFILE('TABLE_ACTIONS_RESZTA');
?>

<?php
PROFILE('table_08');
?>
<?php
		}
PROFILE('TABLE');
/* MILESTONE 1.6 TableForm */
	} elseif ($portletObjectDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_portlet_object") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var portletObjectChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == portletObjectChildrenDivOpen) {
					div.style.display = 'none';
					portletObjectChildrenDivOpen = '';
				} else {
					if (portletObjectChildrenDivOpen != '') {
						document.getElementById(portletObjectChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					portletObjectChildrenDivOpen = clickedDivId;
				}
			}
			
			function copyIds(form) {
				var chcks = document.getElementsByTagName("input");
				var ids = form.ids;
				var firstOne = 1;
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							if (firstOne == 1) {
								firstOne = 0;
							} else {
								ids.value = ids.value + ",";
							}
							ids.value = ids.value + chcks[i].name.substring(7);
						}
					}
				}
				form.submit();
			}
			
			function nothingSelected(form) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						if (chcks[i].checked == 1) {
							return false;
						}
					}
				}
				return true;
			}
			
			function checkAll(value) {
				var chcks = document.getElementsByTagName("input");
				for (i=0;i<chcks.length;i++) {
					if (chcks[i].name.match("^DELETE_\d*")) {
						chcks[i].checked = value;
					}
				}
			}
		</script>

	<form method="post" style="display: inline;" action="" id="virgo_form_portlet_object" name="virgo_form_portlet_object" enctype="multipart/form-data">
						<input type="text" name="pob_id_<?php echo $this->getId() ?>" id="pob_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_show_title', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Show title
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_custom_title', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Custom title
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_left', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Left
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_top', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Top
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_width', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Width
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_height', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Height
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_inline', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Inline
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_ajax', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ajax
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_render_condition', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Render condition
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_autorefresh', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Autorefresh
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_portlet_definition', "1") == "1" /* && ($masterComponentName != "portlet_definition" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Portlet definition </td>
<?php
	}
?>
<?php
	if (P('show_table_portlet_object', "1") == "1" /* && ($masterComponentName != "portlet_object" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Portlet object </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsPortletObject = $resultPortletObject->getRecordsToEdit();
				$idsToCorrect = $resultPortletObject->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsPortletObject as $resultPortletObject) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPortletObject->pob_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultPortletObject->pob_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('show title');
	if (P('show_table_show_title', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 0;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_showTitle_<?php echo $resultPortletObject->getId() ?>" name="pob_showTitle_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_SHOW_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getShowTitle() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getShowTitle() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getShowTitle()) || $resultPortletObject->getShowTitle() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_showTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('show title');
	} else {
?> 
						<input
							type="hidden"
							id="showTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="showTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_show_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('custom title');
	if (P('show_table_custom_title', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 1;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_custom_title_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pob_customTitle_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_customTitle_<?php echo $resultPortletObject->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletObject->getCustomTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_CUSTOM_TITLE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_customTitle_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('custom title');
	} else {
?> 
						<input
							type="hidden"
							id="customTitle_<?php echo $resultPortletObject->pob_id ?>" 
							name="customTitle_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_custom_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('left');
	if (P('show_table_left', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 2;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_left_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_left_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_left_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getLeft(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_LEFT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_left_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('left');
	} else {
?> 
						<input
							type="hidden"
							id="left_<?php echo $resultPortletObject->pob_id ?>" 
							name="left_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_left, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('top');
	if (P('show_table_top', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 3;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_top_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_top_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_top_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getTop(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_TOP');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_top_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('top');
	} else {
?> 
						<input
							type="hidden"
							id="top_<?php echo $resultPortletObject->pob_id ?>" 
							name="top_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_top, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('width');
	if (P('show_table_width', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 4;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_width_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_width_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_width_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getWidth(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_WIDTH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_width_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('width');
	} else {
?> 
						<input
							type="hidden"
							id="width_<?php echo $resultPortletObject->pob_id ?>" 
							name="width_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_width, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('height');
	if (P('show_table_height', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 5;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_height_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_height_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_height_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getHeight(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_HEIGHT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_height_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('height');
	} else {
?> 
						<input
							type="hidden"
							id="height_<?php echo $resultPortletObject->pob_id ?>" 
							name="height_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_height, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('inline');
	if (P('show_table_inline', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 6;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_inline_<?php echo $resultPortletObject->getId() ?>" name="pob_inline_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_INLINE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getInline() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getInline() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getInline()) || $resultPortletObject->getInline() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_inline_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('inline');
	} else {
?> 
						<input
							type="hidden"
							id="inline_<?php echo $resultPortletObject->pob_id ?>" 
							name="inline_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_inline, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('ajax');
	if (P('show_table_ajax', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 7;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<select class="inputbox" id="pob_ajax_<?php echo $resultPortletObject->getId() ?>" name="pob_ajax_<?php echo $resultPortletObject->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AJAX');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortletObject->getAjax() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortletObject->getAjax() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortletObject->getAjax()) || $resultPortletObject->getAjax() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_ajax_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('ajax');
	} else {
?> 
						<input
							type="hidden"
							id="ajax_<?php echo $resultPortletObject->pob_id ?>" 
							name="ajax_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_ajax, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('render condition');
	if (P('show_table_render_condition', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 8;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
<textarea 
	class="inputbox render_condition" 
	id="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>" 
	name="pob_renderCondition_<?php echo $resultPortletObject->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_RENDER_CONDITION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultPortletObject->getRenderCondition(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_renderCondition_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('render condition');
	} else {
?> 
						<input
							type="hidden"
							id="renderCondition_<?php echo $resultPortletObject->pob_id ?>" 
							name="renderCondition_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_render_condition, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('autorefresh');
	if (P('show_table_autorefresh', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 9;
?>
<?php
	if (!isset($resultPortletObject)) {
		$resultPortletObject = new portal\virgoPortletObject();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_autorefresh_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>" 
							name="pob_autorefresh_<?php echo $resultPortletObject->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPortletObject->getAutorefresh(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_OBJECT_AUTOREFRESH');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_autorefresh_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('autorefresh');
	} else {
?> 
						<input
							type="hidden"
							id="autorefresh_<?php echo $resultPortletObject->pob_id ?>" 
							name="autorefresh_<?php echo $resultPortletObject->pob_id ?>"
							value="<?php echo htmlentities($resultPortletObject->pob_autorefresh, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('extra data');
?>
<?php
PROFILE('extra data');
?>
<?php
	if (P('show_table_portlet_definition', "1") == "1"/* && ($masterComponentName != "portlet_definition" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 10;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoPortletObject::getParentInContext("portal\\virgoPortletDefinition");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_definition', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pdf__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPdfId())) {
				$parentId = $resultPortletObject->getPdfId();
				$parentValue = portal\virgoPortletDefinition::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_DEFINITION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_definition) && trim($limit_portlet_definition) != "") {
		$whereList = $whereList . " pdf_id ";
		if (trim($limit_portlet_definition) == "page_title") {
			$limit_portlet_definition = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_" . $limit_portlet_definition . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_definition = \"$limit_portlet_definition\";");
		$whereList = $whereList . " IN (" . $limit_portlet_definition . ") ";
	}						
	$parentCount = portal\virgoPortletDefinition::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_definition', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletDefinition_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_definition) || trim($limit_portlet_definition) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletDefinition = portal\virgoPortletDefinition::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletDefinition)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPdfId()) && $id == $resultPortletObject->getPdfId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPdfId();
				$parentPortletDefinition = new portal\virgoPortletDefinition();
				$parentValue = $parentPortletDefinition->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletDefinition",
			virgo_field_name: "portlet_definition",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_definition_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<li <?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>>
<label>&nbsp;</label>
<input type="hidden" name="calling_view" value="form">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('AddPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('+') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</li>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_definition_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	if (isset($context["pdf"])) {
		$parentValue = $context["pdf"];
	} else {
		$parentValue = $resultPortletObject->pob_pdf_id;
	}
	
?>
				<input type="hidden" id="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletDefinition_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_portlet_object', "1") == "1"/* && ($masterComponentName != "portlet_object" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletObject) * 11;
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletObject->pob_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletObject->getPobId())) {
				$parentId = $resultPortletObject->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_OBJECT_PORTLET_OBJECT');
?>
<?php
	$whereList = "";
	if (!is_null($limit_portlet_object) && trim($limit_portlet_object) != "") {
		$whereList = $whereList . " pob_id ";
		if (trim($limit_portlet_object) == "page_title") {
			$limit_portlet_object = "SELECT pob_id FROM prt_portlet_objects WHERE pob_" . $limit_portlet_object . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_portlet_object = \"$limit_portlet_object\";");
		$whereList = $whereList . " IN (" . $limit_portlet_object . ") ";
	}						
	$parentCount = portal\virgoPortletObject::getVirgoListSize($whereList);
	$showAjaxpob = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpob) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
							name="pob_portletObject_<?php echo !is_null($resultPortletObject->getId()) ? $resultPortletObject->getId() : '' ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
							onchange="this.form.virgo_changed.value='T';
							"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
						>
<?php
			if (is_null($limit_portlet_object) || trim($limit_portlet_object) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsPortletObject = portal\virgoPortletObject::getVirgoList($whereList);
			while(list($id, $label)=each($resultsPortletObject)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultPortletObject->getPobId()) && $id == $resultPortletObject->getPobId() ? "selected='selected'" : "");
?>
							>
								<?php echo $label ?>
							</option>
<?php
			} 
?>
    						</select>
<?php
			} else {
				$parentId = $resultPortletObject->getPobId();
				$parentPortletObject = new portal\virgoPortletObject();
				$parentValue = $parentPortletObject->lookup($parentId);
?>
<?php
	if ($parentAjaxRendered == "0") {
		$parentAjaxRendered = "1";
?>
<style type="text/css">
input.locked  {
  font-weight: bold;
  background-color: #DDD;
}
.ui-autocomplete-loading {
    background: white url('/media/icons/executing.gif') right center no-repeat;
}
</style>
<?php
	}
?>
	<input type="hidden" id="pob_portlet_object_<?php echo $resultPortletObject->getId() ?>" name="pob_portletObject_<?php echo $resultPortletObject->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" 
		autocomplete="off" 
		value="<?php echo $parentValue ?>" 
<?php
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
?>							
	/>
<script type="text/javascript">
$(function() {
        $( "#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "PortletObject",
			virgo_field_name: "portlet_object",
			virgo_matching_labels_namespace: "portal",
			virgo_match: request.term,
			<?php echo getTokenName(virgoUser::getUserId()) ?>: "<?php echo getTokenValue(virgoUser::getUserId()) ?>"
                    },
                    success: function( data ) {
                        response( $.map( data, function( item ) {
                            return {
                                label: item.title,
                                value: item.id
                            }
                        }));
                    }
                });
            },
            minLength: 0,
            select: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val(ui.item.value);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				  	$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pob_portlet_object_<?php echo $resultPortletObject->getId() ?>').val('');
				$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').removeClass("locked");		
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
</script>
<?php			
			}
?>
<?php
		} 
?>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pob_portlet_object_dropdown_<?php echo $resultPortletObject->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

    </td>
<?php
	} else {
?>
<?php
	if (isset($context["pob"])) {
		$parentValue = $context["pob"];
	} else {
		$parentValue = $resultPortletObject->pob_pob_id;
	}
	
?>
				<input type="hidden" id="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" name="pob_portletObject_<?php echo $resultPortletObject->pob_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultPortletObject->pob_id])) {
		$errorMessage = $idsToCorrect[$resultPortletObject->pob_id];
?>
					<div class="error">
						<?php echo $errorMessage ?>
					</div>
<?php
	}
?>
				</td>
				<td nowrap class="actions" align="right">

				</td>
			</tr>

<?php
				}
PROFILE('rows rendering');
?>		
				<tr>
					<td colspan="99" align="center">
						<input type="hidden" name="virgo_changed" value="N">
						<input type="hidden" name="virgo_validate_new" value="<?php echo R('virgo_validate_new', "N") ?>">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreSelected')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storeselected inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreSelected';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
			if ($this->canExecute("add")) {
?>						
						<div id="add_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'inline-block' : 'none' ?>" ><input type="button" class="button" value="<?php echo T('ADD') ?>" onclick="this.form.virgo_validate_new.value='Y'; document.getElementById('virgo_tr_id_0').style.display='table-row'; document.getElementById('remove_button').style.display='inline-block'; document.getElementById('add_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
						<div id="remove_button" class="button_wrapper" style="display: <?php echo R('virgo_validate_new', "N") == "N" ? 'none' : 'inline-block' ?>" ><input type="button" class="button" value="<?php echo T('REMOVE') ?>" onclick="this.form.virgo_validate_new.value='N'; document.getElementById('virgo_tr_id_0').style.display='none'; document.getElementById('add_button').style.display='inline-block'; document.getElementById('remove_button').style.display='none';" onmousedown="this.className='button_pressed'" onmouseup="this.className='button'" onmouseout="this.className='button'"><div class="button_right"></div></div>
<?php
			}
?>						
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} elseif ($portletObjectDisplayMode == "ADD_NEW_PARENT_PORTLET_DEFINITION") {
		$resultPortletDefinition = portal\virgoPortletDefinition::createGuiAware();
		$resultPortletDefinition->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Portlet definition</label>
<?php
	if (P('show_create_name', "1") == "1" || P('show_create_name', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  obligatory " for="pdf_name_<?php echo $resultPortletDefinition->getId() ?>">
* <?php echo T('NAME') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "name") {
				$resultPortletObject->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="pdf_name_<?php echo $resultPortletDefinition->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletDefinition)) {
		$resultPortletDefinition = new portal\virgoPortletDefinition();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pdf_name_<?php echo $resultPortletDefinition->getId() ?>" 
							name="pdf_name_<?php echo $resultPortletDefinition->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletDefinition->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_DEFINITION_NAME');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pdf_name_<?php echo $resultPortletDefinition->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_namespace', "1") == "1" || P('show_create_namespace', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  obligatory " for="pdf_namespace_<?php echo $resultPortletDefinition->getId() ?>">
* <?php echo T('NAMESPACE') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "namespace") {
				$resultPortletObject->setNamespace($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_namespace', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getNamespace(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="namespace" name="pdf_namespace_<?php echo $resultPortletDefinition->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getNamespace(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletDefinition)) {
		$resultPortletDefinition = new portal\virgoPortletDefinition();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pdf_namespace_<?php echo $resultPortletDefinition->getId() ?>" 
							name="pdf_namespace_<?php echo $resultPortletDefinition->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletDefinition->getNamespace(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_DEFINITION_NAMESPACE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pdf_namespace_<?php echo $resultPortletDefinition->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_alias', "1") == "1" || P('show_create_alias', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  obligatory " for="pdf_alias_<?php echo $resultPortletDefinition->getId() ?>">
* <?php echo T('ALIAS') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "alias") {
				$resultPortletObject->setAlias($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_alias', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAlias(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="alias" name="pdf_alias_<?php echo $resultPortletDefinition->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAlias(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletDefinition)) {
		$resultPortletDefinition = new portal\virgoPortletDefinition();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pdf_alias_<?php echo $resultPortletDefinition->getId() ?>" 
							name="pdf_alias_<?php echo $resultPortletDefinition->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletDefinition->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_DEFINITION_ALIAS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pdf_alias_<?php echo $resultPortletDefinition->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_author', "1") == "1" || P('show_create_author', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_author_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pdf_author_<?php echo $resultPortletDefinition->getId() ?>">
 <?php echo P('show_create_author_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('AUTHOR') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "author") {
				$resultPortletObject->setAuthor($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_author', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getAuthor(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="author" name="pdf_author_<?php echo $resultPortletDefinition->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getAuthor(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletDefinition)) {
		$resultPortletDefinition = new portal\virgoPortletDefinition();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_author_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pdf_author_<?php echo $resultPortletDefinition->getId() ?>" 
							name="pdf_author_<?php echo $resultPortletDefinition->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletDefinition->getAuthor(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_DEFINITION_AUTHOR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pdf_author_<?php echo $resultPortletDefinition->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<?php
	if (P('show_create_version', "1") == "1" || P('show_create_version', "1") == "2") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<label nowrap class="fieldlabel  <?php echo P('show_create_version_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="pdf_version_<?php echo $resultPortletDefinition->getId() ?>">
 <?php echo P('show_create_version_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('VERSION') ?>
					</label>
<?php
	if (!$formsInTable) {
?>
<?php
	} else {
?>
	</td><td>
<?php
	}
?>
					<span align="left" nowrap>
<?php
	$virgoSelectedDay = R('virgo_selected_day');
	if (S($virgoSelectedDay)) {
		if (P('form_only') == "3") {
			if (P('event_column') == "version") {
				$resultPortletObject->setVersion($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_version', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultPortletObject->getVersion(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="version" name="pdf_version_<?php echo $resultPortletDefinition->getId() ?>" value="<?php echo htmlentities($resultPortletObject->getVersion(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultPortletDefinition)) {
		$resultPortletDefinition = new portal\virgoPortletDefinition();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_version_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="pdf_version_<?php echo $resultPortletDefinition->getId() ?>" 
							name="pdf_version_<?php echo $resultPortletDefinition->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortletDefinition->getVersion(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTLET_DEFINITION_VERSION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
						>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pdf_version_<?php echo $resultPortletDefinition->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

<?php
	}
?>
					</span>
<?php
	if (!$formsInTable) {
?>
	</li>
<?php
	} else {
?>
	</td></tr>
<?php
	}
?>
<?php	
	}
?>

<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewPortletDefinition')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewportletdefinition inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewPortletDefinition';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('STORE') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 <div class="button_wrapper button_wrapper_backfromparent inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='BackFromParent';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('pob_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="pob_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="pob_showTitle_<?php echo $childId ?>" 
	value="<?php echo R('pob_showTitle_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_customTitle_<?php echo $childId ?>" 
	value="<?php echo R('pob_customTitle_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_left_<?php echo $childId ?>" 
	value="<?php echo R('pob_left_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_top_<?php echo $childId ?>" 
	value="<?php echo R('pob_top_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_width_<?php echo $childId ?>" 
	value="<?php echo R('pob_width_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_height_<?php echo $childId ?>" 
	value="<?php echo R('pob_height_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_inline_<?php echo $childId ?>" 
	value="<?php echo R('pob_inline_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_ajax_<?php echo $childId ?>" 
	value="<?php echo R('pob_ajax_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_renderCondition_<?php echo $childId ?>" 
	value="<?php echo R('pob_renderCondition_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_autorefresh_<?php echo $childId ?>" 
	value="<?php echo R('pob_autorefresh_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_portletDefinition_<?php echo $childId ?>" 
	value="<?php echo R('pob_portletDefinition_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="pob_portletObject_<?php echo $childId ?>" 
	value="<?php echo R('pob_portletObject_' . $childId) ?>"
/>
<?php		
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $portletObjectDisplayMode ?>">
<?php
?>
			<div class="buttons form-actions">
<?php
				if ($virgoShowReturn) {
?>
 <div class="button_wrapper button_wrapper_close inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Close';
	_pSF(form, 'pob_id_<?php echo $this->getId() ?>', '<?php echo isset($resultPortletObject) ? (is_array($resultPortletObject) ? $resultPortletObject['pob_id'] : $resultPortletObject->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
				}
?>
			</div>
		</div>
<?php
	}
} 
?>


		</div>
	</div>
</div>
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_portlet_object" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_portlet_object').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
</table>
</td>
<td valign="top">
<table>
	<tr>
		<td colspan="2">
			<b>Bean:</b>
		</td>
	</tr>
<?php
	$infos = virgoPortletObject::getExtraFilesInfo();
	foreach ($infos as $fileName => $date) {
?>
	<tr>
		<td align="right">
			<?php echo $fileName ?>
		</td>
		<td align="left">
			<?php echo $date ?>
		</td>
	</tr>
<?php
	}
?>
</table>
</td></tr></table>
</div>
<?php 
		if ($underConstruction == "1" && !is_null($user) && $user->username == "admin") {
?>
		<div style="background-color: #FFFF00; border: 1px dashed; color: #111111; font-family: monospace; font-size: 1.2em; font-weight: bold; margin: 0; padding: 2px; text-align: center;">
			Komponent w trakcie przebudowy.
		</div>
<?php
	}
?>

