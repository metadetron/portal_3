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
	use portal\virgoProcess;

//	setlocale(LC_ALL, '$messages.LOCALE');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_process');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_process/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'prt_prc.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoProcess/prt_prc.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_process" style="border: none;">
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
		$contextId = null;		
			$resultProcess = virgoProcess::createGuiAware();
			$contextId = $resultProcess->getContextId();
			if (isset($contextId)) {
				if (virgoProcess::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultProcess->load($contextId);
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
		if ($className == "virgoProcess") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultProcess = new virgoProcess($tmpId);
				virgoProcess::setDisplayMode("FORM");
			} else {
				$resultProcess = new virgoProcess();
				virgoProcess::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultProcess->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultProcess->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultProcess = new virgoProcess($allPrivateRecords[0]['prc_id']);
						$resultProcess->putInContext(false);
					} else {
						$resultProcess = new virgoProcess();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultProcess->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultProcess = new virgoProcess($records[0]['prc_id']);
							$resultProcess->putInContext(false);
						} else {
							$resultProcess = new virgoProcess();
						}
					} else {
						$resultProcess = new virgoProcess();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultProcess = new virgoProcess(virgoUser::getUserId());
			$resultProcess->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultProcess = new virgoProcess();
		}
?>
<?php
	$processDisplayMode = virgoProcess::getDisplayMode();
