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
	use portal\virgoExecution;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_execution');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_execution/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'prt_exc.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoExecution/prt_exc.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_execution" style="border: none;">
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
		$ancestors["process"] = "TRUE";
		$contextId = null;		
			$resultExecution = virgoExecution::createGuiAware();
			$contextId = $resultExecution->getContextId();
			if (isset($contextId)) {
				if (virgoExecution::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultExecution->load($contextId);
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
		if ($className == "virgoExecution") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultExecution = new virgoExecution($tmpId);
				virgoExecution::setDisplayMode("FORM");
			} else {
				$resultExecution = new virgoExecution();
				virgoExecution::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultExecution->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultExecution->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultExecution = new virgoExecution($allPrivateRecords[0]['exc_id']);
						$resultExecution->putInContext(false);
					} else {
						$resultExecution = new virgoExecution();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultExecution->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultExecution = new virgoExecution($records[0]['exc_id']);
							$resultExecution->putInContext(false);
						} else {
							$resultExecution = new virgoExecution();
						}
					} else {
						$resultExecution = new virgoExecution();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultExecution = new virgoExecution(virgoUser::getUserId());
			$resultExecution->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultExecution = new virgoExecution();
		}
?>
<?php
	$executionDisplayMode = virgoExecution::getDisplayMode();