//	if ($processDisplayMode == "" || $processDisplayMode == "TABLE") {
//		$resultProcess = $resultProcess->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultProcess->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseProcess = $whereClauseProcess . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaProcess = $resultProcess->getCriteria();
		$countTmp = 0;
		if (isset($criteriaProcess["name"])) {
			$fieldCriteriaName = $criteriaProcess["name"];
			if ($fieldCriteriaName["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaName["value"];
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
		if (isset($criteriaProcess["execution_time"])) {
			$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
			if ($fieldCriteriaExecutionTime["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
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
		if (isset($criteriaProcess["description"])) {
			$fieldCriteriaDescription = $criteriaProcess["description"];
			if ($fieldCriteriaDescription["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaDescription["value"];
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
		if (isset($criteriaProcess["initiation_code"])) {
			$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
			if ($fieldCriteriaInitiationCode["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaProcess["execution_code"])) {
			$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
			if ($fieldCriteriaExecutionCode["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaProcess["closing_code"])) {
			$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
			if ($fieldCriteriaClosingCode["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaProcess["portion_size"])) {
			$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
			if ($fieldCriteriaPortionSize["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
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
		if (isset($criteriaProcess["active"])) {
			$fieldCriteriaActive = $criteriaProcess["active"];
			if ($fieldCriteriaActive["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaActive["value"];
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
		if (isset($criteriaProcess["order"])) {
			$fieldCriteriaOrder = $criteriaProcess["order"];
			if ($fieldCriteriaOrder["is_null"] != 0) {
				$countTmp = $countTmp + 1;
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
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaProcess["last_session"])) {
			$fieldCriteriaLastSession = $criteriaProcess["last_session"];
			if ($fieldCriteriaLastSession["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaLastSession["value"];
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
		if (isset($criteriaProcess["subprocess_count"])) {
			$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
			if ($fieldCriteriaSubprocessCount["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
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
		if (isset($criteriaProcess["clear"])) {
			$fieldCriteriaClear = $criteriaProcess["clear"];
			if ($fieldCriteriaClear["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaClear["value"];
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
		if (is_null($criteriaProcess) || sizeof($criteriaProcess) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaProcess["name"])) {
				$fieldCriteriaName = $criteriaProcess["name"];
				if ($fieldCriteriaName["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaName["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaName["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaName["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='name';
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
			if (isset($criteriaProcess["execution_time"])) {
				$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
				if ($fieldCriteriaExecutionTime["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Execution time') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaExecutionTime["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaExecutionTime["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution_time';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Execution time') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution_time';
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
			if (isset($criteriaProcess["description"])) {
				$fieldCriteriaDescription = $criteriaProcess["description"];
				if ($fieldCriteriaDescription["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Description') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaDescription["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaDescription["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='description';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaDescription["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Description') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='description';
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
			if (isset($criteriaProcess["initiation_code"])) {
				$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
				if ($fieldCriteriaInitiationCode["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Initiation code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaInitiationCode["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaInitiationCode["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='initiation_code';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Initiation code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='initiation_code';
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
			if (isset($criteriaProcess["execution_code"])) {
				$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
				if ($fieldCriteriaExecutionCode["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Execution code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaExecutionCode["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaExecutionCode["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution_code';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Execution code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution_code';
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
			if (isset($criteriaProcess["closing_code"])) {
				$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
				if ($fieldCriteriaClosingCode["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Closing code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaClosingCode["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaClosingCode["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='closing_code';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Closing code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='closing_code';
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
			if (isset($criteriaProcess["portion_size"])) {
				$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
				if ($fieldCriteriaPortionSize["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Portion size') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaPortionSize["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaPortionSize["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portion_size';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
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
					<?php echo T('Portion size') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='portion_size';
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
			if (isset($criteriaProcess["active"])) {
				$fieldCriteriaActive = $criteriaProcess["active"];
				if ($fieldCriteriaActive["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Active') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaActive["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaActive["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='active';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaActive["value"];
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
					<?php echo T('Active') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='active';
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
			if (isset($criteriaProcess["order"])) {
				$fieldCriteriaOrder = $criteriaProcess["order"];
				if ($fieldCriteriaOrder["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Order') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaOrder["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaOrder["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='order';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
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
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Order') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='order';
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
			if (isset($criteriaProcess["last_session"])) {
				$fieldCriteriaLastSession = $criteriaProcess["last_session"];
				if ($fieldCriteriaLastSession["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last session') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaLastSession["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaLastSession["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_session';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaLastSession["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Last session') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='last_session';
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
			if (isset($criteriaProcess["subprocess_count"])) {
				$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
				if ($fieldCriteriaSubprocessCount["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Subprocess count') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaSubprocessCount["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaSubprocessCount["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='subprocess_count';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
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
					<?php echo T('Subprocess count') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='subprocess_count';
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
			if (isset($criteriaProcess["clear"])) {
				$fieldCriteriaClear = $criteriaProcess["clear"];
				if ($fieldCriteriaClear["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Clear') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaClear["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaClear["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='clear';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaClear["value"];
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
					<?php echo T('Clear') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='clear';
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
	if (isset($resultProcess)) {
		$tmpId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($processDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultProcess->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultProcess->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$processDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultProcess->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($processDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_process") {
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
<?php echo T('PROCESS') ?>:</legend>
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
	if (P('show_form_name', "1") == "1" || P('show_form_name', "1") == "2") {
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
						class="fieldlabel  obligatory   name varchar" 
						for="prc_name_<?php echo $resultProcess->getId() ?>"
					>* <?php echo T('NAME') ?>
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
	if (P('show_form_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prc_name_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prc_name_<?php echo $resultProcess->getId() ?>" 
							name="prc_name_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_NAME');
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
$('#prc_name_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_execution_time', "1") == "1" || P('show_form_execution_time', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?>   execution_time varchar" 
						for="prc_executionTime_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_TIME') ?>
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
	if (P('show_form_execution_time', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="executionTime" name="prc_executionTime_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_executionTime_<?php echo $resultProcess->getId() ?>" 
							name="prc_executionTime_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_TIME');
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
$('#prc_executionTime_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_description', "1") == "1" || P('show_form_description', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_description_obligatory', "0") == "1" ? " obligatory " : "" ?>   description text" 
						for="prc_description_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
	if (P('show_form_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultProcess->prc_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox description" 
	id="prc_description_<?php echo $resultProcess->getId() ?>" 
	name="prc_description_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_description_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_initiation_code', "1") == "1" || P('show_form_initiation_code', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_initiation_code_obligatory', "0") == "1" ? " obligatory " : "" ?>   initiation_code code" 
						for="prc_initiationCode_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_initiation_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INITIATION_CODE') ?>
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
	if (P('show_form_initiation_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_initiationCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_initiation_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_initiationCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox initiation_code" 
	id="prc_initiationCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_INITIATION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getInitiationCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_initiationCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_execution_code', "1") == "1" || P('show_form_execution_code', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_execution_code_obligatory', "0") == "1" ? " obligatory " : "" ?>   execution_code code" 
						for="prc_executionCode_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_execution_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_CODE') ?>
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
	if (P('show_form_execution_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_executionCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_executionCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_execution_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_executionCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox execution_code" 
	id="prc_executionCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_executionCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getExecutionCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_executionCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_closing_code', "1") == "1" || P('show_form_closing_code', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_closing_code_obligatory', "0") == "1" ? " obligatory " : "" ?>   closing_code code" 
						for="prc_closingCode_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_closing_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLOSING_CODE') ?>
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
	if (P('show_form_closing_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_closingCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_closingCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_closing_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_closingCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox closing_code" 
	id="prc_closingCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_closingCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLOSING_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getClosingCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_closingCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_portion_size', "1") == "1" || P('show_form_portion_size', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?>   portion_size integer" 
						for="prc_portionSize_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PORTION_SIZE') ?>
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
	if (P('show_form_portion_size', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="portionSize" name="prc_portionSize_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_portionSize_<?php echo $resultProcess->getId() ?>" 
							name="prc_portionSize_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_PORTION_SIZE');
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
$('#prc_portionSize_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_active', "1") == "1" || P('show_form_active', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_active_obligatory', "0") == "1" ? " obligatory " : "" ?>   active bool" 
						for="prc_active_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_active_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACTIVE') ?>
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
	if (P('show_form_active', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="active"
>
<?php
	if (is_null($resultProcess->prc_active) || $resultProcess->prc_active == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_active == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_active === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_active_<?php echo $resultProcess->getId() ?>" name="prc_active_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ACTIVE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getActive() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getActive() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getActive()) || $resultProcess->getActive() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_active_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_order', "1") == "1" || P('show_form_order', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   order integer" 
						for="prc_order_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
	if (P('show_form_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="prc_order_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_order_<?php echo $resultProcess->getId() ?>" 
							name="prc_order_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ORDER');
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
$('#prc_order_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_last_session', "1") == "1" || P('show_form_last_session', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?>   last_session varchar" 
						for="prc_lastSession_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_last_session_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SESSION') ?>
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
	if (P('show_form_last_session', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSession" name="prc_lastSession_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_lastSession_<?php echo $resultProcess->getId() ?>" 
							name="prc_lastSession_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_LAST_SESSION');
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
$('#prc_lastSession_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_subprocess_count', "1") == "1" || P('show_form_subprocess_count', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?>   subprocess_count integer" 
						for="prc_subprocessCount_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SUBPROCESS_COUNT') ?>
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
	if (P('show_form_subprocess_count', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="subprocessCount" name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" 
							name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_SUBPROCESS_COUNT');
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
$('#prc_subprocessCount_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_form_clear', "1") == "1" || P('show_form_clear', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_clear_obligatory', "0") == "1" ? " obligatory " : "" ?>   clear bool" 
						for="prc_clear_<?php echo $resultProcess->getId() ?>"
					> <?php echo P('show_form_clear_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLEAR') ?>
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
	if (P('show_form_clear', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="clear"
>
<?php
	if (is_null($resultProcess->prc_clear) || $resultProcess->prc_clear == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_clear == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_clear === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_clear_<?php echo $resultProcess->getId() ?>" name="prc_clear_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLEAR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getClear() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getClear() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getClear()) || $resultProcess->getClear() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_clear_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoExecution') && P('show_form_executions', '1') == "1") {
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
	if (false) { //$componentParams->get('show_form_executions') == "1") {
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
//	$componentParamsExecution = &JComponentHelper::getParams('com_prt_execution');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_process/prt_process_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_process/prt_process_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_process/prt_process_class.php");
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
	if (false) { //$componentParamsExecution->get('show_table_begin') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Begin
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_progress') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Progress
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_end') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							End
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_result') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Result
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_statistics') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Statistics
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpExecution = new portal\virgoExecution();
				$resultsExecution = $tmpExecution->selectAll(' exc_prc_id = ' . $resultProcess->prc_id);
				$idsToCorrect = $tmpExecution->getInvalidRecords();
				$index = 0;
				foreach ($resultsExecution as $resultExecution) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultExecution->exc_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultExecution->exc_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultExecution->exc_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultExecution->exc_id) ? 0 : $resultExecution->exc_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultExecution->exc_id;
		$resultExecution = new virgoExecution;
		$resultExecution->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsExecution->get('show_table_begin') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 0;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultExecution->getBegin();
?>
						<input class="inputbox" id="exc_begin_<?php echo $resultExecution->getId() ?>" name="exc_begin_<?php echo $resultExecution->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_begin_<?php echo $resultExecution->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_begin_<?php echo $resultExecution->getId() ?>'] = function () {
  $("#exc_begin_<?php echo $resultExecution->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="begin_<?php echo $resultProcess->prc_id ?>" 
							name="begin_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_begin, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_progress') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 1;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_progress_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="exc_progress_<?php echo $resultExecution->getId() ?>" 
							name="exc_progress_<?php echo $resultExecution->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PROGRESS');
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
$('#exc_progress_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
							id="progress_<?php echo $resultProcess->prc_id ?>" 
							name="progress_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_progress, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_end') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 2;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultExecution->getEnd();
?>
						<input class="inputbox" id="exc_end_<?php echo $resultExecution->getId() ?>" name="exc_end_<?php echo $resultExecution->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_end_<?php echo $resultExecution->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_end_<?php echo $resultExecution->getId() ?>'] = function () {
  $("#exc_end_<?php echo $resultExecution->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="end_<?php echo $resultProcess->prc_id ?>" 
							name="end_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_end, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_result') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 3;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_result_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="exc_result_<?php echo $resultExecution->getId() ?>" 
							name="exc_result_<?php echo $resultExecution->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_RESULT');
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
$('#exc_result_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
							id="result_<?php echo $resultProcess->prc_id ?>" 
							name="result_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_result, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_statistics') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 4;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
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
	id="exc_statistics_<?php echo $resultExecution->getId() ?>" 
	name="exc_statistics_<?php echo $resultExecution->getId() ?>"
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
><?php echo htmlentities($resultExecution->getStatistics(), ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
		var editor = CKEDITOR.instances['exc_statistics_<?php echo $resultExecution->getId() ?>'];
		if (editor) { 
			editor.destroy(true); 
		}
  $('#exc_statistics_<?php echo $resultExecution->getId() ?>').ckeditor({
		filebrowserUploadUrl: '<?php echo $_SESSION['portal_url'] ?>/?virgo_upload=true'
<?php
		if (P('show_toolbar_statistics', '1') == '0') {
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
							id="statistics_<?php echo $resultProcess->prc_id ?>" 
							name="statistics_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_statistics, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$resultExecution = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultExecution->exc_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultExecution->exc_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultExecution->exc_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultExecution->exc_id) ? 0 : $resultExecution->exc_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultExecution->exc_id;
		$resultExecution = new virgoExecution;
		$resultExecution->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsExecution->get('show_table_begin') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 0;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultExecution->getBegin();
?>
						<input class="inputbox" id="exc_begin_<?php echo $resultExecution->getId() ?>" name="exc_begin_<?php echo $resultExecution->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_begin_<?php echo $resultExecution->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_begin_<?php echo $resultExecution->getId() ?>'] = function () {
  $("#exc_begin_<?php echo $resultExecution->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="begin_<?php echo $resultProcess->prc_id ?>" 
							name="begin_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_begin, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_progress') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 1;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_progress_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="exc_progress_<?php echo $resultExecution->getId() ?>" 
							name="exc_progress_<?php echo $resultExecution->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PROGRESS');
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
$('#exc_progress_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
							id="progress_<?php echo $resultProcess->prc_id ?>" 
							name="progress_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_progress, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_end') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 2;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
<?php
	$locale = setlocale(LC_ALL,"0");
	if (isset($locale) && trim($locale) != "") {
		$lang = substr($locale, 0, 2);
	} else {
		$lang = "en";
	}
	if (!defined('JS_INCLUDED_DATEPICKER')) {
		define('JS_INCLUDED_DATEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/development-bundle/ui/i18n/jquery.ui.datepicker-<?php echo $lang ?>.js"></script>
<?php
	}
	if (!defined('JS_INCLUDED_TIMEPICKER')) {
		define('JS_INCLUDED_TIMEPICKER', 1);
?>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQuery.timepicker/jquery-ui-timepicker-addon.js"></script>
<?php
	}
?>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = $resultExecution->getEnd();
?>
						<input class="inputbox" id="exc_end_<?php echo $resultExecution->getId() ?>" name="exc_end_<?php echo $resultExecution->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_end_<?php echo $resultExecution->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['exc_end_<?php echo $resultExecution->getId() ?>'] = function () {
  $("#exc_end_<?php echo $resultExecution->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="end_<?php echo $resultProcess->prc_id ?>" 
							name="end_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_end, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_result') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 3;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_result_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="exc_result_<?php echo $resultExecution->getId() ?>" 
							name="exc_result_<?php echo $resultExecution->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_RESULT');
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
$('#exc_result_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
							id="result_<?php echo $resultProcess->prc_id ?>" 
							name="result_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_result, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecution->get('show_table_statistics') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 4;
?>
<?php
	if (!isset($resultExecution)) {
		$resultExecution = new portal\virgoExecution();
	}
?>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox" 
	id="exc_statistics_<?php echo $resultExecution->getId() ?>" 
	name="exc_statistics_<?php echo $resultExecution->getId() ?>"
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
><?php echo htmlentities($resultExecution->getStatistics(), ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
		var editor = CKEDITOR.instances['exc_statistics_<?php echo $resultExecution->getId() ?>'];
		if (editor) { 
			editor.destroy(true); 
		}
  $('#exc_statistics_<?php echo $resultExecution->getId() ?>').ckeditor({
		filebrowserUploadUrl: '<?php echo $_SESSION['portal_url'] ?>/?virgo_upload=true'
<?php
		if (P('show_toolbar_statistics', '1') == '0') {
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
							id="statistics_<?php echo $resultProcess->prc_id ?>" 
							name="statistics_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_statistics, ENT_QUOTES, "UTF-8") ?>"
						>

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
				$tmpExecution->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultProcess->getDateCreated()) {
		if ($resultProcess->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultProcess->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultProcess->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultProcess->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultProcess->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultProcess->getDateModified()) {
		if ($resultProcess->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultProcess->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultProcess->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultProcess->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultProcess->getDateModified() ?>"	>
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
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PROCESS"), "\\'".rawurlencode($resultProcess->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreAndExecuteNow')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storeandexecutenow inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('Are you sure you want to execute process?'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreAndExecuteNow';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EXECUTE NOW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['prc_name_<?php echo $resultProcess->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($processDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_process") {
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
<?php echo T('PROCESS') ?>:</legend>
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
		if (isset($resultProcess->prc_id)) {
			$resultProcess->prc_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

	}
?>
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
					<label nowrap class="fieldlabel  obligatory " for="prc_name_<?php echo $resultProcess->getId() ?>">
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
				$resultProcess->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prc_name_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prc_name_<?php echo $resultProcess->getId() ?>" 
							name="prc_name_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_NAME');
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
$('#prc_name_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_execution_time', "1") == "1" || P('show_create_execution_time', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_executionTime_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_execution_time_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_TIME') ?>
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
			if (P('event_column') == "execution_time") {
				$resultProcess->setExecutionTime($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_execution_time', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="executionTime" name="prc_executionTime_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_executionTime_<?php echo $resultProcess->getId() ?>" 
							name="prc_executionTime_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_TIME');
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
$('#prc_executionTime_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_description', "1") == "1" || P('show_create_description', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_description_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_description_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
			if (P('event_column') == "description") {
				$resultProcess->setDescription($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultProcess->prc_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox description" 
	id="prc_description_<?php echo $resultProcess->getId() ?>" 
	name="prc_description_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_description_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_initiation_code', "1") == "1" || P('show_create_initiation_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_initiation_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_initiationCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_initiation_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INITIATION_CODE') ?>
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
			if (P('event_column') == "initiation_code") {
				$resultProcess->setInitiationCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_initiation_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_initiationCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_initiation_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_initiationCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox initiation_code" 
	id="prc_initiationCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_INITIATION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getInitiationCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_initiationCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_execution_code', "1") == "1" || P('show_create_execution_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_execution_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_executionCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_execution_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_CODE') ?>
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
			if (P('event_column') == "execution_code") {
				$resultProcess->setExecutionCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_execution_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_executionCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_executionCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_execution_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_executionCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox execution_code" 
	id="prc_executionCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_executionCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getExecutionCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_executionCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_closing_code', "1") == "1" || P('show_create_closing_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_closing_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_closingCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_closing_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLOSING_CODE') ?>
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
			if (P('event_column') == "closing_code") {
				$resultProcess->setClosingCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_closing_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_closingCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_closingCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_closing_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_closingCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox closing_code" 
	id="prc_closingCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_closingCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLOSING_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getClosingCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_closingCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_portion_size', "1") == "1" || P('show_create_portion_size', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_portionSize_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_portion_size_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PORTION_SIZE') ?>
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
			if (P('event_column') == "portion_size") {
				$resultProcess->setPortionSize($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_portion_size', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="portionSize" name="prc_portionSize_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_portionSize_<?php echo $resultProcess->getId() ?>" 
							name="prc_portionSize_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_PORTION_SIZE');
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
$('#prc_portionSize_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_active', "1") == "1" || P('show_create_active', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_active_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_active_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_active_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACTIVE') ?>
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
			if (P('event_column') == "active") {
				$resultProcess->setActive($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_active', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="active"
>
<?php
	if (is_null($resultProcess->prc_active) || $resultProcess->prc_active == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_active == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_active === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_active_<?php echo $resultProcess->getId() ?>" name="prc_active_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ACTIVE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getActive() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getActive() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getActive()) || $resultProcess->getActive() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_active_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_order', "1") == "1" || P('show_create_order', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_order_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_order_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
			if (P('event_column') == "order") {
				$resultProcess->setOrder($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="prc_order_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_order_<?php echo $resultProcess->getId() ?>" 
							name="prc_order_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ORDER');
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
$('#prc_order_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_last_session', "1") == "1" || P('show_create_last_session', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_lastSession_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_last_session_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SESSION') ?>
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
			if (P('event_column') == "last_session") {
				$resultProcess->setLastSession($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_session', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSession" name="prc_lastSession_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_lastSession_<?php echo $resultProcess->getId() ?>" 
							name="prc_lastSession_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_LAST_SESSION');
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
$('#prc_lastSession_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_subprocess_count', "1") == "1" || P('show_create_subprocess_count', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_subprocessCount_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_subprocess_count_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SUBPROCESS_COUNT') ?>
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
			if (P('event_column') == "subprocess_count") {
				$resultProcess->setSubprocessCount($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_subprocess_count', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="subprocessCount" name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" 
							name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_SUBPROCESS_COUNT');
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
$('#prc_subprocessCount_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_clear', "1") == "1" || P('show_create_clear', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_clear_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_clear_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_clear_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLEAR') ?>
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
			if (P('event_column') == "clear") {
				$resultProcess->setClear($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_clear', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="clear"
>
<?php
	if (is_null($resultProcess->prc_clear) || $resultProcess->prc_clear == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_clear == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_clear === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_clear_<?php echo $resultProcess->getId() ?>" name="prc_clear_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLEAR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getClear() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getClear() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getClear()) || $resultProcess->getClear() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_clear_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoExecution') && P('show_create_executions', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultProcess->prc_id)) {
			$resultProcess->prc_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

	}
?>
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
					<label nowrap class="fieldlabel  obligatory " for="prc_name_<?php echo $resultProcess->getId() ?>">
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
				$resultProcess->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prc_name_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prc_name_<?php echo $resultProcess->getId() ?>" 
							name="prc_name_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_NAME');
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
$('#prc_name_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_execution_time', "1") == "1" || P('show_create_execution_time', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_executionTime_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_execution_time_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_TIME') ?>
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
			if (P('event_column') == "execution_time") {
				$resultProcess->setExecutionTime($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_execution_time', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="executionTime" name="prc_executionTime_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_executionTime_<?php echo $resultProcess->getId() ?>" 
							name="prc_executionTime_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_TIME');
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
$('#prc_executionTime_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_description', "1") == "1" || P('show_create_description', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_description_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_description_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_description_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DESCRIPTION') ?>
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
			if (P('event_column') == "description") {
				$resultProcess->setDescription($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultProcess->prc_description, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox description" 
	id="prc_description_<?php echo $resultProcess->getId() ?>" 
	name="prc_description_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_description_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_initiation_code', "1") == "1" || P('show_create_initiation_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_initiation_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_initiationCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_initiation_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('INITIATION_CODE') ?>
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
			if (P('event_column') == "initiation_code") {
				$resultProcess->setInitiationCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_initiation_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_initiationCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_initiation_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_initiationCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox initiation_code" 
	id="prc_initiationCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_INITIATION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getInitiationCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_initiationCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_execution_code', "1") == "1" || P('show_create_execution_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_execution_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_executionCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_execution_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('EXECUTION_CODE') ?>
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
			if (P('event_column') == "execution_code") {
				$resultProcess->setExecutionCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_execution_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_executionCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_executionCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_execution_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_executionCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox execution_code" 
	id="prc_executionCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_executionCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getExecutionCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_executionCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_closing_code', "1") == "1" || P('show_create_closing_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_closing_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_closingCode_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_closing_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLOSING_CODE') ?>
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
			if (P('event_column') == "closing_code") {
				$resultProcess->setClosingCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_closing_code', "1") == "2") {
?>
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_closingCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_closingCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_closing_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_closingCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox closing_code" 
	id="prc_closingCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_closingCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLOSING_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getClosingCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_closingCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_portion_size', "1") == "1" || P('show_create_portion_size', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_portionSize_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_portion_size_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PORTION_SIZE') ?>
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
			if (P('event_column') == "portion_size") {
				$resultProcess->setPortionSize($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_portion_size', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="portionSize" name="prc_portionSize_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_portionSize_<?php echo $resultProcess->getId() ?>" 
							name="prc_portionSize_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_PORTION_SIZE');
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
$('#prc_portionSize_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_active', "1") == "1" || P('show_create_active', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_active_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_active_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_active_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ACTIVE') ?>
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
			if (P('event_column') == "active") {
				$resultProcess->setActive($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_active', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="active"
>
<?php
	if (is_null($resultProcess->prc_active) || $resultProcess->prc_active == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_active == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_active === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_active_<?php echo $resultProcess->getId() ?>" name="prc_active_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ACTIVE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getActive() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getActive() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getActive()) || $resultProcess->getActive() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_active_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_order', "1") == "1" || P('show_create_order', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_order_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_order_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_order_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('ORDER') ?>
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
			if (P('event_column') == "order") {
				$resultProcess->setOrder($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="prc_order_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_order_<?php echo $resultProcess->getId() ?>" 
							name="prc_order_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ORDER');
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
$('#prc_order_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_last_session', "1") == "1" || P('show_create_last_session', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_lastSession_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_last_session_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('LAST_SESSION') ?>
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
			if (P('event_column') == "last_session") {
				$resultProcess->setLastSession($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_session', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSession" name="prc_lastSession_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_lastSession_<?php echo $resultProcess->getId() ?>" 
							name="prc_lastSession_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_LAST_SESSION');
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
$('#prc_lastSession_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_subprocess_count', "1") == "1" || P('show_create_subprocess_count', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_subprocessCount_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_subprocess_count_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('SUBPROCESS_COUNT') ?>
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
			if (P('event_column') == "subprocess_count") {
				$resultProcess->setSubprocessCount($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_subprocess_count', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="subprocessCount" name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" 
							name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_SUBPROCESS_COUNT');
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
$('#prc_subprocessCount_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (P('show_create_clear', "1") == "1" || P('show_create_clear', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_clear_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="prc_clear_<?php echo $resultProcess->getId() ?>">
 <?php echo P('show_create_clear_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CLEAR') ?>
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
			if (P('event_column') == "clear") {
				$resultProcess->setClear($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_clear', "1") == "2") {
?>


<span 
	class="inputbox readonly" 
	id="clear"
>
<?php
	if (is_null($resultProcess->prc_clear) || $resultProcess->prc_clear == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_clear == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_clear === "0") {
		$booleanValue = T("NO");
	}
?>
	<?php echo $booleanValue ?>
</span>

<?php
	} else {
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_clear_<?php echo $resultProcess->getId() ?>" name="prc_clear_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLEAR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getClear() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getClear() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getClear()) || $resultProcess->getClear() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_clear_<?php echo $resultProcess->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoExecution') && P('show_create_executions', '1') == "1") {
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
	if ($resultProcess->getDateCreated()) {
		if ($resultProcess->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultProcess->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultProcess->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultProcess->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultProcess->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultProcess->getDateModified()) {
		if ($resultProcess->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultProcess->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultProcess->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultProcess->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultProcess->getDateModified() ?>"	>
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
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['prc_name_<?php echo $resultProcess->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($processDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('PROCESS') ?>:</legend>
				<ul>
<?php
	$criteriaProcess = $resultProcess->getCriteria();
?>
<?php
	if (P('show_search_name', "1") == "1") {

		if (isset($criteriaProcess["name"])) {
			$fieldCriteriaName = $criteriaProcess["name"];
			$dataTypeCriteria = $fieldCriteriaName["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('NAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_name" 
							name="virgo_search_name"
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
				id="virgo_search_name_is_null" 
				name="virgo_search_name_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaName) && $fieldCriteriaName["is_null"] == 2) {
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
	if (P('show_search_execution_time', "1") == "1") {

		if (isset($criteriaProcess["execution_time"])) {
			$fieldCriteriaExecutionTime = $criteriaProcess["execution_time"];
			$dataTypeCriteria = $fieldCriteriaExecutionTime["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('EXECUTION_TIME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_executionTime" 
							name="virgo_search_executionTime"
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
				id="virgo_search_executionTime_is_null" 
				name="virgo_search_executionTime_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaExecutionTime) && $fieldCriteriaExecutionTime["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaExecutionTime) && $fieldCriteriaExecutionTime["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaExecutionTime) && $fieldCriteriaExecutionTime["is_null"] == 2) {
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
	if (P('show_search_description', "1") == "1") {

		if (isset($criteriaProcess["description"])) {
			$fieldCriteriaDescription = $criteriaProcess["description"];
			$dataTypeCriteria = $fieldCriteriaDescription["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('DESCRIPTION') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_description" 
							name="virgo_search_description"
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
				id="virgo_search_description_is_null" 
				name="virgo_search_description_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaDescription) && $fieldCriteriaDescription["is_null"] == 2) {
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
	if (P('show_search_initiation_code', "1") == "1") {

		if (isset($criteriaProcess["initiation_code"])) {
			$fieldCriteriaInitiationCode = $criteriaProcess["initiation_code"];
			$dataTypeCriteria = $fieldCriteriaInitiationCode["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('INITIATION_CODE') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_initiationCode_is_null" 
				name="virgo_search_initiationCode_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaInitiationCode) && $fieldCriteriaInitiationCode["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaInitiationCode) && $fieldCriteriaInitiationCode["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaInitiationCode) && $fieldCriteriaInitiationCode["is_null"] == 2) {
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
	if (P('show_search_execution_code', "1") == "1") {

		if (isset($criteriaProcess["execution_code"])) {
			$fieldCriteriaExecutionCode = $criteriaProcess["execution_code"];
			$dataTypeCriteria = $fieldCriteriaExecutionCode["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('EXECUTION_CODE') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_executionCode_is_null" 
				name="virgo_search_executionCode_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaExecutionCode) && $fieldCriteriaExecutionCode["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaExecutionCode) && $fieldCriteriaExecutionCode["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaExecutionCode) && $fieldCriteriaExecutionCode["is_null"] == 2) {
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
	if (P('show_search_closing_code', "1") == "1") {

		if (isset($criteriaProcess["closing_code"])) {
			$fieldCriteriaClosingCode = $criteriaProcess["closing_code"];
			$dataTypeCriteria = $fieldCriteriaClosingCode["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CLOSING_CODE') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_closingCode_is_null" 
				name="virgo_search_closingCode_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaClosingCode) && $fieldCriteriaClosingCode["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaClosingCode) && $fieldCriteriaClosingCode["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaClosingCode) && $fieldCriteriaClosingCode["is_null"] == 2) {
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
	if (P('show_search_portion_size', "1") == "1") {

		if (isset($criteriaProcess["portion_size"])) {
			$fieldCriteriaPortionSize = $criteriaProcess["portion_size"];
			$dataTypeCriteria = $fieldCriteriaPortionSize["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('PORTION_SIZE') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_portionSize_from" 
							name="virgo_search_portionSize_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_portionSize_to" 
							name="virgo_search_portionSize_to"
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
				id="virgo_search_portionSize_is_null" 
				name="virgo_search_portionSize_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaPortionSize) && $fieldCriteriaPortionSize["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaPortionSize) && $fieldCriteriaPortionSize["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaPortionSize) && $fieldCriteriaPortionSize["is_null"] == 2) {
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
	if (P('show_search_active', "1") == "1") {

		if (isset($criteriaProcess["active"])) {
			$fieldCriteriaActive = $criteriaProcess["active"];
			$dataTypeCriteria = $fieldCriteriaActive["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ACTIVE') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_active" name="virgo_search_active">
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
				id="virgo_search_active_is_null" 
				name="virgo_search_active_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaActive) && $fieldCriteriaActive["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaActive) && $fieldCriteriaActive["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaActive) && $fieldCriteriaActive["is_null"] == 2) {
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
	if (P('show_search_order', "1") == "1") {

		if (isset($criteriaProcess["order"])) {
			$fieldCriteriaOrder = $criteriaProcess["order"];
			$dataTypeCriteria = $fieldCriteriaOrder["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('ORDER') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_order_from" 
							name="virgo_search_order_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_order_to" 
							name="virgo_search_order_to"
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
				id="virgo_search_order_is_null" 
				name="virgo_search_order_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaOrder) && $fieldCriteriaOrder["is_null"] == 2) {
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
	if (P('show_search_last_session', "1") == "1") {

		if (isset($criteriaProcess["last_session"])) {
			$fieldCriteriaLastSession = $criteriaProcess["last_session"];
			$dataTypeCriteria = $fieldCriteriaLastSession["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('LAST_SESSION') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_lastSession" 
							name="virgo_search_lastSession"
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
				id="virgo_search_lastSession_is_null" 
				name="virgo_search_lastSession_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaLastSession) && $fieldCriteriaLastSession["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLastSession) && $fieldCriteriaLastSession["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLastSession) && $fieldCriteriaLastSession["is_null"] == 2) {
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
	if (P('show_search_subprocess_count', "1") == "1") {

		if (isset($criteriaProcess["subprocess_count"])) {
			$fieldCriteriaSubprocessCount = $criteriaProcess["subprocess_count"];
			$dataTypeCriteria = $fieldCriteriaSubprocessCount["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('SUBPROCESS_COUNT') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_subprocessCount_from" 
							name="virgo_search_subprocessCount_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_subprocessCount_to" 
							name="virgo_search_subprocessCount_to"
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
				id="virgo_search_subprocessCount_is_null" 
				name="virgo_search_subprocessCount_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaSubprocessCount) && $fieldCriteriaSubprocessCount["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaSubprocessCount) && $fieldCriteriaSubprocessCount["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaSubprocessCount) && $fieldCriteriaSubprocessCount["is_null"] == 2) {
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
	if (P('show_search_clear', "1") == "1") {

		if (isset($criteriaProcess["clear"])) {
			$fieldCriteriaClear = $criteriaProcess["clear"];
			$dataTypeCriteria = $fieldCriteriaClear["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CLEAR') ?>
		</label>
		<span align="left" nowrap>
<select id="virgo_search_clear" name="virgo_search_clear">
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
				id="virgo_search_clear_is_null" 
				name="virgo_search_clear_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaClear) && $fieldCriteriaClear["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaClear) && $fieldCriteriaClear["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaClear) && $fieldCriteriaClear["is_null"] == 2) {
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
	if (P('show_search_executions') == "1") {
?>
<?php
	$record = new portal\virgoProcess();
	$recordId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->prc_id;
	$record->load($recordId);
	$subrecordsExecutions = $record->getExecutions();
	$sizeExecutions = count($subrecordsExecutions);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Executions
					</label>
<?php
	if ($sizeExecutions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsExecutions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeExecutions) {
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
	unset($criteriaProcess);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	} elseif ($processDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('PROCESS') ?>:</legend>
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
	if (P('show_view_name', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="name"
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
<?php echo T('NAME') ?>
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
							<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prc_name_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_execution_time', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="execution_time"
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
<?php echo T('EXECUTION_TIME') ?>
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
							<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="executionTime" name="prc_executionTime_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_description', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="description"
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
<?php echo T('DESCRIPTION') ?>
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
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultProcess->prc_description, ENT_QUOTES, "UTF-8") ?></div>

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
	if (P('show_view_initiation_code', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="initiation_code"
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
<?php echo T('INITIATION_CODE') ?>
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
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_initiationCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_initiation_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_initiationCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

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
	if (P('show_view_execution_code', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="execution_code"
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
<?php echo T('EXECUTION_CODE') ?>
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
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_executionCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_executionCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_execution_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_executionCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

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
	if (P('show_view_closing_code', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="closing_code"
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
<?php echo T('CLOSING_CODE') ?>
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
<script type="text/javascript" src="<?php echo $live_site ?>/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script >
<?php
	$codeMirrorHome = "libraries/CodeMirror-2.12";
?>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.css">
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/lib/codemirror.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/xml/xml.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/javascript/javascript.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/css/css.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/clike/clike.js"></script>
<script src="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/mode/php/php.js"></script>
<link rel="stylesheet" href="<?php echo $live_site ?>/<?php echo $codeMirrorHome ?>/theme/default.css">
<style type="text/css">.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black; background-color: #fff; font-size: 0.7em;}</style>
<textarea 
	style="width:100%; height:550px;"
	class="inputbox readonly"  
	id="prc_closingCode_<?php echo $resultProcess->prc_id ?>" 
	name="prc_closingCode_<?php echo $resultProcess->prc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultProcess->prc_closing_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("prc_closingCode_<?php echo $resultProcess->prc_id ?>"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 8,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        readOnly: "nocursor"
});
</script>

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
	if (P('show_view_portion_size', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="portion_size"
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
<?php echo T('PORTION_SIZE') ?>
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
							<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="portionSize" name="prc_portionSize_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_active', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="active"
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
<?php echo T('ACTIVE') ?>
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
	id="active"
>
<?php
	if (is_null($resultProcess->prc_active) || $resultProcess->prc_active == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_active == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_active === "0") {
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
	if (P('show_view_order', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="order"
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
<?php echo T('ORDER') ?>
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
							<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="prc_order_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_last_session', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="last_session"
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
<?php echo T('LAST_SESSION') ?>
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
							<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSession" name="prc_lastSession_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_subprocess_count', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="subprocess_count"
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
<?php echo T('SUBPROCESS_COUNT') ?>
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
							<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="subprocessCount" name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_clear', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="clear"
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
<?php echo T('CLEAR') ?>
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
	id="clear"
>
<?php
	if (is_null($resultProcess->prc_clear) || $resultProcess->prc_clear == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultProcess->prc_clear == 1) {
		$booleanValue = T("YES");
	} elseif ($resultProcess->prc_clear === "0") {
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
	if (class_exists('portal\virgoExecution') && P('show_view_executions', '0') == "1") {
?>
<?php
	$record = new portal\virgoProcess();
	$recordId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->prc_id;
	$record->load($recordId);
	$subrecordsExecutions = $record->getExecutions();
	$sizeExecutions = count($subrecordsExecutions);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="process"
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
						Executions 
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
	if ($sizeExecutions == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsExecutions as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeExecutions) {
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
<?php echo T('PROCESS') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultProcess->getDateCreated()) {
		if ($resultProcess->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultProcess->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultProcess->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultProcess->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultProcess->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultProcess->getDateModified()) {
		if ($resultProcess->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultProcess->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultProcess->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultProcess->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultProcess->getDateModified() ?>"	>
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
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PROCESS"), "\\'".$resultProcess->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	} elseif ($processDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "prc_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultProcess->setShowPage(1); 
	$resultProcess->setShowRows('all'); 	
	$resultsProcess = $resultProcess->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsProcess as $resultProcess) {
		if (isset($resultProcess[$eventColumn]) && isset($events[substr($resultProcess[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultProcess[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoProcess($resultProcess['prc_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultProcess[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='prc_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultProcess) {
?>
<?php
PROFILE('token');
	if (isset($resultProcess)) {
		$tmpId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId();
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultProcess->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.prc_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var processChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == processChildrenDivOpen) {
					div.style.display = 'none';
					processChildrenDivOpen = '';
				} else {
					if (processChildrenDivOpen != '') {
						document.getElementById(processChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					processChildrenDivOpen = clickedDivId;
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
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultProcess->getShowPage(); 
			$showRows = $resultProcess->getShowRows(); 
?>
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Processes') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultProcess->getOrderColumn();
			$virgoOrderMode = $resultProcess->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsProcess = $resultProcess->getTableData($resultCount, $filterApplied);
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
	if (P('show_table_name', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('NAME') ?>							<?php echo ($oc == "prc_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterName', null);
?>
						<input
							name="virgo_filter_name"
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
	if (P('show_table_execution_time', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_execution_time');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('EXECUTION_TIME') ?>							<?php echo ($oc == "prc_execution_time" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterExecutionTime', null);
?>
						<input
							name="virgo_filter_execution_time"
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
	if (P('show_table_description', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_description');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('DESCRIPTION') ?>							<?php echo ($oc == "prc_description" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterDescription', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_initiation_code', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_initiation_code');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('INITIATION_CODE') ?>							<?php echo ($oc == "prc_initiation_code" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterInitiationCode', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_execution_code', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_execution_code');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('EXECUTION_CODE') ?>							<?php echo ($oc == "prc_execution_code" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterExecutionCode', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_closing_code', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_closing_code');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CLOSING_CODE') ?>							<?php echo ($oc == "prc_closing_code" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterClosingCode', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_portion_size', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_portion_size');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PORTION_SIZE') ?>							<?php echo ($oc == "prc_portion_size" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterPortionSize', null);
?>
						<input
							name="virgo_filter_portion_size"
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
	if (P('show_table_active', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_active');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ACTIVE') ?>							<?php echo ($oc == "prc_active" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterActive', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_order', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_order');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('ORDER') ?>							<?php echo ($oc == "prc_order" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterOrder', null);
?>
						<input
							name="virgo_filter_order"
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
	if (P('show_table_last_session', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_last_session');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LAST_SESSION') ?>							<?php echo ($oc == "prc_last_session" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterLastSession', null);
?>
						<input
							name="virgo_filter_last_session"
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
	if (P('show_table_subprocess_count', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_subprocess_count');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('SUBPROCESS_COUNT') ?>							<?php echo ($oc == "prc_subprocess_count" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterSubprocessCount', null);
?>
						<input
							name="virgo_filter_subprocess_count"
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
	if (P('show_table_clear', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultProcess->getOrderColumn(); 
	$om = $resultProcess->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'prc_clear');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CLEAR') ?>							<?php echo ($oc == "prc_clear" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoProcess::getLocalSessionValue('VirgoFilterClear', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (class_exists('portal\virgoExecution') && P('show_table_executions', '0') == "1") {
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
					$resultProcess->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsProcess as $resultProcess) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoProcess/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultProcess['prc_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoProcess::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoProcess::setContextId($resultProcess['prc_id'], false);
						$tmpContextId = $resultProcess['prc_id'];
					}
				}
				if (isset($tmpContextId) && $resultProcess['prc_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : "" ?>" 
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultProcess['prc_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultProcess['prc_id'] ?>">
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
PROFILE('name');
	if (P('show_table_name', "1") == "1") {
PROFILE('render_data_table_name');
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
			<li class="name">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_name');
	}
PROFILE('name');
?>
<?php
PROFILE('execution time');
	if (P('show_table_execution_time', "0") == "1") {
PROFILE('render_data_table_execution_time');
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
			<li class="execution_time">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_execution_time'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_execution_time');
	}
PROFILE('execution time');
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") {
PROFILE('render_data_table_description');
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
			<li class="description">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_description']);
			$shortTextSize = P('short_text_size_description', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_description'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_description'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_description'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_description');
	}
PROFILE('description');
?>
<?php
PROFILE('initiation code');
	if (P('show_table_initiation_code', "0") == "1") {
PROFILE('render_data_table_initiation_code');
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
			<li class="initiation_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_initiation_code']);
			$shortTextSize = P('short_text_size_initiation_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_initiation_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_initiation_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_initiation_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_initiation_code');
	}
PROFILE('initiation code');
?>
<?php
PROFILE('execution code');
	if (P('show_table_execution_code', "0") == "1") {
PROFILE('render_data_table_execution_code');
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
			<li class="execution_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_execution_code']);
			$shortTextSize = P('short_text_size_execution_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_execution_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_execution_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_execution_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_execution_code');
	}
PROFILE('execution code');
?>
<?php
PROFILE('closing code');
	if (P('show_table_closing_code', "0") == "1") {
PROFILE('render_data_table_closing_code');
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
			<li class="closing_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_closing_code']);
			$shortTextSize = P('short_text_size_closing_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_closing_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_closing_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_closing_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_closing_code');
	}
PROFILE('closing code');
?>
<?php
PROFILE('portion size');
	if (P('show_table_portion_size', "0") == "1") {
PROFILE('render_data_table_portion_size');
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
			<li class="portion_size">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_portion_size'] 
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
PROFILE('render_data_table_portion_size');
	}
PROFILE('portion size');
?>
<?php
PROFILE('active');
	if (P('show_table_active', "0") == "1") {
PROFILE('render_data_table_active');
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
			<li class="active">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_active', "1") == "1");
	if ($resultProcess['prc_active'] == 2 || is_null($resultProcess['prc_active'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo is_null($resultProcess['prc_active']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultProcess['prc_active'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultProcess['prc_active'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
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
PROFILE('render_data_table_active');
	}
PROFILE('active');
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") {
PROFILE('render_data_table_order');
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
			<li class="order">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_order'] 
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
PROFILE('render_data_table_order');
	}
PROFILE('order');
?>
<?php
PROFILE('last session');
	if (P('show_table_last_session', "0") == "1") {
PROFILE('render_data_table_last_session');
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
			<li class="last_session">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_last_session'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_last_session');
	}
PROFILE('last session');
?>
<?php
PROFILE('subprocess count');
	if (P('show_table_subprocess_count', "0") == "1") {
PROFILE('render_data_table_subprocess_count');
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
			<li class="subprocess_count">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_subprocess_count'] 
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
PROFILE('render_data_table_subprocess_count');
	}
PROFILE('subprocess count');
?>
<?php
PROFILE('clear');
	if (P('show_table_clear', "0") == "1") {
PROFILE('render_data_table_clear');
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
			<li class="clear">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_clear', "1") == "1");
	if ($resultProcess['prc_clear'] == 2 || is_null($resultProcess['prc_clear'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo is_null($resultProcess['prc_clear']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultProcess['prc_clear'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultProcess['prc_clear'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
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
PROFILE('render_data_table_clear');
	}
PROFILE('clear');
?>
<?php
	if (class_exists('portal\virgoExecution') && P('show_table_executions', '0') == "1") {
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
	if (isset($resultProcess)) {
		$tmpId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId();
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PROCESS"), "\\'".rawurlencode($resultProcess['prc_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	$buttonRendered = false;
	if ($this->canExecute('ExecuteNow')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_executenow inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('Are you sure you want to execute process?'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ExecuteNow';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EXECUTE NOW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
			if ($this->canExecute("form")) {
	if ($virgoOrderColumn == "prc_order") {
?>	
<input type="hidden" name="virgo_swap_down_with_<?php echo $resultProcess['prc_id'] ?>" id="virgo_swap_down_with_<?php echo $resultProcess['prc_id'] ?>" value="">
<td>
<?php
		if (isset($virgoPreviousId)) {
?>
<input type="hidden" name="virgo_swap_up_with_<?php echo $resultProcess['prc_id'] ?>" value="<?php echo $virgoPreviousId ?>">
<script type="text/javascript">
var f = document.getElementById("virgo_swap_down_with_<?php echo $virgoPreviousId ?>");
f.value = <?php echo $resultProcess['prc_id'] ?>;
f = document.getElementById("arrow_down_<?php echo $virgoPreviousId ?>");
f.style.display = 'block';
</script>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoUp')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgoup inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoUp';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↑') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
?>
</td>
<td>
<div id="arrow_down_<?php echo $resultProcess['prc_id'] ?>" style="display: none;">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoDown')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgodown inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoDown';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↓') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</div>
</td>
<?php		
		$virgoPreviousId = $resultProcess['prc_id'];
	}
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultProcess['prc_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultProcess['prc_id'] ?>">
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
PROFILE('name');
	if (P('show_table_name', "1") == "1") {
PROFILE('render_data_table_name');
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
			<li class="name">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_name');
	}
PROFILE('name');
?>
<?php
PROFILE('execution time');
	if (P('show_table_execution_time', "0") == "1") {
PROFILE('render_data_table_execution_time');
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
			<li class="execution_time">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_execution_time'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_execution_time');
	}
PROFILE('execution time');
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") {
PROFILE('render_data_table_description');
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
			<li class="description">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_description']);
			$shortTextSize = P('short_text_size_description', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_description'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_description'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_description'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_description');
	}
PROFILE('description');
?>
<?php
PROFILE('initiation code');
	if (P('show_table_initiation_code', "0") == "1") {
PROFILE('render_data_table_initiation_code');
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
			<li class="initiation_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_initiation_code']);
			$shortTextSize = P('short_text_size_initiation_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_initiation_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_initiation_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_initiation_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_initiation_code');
	}
PROFILE('initiation code');
?>
<?php
PROFILE('execution code');
	if (P('show_table_execution_code', "0") == "1") {
PROFILE('render_data_table_execution_code');
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
			<li class="execution_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_execution_code']);
			$shortTextSize = P('short_text_size_execution_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_execution_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_execution_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_execution_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_execution_code');
	}
PROFILE('execution code');
?>
<?php
PROFILE('closing code');
	if (P('show_table_closing_code', "0") == "1") {
PROFILE('render_data_table_closing_code');
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
			<li class="closing_code">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
			$len = strlen($resultProcess['prc_closing_code']);
			$shortTextSize = P('short_text_size_closing_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultProcess['prc_closing_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultProcess['prc_closing_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultProcess['prc_closing_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_closing_code');
	}
PROFILE('closing code');
?>
<?php
PROFILE('portion size');
	if (P('show_table_portion_size', "0") == "1") {
PROFILE('render_data_table_portion_size');
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
			<li class="portion_size">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_portion_size'] 
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
PROFILE('render_data_table_portion_size');
	}
PROFILE('portion size');
?>
<?php
PROFILE('active');
	if (P('show_table_active', "0") == "1") {
PROFILE('render_data_table_active');
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
			<li class="active">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_active', "1") == "1");
	if ($resultProcess['prc_active'] == 2 || is_null($resultProcess['prc_active'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo is_null($resultProcess['prc_active']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultProcess['prc_active'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultProcess['prc_active'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_active_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_active_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetActiveTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
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
PROFILE('render_data_table_active');
	}
PROFILE('active');
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") {
PROFILE('render_data_table_order');
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
			<li class="order">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_order'] 
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
PROFILE('render_data_table_order');
	}
PROFILE('order');
?>
<?php
PROFILE('last session');
	if (P('show_table_last_session', "0") == "1") {
PROFILE('render_data_table_last_session');
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
			<li class="last_session">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultProcess['prc_last_session'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_last_session');
	}
PROFILE('last session');
?>
<?php
PROFILE('subprocess count');
	if (P('show_table_subprocess_count', "0") == "1") {
PROFILE('render_data_table_subprocess_count');
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
			<li class="subprocess_count">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
				$resultProcess['prc_subprocess_count'] 
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
PROFILE('render_data_table_subprocess_count');
	}
PROFILE('subprocess count');
?>
<?php
PROFILE('clear');
	if (P('show_table_clear', "0") == "1") {
PROFILE('render_data_table_clear');
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
			<li class="clear">
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
					form.prc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultProcess['prc_id']) ? $resultProcess['prc_id'] : '' ?>'; 
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
	$canEditBoolean = ($this->canEdit() && P('show_form_clear', "1") == "1");
	if ($resultProcess['prc_clear'] == 2 || is_null($resultProcess['prc_clear'])) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo is_null($resultProcess['prc_clear']) ? "&nbsp;&nbsp;&nbsp;&nbsp;" : T('NO_DATA')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('NO_DATA')
;			
		}
	} elseif ($resultProcess['prc_clear'] == 1) {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('YES')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('NO')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearFalse';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
		"
>
	</div> 
</div>
<?php		
		} else {
			echo T('YES')
;			
		}
	} elseif ($resultProcess['prc_clear'] === "0") {
		if ($canEditBoolean) { 
?>
<div class="parent inlineBlock">
<div class="dropdown"><span style="cursor: pointer;" onclick="changeDisplay('boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>'); return false;"><?php echo T('NO')
 ?></span></div>
	<div id="boolean_options_clear_<?php echo $resultProcess['prc_id'] ?>" class="child" style="border: 1px solid #DDD; display: none; position: absolute; box-shadow: 1px 2px 2px black; border-radius: 0px;">
<input 
	type="submit" 
	style="border: none; background-color: white;"
	value="<?php echo T('YES')
 ?>" 
	onclick="
		this.form.portlet_action.value='VirgoSetClearTrue';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo $resultProcess['prc_id'] ?>');
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
PROFILE('render_data_table_clear');
	}
PROFILE('clear');
?>
<?php
	if (class_exists('portal\virgoExecution') && P('show_table_executions', '0') == "1") {
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
	if (isset($resultProcess)) {
		$tmpId = is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId();
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("PROCESS"), "\\'".rawurlencode($resultProcess['prc_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	$buttonRendered = false;
	if ($this->canExecute('ExecuteNow')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_executenow inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('Are you sure you want to execute process?'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ExecuteNow';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('EXECUTE NOW') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
			if ($this->canExecute("form")) {
	if ($virgoOrderColumn == "prc_order") {
?>	
<input type="hidden" name="virgo_swap_down_with_<?php echo $resultProcess['prc_id'] ?>" id="virgo_swap_down_with_<?php echo $resultProcess['prc_id'] ?>" value="">
<td>
<?php
		if (isset($virgoPreviousId)) {
?>
<input type="hidden" name="virgo_swap_up_with_<?php echo $resultProcess['prc_id'] ?>" value="<?php echo $virgoPreviousId ?>">
<script type="text/javascript">
var f = document.getElementById("virgo_swap_down_with_<?php echo $virgoPreviousId ?>");
f.value = <?php echo $resultProcess['prc_id'] ?>;
f = document.getElementById("arrow_down_<?php echo $virgoPreviousId ?>");
f.style.display = 'block';
</script>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoUp')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgoup inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoUp';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↑') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php
		}
?>
</td>
<td>
<div id="arrow_down_<?php echo $resultProcess['prc_id'] ?>" style="display: none;">
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoDown')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgodown inlineBlock"><input 							name="submit_button" 
							class="button btn   btn-mini " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='VirgoDown';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('↓') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
</div>
</td>
<?php		
		$virgoPreviousId = $resultProcess['prc_id'];
	}
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
			virgoProcess::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultProcess);
				unset($resultsProcess);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpProcess = new virgoProcess();
						$tmpCount = $tmpProcess->getAllRecordCount(' prc_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoProcess::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&prc_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.prc_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.prc_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'prc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'prc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'prc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'prc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'prc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'prc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
					$sessionSeparator = virgoProcess::getImportFieldSeparator();
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
						$sessionSeparator = virgoProcess::getImportFieldSeparator();
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('PROCESSES'), "") ?>'))) return false;
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	} elseif ($processDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_process") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var processChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == processChildrenDivOpen) {
					div.style.display = 'none';
					processChildrenDivOpen = '';
				} else {
					if (processChildrenDivOpen != '') {
						document.getElementById(processChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					processChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_process" name="virgo_form_process" enctype="multipart/form-data">
						<input type="text" name="prc_id_<?php echo $this->getId() ?>" id="prc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_name', "1") == "1") {
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
	if (P('show_table_execution_time', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Execution time
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_description', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Description
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_initiation_code', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Initiation code
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_execution_code', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Execution code
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_closing_code', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Closing code
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_portion_size', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Portion size
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_active', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Active
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_order', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Order
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_last_session', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Last session
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_subprocess_count', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Subprocess count
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_clear', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Clear
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsProcess = $resultProcess->getRecordsToEdit();
				$idsToCorrect = $resultProcess->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsProcess as $resultProcess) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultProcess->prc_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultProcess->prc_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('name');
	if (P('show_table_name', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 0;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prc_name_<?php echo $resultProcess->getId() ?>" 
							name="prc_name_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_NAME');
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
$('#prc_name_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('name');
	} else {
?> 
						<input
							type="hidden"
							id="name_<?php echo $resultProcess->prc_id ?>" 
							name="name_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('execution time');
	if (P('show_table_execution_time', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 1;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_execution_time_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_executionTime_<?php echo $resultProcess->getId() ?>" 
							name="prc_executionTime_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_TIME');
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
$('#prc_executionTime_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('execution time');
	} else {
?> 
						<input
							type="hidden"
							id="executionTime_<?php echo $resultProcess->prc_id ?>" 
							name="executionTime_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_execution_time, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('description');
	if (P('show_table_description', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 2;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox description" 
	id="prc_description_<?php echo $resultProcess->getId() ?>" 
	name="prc_description_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_DESCRIPTION');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getDescription(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_description_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('description');
	} else {
?> 
						<input
							type="hidden"
							id="description_<?php echo $resultProcess->prc_id ?>" 
							name="description_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_description, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('initiation code');
	if (P('show_table_initiation_code', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 3;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox initiation_code" 
	id="prc_initiationCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_initiationCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_INITIATION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getInitiationCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_initiationCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('initiation code');
	} else {
?> 
						<input
							type="hidden"
							id="initiationCode_<?php echo $resultProcess->prc_id ?>" 
							name="initiationCode_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_initiation_code, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('execution code');
	if (P('show_table_execution_code', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 4;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox execution_code" 
	id="prc_executionCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_executionCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_EXECUTION_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getExecutionCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_executionCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('execution code');
	} else {
?> 
						<input
							type="hidden"
							id="executionCode_<?php echo $resultProcess->prc_id ?>" 
							name="executionCode_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_execution_code, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('closing code');
	if (P('show_table_closing_code', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 5;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<textarea 
	class="inputbox closing_code" 
	id="prc_closingCode_<?php echo $resultProcess->getId() ?>" 
	name="prc_closingCode_<?php echo $resultProcess->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLOSING_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultProcess->getClosingCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_closingCode_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('closing code');
	} else {
?> 
						<input
							type="hidden"
							id="closingCode_<?php echo $resultProcess->prc_id ?>" 
							name="closingCode_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_closing_code, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('portion size');
	if (P('show_table_portion_size', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 6;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_portion_size_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_portionSize_<?php echo $resultProcess->getId() ?>" 
							name="prc_portionSize_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getPortionSize(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_PORTION_SIZE');
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
$('#prc_portionSize_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('portion size');
	} else {
?> 
						<input
							type="hidden"
							id="portionSize_<?php echo $resultProcess->prc_id ?>" 
							name="portionSize_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_portion_size, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('active');
	if (P('show_table_active', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 7;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_active_<?php echo $resultProcess->getId() ?>" name="prc_active_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ACTIVE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getActive() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getActive() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getActive()) || $resultProcess->getActive() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_active_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('active');
	} else {
?> 
						<input
							type="hidden"
							id="active_<?php echo $resultProcess->prc_id ?>" 
							name="active_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_active, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('order');
	if (P('show_table_order', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 8;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_order_<?php echo $resultProcess->getId() ?>" 
							name="prc_order_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_ORDER');
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
$('#prc_order_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('order');
	} else {
?> 
						<input
							type="hidden"
							id="order_<?php echo $resultProcess->prc_id ?>" 
							name="order_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('last session');
	if (P('show_table_last_session', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 9;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_last_session_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prc_lastSession_<?php echo $resultProcess->getId() ?>" 
							name="prc_lastSession_<?php echo $resultProcess->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultProcess->getLastSession(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_LAST_SESSION');
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
$('#prc_lastSession_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('last session');
	} else {
?> 
						<input
							type="hidden"
							id="lastSession_<?php echo $resultProcess->prc_id ?>" 
							name="lastSession_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_last_session, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('subprocess count');
	if (P('show_table_subprocess_count', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 10;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_subprocess_count_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" 
							name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultProcess->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_SUBPROCESS_COUNT');
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
$('#prc_subprocessCount_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						

</td>
<?php
PROFILE('subprocess count');
	} else {
?> 
						<input
							type="hidden"
							id="subprocessCount_<?php echo $resultProcess->prc_id ?>" 
							name="subprocessCount_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_subprocess_count, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('clear');
	if (P('show_table_clear', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsProcess) * 11;
?>
<?php
	if (!isset($resultProcess)) {
		$resultProcess = new portal\virgoProcess();
	}
?>
<select class="inputbox" id="prc_clear_<?php echo $resultProcess->getId() ?>" name="prc_clear_<?php echo $resultProcess->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PROCESS_CLEAR');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultProcess->getClear() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultProcess->getClear() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultProcess->getClear()) || $resultProcess->getClear() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prc_clear_<?php echo $resultProcess->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						


</td>
<?php
PROFILE('clear');
	} else {
?> 
						<input
							type="hidden"
							id="clear_<?php echo $resultProcess->prc_id ?>" 
							name="clear_<?php echo $resultProcess->prc_id ?>"
							value="<?php echo htmlentities($resultProcess->prc_clear, ENT_QUOTES, "UTF-8") ?>"
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
				<td>
<?php
	if (isset($idsToCorrect[$resultProcess->prc_id])) {
		$errorMessage = $idsToCorrect[$resultProcess->prc_id];
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $processDisplayMode ?>">
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
	_pSF(form, 'prc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultProcess) ? (is_array($resultProcess) ? $resultProcess['prc_id'] : $resultProcess->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_process" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_process').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
	<tr>
		<td align="right">
			extraFormActions/process.php
		</td>
		<td align="left">
			<b>2012-08-21</b> <span style='font-size: 0.78em;'>12:17:01</span>
		</td>
	</tr>
	<tr>
		<td align="right">
			extraPublicActions/process.php
		</td>
		<td align="left">
			<b>2012-08-21</b> <span style='font-size: 0.78em;'>11:20:42</span>
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
	$infos = virgoProcess::getExtraFilesInfo();
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