//	if ($executionDisplayMode == "" || $executionDisplayMode == "TABLE") {
//		$resultExecution = $resultExecution->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultExecution->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseExecution = $whereClauseExecution . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaExecution = $resultExecution->getCriteria();
		$countTmp = 0;
		if (isset($criteriaExecution["begin"])) {
			$fieldCriteriaBegin = $criteriaExecution["begin"];
			if ($fieldCriteriaBegin["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaBegin["value"];
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
		if (isset($criteriaExecution["progress"])) {
			$fieldCriteriaProgress = $criteriaExecution["progress"];
			if ($fieldCriteriaProgress["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaProgress["value"];
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
		if (isset($criteriaExecution["end"])) {
			$fieldCriteriaEnd = $criteriaExecution["end"];
			if ($fieldCriteriaEnd["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaEnd["value"];
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
		if (isset($criteriaExecution["result"])) {
			$fieldCriteriaResult = $criteriaExecution["result"];
			if ($fieldCriteriaResult["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaResult["value"];
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
		if (isset($criteriaExecution["statistics"])) {
			$fieldCriteriaStatistics = $criteriaExecution["statistics"];
			if ($fieldCriteriaStatistics["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaStatistics["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaExecution["process"])) {
			$parentCriteria = $criteriaExecution["process"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (is_null($criteriaExecution) || sizeof($criteriaExecution) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaExecution["begin"])) {
				$fieldCriteriaBegin = $criteriaExecution["begin"];
				if ($fieldCriteriaBegin["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Begin') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaBegin["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaBegin["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='begin';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaBegin["value"];
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
					<?php echo T('Begin') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='begin';
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
			if (isset($criteriaExecution["progress"])) {
				$fieldCriteriaProgress = $criteriaExecution["progress"];
				if ($fieldCriteriaProgress["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Progress') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaProgress["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaProgress["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='progress';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaProgress["value"];
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
					<?php echo T('Progress') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='progress';
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
			if (isset($criteriaExecution["end"])) {
				$fieldCriteriaEnd = $criteriaExecution["end"];
				if ($fieldCriteriaEnd["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('End') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaEnd["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaEnd["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='end';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaEnd["value"];
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
					<?php echo T('End') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='end';
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
			if (isset($criteriaExecution["result"])) {
				$fieldCriteriaResult = $criteriaExecution["result"];
				if ($fieldCriteriaResult["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Result') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaResult["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaResult["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='result';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaResult["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Result') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='result';
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
			if (isset($criteriaExecution["statistics"])) {
				$fieldCriteriaStatistics = $criteriaExecution["statistics"];
				if ($fieldCriteriaStatistics["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Statistics') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaStatistics["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaStatistics["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='statistics';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaStatistics["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Statistics') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='statistics';
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
			if (isset($criteriaExecution["process"])) {
				$parentCriteria = $criteriaExecution["process"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Process') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='process';
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
					<?php echo T('process') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='process';
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
	if (isset($resultExecution)) {
		$tmpId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($executionDisplayMode != "TABLE") {
		$tmpAction = R('portlet_action');
		if (
			$tmpAction == "Store" 
			|| $tmpAction == "Apply"
			|| $tmpAction == "StoreAndClear"
			|| $tmpAction == "BackFromParent"
			|| $tmpAction == "StoreNewProcess"
		) {
			$invokedPortletId = R('invoked_portlet_object_id');
			if (is_null($invokedPortletId) || trim($invokedPortletId) == "") {
				$invokedPortletId = R('legacy_invoked_portlet_object_id');
			}
			$pob = $resultExecution->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultExecution->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$executionDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultExecution->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($executionDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_execution") {
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
<?php echo T('EXECUTION') ?>:</legend>
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
	if (P('show_form_begin', "1") == "1" || P('show_form_begin', "1") == "2") {
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
						class="fieldlabel  obligatory   begin datetime" 
						for="exc_begin_<?php echo $resultExecution->getId() ?>"
					>* <?php echo T('BEGIN') ?>
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
	if (P('show_form_begin', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="begin" name="exc_begin_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_progress', "1") == "1" || P('show_form_progress', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_progress_obligatory', "0") == "1" ? " obligatory " : "" ?>   progress integer" 
						for="exc_progress_<?php echo $resultExecution->getId() ?>"
					> <?php echo P('show_form_progress_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PROGRESS') ?>
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
	if (P('show_form_progress', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="progress" name="exc_progress_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_end', "1") == "1" || P('show_form_end', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_end_obligatory', "0") == "1" ? " obligatory " : "" ?>   end datetime" 
						for="exc_end_<?php echo $resultExecution->getId() ?>"
					> <?php echo P('show_form_end_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('END') ?>
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
	if (P('show_form_end', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="end" name="exc_end_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_result', "1") == "1" || P('show_form_result', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_result_obligatory', "0") == "1" ? " obligatory " : "" ?>   result varchar" 
						for="exc_result_<?php echo $resultExecution->getId() ?>"
					> <?php echo P('show_form_result_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RESULT') ?>
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
	if (P('show_form_result', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="result" name="exc_result_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_statistics', "1") == "1" || P('show_form_statistics', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_statistics_obligatory', "0") == "1" ? " obligatory " : "" ?>   statistics html" 
						for="exc_statistics_<?php echo $resultExecution->getId() ?>"
					> <?php echo P('show_form_statistics_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STATISTICS') ?>
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
	if (P('show_form_statistics', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid;" 
	class="inputbox readonly" 
>
	<?php echo $resultExecution->exc_statistics ?>
</div>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoStatisticsAsPdf')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgostatisticsaspdf inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='VirgoStatisticsAsPdf';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('Download as PDF') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
	} else {
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
	if (class_exists('portal\virgoProcess') && ((P('show_form_process', "1") == "1" || P('show_form_process', "1") == "2" || P('show_form_process', "1") == "3") && !isset($context["prc"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="exc_process_<?php echo isset($resultExecution->exc_id) ? $resultExecution->exc_id : '' ?>">
 *
<?php echo T('PROCESS') ?> <?php echo T('') ?>
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
//		$limit_process = $componentParams->get('limit_to_process');
		$limit_process = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoProcess");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_process', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultExecution->exc_prc__id = $tmpId;
//			}
			if (!is_null($resultExecution->getPrcId())) {
				$parentId = $resultExecution->getPrcId();
				$parentValue = portal\virgoProcess::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_EXECUTION_PROCESS');
?>
<?php
	$whereList = "";
	if (!is_null($limit_process) && trim($limit_process) != "") {
		$whereList = $whereList . " prc_id ";
		if (trim($limit_process) == "page_title") {
			$limit_process = "SELECT prc_id FROM prt_processes WHERE prc_" . $limit_process . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_process = \"$limit_process\";");
		$whereList = $whereList . " IN (" . $limit_process . ") ";
	}						
	$parentCount = portal\virgoProcess::getVirgoListSize($whereList);
	$showAjaxexc = P('show_form_process', "1") == "3" || $parentCount > 100;
	if (!$showAjaxexc) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
							name="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
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
			if (is_null($limit_process) || trim($limit_process) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsProcess = portal\virgoProcess::getVirgoList($whereList);
			while(list($id, $label)=each($resultsProcess)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultExecution->getPrcId()) && $id == $resultExecution->getPrcId() ? "selected='selected'" : "");
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
				$parentId = $resultExecution->getPrcId();
				$parentProcess = new portal\virgoProcess();
				$parentValue = $parentProcess->lookup($parentId);
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
	<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="exc_process_dropdown_<?php echo $resultExecution->getId() ?>" 
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
        $( "#exc_process_dropdown_<?php echo $resultExecution->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Process",
			virgo_field_name: "process",
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
					$('#exc_process_<?php echo $resultExecution->getId() ?>').val(ui.item.value);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#exc_process_<?php echo $resultExecution->getId() ?>').val('');
				$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddProcess')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addprocess inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (isset($context["prc"])) {
		$parentValue = $context["prc"];
	} else {
		$parentValue = $resultExecution->exc_prc_id;
	}
	
?>
				<input type="hidden" id="exc_process_<?php echo $resultExecution->exc_id ?>" name="exc_process_<?php echo $resultExecution->exc_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_form_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_form_elements', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_form_execution_parameters', '1') == "1") {
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
	if (false) { //$componentParams->get('show_form_system_messages') == "1") {
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
//	$componentParamsSystemMessage = &JComponentHelper::getParams('com_prt_system_message');
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
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Timestamp
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Message
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Details
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Ip
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Deleted user name
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Url
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Stack trace
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_user') == "1" && ($masterComponentName != "user" || is_null($contextId))) {
?>
				<td align="center" nowrap>User </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td align="center" nowrap>Log level </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpSystemMessage = new portal\virgoSystemMessage();
				$resultsSystemMessage = $tmpSystemMessage->selectAll(' sms_exc_id = ' . $resultExecution->exc_id);
				$idsToCorrect = $tmpSystemMessage->getInvalidRecords();
				$index = 0;
				foreach ($resultsSystemMessage as $resultSystemMessage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultSystemMessage->sms_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSystemMessage->sms_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSystemMessage->sms_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSystemMessage->sms_id) ? 0 : $resultSystemMessage->sms_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSystemMessage->sms_id;
		$resultSystemMessage = new virgoSystemMessage;
		$resultSystemMessage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
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
	$tmp_date = $resultSystemMessage->getTimestamp();
?>
						<input class="inputbox" id="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'] = function () {
  $("#sms_timestamp_<?php echo $resultSystemMessage->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="timestamp_<?php echo $resultExecution->exc_id ?>" 
							name="timestamp_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_timestamp, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="sms_message_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_message_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_MESSAGE');
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
$('#sms_message_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="message_<?php echo $resultExecution->exc_id ?>" 
							name="message_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_message, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 2;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox details" 
	id="sms_details_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_details_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DETAILS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getDetails(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_details_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="details_<?php echo $resultExecution->exc_id ?>" 
							name="details_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_details, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 3;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_ip_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_ip_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_IP');
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
$('#sms_ip_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="ip_<?php echo $resultExecution->exc_id ?>" 
							name="ip_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 4;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DELETED_USER_NAME');
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
$('#sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="deletedUserName_<?php echo $resultExecution->exc_id ?>" 
							name="deletedUserName_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_deleted_user_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 5;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_url_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_url_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_URL');
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
$('#sms_url_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="url_<?php echo $resultExecution->exc_id ?>" 
							name="url_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 6;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox stack_trace" 
	id="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_STACK_TRACE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getStackTrace(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="stackTrace_<?php echo $resultExecution->exc_id ?>" 
							name="stackTrace_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_stack_trace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_user') == "1" && ($masterComponentName != "user" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 7;
?>
<?php
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoUser");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_user', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_usr__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getUsrId())) {
				$parentId = $resultSystemMessage->getUsrId();
				$parentValue = portal\virgoUser::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->getId() ?>" name="sms_user_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_USER');
?>
<?php
	$whereList = "";
	if (!is_null($limit_user) && trim($limit_user) != "") {
		$whereList = $whereList . " usr_id ";
		if (trim($limit_user) == "page_title") {
			$limit_user = "SELECT usr_id FROM prt_users WHERE usr_" . $limit_user . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_user = \"$limit_user\";");
		$whereList = $whereList . " IN (" . $limit_user . ") ";
	}						
	$parentCount = portal\virgoUser::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_user', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_user_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_user_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_user_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_user) || trim($limit_user) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsUser = portal\virgoUser::getVirgoList($whereList);
			while(list($id, $label)=each($resultsUser)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getUsrId()) && $id == $resultSystemMessage->getUsrId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getUsrId();
				$parentUser = new portal\virgoUser();
				$parentValue = $parentUser->lookup($parentId);
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
	<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->getId() ?>" name="sms_user_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "User",
			virgo_field_name: "user",
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
					$('#sms_user_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_user_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#exc_user_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 8;
?>
<?php
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_log_level', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_llv__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getLlvId())) {
				$parentId = $resultSystemMessage->getLlvId();
				$parentValue = portal\virgoLogLevel::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_LOG_LEVEL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_log_level) && trim($limit_log_level) != "") {
		$whereList = $whereList . " llv_id ";
		if (trim($limit_log_level) == "page_title") {
			$limit_log_level = "SELECT llv_id FROM prt_log_levels WHERE llv_" . $limit_log_level . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_log_level = \"$limit_log_level\";");
		$whereList = $whereList . " IN (" . $limit_log_level . ") ";
	}						
	$parentCount = portal\virgoLogLevel::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_log_level', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_log_level) || trim($limit_log_level) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLogLevel = portal\virgoLogLevel::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLogLevel)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getLlvId()) && $id == $resultSystemMessage->getLlvId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getLlvId();
				$parentLogLevel = new portal\virgoLogLevel();
				$parentValue = $parentLogLevel->lookup($parentId);
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
	<input type="hidden" id="sms_log_level_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "LogLevel",
			virgo_field_name: "log_level",
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
					$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#exc_log_level_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
				$resultSystemMessage = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultSystemMessage->sms_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultSystemMessage->sms_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultSystemMessage->sms_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultSystemMessage->sms_id) ? 0 : $resultSystemMessage->sms_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultSystemMessage->sms_id;
		$resultSystemMessage = new virgoSystemMessage;
		$resultSystemMessage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_timestamp') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
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
	$tmp_date = $resultSystemMessage->getTimestamp();
?>
						<input class="inputbox" id="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" size="16" value="<?php echo $tmp_date ?>" onchange="this.form.virgo_changed.value='T'">
<script type="text/javascript">
var functionToCall = functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'];
if (typeof(functionToCall) === 'undefined') {
	functionsToCallAfterLoad<?php echo $_SESSION['current_portlet_object_id'] ?>['sms_timestamp_<?php echo $resultSystemMessage->getId() ?>'] = function () {
  $("#sms_timestamp_<?php echo $resultSystemMessage->getId() ?>").datetimepicker({dateFormat: "yy-mm-dd", hour: 12, minute: 00});
	};
}
</script>  


</td>
<?php
	} else {
?> 
						<input
							type="hidden"
							id="timestamp_<?php echo $resultExecution->exc_id ?>" 
							name="timestamp_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_timestamp, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_message') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="sms_message_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_message_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_MESSAGE');
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
$('#sms_message_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="message_<?php echo $resultExecution->exc_id ?>" 
							name="message_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_message, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_details') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 2;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox details" 
	id="sms_details_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_details_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DETAILS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getDetails(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_details_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="details_<?php echo $resultExecution->exc_id ?>" 
							name="details_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_details, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_ip') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 3;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_ip_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_ip_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="15"
							size="15" 
							value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_IP');
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
$('#sms_ip_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="ip_<?php echo $resultExecution->exc_id ?>" 
							name="ip_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_deleted_user_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 4;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_DELETED_USER_NAME');
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
$('#sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="deletedUserName_<?php echo $resultExecution->exc_id ?>" 
							name="deletedUserName_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_deleted_user_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 5;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="sms_url_<?php echo $resultSystemMessage->getId() ?>" 
							name="sms_url_<?php echo $resultSystemMessage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_URL');
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
$('#sms_url_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="url_<?php echo $resultExecution->exc_id ?>" 
							name="url_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_stack_trace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 6;
?>
<?php
	if (!isset($resultSystemMessage)) {
		$resultSystemMessage = new portal\virgoSystemMessage();
	}
?>
<textarea 
	class="inputbox stack_trace" 
	id="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>" 
	name="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_SYSTEM_MESSAGE_STACK_TRACE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultSystemMessage->getStackTrace(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
							id="stackTrace_<?php echo $resultExecution->exc_id ?>" 
							name="stackTrace_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_stack_trace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsSystemMessage->get('show_table_user') == "1" && ($masterComponentName != "user" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 7;
?>
<?php
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoUser");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_user', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_usr__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getUsrId())) {
				$parentId = $resultSystemMessage->getUsrId();
				$parentValue = portal\virgoUser::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->getId() ?>" name="sms_user_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_USER');
?>
<?php
	$whereList = "";
	if (!is_null($limit_user) && trim($limit_user) != "") {
		$whereList = $whereList . " usr_id ";
		if (trim($limit_user) == "page_title") {
			$limit_user = "SELECT usr_id FROM prt_users WHERE usr_" . $limit_user . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_user = \"$limit_user\";");
		$whereList = $whereList . " IN (" . $limit_user . ") ";
	}						
	$parentCount = portal\virgoUser::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_user', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_user_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_user_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_user_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_user) || trim($limit_user) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsUser = portal\virgoUser::getVirgoList($whereList);
			while(list($id, $label)=each($resultsUser)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getUsrId()) && $id == $resultSystemMessage->getUsrId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getUsrId();
				$parentUser = new portal\virgoUser();
				$parentValue = $parentUser->lookup($parentId);
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
	<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->getId() ?>" name="sms_user_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "User",
			virgo_field_name: "user",
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
					$('#sms_user_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_user_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#exc_user_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsSystemMessage->get('show_table_log_level') == "1" && ($masterComponentName != "log_level" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 8;
?>
<?php
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_log_level', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_llv__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getLlvId())) {
				$parentId = $resultSystemMessage->getLlvId();
				$parentValue = portal\virgoLogLevel::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_LOG_LEVEL');
?>
<?php
	$whereList = "";
	if (!is_null($limit_log_level) && trim($limit_log_level) != "") {
		$whereList = $whereList . " llv_id ";
		if (trim($limit_log_level) == "page_title") {
			$limit_log_level = "SELECT llv_id FROM prt_log_levels WHERE llv_" . $limit_log_level . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_log_level = \"$limit_log_level\";");
		$whereList = $whereList . " IN (" . $limit_log_level . ") ";
	}						
	$parentCount = portal\virgoLogLevel::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_log_level', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_logLevel_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_log_level) || trim($limit_log_level) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsLogLevel = portal\virgoLogLevel::getVirgoList($whereList);
			while(list($id, $label)=each($resultsLogLevel)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getLlvId()) && $id == $resultSystemMessage->getLlvId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getLlvId();
				$parentLogLevel = new portal\virgoLogLevel();
				$parentValue = $parentLogLevel->lookup($parentId);
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
	<input type="hidden" id="sms_log_level_<?php echo $resultSystemMessage->getId() ?>" name="sms_logLevel_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "LogLevel",
			virgo_field_name: "log_level",
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
					$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_log_level_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#exc_log_level_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
				$tmpSystemMessage->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_elements') == "1") {
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
//	$componentParamsElement = &JComponentHelper::getParams('com_prt_element');
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
	if (false) { //$componentParamsElement->get('show_table_key') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Key
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_processed') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Processed
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_result') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Result
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpElement = new portal\virgoElement();
				$resultsElement = $tmpElement->selectAll(' elm_exc_id = ' . $resultExecution->exc_id);
				$idsToCorrect = $tmpElement->getInvalidRecords();
				$index = 0;
				foreach ($resultsElement as $resultElement) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultElement->elm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultElement->elm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultElement->elm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultElement->elm_id) ? 0 : $resultElement->elm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultElement->elm_id;
		$resultElement = new virgoElement;
		$resultElement->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsElement->get('show_table_key') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="elm_key_<?php echo $resultElement->getId() ?>" 
							name="elm_key_<?php echo $resultElement->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultElement->getKey(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_KEY');
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
$('#elm_key_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="key_<?php echo $resultExecution->exc_id ?>" 
							name="key_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_key, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_processed') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
<select class="inputbox" id="elm_processed_<?php echo $resultElement->getId() ?>" name="elm_processed_<?php echo $resultElement->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_PROCESSED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultElement->getProcessed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultElement->getProcessed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultElement->getProcessed()) || $resultElement->getProcessed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#elm_processed_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="processed_<?php echo $resultExecution->exc_id ?>" 
							name="processed_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_processed, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_result') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 2;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_result_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="elm_result_<?php echo $resultElement->getId() ?>" 
							name="elm_result_<?php echo $resultElement->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultElement->getResult(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_RESULT');
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
$('#elm_result_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="result_<?php echo $resultExecution->exc_id ?>" 
							name="result_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_result, ENT_QUOTES, "UTF-8") ?>"
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
				$resultElement = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultElement->elm_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultElement->elm_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultElement->elm_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultElement->elm_id) ? 0 : $resultElement->elm_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultElement->elm_id;
		$resultElement = new virgoElement;
		$resultElement->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsElement->get('show_table_key') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="elm_key_<?php echo $resultElement->getId() ?>" 
							name="elm_key_<?php echo $resultElement->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultElement->getKey(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_KEY');
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
$('#elm_key_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="key_<?php echo $resultExecution->exc_id ?>" 
							name="key_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_key, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_processed') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
<select class="inputbox" id="elm_processed_<?php echo $resultElement->getId() ?>" name="elm_processed_<?php echo $resultElement->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_PROCESSED');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultElement->getProcessed() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultElement->getProcessed() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultElement->getProcessed()) || $resultElement->getProcessed() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#elm_processed_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="processed_<?php echo $resultExecution->exc_id ?>" 
							name="processed_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_processed, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsElement->get('show_table_result') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 2;
?>
<?php
	if (!isset($resultElement)) {
		$resultElement = new portal\virgoElement();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_result_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="elm_result_<?php echo $resultElement->getId() ?>" 
							name="elm_result_<?php echo $resultElement->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultElement->getResult(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_ELEMENT_RESULT');
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
$('#elm_result_<?php echo $resultElement->getId() ?>').qtip({position: {
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
							id="result_<?php echo $resultExecution->exc_id ?>" 
							name="result_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_result, ENT_QUOTES, "UTF-8") ?>"
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
				$tmpElement->setInvalidRecords(null);
?>
<?php
	}
?>
<?php 
	if (false) { //$componentParams->get('show_form_execution_parameters') == "1") {
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
//	$componentParamsExecutionParameter = &JComponentHelper::getParams('com_prt_execution_parameter');
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
	if (false) { //$componentParamsExecutionParameter->get('show_table_name') == "1") {
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
	if (false) { //$componentParamsExecutionParameter->get('show_table_value') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Value
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpExecutionParameter = new portal\virgoExecutionParameter();
				$resultsExecutionParameter = $tmpExecutionParameter->selectAll(' epr_exc_id = ' . $resultExecution->exc_id);
				$idsToCorrect = $tmpExecutionParameter->getInvalidRecords();
				$index = 0;
				foreach ($resultsExecutionParameter as $resultExecutionParameter) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultExecutionParameter->epr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultExecutionParameter->epr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultExecutionParameter->epr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultExecutionParameter->epr_id) ? 0 : $resultExecutionParameter->epr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultExecutionParameter->epr_id;
		$resultExecutionParameter = new virgoExecutionParameter;
		$resultExecutionParameter->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsExecutionParameter->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultExecutionParameter)) {
		$resultExecutionParameter = new portal\virgoExecutionParameter();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="epr_name_<?php echo $resultExecutionParameter->getId() ?>" 
							name="epr_name_<?php echo $resultExecutionParameter->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultExecutionParameter->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PARAMETER_NAME');
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
$('#epr_name_<?php echo $resultExecutionParameter->getId() ?>').qtip({position: {
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
							id="name_<?php echo $resultExecution->exc_id ?>" 
							name="name_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecutionParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultExecutionParameter)) {
		$resultExecutionParameter = new portal\virgoExecutionParameter();
	}
?>
<textarea 
	class="inputbox value" 
	id="epr_value_<?php echo $resultExecutionParameter->getId() ?>" 
	name="epr_value_<?php echo $resultExecutionParameter->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PARAMETER_VALUE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultExecutionParameter->getValue(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#epr_value_<?php echo $resultExecutionParameter->getId() ?>').qtip({position: {
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
							id="value_<?php echo $resultExecution->exc_id ?>" 
							name="value_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_value, ENT_QUOTES, "UTF-8") ?>"
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
				$resultExecutionParameter = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultExecutionParameter->epr_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultExecutionParameter->epr_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultExecutionParameter->epr_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultExecutionParameter->epr_id) ? 0 : $resultExecutionParameter->epr_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultExecutionParameter->epr_id;
		$resultExecutionParameter = new virgoExecutionParameter;
		$resultExecutionParameter->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsExecutionParameter->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
?>
<?php
	if (!isset($resultExecutionParameter)) {
		$resultExecutionParameter = new portal\virgoExecutionParameter();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="epr_name_<?php echo $resultExecutionParameter->getId() ?>" 
							name="epr_name_<?php echo $resultExecutionParameter->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultExecutionParameter->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PARAMETER_NAME');
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
$('#epr_name_<?php echo $resultExecutionParameter->getId() ?>').qtip({position: {
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
							id="name_<?php echo $resultExecution->exc_id ?>" 
							name="name_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsExecutionParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
?>
<?php
	if (!isset($resultExecutionParameter)) {
		$resultExecutionParameter = new portal\virgoExecutionParameter();
	}
?>
<textarea 
	class="inputbox value" 
	id="epr_value_<?php echo $resultExecutionParameter->getId() ?>" 
	name="epr_value_<?php echo $resultExecutionParameter->getId() ?>"
	rows="5"
	cols="48"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_EXECUTION_PARAMETER_VALUE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultExecutionParameter->getValue(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#epr_value_<?php echo $resultExecutionParameter->getId() ?>').qtip({position: {
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
							id="value_<?php echo $resultExecution->exc_id ?>" 
							name="value_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_value, ENT_QUOTES, "UTF-8") ?>"
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
				$tmpExecutionParameter->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultExecution->getDateCreated()) {
		if ($resultExecution->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultExecution->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultExecution->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultExecution->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultExecution->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultExecution->getDateModified()) {
		if ($resultExecution->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultExecution->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultExecution->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultExecution->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultExecution->getDateModified() ?>"	>
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
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("EXECUTION"), "\\'".rawurlencode($resultExecution->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['exc_begin_<?php echo $resultExecution->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($executionDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_execution") {
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
<?php echo T('EXECUTION') ?>:</legend>
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
		if (isset($resultExecution->exc_id)) {
			$resultExecution->exc_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_process');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoProcess::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoProcess::token2Id($tmpToken);
	}
	$resultExecution->setPrcId($defaultValue);
}
	}
?>
																																<?php
	if (P('show_create_begin', "1") == "1" || P('show_create_begin', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="exc_begin_<?php echo $resultExecution->getId() ?>">
* <?php echo T('BEGIN') ?>
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
			if (P('event_column') == "begin") {
				$resultExecution->setBegin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_begin', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="begin" name="exc_begin_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_progress', "1") == "1" || P('show_create_progress', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_progress_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_progress_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_progress_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PROGRESS') ?>
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
			if (P('event_column') == "progress") {
				$resultExecution->setProgress($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_progress', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="progress" name="exc_progress_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_end', "1") == "1" || P('show_create_end', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_end_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_end_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_end_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('END') ?>
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
			if (P('event_column') == "end") {
				$resultExecution->setEnd($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_end', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="end" name="exc_end_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_result', "1") == "1" || P('show_create_result', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_result_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_result_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_result_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RESULT') ?>
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
			if (P('event_column') == "result") {
				$resultExecution->setResult($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_result', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="result" name="exc_result_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_statistics', "1") == "1" || P('show_create_statistics', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_statistics_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_statistics_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_statistics_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STATISTICS') ?>
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
			if (P('event_column') == "statistics") {
				$resultExecution->setStatistics($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_statistics', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid;" 
	class="inputbox readonly" 
>
	<?php echo $resultExecution->exc_statistics ?>
</div>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoStatisticsAsPdf')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgostatisticsaspdf inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='VirgoStatisticsAsPdf';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('Download as PDF') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
	} else {
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
	if (class_exists('portal\virgoProcess') && ((P('show_create_process', "1") == "1" || P('show_create_process', "1") == "2" || P('show_create_process', "1") == "3") && !isset($context["prc"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="exc_process_<?php echo isset($resultExecution->exc_id) ? $resultExecution->exc_id : '' ?>">
 *
<?php echo T('PROCESS') ?> <?php echo T('') ?>
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
//		$limit_process = $componentParams->get('limit_to_process');
		$limit_process = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoProcess");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_process', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultExecution->exc_prc__id = $tmpId;
//			}
			if (!is_null($resultExecution->getPrcId())) {
				$parentId = $resultExecution->getPrcId();
				$parentValue = portal\virgoProcess::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_EXECUTION_PROCESS');
?>
<?php
	$whereList = "";
	if (!is_null($limit_process) && trim($limit_process) != "") {
		$whereList = $whereList . " prc_id ";
		if (trim($limit_process) == "page_title") {
			$limit_process = "SELECT prc_id FROM prt_processes WHERE prc_" . $limit_process . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_process = \"$limit_process\";");
		$whereList = $whereList . " IN (" . $limit_process . ") ";
	}						
	$parentCount = portal\virgoProcess::getVirgoListSize($whereList);
	$showAjaxexc = P('show_create_process', "1") == "3" || $parentCount > 100;
	if (!$showAjaxexc) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
							name="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
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
			if (is_null($limit_process) || trim($limit_process) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsProcess = portal\virgoProcess::getVirgoList($whereList);
			while(list($id, $label)=each($resultsProcess)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultExecution->getPrcId()) && $id == $resultExecution->getPrcId() ? "selected='selected'" : "");
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
				$parentId = $resultExecution->getPrcId();
				$parentProcess = new portal\virgoProcess();
				$parentValue = $parentProcess->lookup($parentId);
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
	<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="exc_process_dropdown_<?php echo $resultExecution->getId() ?>" 
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
        $( "#exc_process_dropdown_<?php echo $resultExecution->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Process",
			virgo_field_name: "process",
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
					$('#exc_process_<?php echo $resultExecution->getId() ?>').val(ui.item.value);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#exc_process_<?php echo $resultExecution->getId() ?>').val('');
				$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddProcess')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addprocess inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (isset($context["prc"])) {
		$parentValue = $context["prc"];
	} else {
		$parentValue = $resultExecution->exc_prc_id;
	}
	
?>
				<input type="hidden" id="exc_process_<?php echo $resultExecution->exc_id ?>" name="exc_process_<?php echo $resultExecution->exc_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_create_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_create_elements', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_create_execution_parameters', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultExecution->exc_id)) {
			$resultExecution->exc_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_process');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoProcess::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoProcess::token2Id($tmpToken);
	}
	$resultExecution->setPrcId($defaultValue);
}
	}
?>
																																<?php
	if (P('show_create_begin', "1") == "1" || P('show_create_begin', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="exc_begin_<?php echo $resultExecution->getId() ?>">
* <?php echo T('BEGIN') ?>
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
			if (P('event_column') == "begin") {
				$resultExecution->setBegin($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_begin', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="begin" name="exc_begin_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_progress', "1") == "1" || P('show_create_progress', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_progress_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_progress_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_progress_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('PROGRESS') ?>
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
			if (P('event_column') == "progress") {
				$resultExecution->setProgress($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_progress', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="progress" name="exc_progress_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_end', "1") == "1" || P('show_create_end', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_end_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_end_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_end_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('END') ?>
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
			if (P('event_column') == "end") {
				$resultExecution->setEnd($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_end', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="end" name="exc_end_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_result', "1") == "1" || P('show_create_result', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_result_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_result_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_result_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('RESULT') ?>
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
			if (P('event_column') == "result") {
				$resultExecution->setResult($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_result', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="result" name="exc_result_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_statistics', "1") == "1" || P('show_create_statistics', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_statistics_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="exc_statistics_<?php echo $resultExecution->getId() ?>">
 <?php echo P('show_create_statistics_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STATISTICS') ?>
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
			if (P('event_column') == "statistics") {
				$resultExecution->setStatistics($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_statistics', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid;" 
	class="inputbox readonly" 
>
	<?php echo $resultExecution->exc_statistics ?>
</div>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoStatisticsAsPdf')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgostatisticsaspdf inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='VirgoStatisticsAsPdf';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('Download as PDF') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

<?php
	} else {
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
	if (class_exists('portal\virgoProcess') && ((P('show_create_process', "1") == "1" || P('show_create_process', "1") == "2" || P('show_create_process', "1") == "3") && !isset($context["prc"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="exc_process_<?php echo isset($resultExecution->exc_id) ? $resultExecution->exc_id : '' ?>">
 *
<?php echo T('PROCESS') ?> <?php echo T('') ?>
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
//		$limit_process = $componentParams->get('limit_to_process');
		$limit_process = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoProcess");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_process', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultExecution->exc_prc__id = $tmpId;
//			}
			if (!is_null($resultExecution->getPrcId())) {
				$parentId = $resultExecution->getPrcId();
				$parentValue = portal\virgoProcess::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_EXECUTION_PROCESS');
?>
<?php
	$whereList = "";
	if (!is_null($limit_process) && trim($limit_process) != "") {
		$whereList = $whereList . " prc_id ";
		if (trim($limit_process) == "page_title") {
			$limit_process = "SELECT prc_id FROM prt_processes WHERE prc_" . $limit_process . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_process = \"$limit_process\";");
		$whereList = $whereList . " IN (" . $limit_process . ") ";
	}						
	$parentCount = portal\virgoProcess::getVirgoListSize($whereList);
	$showAjaxexc = P('show_create_process', "1") == "3" || $parentCount > 100;
	if (!$showAjaxexc) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
							name="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
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
			if (is_null($limit_process) || trim($limit_process) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsProcess = portal\virgoProcess::getVirgoList($whereList);
			while(list($id, $label)=each($resultsProcess)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultExecution->getPrcId()) && $id == $resultExecution->getPrcId() ? "selected='selected'" : "");
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
				$parentId = $resultExecution->getPrcId();
				$parentProcess = new portal\virgoProcess();
				$parentValue = $parentProcess->lookup($parentId);
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
	<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="exc_process_dropdown_<?php echo $resultExecution->getId() ?>" 
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
        $( "#exc_process_dropdown_<?php echo $resultExecution->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Process",
			virgo_field_name: "process",
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
					$('#exc_process_<?php echo $resultExecution->getId() ?>').val(ui.item.value);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#exc_process_<?php echo $resultExecution->getId() ?>').val('');
				$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddProcess')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addprocess inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (isset($context["prc"])) {
		$parentValue = $context["prc"];
	} else {
		$parentValue = $resultExecution->exc_prc_id;
	}
	
?>
				<input type="hidden" id="exc_process_<?php echo $resultExecution->exc_id ?>" name="exc_process_<?php echo $resultExecution->exc_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>

<?php
	if (class_exists('portal\virgoSystemMessage') && P('show_create_system_messages', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_create_elements', '1') == "1") {
?>
<?php
	} else {
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_create_execution_parameters', '1') == "1") {
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
	if ($resultExecution->getDateCreated()) {
		if ($resultExecution->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultExecution->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultExecution->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultExecution->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultExecution->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultExecution->getDateModified()) {
		if ($resultExecution->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultExecution->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultExecution->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultExecution->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultExecution->getDateModified() ?>"	>
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
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['exc_begin_<?php echo $resultExecution->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($executionDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('EXECUTION') ?>:</legend>
				<ul>
<?php
	$criteriaExecution = $resultExecution->getCriteria();
?>
<?php
	if (P('show_search_begin', "1") == "1") {

		if (isset($criteriaExecution["begin"])) {
			$fieldCriteriaBegin = $criteriaExecution["begin"];
			$dataTypeCriteria = $fieldCriteriaBegin["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('BEGIN') ?>
		</label>
		<span align="left" nowrap>
<script src="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/js/jquery-ui-1.8.21.custom.min.js"></script>
<link href="<?php echo $_SESSION['portal_url'] ?>/libraries/jQueryUI/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_begin_from" 
							name="virgo_search_begin_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_begin_from").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
						&nbsp;-&nbsp;
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_begin_to" 
							name="virgo_search_begin_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_begin_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_begin_is_null" 
				name="virgo_search_begin_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaBegin) && $fieldCriteriaBegin["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaBegin) && $fieldCriteriaBegin["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaBegin) && $fieldCriteriaBegin["is_null"] == 2) {
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
	if (P('show_search_progress', "1") == "1") {

		if (isset($criteriaExecution["progress"])) {
			$fieldCriteriaProgress = $criteriaExecution["progress"];
			$dataTypeCriteria = $fieldCriteriaProgress["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('PROGRESS') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_progress_from" 
							name="virgo_search_progress_from"
							style="border: yellow 1 solid;" 
							size="5" 
							value="<?php echo isset($dataTypeCriteria["from"]) ? htmlentities($dataTypeCriteria["from"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>
						&nbsp;-&nbsp;
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_progress_to" 
							name="virgo_search_progress_to"
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
				id="virgo_search_progress_is_null" 
				name="virgo_search_progress_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaProgress) && $fieldCriteriaProgress["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaProgress) && $fieldCriteriaProgress["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaProgress) && $fieldCriteriaProgress["is_null"] == 2) {
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
	if (P('show_search_end', "1") == "1") {

		if (isset($criteriaExecution["end"])) {
			$fieldCriteriaEnd = $criteriaExecution["end"];
			$dataTypeCriteria = $fieldCriteriaEnd["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('END') ?>
		</label>
		<span align="left" nowrap>
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["from"]) ? $dataTypeCriteria["from"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_end_from" 
							name="virgo_search_end_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_end_from").datepicker({dateFormat: "yy-mm-dd"});
});
</script>
						&nbsp;-&nbsp;
<?php
	$tmp_date_format = "Y-m-d H:i:s";
	$tmp_date = isset($dataTypeCriteria["to"]) ? $dataTypeCriteria["to"] : "";
?>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_end_to" 
							name="virgo_search_end_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_end_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_end_is_null" 
				name="virgo_search_end_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaEnd) && $fieldCriteriaEnd["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaEnd) && $fieldCriteriaEnd["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaEnd) && $fieldCriteriaEnd["is_null"] == 2) {
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
	if (P('show_search_result', "1") == "1") {

		if (isset($criteriaExecution["result"])) {
			$fieldCriteriaResult = $criteriaExecution["result"];
			$dataTypeCriteria = $fieldCriteriaResult["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('RESULT') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_result" 
							name="virgo_search_result"
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
				id="virgo_search_result_is_null" 
				name="virgo_search_result_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaResult) && $fieldCriteriaResult["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaResult) && $fieldCriteriaResult["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaResult) && $fieldCriteriaResult["is_null"] == 2) {
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
	if (P('show_search_statistics', "1") == "1") {

		if (isset($criteriaExecution["statistics"])) {
			$fieldCriteriaStatistics = $criteriaExecution["statistics"];
			$dataTypeCriteria = $fieldCriteriaStatistics["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('STATISTICS') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_statistics_is_null" 
				name="virgo_search_statistics_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaStatistics) && $fieldCriteriaStatistics["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaStatistics) && $fieldCriteriaStatistics["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaStatistics) && $fieldCriteriaStatistics["is_null"] == 2) {
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
	if (P('show_search_process', '1') == "1") {
		if (isset($criteriaExecution["process"])) {
			$fieldCriteriaProcess = $criteriaExecution["process"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('PROCESS') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaProcess["value"]) ? $fieldCriteriaProcess["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_process" name="virgo_search_process" value="<?php echo $value ?>">
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
		if (isset($fieldCriteriaProcess) && $fieldCriteriaProcess["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaProcess) && $fieldCriteriaProcess["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaProcess) && $fieldCriteriaProcess["is_null"] == 2) {
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
	if (P('show_search_system_messages') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsSystemMessages = $record->getSystemMessages();
	$sizeSystemMessages = count($subrecordsSystemMessages);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						System messages
					</label>
<?php
	if ($sizeSystemMessages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSystemMessages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSystemMessages) {
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
	if (P('show_search_elements') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsElements = $record->getElements();
	$sizeElements = count($subrecordsElements);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Elements
					</label>
<?php
	if ($sizeElements == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsElements as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeElements) {
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
	if (P('show_search_execution_parameters') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsExecutionParameters = $record->getExecutionParameters();
	$sizeExecutionParameters = count($subrecordsExecutionParameters);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Execution parameters
					</label>
<?php
	if ($sizeExecutionParameters == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsExecutionParameters as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeExecutionParameters) {
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
	unset($criteriaExecution);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	} elseif ($executionDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('EXECUTION') ?>:</legend>
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
	if (P('show_view_begin', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="begin"
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
<?php echo T('BEGIN') ?>
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
							<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="begin" name="exc_begin_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getBegin(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_progress', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="progress"
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
<?php echo T('PROGRESS') ?>
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
							<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="progress" name="exc_progress_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getProgress(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_end', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="end"
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
<?php echo T('END') ?>
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
							<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="end" name="exc_end_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getEnd(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_result', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="result"
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
<?php echo T('RESULT') ?>
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
							<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="result" name="exc_result_<?php echo $resultExecution->getId() ?>" value="<?php echo htmlentities($resultExecution->getResult(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_statistics', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="statistics"
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
<?php echo T('STATISTICS') ?>
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
	style="border: yellow 1 solid;" 
	class="inputbox readonly" 
>
	<?php echo $resultExecution->exc_statistics ?>
</div>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('VirgoStatisticsAsPdf')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_virgostatisticsaspdf inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="button" 
							onclick="
								var form = document.getElementById('portlet_form_download_<?php echo $this->getId() ?>');
								var children = form.getElementsByTagName('input');
								var found = 0;
								for(var i = 0; i< children.length;i++) {
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='VirgoStatisticsAsPdf';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
								form.submit();
								return false;
							" 
							value="<?php echo T('Download as PDF') ?>"
						/><div class="button_right"></div></div><?php
	}
?>

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
	if (class_exists('portal\virgoProcess') && P('show_view_process', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "process" || is_null($contextId))) {
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
					<span align="right" nowrap class="fieldlabel">Process </span>
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
			if (!is_null($context) && isset($context['prc_id'])) {
				$tmpId = $context['prc_id'];
			}
			$readOnly = "";
			if ($resultExecution->getId() == 0) {
// przesuac do createforgui				$resultExecution->exc_prc__id = $tmpId;
			}
			$parentId = $resultExecution->getProcessId();
			$parentValue = portal\virgoProcess::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="exc_process_<?php echo isset($resultExecution->exc_id) ? $resultExecution->exc_id : '' ?>" 
						name="exc_process_<?php echo isset($resultExecution->exc_id) ? $resultExecution->exc_id : '' ?>" 						
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
	if (class_exists('portal\virgoSystemMessage') && P('show_view_system_messages', '0') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsSystemMessages = $record->getSystemMessages();
	$sizeSystemMessages = count($subrecordsSystemMessages);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="execution"
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
						System messages 
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
	if ($sizeSystemMessages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsSystemMessages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeSystemMessages) {
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
	if (class_exists('portal\virgoElement') && P('show_view_elements', '0') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsElements = $record->getElements();
	$sizeElements = count($subrecordsElements);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="execution"
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
						Elements 
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
	if ($sizeElements == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsElements as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeElements) {
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
	if (class_exists('portal\virgoExecutionParameter') && P('show_view_execution_parameters', '0') == "1") {
?>
<?php
	$record = new portal\virgoExecution();
	$recordId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->exc_id;
	$record->load($recordId);
	$subrecordsExecutionParameters = $record->getExecutionParameters();
	$sizeExecutionParameters = count($subrecordsExecutionParameters);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="execution"
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
						Execution parameters 
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
	if ($sizeExecutionParameters == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsExecutionParameters as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizeExecutionParameters) {
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
<?php echo T('EXECUTION') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultExecution->getDateCreated()) {
		if ($resultExecution->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultExecution->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultExecution->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultExecution->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultExecution->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultExecution->getDateModified()) {
		if ($resultExecution->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultExecution->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultExecution->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultExecution->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultExecution->getDateModified() ?>"	>
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
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("EXECUTION"), "\\'".$resultExecution->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	} elseif ($executionDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "exc_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultExecution->setShowPage(1); 
	$resultExecution->setShowRows('all'); 	
	$resultsExecution = $resultExecution->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsExecution as $resultExecution) {
		if (isset($resultExecution[$eventColumn]) && isset($events[substr($resultExecution[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultExecution[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoExecution($resultExecution['exc_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultExecution[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='exc_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultExecution) {
?>
<?php
PROFILE('token');
	if (isset($resultExecution)) {
		$tmpId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId();
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultExecution->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.exc_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var executionChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == executionChildrenDivOpen) {
					div.style.display = 'none';
					executionChildrenDivOpen = '';
				} else {
					if (executionChildrenDivOpen != '') {
						document.getElementById(executionChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					executionChildrenDivOpen = clickedDivId;
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
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultExecution->getShowPage(); 
			$showRows = $resultExecution->getShowRows(); 
?>
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Executions') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultExecution->getOrderColumn();
			$virgoOrderMode = $resultExecution->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsExecution = $resultExecution->getTableData($resultCount, $filterApplied);
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
	if (P('show_table_begin', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'exc_begin');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('BEGIN') ?>							<?php echo ($oc == "exc_begin" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoExecution::getLocalSessionValue('VirgoFilterBegin', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_progress', "0") == "1") {
?>
				<th align="right" valign="middle" rowspan="2" style="text-align: right;">
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'exc_progress');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PROGRESS') ?>							<?php echo ($oc == "exc_progress" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoExecution::getLocalSessionValue('VirgoFilterProgress', null);
?>
						<input
							name="virgo_filter_progress"
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
	if (P('show_table_end', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'exc_end');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('END') ?>							<?php echo ($oc == "exc_end" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoExecution::getLocalSessionValue('VirgoFilterEnd', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_result', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'exc_result');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('RESULT') ?>							<?php echo ($oc == "exc_result" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoExecution::getLocalSessionValue('VirgoFilterResult', null);
?>
						<input
							name="virgo_filter_result"
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
	if (P('show_table_statistics', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'exc_statistics');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('STATISTICS') ?>							<?php echo ($oc == "exc_statistics" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoExecution::getLocalSessionValue('VirgoFilterStatistics', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoProcess'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_process', "1") != "0"  && !isset($parentsInContext['portal\\virgoProcess'])  ) {
	if (P('show_table_process', "1") == "2") {
		$tmpLookupProcess = virgoProcess::getVirgoListStatic();
?>
<input name='exc_Process_id_<?php echo $this->getId() ?>' id='exc_Process_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultExecution->getOrderColumn(); 
	$om = $resultExecution->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'process');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('PROCESS') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "process" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoProcess::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoProcess::getVirgoListStatic();
			$parentFilter = virgoExecution::getLocalSessionValue('VirgoFilterProcess', null);
?>
						<select 
							name="virgo_filter_process"
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
			$parentFilter = virgoExecution::getLocalSessionValue('VirgoFilterTitleProcess', null);
?>
						<input
							name="virgo_filter_title_process"
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
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_table_elements', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_table_execution_parameters', '0') == "1") {
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
					$resultExecution->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsExecution as $resultExecution) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoExecution/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultExecution['exc_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoExecution::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoExecution::setContextId($resultExecution['exc_id'], false);
						$tmpContextId = $resultExecution['exc_id'];
					}
				}
				if (isset($tmpContextId) && $resultExecution['exc_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : "" ?>" 
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultExecution['exc_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultExecution['exc_id'] ?>">
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
PROFILE('begin');
	if (P('show_table_begin', "1") == "1") {
PROFILE('render_data_table_begin');
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
			<li class="begin">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_begin'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_begin');
	}
PROFILE('begin');
?>
<?php
PROFILE('progress');
	if (P('show_table_progress', "0") == "1") {
PROFILE('render_data_table_progress');
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
			<li class="progress">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				$resultExecution['exc_progress'] 
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
PROFILE('render_data_table_progress');
	}
PROFILE('progress');
?>
<?php
PROFILE('end');
	if (P('show_table_end', "0") == "1") {
PROFILE('render_data_table_end');
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
			<li class="end">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_end'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_end');
	}
PROFILE('end');
?>
<?php
PROFILE('result');
	if (P('show_table_result', "0") == "1") {
PROFILE('render_data_table_result');
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
			<li class="result">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_result'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_result');
	}
PROFILE('result');
?>
<?php
PROFILE('statistics');
	if (P('show_table_statistics', "0") == "1") {
PROFILE('render_data_table_statistics');
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
			<li class="statistics">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
	<?php echo $resultExecution['exc_statistics'] ?>
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
PROFILE('render_data_table_statistics');
	}
PROFILE('statistics');
?>
<?php
	if (class_exists('portal\virgoProcess') && P('show_table_process', "1") != "0"  && !isset($parentsInContext["portal\\virgoProcess"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_process', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="process">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
	if (P('show_table_process', "1") == "1") {
		if (isset($resultExecution['process'])) {
			echo $resultExecution['process'];
		}
	} else {
//		echo $resultExecution['exc_prc_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo $resultExecution['exc_id'] ?>');
	_pSF(form, 'exc_Process_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupProcess as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultExecution['exc_prc_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_table_elements', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_table_execution_parameters', '0') == "1") {
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
	if (isset($resultExecution)) {
		$tmpId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId();
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("EXECUTION"), "\\'".rawurlencode($resultExecution['exc_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultExecution['exc_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultExecution['exc_id'] ?>">
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
PROFILE('begin');
	if (P('show_table_begin', "1") == "1") {
PROFILE('render_data_table_begin');
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
			<li class="begin">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_begin'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_begin');
	}
PROFILE('begin');
?>
<?php
PROFILE('progress');
	if (P('show_table_progress', "0") == "1") {
PROFILE('render_data_table_progress');
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
			<li class="progress">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				$resultExecution['exc_progress'] 
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
PROFILE('render_data_table_progress');
	}
PROFILE('progress');
?>
<?php
PROFILE('end');
	if (P('show_table_end', "0") == "1") {
PROFILE('render_data_table_end');
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
			<li class="end">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_end'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_end');
	}
PROFILE('end');
?>
<?php
PROFILE('result');
	if (P('show_table_result', "0") == "1") {
PROFILE('render_data_table_result');
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
			<li class="result">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultExecution['exc_result'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_result');
	}
PROFILE('result');
?>
<?php
PROFILE('statistics');
	if (P('show_table_statistics', "0") == "1") {
PROFILE('render_data_table_statistics');
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
			<li class="statistics">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
	<?php echo $resultExecution['exc_statistics'] ?>
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
PROFILE('render_data_table_statistics');
	}
PROFILE('statistics');
?>
<?php
	if (class_exists('portal\virgoProcess') && P('show_table_process', "1") != "0"  && !isset($parentsInContext["portal\\virgoProcess"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_process', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="process">
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
					form.exc_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultExecution['exc_id']) ? $resultExecution['exc_id'] : '' ?>'; 
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
	if (P('show_table_process', "1") == "1") {
		if (isset($resultExecution['process'])) {
			echo $resultExecution['process'];
		}
	} else {
//		echo $resultExecution['exc_prc_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo $resultExecution['exc_id'] ?>');
	_pSF(form, 'exc_Process_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupProcess as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultExecution['exc_prc_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoSystemMessage') && P('show_table_system_messages', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoElement') && P('show_table_elements', '0') == "1") {
?>
<?php
	}
?>
<?php
	if (class_exists('portal\virgoExecutionParameter') && P('show_table_execution_parameters', '0') == "1") {
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
	if (isset($resultExecution)) {
		$tmpId = is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId();
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("EXECUTION"), "\\'".rawurlencode($resultExecution['exc_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
			virgoExecution::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultExecution);
				unset($resultsExecution);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpExecution = new virgoExecution();
						$tmpCount = $tmpExecution->getAllRecordCount(' exc_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoExecution::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&exc_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.exc_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.exc_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'exc_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'exc_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
					$sessionSeparator = virgoExecution::getImportFieldSeparator();
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
						$sessionSeparator = virgoExecution::getImportFieldSeparator();
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('EXECUTIONS'), "") ?>'))) return false;
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	} elseif ($executionDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_execution") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var executionChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == executionChildrenDivOpen) {
					div.style.display = 'none';
					executionChildrenDivOpen = '';
				} else {
					if (executionChildrenDivOpen != '') {
						document.getElementById(executionChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					executionChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_execution" name="virgo_form_execution" enctype="multipart/form-data">
						<input type="text" name="exc_id_<?php echo $this->getId() ?>" id="exc_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_begin', "1") == "1") {
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
	if (P('show_table_progress', "0") == "1") {
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
	if (P('show_table_end', "0") == "1") {
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
	if (P('show_table_result', "0") == "1") {
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
	if (P('show_table_statistics', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Statistics
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_process', "1") == "1" /* && ($masterComponentName != "process" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Process </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsExecution = $resultExecution->getRecordsToEdit();
				$idsToCorrect = $resultExecution->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsExecution as $resultExecution) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultExecution->exc_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultExecution->exc_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('begin');
	if (P('show_table_begin', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 0;
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
PROFILE('begin');
	} else {
?> 
						<input
							type="hidden"
							id="begin_<?php echo $resultExecution->exc_id ?>" 
							name="begin_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_begin, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('progress');
	if (P('show_table_progress', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 1;
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
PROFILE('progress');
	} else {
?> 
						<input
							type="hidden"
							id="progress_<?php echo $resultExecution->exc_id ?>" 
							name="progress_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_progress, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('end');
	if (P('show_table_end', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 2;
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
PROFILE('end');
	} else {
?> 
						<input
							type="hidden"
							id="end_<?php echo $resultExecution->exc_id ?>" 
							name="end_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_end, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('result');
	if (P('show_table_result', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 3;
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
PROFILE('result');
	} else {
?> 
						<input
							type="hidden"
							id="result_<?php echo $resultExecution->exc_id ?>" 
							name="result_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_result, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('statistics');
	if (P('show_table_statistics', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 4;
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
PROFILE('statistics');
	} else {
?> 
						<input
							type="hidden"
							id="statistics_<?php echo $resultExecution->exc_id ?>" 
							name="statistics_<?php echo $resultExecution->exc_id ?>"
							value="<?php echo htmlentities($resultExecution->exc_statistics, ENT_QUOTES, "UTF-8") ?>"
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
	if (P('show_table_process', "1") == "1"/* && ($masterComponentName != "process" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsExecution) * 5;
?>
<?php
//		$limit_process = $componentParams->get('limit_to_process');
		$limit_process = null;
		$tmpId = portal\virgoExecution::getParentInContext("portal\\virgoProcess");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_process', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultExecution->exc_prc__id = $tmpId;
//			}
			if (!is_null($resultExecution->getPrcId())) {
				$parentId = $resultExecution->getPrcId();
				$parentValue = portal\virgoProcess::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_EXECUTION_PROCESS');
?>
<?php
	$whereList = "";
	if (!is_null($limit_process) && trim($limit_process) != "") {
		$whereList = $whereList . " prc_id ";
		if (trim($limit_process) == "page_title") {
			$limit_process = "SELECT prc_id FROM prt_processes WHERE prc_" . $limit_process . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_process = \"$limit_process\";");
		$whereList = $whereList . " IN (" . $limit_process . ") ";
	}						
	$parentCount = portal\virgoProcess::getVirgoListSize($whereList);
	$showAjaxexc = P('show_form_process', "1") == "3" || $parentCount > 100;
	if (!$showAjaxexc) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
							name="exc_process_<?php echo !is_null($resultExecution->getId()) ? $resultExecution->getId() : '' ?>" 
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
			if (is_null($limit_process) || trim($limit_process) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsProcess = portal\virgoProcess::getVirgoList($whereList);
			while(list($id, $label)=each($resultsProcess)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultExecution->getPrcId()) && $id == $resultExecution->getPrcId() ? "selected='selected'" : "");
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
				$parentId = $resultExecution->getPrcId();
				$parentProcess = new portal\virgoProcess();
				$parentValue = $parentProcess->lookup($parentId);
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
	<input type="hidden" id="exc_process_<?php echo $resultExecution->getId() ?>" name="exc_process_<?php echo $resultExecution->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="exc_process_dropdown_<?php echo $resultExecution->getId() ?>" 
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
        $( "#exc_process_dropdown_<?php echo $resultExecution->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Process",
			virgo_field_name: "process",
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
					$('#exc_process_<?php echo $resultExecution->getId() ?>').val(ui.item.value);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				  	$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#exc_process_<?php echo $resultExecution->getId() ?>').val('');
				$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddProcess')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addprocess inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
$('#exc_process_dropdown_<?php echo $resultExecution->getId() ?>').qtip({position: {
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
	if (isset($context["prc"])) {
		$parentValue = $context["prc"];
	} else {
		$parentValue = $resultExecution->exc_prc_id;
	}
	
?>
				<input type="hidden" id="exc_process_<?php echo $resultExecution->exc_id ?>" name="exc_process_<?php echo $resultExecution->exc_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultExecution->exc_id])) {
		$errorMessage = $idsToCorrect[$resultExecution->exc_id];
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div>					</td>
				</tr>
		</table>
	</form>
<?php
	} elseif ($executionDisplayMode == "ADD_NEW_PARENT_PROCESS") {
		$resultProcess = portal\virgoProcess::createGuiAware();
		$resultProcess->loadFromRequest();
?>
<fieldset>
	<label>Dodaj nowy rekord Process</label>
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
				$resultExecution->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="prc_name_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getName(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setExecutionTime($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_execution_time', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getExecutionTime(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="executionTime" name="prc_executionTime_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getExecutionTime(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setDescription($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_description', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly description" 
	id="description" 
><?php echo htmlentities($resultExecution->exc_description, ENT_QUOTES, "UTF-8") ?></div>

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
				$resultExecution->setInitiationCode($virgoSelectedDay);
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
	id="exc_initiationCode_<?php echo $resultExecution->exc_id ?>" 
	name="exc_initiationCode_<?php echo $resultExecution->exc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultExecution->exc_initiation_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("exc_initiationCode_<?php echo $resultExecution->exc_id ?>"), {
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
				$resultExecution->setExecutionCode($virgoSelectedDay);
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
	id="exc_executionCode_<?php echo $resultExecution->exc_id ?>" 
	name="exc_executionCode_<?php echo $resultExecution->exc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultExecution->exc_execution_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("exc_executionCode_<?php echo $resultExecution->exc_id ?>"), {
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
				$resultExecution->setClosingCode($virgoSelectedDay);
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
	id="exc_closingCode_<?php echo $resultExecution->exc_id ?>" 
	name="exc_closingCode_<?php echo $resultExecution->exc_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultExecution->exc_closing_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("exc_closingCode_<?php echo $resultExecution->exc_id ?>"), {
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
				$resultExecution->setPortionSize($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_portion_size', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getPortionSize(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="portionSize" name="prc_portionSize_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getPortionSize(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setActive($virgoSelectedDay);
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
	if (is_null($resultExecution->exc_active) || $resultExecution->exc_active == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultExecution->exc_active == 1) {
		$booleanValue = T("YES");
	} elseif ($resultExecution->exc_active === "0") {
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
				$resultExecution->setOrder($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_order', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getOrder(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="order" name="prc_order_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getOrder(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setLastSession($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_last_session', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getLastSession(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="lastSession" name="prc_lastSession_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getLastSession(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setSubprocessCount($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_subprocess_count', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultExecution->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="subprocessCount" name="prc_subprocessCount_<?php echo $resultProcess->getId() ?>" value="<?php echo htmlentities($resultExecution->getSubprocessCount(), ENT_QUOTES, "UTF-8") ?>"> 

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
				$resultExecution->setClear($virgoSelectedDay);
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
	if (is_null($resultExecution->exc_clear) || $resultExecution->exc_clear == 2) {
		$booleanValue = T("NO_DATA");
	} elseif ($resultExecution->exc_clear == 1) {
		$booleanValue = T("YES");
	} elseif ($resultExecution->exc_clear === "0") {
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

<input type="hidden" name="calling_view" value="<?php echo R('calling_view') ?>">
</fieldset>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('StoreNewProcess')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_storenewprocess inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='StoreNewProcess';
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php
	$pobId = $_SESSION['current_portlet_object_id'];
	$childId = R('exc_id_' . $pobId);
?>
<input 
	type="hidden" 
	name="exc_id_<?php echo $pobId ?>" 
	value="<?php echo $childId ?>"
/>
<input 
	type="hidden" 
	name="exc_begin_<?php echo $childId ?>" 
	value="<?php echo R('exc_begin_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="exc_progress_<?php echo $childId ?>" 
	value="<?php echo R('exc_progress_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="exc_end_<?php echo $childId ?>" 
	value="<?php echo R('exc_end_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="exc_result_<?php echo $childId ?>" 
	value="<?php echo R('exc_result_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="exc_statistics_<?php echo $childId ?>" 
	value="<?php echo R('exc_statistics_' . $childId) ?>"
/>
<input 
	type="hidden" 
	name="exc_process_<?php echo $childId ?>" 
	value="<?php echo R('exc_process_' . $childId) ?>"
/>
<?php		
	} else {
		$virgoShowReturn = true;
?>
		<div class="<?php echo $executionDisplayMode ?>">
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
	_pSF(form, 'exc_id_<?php echo $this->getId() ?>', '<?php echo isset($resultExecution) ? (is_array($resultExecution) ? $resultExecution['exc_id'] : $resultExecution->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_execution" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_execution').style.display='none';">
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
	$infos = virgoExecution::getExtraFilesInfo();
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

