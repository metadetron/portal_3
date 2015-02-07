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
	use portal\virgoSystemMessage;

//	setlocale(LC_ALL, '$messages.LOCALE');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php');
//	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_system_message');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_system_message/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'prt_sms.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoSystemMessage/prt_sms.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_system_message" style="border: none;">
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
		$ancestors["portal"] = "TRUE";
		$ancestors["template"] = "TRUE";
		$ancestors["user"] = "TRUE";
		$ancestors["execution"] = "TRUE";
		$ancestors["process"] = "TRUE";
		$ancestors["page"] = "TRUE";
		$contextId = null;		
			$resultSystemMessage = virgoSystemMessage::createGuiAware();
			$contextId = $resultSystemMessage->getContextId();
			if (isset($contextId)) {
				if (virgoSystemMessage::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultSystemMessage->load($contextId);
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
		if ($className == "virgoSystemMessage") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultSystemMessage = new virgoSystemMessage($tmpId);
				virgoSystemMessage::setDisplayMode("FORM");
			} else {
				$resultSystemMessage = new virgoSystemMessage();
				virgoSystemMessage::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultSystemMessage->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultSystemMessage->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultSystemMessage = new virgoSystemMessage($allPrivateRecords[0]['sms_id']);
						$resultSystemMessage->putInContext(false);
					} else {
						$resultSystemMessage = new virgoSystemMessage();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultSystemMessage->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultSystemMessage = new virgoSystemMessage($records[0]['sms_id']);
							$resultSystemMessage->putInContext(false);
						} else {
							$resultSystemMessage = new virgoSystemMessage();
						}
					} else {
						$resultSystemMessage = new virgoSystemMessage();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultSystemMessage = new virgoSystemMessage(virgoUser::getUserId());
			$resultSystemMessage->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultSystemMessage = new virgoSystemMessage();
		}
?>
<?php
	$systemMessageDisplayMode = virgoSystemMessage::getDisplayMode();
//	if ($systemMessageDisplayMode == "" || $systemMessageDisplayMode == "TABLE") {
//		$resultSystemMessage = $resultSystemMessage->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultSystemMessage->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseSystemMessage = $whereClauseSystemMessage . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaSystemMessage = $resultSystemMessage->getCriteria();
		$countTmp = 0;
		if (isset($criteriaSystemMessage["timestamp"])) {
			$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
			if ($fieldCriteriaTimestamp["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
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
		if (isset($criteriaSystemMessage["message"])) {
			$fieldCriteriaMessage = $criteriaSystemMessage["message"];
			if ($fieldCriteriaMessage["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaMessage["value"];
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
		if (isset($criteriaSystemMessage["details"])) {
			$fieldCriteriaDetails = $criteriaSystemMessage["details"];
			if ($fieldCriteriaDetails["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaDetails["value"];
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
		if (isset($criteriaSystemMessage["ip"])) {
			$fieldCriteriaIp = $criteriaSystemMessage["ip"];
			if ($fieldCriteriaIp["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaIp["value"];
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
		if (isset($criteriaSystemMessage["deleted_user_name"])) {
			$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
			if ($fieldCriteriaDeletedUserName["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
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
		if (isset($criteriaSystemMessage["url"])) {
			$fieldCriteriaUrl = $criteriaSystemMessage["url"];
			if ($fieldCriteriaUrl["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaUrl["value"];
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
		if (isset($criteriaSystemMessage["stack_trace"])) {
			$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
			if ($fieldCriteriaStackTrace["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
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
		if (isset($criteriaSystemMessage["user"])) {
			$parentCriteria = $criteriaSystemMessage["user"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaSystemMessage["log_level"])) {
			$parentCriteria = $criteriaSystemMessage["log_level"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
					$parentIds = $parentCriteria["ids"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaSystemMessage["execution"])) {
			$parentCriteria = $criteriaSystemMessage["execution"];
			if ($parentCriteria["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				if (isset($parentCriteria["value"]) && $parentCriteria["value"] != "") {
					$parentValue = $parentCriteria["value"];
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (is_null($criteriaSystemMessage) || sizeof($criteriaSystemMessage) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaSystemMessage["timestamp"])) {
				$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
				if ($fieldCriteriaTimestamp["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Timestamp') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaTimestamp["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaTimestamp["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='timestamp';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
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
					<?php echo T('Timestamp') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='timestamp';
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
			if (isset($criteriaSystemMessage["message"])) {
				$fieldCriteriaMessage = $criteriaSystemMessage["message"];
				if ($fieldCriteriaMessage["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Message') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaMessage["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaMessage["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='message';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaMessage["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Message') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='message';
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
			if (isset($criteriaSystemMessage["details"])) {
				$fieldCriteriaDetails = $criteriaSystemMessage["details"];
				if ($fieldCriteriaDetails["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Details') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaDetails["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaDetails["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='details';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaDetails["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Details') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='details';
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
			if (isset($criteriaSystemMessage["ip"])) {
				$fieldCriteriaIp = $criteriaSystemMessage["ip"];
				if ($fieldCriteriaIp["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ip') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaIp["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaIp["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ip';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaIp["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Ip') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='ip';
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
			if (isset($criteriaSystemMessage["deleted_user_name"])) {
				$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
				if ($fieldCriteriaDeletedUserName["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Deleted user name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaDeletedUserName["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaDeletedUserName["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='deleted_user_name';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Deleted user name') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='deleted_user_name';
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
			if (isset($criteriaSystemMessage["url"])) {
				$fieldCriteriaUrl = $criteriaSystemMessage["url"];
				if ($fieldCriteriaUrl["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Url') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaUrl["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaUrl["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='url';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaUrl["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Url') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='url';
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
			if (isset($criteriaSystemMessage["stack_trace"])) {
				$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
				if ($fieldCriteriaStackTrace["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Stack trace') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaStackTrace["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaStackTrace["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='stack_trace';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
					$renderCriteria = "";
			$condition = $dataTypeCriteria["default"];
			if (!is_null($condition) && trim($condition) != "") { 
				$renderCriteria = $condition;
			}
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Stack trace') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='stack_trace';
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
			if (isset($criteriaSystemMessage["user"])) {
				$parentCriteria = $criteriaSystemMessage["user"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('User') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='user';
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
					<?php echo T('user') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='user';
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
			if (isset($criteriaSystemMessage["log_level"])) {
				$parentCriteria = $criteriaSystemMessage["log_level"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Log level') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='log_level';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php
			} else {
					if (isset($parentCriteria["ids"]) && is_array($parentCriteria["ids"])) {
				  		$parentIds = $parentCriteria["ids"];
						$parentLookups = array();
						foreach ($parentIds as $parentId) {
							$parentLookups[] = portal\virgoLogLevel::lookup($parentId);
						}
//	$tmpName =  $contextLogLevel->lookup($tmpId);
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Log level') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo implode(", ", $parentLookups) ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='log_level';
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
			if (isset($criteriaSystemMessage["execution"])) {
				$parentCriteria = $criteriaSystemMessage["execution"];
				if ($parentCriteria["is_null"] == 1) {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Execution') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo T('EMPTY_VALUE') ?>				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution';
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
					<?php echo T('execution') ?> <?php echo T('') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='execution';
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
	if (isset($resultSystemMessage)) {
		$tmpId = is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($systemMessageDisplayMode != "TABLE") {
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
			$pob = $resultSystemMessage->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultSystemMessage->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$systemMessageDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultSystemMessage->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($systemMessageDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_system_message") {
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
<?php echo T('SYSTEM_MESSAGE') ?>:</legend>
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
	if (class_exists('portal\virgoExecution') && ((P('show_form_execution', "1") == "1" || P('show_form_execution', "1") == "2" || P('show_form_execution', "1") == "3") && !isset($context["exc"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_execution_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_execution_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_form_execution_obligatory') == "1" ? " * " : "" ?>
<?php echo T('EXECUTION') ?> <?php echo T('') ?>
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
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
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
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
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
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["exc"])) {
		$parentValue = $context["exc"];
	} else {
		$parentValue = $resultSystemMessage->sms_exc_id;
	}
	
?>
				<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" name="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_form_timestamp', "1") == "1" || P('show_form_timestamp', "1") == "2") {
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
						class="fieldlabel  obligatory   timestamp datetime" 
						for="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>"
					>* <?php echo T('TIMESTAMP') ?>
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
	if (P('show_form_timestamp', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="timestamp" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_message', "1") == "1" || P('show_form_message', "1") == "2") {
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
						class="fieldlabel  obligatory   message varchar" 
						for="sms_message_<?php echo $resultSystemMessage->getId() ?>"
					>* <?php echo T('MESSAGE') ?>
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
	if (P('show_form_message', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="message" name="sms_message_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_details', "1") == "1" || P('show_form_details', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_details_obligatory', "0") == "1" ? " obligatory " : "" ?>   details text" 
						for="sms_details_<?php echo $resultSystemMessage->getId() ?>"
					> <?php echo P('show_form_details_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DETAILS') ?>
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
	if (P('show_form_details', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly details" 
	id="details" 
><?php echo htmlentities($resultSystemMessage->sms_details, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (P('show_form_ip', "1") == "1" || P('show_form_ip', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_ip_obligatory', "0") == "1" ? " obligatory " : "" ?>   ip varchar" 
						for="sms_ip_<?php echo $resultSystemMessage->getId() ?>"
					> <?php echo P('show_form_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
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
	if (P('show_form_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="sms_ip_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_deleted_user_name', "1") == "1" || P('show_form_deleted_user_name', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   deleted_user_name varchar" 
						for="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>"
					> <?php echo P('show_form_deleted_user_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DELETED_USER_NAME') ?>
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
	if (P('show_form_deleted_user_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="deletedUserName" name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_url', "1") == "1" || P('show_form_url', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   url varchar" 
						for="sms_url_<?php echo $resultSystemMessage->getId() ?>"
					> <?php echo P('show_form_url_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('URL') ?>
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
	if (P('show_form_url', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="url" name="sms_url_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_form_stack_trace', "1") == "1" || P('show_form_stack_trace', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_stack_trace_obligatory', "0") == "1" ? " obligatory " : "" ?>   stack_trace text" 
						for="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>"
					> <?php echo P('show_form_stack_trace_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STACK_TRACE') ?>
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
	if (P('show_form_stack_trace', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly stack_trace" 
	id="stackTrace" 
><?php echo htmlentities($resultSystemMessage->sms_stack_trace, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (class_exists('portal\virgoUser') && ((P('show_form_user', "1") == "1" || P('show_form_user', "1") == "2" || P('show_form_user', "1") == "3") && !isset($context["usr"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_form_user_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_user_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_form_user_obligatory') == "1" ? " * " : "" ?>
<?php echo T('USER') ?> <?php echo T('') ?>
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
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoUser");
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
$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["usr"])) {
		$parentValue = $context["usr"];
	} else {
		$parentValue = $resultSystemMessage->sms_usr_id;
	}
	
?>
				<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->sms_id ?>" name="sms_user_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoLogLevel') && ((P('show_form_log_level', "1") == "1" || P('show_form_log_level', "1") == "2" || P('show_form_log_level', "1") == "3") && !isset($context["llv"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="sms_logLevel_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
 *
<?php echo T('LOG_LEVEL') ?> <?php echo T('') ?>
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
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoLogLevel");
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
$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["llv"])) {
		$parentValue = $context["llv"];
	} else {
		$parentValue = $resultSystemMessage->sms_llv_id;
	}
	
?>
				<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" name="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
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
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultSystemMessage->getDateCreated()) {
		if ($resultSystemMessage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultSystemMessage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultSystemMessage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultSystemMessage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultSystemMessage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultSystemMessage->getDateModified()) {
		if ($resultSystemMessage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultSystemMessage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultSystemMessage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultSystemMessage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultSystemMessage->getDateModified() ?>"	>
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
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("SYSTEM_MESSAGE"), "\\'".rawurlencode($resultSystemMessage->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['sms_execution_<?php echo $resultSystemMessage->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($systemMessageDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_system_message") {
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
<?php echo T('SYSTEM_MESSAGE') ?>:</legend>
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
		if (isset($resultSystemMessage->sms_id)) {
			$resultSystemMessage->sms_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_user');
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
	$resultSystemMessage->setUsrId($defaultValue);
}
$defaultValue = P('create_default_value_log_level');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoLogLevel::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoLogLevel::token2Id($tmpToken);
	}
	$resultSystemMessage->setLlvId($defaultValue);
}
$defaultValue = P('create_default_value_execution');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoExecution::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoExecution::token2Id($tmpToken);
	}
	$resultSystemMessage->setExcId($defaultValue);
}
	}
?>
																																																														<?php
	if (class_exists('portal\virgoExecution') && ((P('show_create_execution', "1") == "1" || P('show_create_execution', "1") == "2" || P('show_create_execution', "1") == "3") && !isset($context["exc"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_execution_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_execution_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_create_execution_obligatory') == "1" ? " * " : "" ?>
<?php echo T('EXECUTION') ?> <?php echo T('') ?>
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
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_create_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
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
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
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
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["exc"])) {
		$parentValue = $context["exc"];
	} else {
		$parentValue = $resultSystemMessage->sms_exc_id;
	}
	
?>
				<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" name="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_create_timestamp', "1") == "1" || P('show_create_timestamp', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>">
* <?php echo T('TIMESTAMP') ?>
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
			if (P('event_column') == "timestamp") {
				$resultSystemMessage->setTimestamp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_timestamp', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="timestamp" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_message', "1") == "1" || P('show_create_message', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="sms_message_<?php echo $resultSystemMessage->getId() ?>">
* <?php echo T('MESSAGE') ?>
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
			if (P('event_column') == "message") {
				$resultSystemMessage->setMessage($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_message', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="message" name="sms_message_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_details', "1") == "1" || P('show_create_details', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_details_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_details_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_details_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DETAILS') ?>
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
			if (P('event_column') == "details") {
				$resultSystemMessage->setDetails($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_details', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly details" 
	id="details" 
><?php echo htmlentities($resultSystemMessage->sms_details, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (P('show_create_ip', "1") == "1" || P('show_create_ip', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_ip_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_ip_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
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
			if (P('event_column') == "ip") {
				$resultSystemMessage->setIp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="sms_ip_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_deleted_user_name', "1") == "1" || P('show_create_deleted_user_name', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_deleted_user_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DELETED_USER_NAME') ?>
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
			if (P('event_column') == "deleted_user_name") {
				$resultSystemMessage->setDeletedUserName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_deleted_user_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="deletedUserName" name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_url', "1") == "1" || P('show_create_url', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_url_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_url_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_url_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('URL') ?>
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
			if (P('event_column') == "url") {
				$resultSystemMessage->setUrl($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_url', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="url" name="sms_url_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_stack_trace', "1") == "1" || P('show_create_stack_trace', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_stack_trace_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_stack_trace_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STACK_TRACE') ?>
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
			if (P('event_column') == "stack_trace") {
				$resultSystemMessage->setStackTrace($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_stack_trace', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly stack_trace" 
	id="stackTrace" 
><?php echo htmlentities($resultSystemMessage->sms_stack_trace, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (class_exists('portal\virgoUser') && ((P('show_create_user', "1") == "1" || P('show_create_user', "1") == "2" || P('show_create_user', "1") == "3") && !isset($context["usr"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_user_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_user_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_create_user_obligatory') == "1" ? " * " : "" ?>
<?php echo T('USER') ?> <?php echo T('') ?>
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
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoUser");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_user', "1") == "2") {
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
	$showAjaxsms = P('show_create_user', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_user_obligatory') == "1" ? " obligatory " : "" ?> " 
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
$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["usr"])) {
		$parentValue = $context["usr"];
	} else {
		$parentValue = $resultSystemMessage->sms_usr_id;
	}
	
?>
				<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->sms_id ?>" name="sms_user_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoLogLevel') && ((P('show_create_log_level', "1") == "1" || P('show_create_log_level', "1") == "2" || P('show_create_log_level', "1") == "3") && !isset($context["llv"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="sms_logLevel_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
 *
<?php echo T('LOG_LEVEL') ?> <?php echo T('') ?>
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
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_log_level', "1") == "2") {
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
	$showAjaxsms = P('show_create_log_level', "1") == "3" || $parentCount > 100;
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
$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["llv"])) {
		$parentValue = $context["llv"];
	} else {
		$parentValue = $resultSystemMessage->sms_llv_id;
	}
	
?>
				<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" name="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>



<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultSystemMessage->sms_id)) {
			$resultSystemMessage->sms_id = null;
		}
		$parentAjaxRendered = "0";
?>
<?php
	$tmpAction = R('portlet_action');
	if ($tmpAction != "Store" && $tmpAction != "Apply" && $tmpAction != "StoreAndClear" && $tmpAction != "BackFromParent") {

$defaultValue = P('create_default_value_user');
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
	$resultSystemMessage->setUsrId($defaultValue);
}
$defaultValue = P('create_default_value_log_level');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoLogLevel::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoLogLevel::token2Id($tmpToken);
	}
	$resultSystemMessage->setLlvId($defaultValue);
}
$defaultValue = P('create_default_value_execution');
if (isset($defaultValue) && trim($defaultValue) != "") {
	if ($defaultValue == -1) {
		$loggedInUserId = virgoUser::getUserId();
		$parentCreatedByLoggedInUser = virgoExecution::getRecordCreatedBy($loggedInUserId);
		if (isset($parentCreatedByLoggedInUser) && !is_null($parentCreatedByLoggedInUser->getId())) {
			$defaultValue = $parentCreatedByLoggedInUser->getId();
		} else {
			$defaultValue = null;
		}
	} elseif ($defaultValue == -2) {
		$tmpToken = R('_t');
		$defaultValue = virgoExecution::token2Id($tmpToken);
	}
	$resultSystemMessage->setExcId($defaultValue);
}
	}
?>
																																																														<?php
	if (class_exists('portal\virgoExecution') && ((P('show_create_execution', "1") == "1" || P('show_create_execution', "1") == "2" || P('show_create_execution', "1") == "3") && !isset($context["exc"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_execution_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_execution_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_create_execution_obligatory') == "1" ? " * " : "" ?>
<?php echo T('EXECUTION') ?> <?php echo T('') ?>
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
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_create_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
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
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
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
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["exc"])) {
		$parentValue = $context["exc"];
	} else {
		$parentValue = $resultSystemMessage->sms_exc_id;
	}
	
?>
				<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" name="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (P('show_create_timestamp', "1") == "1" || P('show_create_timestamp', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>">
* <?php echo T('TIMESTAMP') ?>
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
			if (P('event_column') == "timestamp") {
				$resultSystemMessage->setTimestamp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_timestamp', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="timestamp" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_message', "1") == "1" || P('show_create_message', "1") == "2") {
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
					<label nowrap class="fieldlabel  obligatory " for="sms_message_<?php echo $resultSystemMessage->getId() ?>">
* <?php echo T('MESSAGE') ?>
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
			if (P('event_column') == "message") {
				$resultSystemMessage->setMessage($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_message', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="message" name="sms_message_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_details', "1") == "1" || P('show_create_details', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_details_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_details_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_details_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DETAILS') ?>
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
			if (P('event_column') == "details") {
				$resultSystemMessage->setDetails($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_details', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly details" 
	id="details" 
><?php echo htmlentities($resultSystemMessage->sms_details, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (P('show_create_ip', "1") == "1" || P('show_create_ip', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_ip_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_ip_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_ip_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('IP') ?>
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
			if (P('event_column') == "ip") {
				$resultSystemMessage->setIp($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_ip', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="sms_ip_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_deleted_user_name', "1") == "1" || P('show_create_deleted_user_name', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_deleted_user_name_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_deleted_user_name_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('DELETED_USER_NAME') ?>
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
			if (P('event_column') == "deleted_user_name") {
				$resultSystemMessage->setDeletedUserName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_deleted_user_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="deletedUserName" name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_url', "1") == "1" || P('show_create_url', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_url_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_url_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_url_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('URL') ?>
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
			if (P('event_column') == "url") {
				$resultSystemMessage->setUrl($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_url', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="url" name="sms_url_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
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
	if (P('show_create_stack_trace', "1") == "1" || P('show_create_stack_trace', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_stack_trace_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="sms_stackTrace_<?php echo $resultSystemMessage->getId() ?>">
 <?php echo P('show_create_stack_trace_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('STACK_TRACE') ?>
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
			if (P('event_column') == "stack_trace") {
				$resultSystemMessage->setStackTrace($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_stack_trace', "1") == "2") {
?>
<div 
	style="border: yellow 1 solid; display: inline-block;" 
	class="inputbox readonly stack_trace" 
	id="stackTrace" 
><?php echo htmlentities($resultSystemMessage->sms_stack_trace, ENT_QUOTES, "UTF-8") ?></div>

<?php
	} else {
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
	if (class_exists('portal\virgoUser') && ((P('show_create_user', "1") == "1" || P('show_create_user', "1") == "2" || P('show_create_user', "1") == "3") && !isset($context["usr"]))) {
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
					<label align="right" nowrap class="fieldlabel  <?php echo P('show_create_user_obligatory') == "1" ? " obligatory " : "" ?> " for="sms_user_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
<?php echo P('show_create_user_obligatory') == "1" ? " * " : "" ?>
<?php echo T('USER') ?> <?php echo T('') ?>
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
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoUser");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_user', "1") == "2") {
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
	$showAjaxsms = P('show_create_user', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_create_user_obligatory') == "1" ? " obligatory " : "" ?> " 
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
$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["usr"])) {
		$parentValue = $context["usr"];
	} else {
		$parentValue = $resultSystemMessage->sms_usr_id;
	}
	
?>
				<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->sms_id ?>" name="sms_user_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	}
?>
<?php
	if (class_exists('portal\virgoLogLevel') && ((P('show_create_log_level', "1") == "1" || P('show_create_log_level', "1") == "2" || P('show_create_log_level', "1") == "3") && !isset($context["llv"]))) {
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
					<label align="right" nowrap class="fieldlabel  obligatory " for="sms_logLevel_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>">
 *
<?php echo T('LOG_LEVEL') ?> <?php echo T('') ?>
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
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoLogLevel");
		$readOnly = "";
		if (isset($tmpId) || P('show_create_log_level', "1") == "2") {
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
	$showAjaxsms = P('show_create_log_level', "1") == "3" || $parentCount > 100;
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
$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["llv"])) {
		$parentValue = $context["llv"];
	} else {
		$parentValue = $resultSystemMessage->sms_llv_id;
	}
	
?>
				<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" name="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
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
				</table>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultSystemMessage->getDateCreated()) {
		if ($resultSystemMessage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultSystemMessage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultSystemMessage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultSystemMessage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultSystemMessage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultSystemMessage->getDateModified()) {
		if ($resultSystemMessage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultSystemMessage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultSystemMessage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultSystemMessage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultSystemMessage->getDateModified() ?>"	>
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
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['sms_execution_<?php echo $resultSystemMessage->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($systemMessageDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('SYSTEM_MESSAGE') ?>:</legend>
				<ul>
<?php
	$criteriaSystemMessage = $resultSystemMessage->getCriteria();
?>
<?php
	if (P('show_search_timestamp', "1") == "1") {

		if (isset($criteriaSystemMessage["timestamp"])) {
			$fieldCriteriaTimestamp = $criteriaSystemMessage["timestamp"];
			$dataTypeCriteria = $fieldCriteriaTimestamp["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('TIMESTAMP') ?>
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
							id="virgo_search_timestamp_from" 
							name="virgo_search_timestamp_from" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_timestamp_from").datepicker({dateFormat: "yy-mm-dd"});
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
							id="virgo_search_timestamp_to" 
							name="virgo_search_timestamp_to" 
							size="20" 
							value="<?php echo $tmp_date ?>" 
						>
<script type="text/javascript">
$(function(){ 
  $("#virgo_search_timestamp_to").datepicker({dateFormat: "yy-mm-dd"});
});
</script>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_timestamp_is_null" 
				name="virgo_search_timestamp_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaTimestamp) && $fieldCriteriaTimestamp["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaTimestamp) && $fieldCriteriaTimestamp["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaTimestamp) && $fieldCriteriaTimestamp["is_null"] == 2) {
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
	if (P('show_search_message', "1") == "1") {

		if (isset($criteriaSystemMessage["message"])) {
			$fieldCriteriaMessage = $criteriaSystemMessage["message"];
			$dataTypeCriteria = $fieldCriteriaMessage["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('MESSAGE') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_message" 
							name="virgo_search_message"
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
				id="virgo_search_message_is_null" 
				name="virgo_search_message_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaMessage) && $fieldCriteriaMessage["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaMessage) && $fieldCriteriaMessage["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaMessage) && $fieldCriteriaMessage["is_null"] == 2) {
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
	if (P('show_search_details', "1") == "1") {

		if (isset($criteriaSystemMessage["details"])) {
			$fieldCriteriaDetails = $criteriaSystemMessage["details"];
			$dataTypeCriteria = $fieldCriteriaDetails["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('DETAILS') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_details" 
							name="virgo_search_details"
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
				id="virgo_search_details_is_null" 
				name="virgo_search_details_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaDetails) && $fieldCriteriaDetails["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaDetails) && $fieldCriteriaDetails["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaDetails) && $fieldCriteriaDetails["is_null"] == 2) {
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
	if (P('show_search_ip', "1") == "1") {

		if (isset($criteriaSystemMessage["ip"])) {
			$fieldCriteriaIp = $criteriaSystemMessage["ip"];
			$dataTypeCriteria = $fieldCriteriaIp["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('IP') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_ip" 
							name="virgo_search_ip"
							style="border: yellow 1 solid;" 
							maxlength="15"
							size="15" 
							value="<?php echo isset($dataTypeCriteria["default"]) ? htmlentities($dataTypeCriteria["default"], ENT_QUOTES, "UTF-8") : "" ?>" 
						>

		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_ip_is_null" 
				name="virgo_search_ip_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaIp) && $fieldCriteriaIp["is_null"] == 2) {
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
	if (P('show_search_deleted_user_name', "1") == "1") {

		if (isset($criteriaSystemMessage["deleted_user_name"])) {
			$fieldCriteriaDeletedUserName = $criteriaSystemMessage["deleted_user_name"];
			$dataTypeCriteria = $fieldCriteriaDeletedUserName["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('DELETED_USER_NAME') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_deletedUserName" 
							name="virgo_search_deletedUserName"
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
				id="virgo_search_deletedUserName_is_null" 
				name="virgo_search_deletedUserName_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaDeletedUserName) && $fieldCriteriaDeletedUserName["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaDeletedUserName) && $fieldCriteriaDeletedUserName["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaDeletedUserName) && $fieldCriteriaDeletedUserName["is_null"] == 2) {
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
	if (P('show_search_url', "1") == "1") {

		if (isset($criteriaSystemMessage["url"])) {
			$fieldCriteriaUrl = $criteriaSystemMessage["url"];
			$dataTypeCriteria = $fieldCriteriaUrl["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('URL') ?>
		</label>
		<span align="left" nowrap>
						<input 
							class="inputbox" 
							type="text"
							id="virgo_search_url" 
							name="virgo_search_url"
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
				id="virgo_search_url_is_null" 
				name="virgo_search_url_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaUrl) && $fieldCriteriaUrl["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaUrl) && $fieldCriteriaUrl["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaUrl) && $fieldCriteriaUrl["is_null"] == 2) {
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
	if (P('show_search_stack_trace', "1") == "1") {

		if (isset($criteriaSystemMessage["stack_trace"])) {
			$fieldCriteriaStackTrace = $criteriaSystemMessage["stack_trace"];
			$dataTypeCriteria = $fieldCriteriaStackTrace["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('STACK_TRACE') ?>
		</label>
		<span align="left" nowrap>
						<input 
							type="text"
							class="inputbox" 
							id="virgo_search_stackTrace" 
							name="virgo_search_stackTrace"
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
				id="virgo_search_stackTrace_is_null" 
				name="virgo_search_stackTrace_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaStackTrace) && $fieldCriteriaStackTrace["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaStackTrace) && $fieldCriteriaStackTrace["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaStackTrace) && $fieldCriteriaStackTrace["is_null"] == 2) {
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
	if (P('show_search_user', '1') == "1") {
		if (isset($criteriaSystemMessage["user"])) {
			$fieldCriteriaUser = $criteriaSystemMessage["user"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('USER') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaUser["value"]) ? $fieldCriteriaUser["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_user" name="virgo_search_user" value="<?php echo $value ?>">
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
		if (isset($fieldCriteriaUser) && $fieldCriteriaUser["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaUser) && $fieldCriteriaUser["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaUser) && $fieldCriteriaUser["is_null"] == 2) {
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
	if (P('show_search_log_level', '1') == "1") {
		if (isset($criteriaSystemMessage["log_level"])) {
			$fieldCriteriaLogLevel = $criteriaSystemMessage["log_level"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('LOG_LEVEL') ?> <?php echo T('') ?></label>
<?php
	$ids = (isset($fieldCriteriaLogLevel["ids"]) ? $fieldCriteriaLogLevel["ids"] : array());
	$resultsLogLevel = portal\virgoLogLevel::getVirgoList();
	$maxListboxSize = 10;
?>
    <select class="inputbox " id="virgo_search_logLevel[]" name="virgo_search_logLevel[]" multiple
<?php
	if (sizeof($resultsLogLevel) > $maxListboxSize) {
		echo "size=" . $maxListboxSize;
	}
?>	
    >
<?php
	while(list($id, $label)=each($resultsLogLevel)) {
?>	
<option value="<?php echo $id ?>" 
<?php 
	echo (is_array($ids) && in_array($id, $ids) ? "selected='selected'" : "");
?>><?php echo $label ?>
</option>
<?php
	}
?>
    </select>
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
		if (isset($fieldCriteriaLogLevel) && $fieldCriteriaLogLevel["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaLogLevel) && $fieldCriteriaLogLevel["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaLogLevel) && $fieldCriteriaLogLevel["is_null"] == 2) {
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
	if (P('show_search_execution', '1') == "1") {
		if (isset($criteriaSystemMessage["execution"])) {
			$fieldCriteriaExecution = $criteriaSystemMessage["execution"];
		}
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
	
				<label align="right" nowrap class="fieldlabel"
					<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>				
				><?php echo T('EXECUTION') ?> <?php echo T('') ?></label>
<?php
	$value = isset($fieldCriteriaExecution["value"]) ? $fieldCriteriaExecution["value"] : null;
?>
    <input type="text" class="inputbox " id="virgo_search_execution" name="virgo_search_execution" value="<?php echo $value ?>">
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
		if (isset($fieldCriteriaExecution) && $fieldCriteriaExecution["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaExecution) && $fieldCriteriaExecution["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaExecution) && $fieldCriteriaExecution["is_null"] == 2) {
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
	unset($criteriaSystemMessage);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	} elseif ($systemMessageDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('SYSTEM_MESSAGE') ?>:</legend>
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
	if (class_exists('portal\virgoExecution') && P('show_view_execution', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "execution" || is_null($contextId))) {
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
					<span align="right" nowrap class="fieldlabel">Execution </span>
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
			if (!is_null($context) && isset($context['exc_id'])) {
				$tmpId = $context['exc_id'];
			}
			$readOnly = "";
			if ($resultSystemMessage->getId() == 0) {
// przesuac do createforgui				$resultSystemMessage->sms_exc__id = $tmpId;
			}
			$parentId = $resultSystemMessage->getExecutionId();
			$parentValue = portal\virgoExecution::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="sms_execution_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 
						name="sms_execution_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 						
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
	if (P('show_view_timestamp', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="timestamp"
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
<?php echo T('TIMESTAMP') ?>
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
							<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="timestamp" name="sms_timestamp_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getTimestamp(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_message', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="message"
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
<?php echo T('MESSAGE') ?>
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
							<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="message" name="sms_message_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getMessage(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_details', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="details"
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
<?php echo T('DETAILS') ?>
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
	class="inputbox readonly details" 
	id="details" 
><?php echo htmlentities($resultSystemMessage->sms_details, ENT_QUOTES, "UTF-8") ?></div>

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
	if (P('show_view_ip', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="ip"
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
<?php echo T('IP') ?>
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
							<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="ip" name="sms_ip_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getIp(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_deleted_user_name', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="deleted_user_name"
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
<?php echo T('DELETED_USER_NAME') ?>
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
							<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="deletedUserName" name="sms_deletedUserName_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getDeletedUserName(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_url', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="url"
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
<?php echo T('URL') ?>
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
							<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="url" name="sms_url_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo htmlentities($resultSystemMessage->getUrl(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_stack_trace', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="stack_trace"
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
<?php echo T('STACK_TRACE') ?>
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
	class="inputbox readonly stack_trace" 
	id="stackTrace" 
><?php echo htmlentities($resultSystemMessage->sms_stack_trace, ENT_QUOTES, "UTF-8") ?></div>

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
	if (class_exists('portal\virgoUser') && P('show_view_user', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "user" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="user"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">User </span>
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
			if (!is_null($context) && isset($context['usr_id'])) {
				$tmpId = $context['usr_id'];
			}
			$readOnly = "";
			if ($resultSystemMessage->getId() == 0) {
// przesuac do createforgui				$resultSystemMessage->sms_usr__id = $tmpId;
			}
			$parentId = $resultSystemMessage->getUserId();
			$parentValue = portal\virgoUser::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="sms_user_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 
						name="sms_user_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 						
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
	if (class_exists('portal\virgoLogLevel') && P('show_view_log_level', '1') == "1") { // && (isset($masterComponentName) && $masterComponentName != "log_level" || is_null($contextId))) {
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="log_level"
<?php echo $floatingFields ? "style='display: inline-block; float: left;'" : '' ?>
	>
<?php
	} else {
?>
	<tr><td align="right">
<?php
	}
?>
					<span align="right" nowrap class="fieldlabel">Log level </span>
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
			if (!is_null($context) && isset($context['llv_id'])) {
				$tmpId = $context['llv_id'];
			}
			$readOnly = "";
			if ($resultSystemMessage->getId() == 0) {
// przesuac do createforgui				$resultSystemMessage->sms_llv__id = $tmpId;
			}
			$parentId = $resultSystemMessage->getLogLevelId();
			$parentValue = portal\virgoLogLevel::lookup($parentId);
				
?>
					<input
						type="hidden"
						id="sms_logLevel_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 
						name="sms_logLevel_<?php echo isset($resultSystemMessage->sms_id) ? $resultSystemMessage->sms_id : '' ?>" 						
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
<?php echo T('SYSTEM_MESSAGE') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultSystemMessage->getDateCreated()) {
		if ($resultSystemMessage->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultSystemMessage->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultSystemMessage->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultSystemMessage->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultSystemMessage->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultSystemMessage->getDateModified()) {
		if ($resultSystemMessage->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultSystemMessage->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultSystemMessage->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultSystemMessage->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultSystemMessage->getDateModified() ?>"	>
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
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("SYSTEM_MESSAGE"), "\\'".$resultSystemMessage->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	} elseif ($systemMessageDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "sms_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultSystemMessage->setShowPage(1); 
	$resultSystemMessage->setShowRows('all'); 	
	$resultsSystemMessage = $resultSystemMessage->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsSystemMessage as $resultSystemMessage) {
		if (isset($resultSystemMessage[$eventColumn]) && isset($events[substr($resultSystemMessage[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultSystemMessage[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoSystemMessage($resultSystemMessage['sms_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultSystemMessage[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='sms_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultSystemMessage) {
?>
<?php
PROFILE('token');
	if (isset($resultSystemMessage)) {
		$tmpId = is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId();
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultSystemMessage->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.sms_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var systemMessageChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == systemMessageChildrenDivOpen) {
					div.style.display = 'none';
					systemMessageChildrenDivOpen = '';
				} else {
					if (systemMessageChildrenDivOpen != '') {
						document.getElementById(systemMessageChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					systemMessageChildrenDivOpen = clickedDivId;
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
			$showPage = $resultSystemMessage->getShowPage(); 
			$showRows = $resultSystemMessage->getShowRows(); 
?>
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('System messages') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultSystemMessage->getOrderColumn();
			$virgoOrderMode = $resultSystemMessage->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsSystemMessage = $resultSystemMessage->getTableData($resultCount, $filterApplied);
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoExecution'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_execution', "1") != "0"  && !isset($parentsInContext['portal\\virgoExecution'])  ) {
	if (P('show_table_execution', "1") == "2") {
		$tmpLookupExecution = virgoExecution::getVirgoListStatic();
?>
<input name='sms_Execution_id_<?php echo $this->getId() ?>' id='sms_Execution_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'execution');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('EXECUTION') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "execution" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoExecution::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoExecution::getVirgoListStatic();
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterExecution', null);
?>
						<select 
							name="virgo_filter_execution"
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
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterTitleExecution', null);
?>
						<input
							name="virgo_filter_title_execution"
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
	if (P('show_table_timestamp', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_timestamp');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('TIMESTAMP') ?>							<?php echo ($oc == "sms_timestamp" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterTimestamp', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_message', "1") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_message');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('MESSAGE') ?>							<?php echo ($oc == "sms_message" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterMessage', null);
?>
						<input
							name="virgo_filter_message"
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
	if (P('show_table_details', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_details');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('DETAILS') ?>							<?php echo ($oc == "sms_details" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterDetails', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_ip', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_ip');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('IP') ?>							<?php echo ($oc == "sms_ip" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterIp', null);
?>
						<input
							name="virgo_filter_ip"
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
	if (P('show_table_deleted_user_name', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_deleted_user_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('DELETED_USER_NAME') ?>							<?php echo ($oc == "sms_deleted_user_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterDeletedUserName', null);
?>
						<input
							name="virgo_filter_deleted_user_name"
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
	if (P('show_table_url', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_url');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('URL') ?>							<?php echo ($oc == "sms_url" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterUrl', null);
?>
						<input
							name="virgo_filter_url"
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
	if (P('show_table_stack_trace', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'sms_stack_trace');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('STACK_TRACE') ?>							<?php echo ($oc == "sms_stack_trace" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterStackTrace', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoUser'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_user', "1") != "0"  && !isset($parentsInContext['portal\\virgoUser'])  ) {
	if (P('show_table_user', "1") == "2") {
		$tmpLookupUser = virgoUser::getVirgoListStatic();
?>
<input name='sms_User_id_<?php echo $this->getId() ?>' id='sms_User_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'user');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('USER') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "user" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoUser::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoUser::getVirgoListStatic();
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterUser', null);
?>
						<select 
							name="virgo_filter_user"
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
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterTitleUser', null);
?>
						<input
							name="virgo_filter_title_user"
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
if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoLogLevel'.DIRECTORY_SEPARATOR.'controller.php') && P('show_table_log_level', "1") != "0"  && !isset($parentsInContext['portal\\virgoLogLevel'])  ) {
	if (P('show_table_log_level', "1") == "2") {
		$tmpLookupLogLevel = virgoLogLevel::getVirgoListStatic();
?>
<input name='sms_LogLevel_id_<?php echo $this->getId() ?>' id='sms_LogLevel_id_<?php echo $this->getId() ?>' type="hidden"/>
<?php		
	}
?>
				<th align="center" valign="middle" rowspan=" 2"><!-- bylo: nowrap -->
<?php
	$oc = $resultSystemMessage->getOrderColumn(); 
	$om = $resultSystemMessage->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder';
	_pSF(form, 'virgo_order_column', 'log_level');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('LOG_LEVEL') ?>&nbsp;
<?php echo T('') ?>							<?php echo ($oc == "log_level" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$parentsCount = virgoLogLevel::getVirgoListStatic('', true);
		if ($parentsCount < 51) {
			$parents = virgoLogLevel::getVirgoListStatic();
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterLogLevel', null);
?>
						<select 
							name="virgo_filter_log_level"
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
			$parentFilter = virgoSystemMessage::getLocalSessionValue('VirgoFilterTitleLogLevel', null);
?>
						<input
							name="virgo_filter_title_log_level"
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
				<th rowspan="2"></th>
			</tr>
			<tr class="data_table_header">
																																								
			</tr>

<?php
			}
			if ($resultCount != 0) {
				if (((int)$showRows) * (((int)$showPage)-1) == $resultCount ) {
					$showPage = ((int)$showPage)-1;
					$resultSystemMessage->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsSystemMessage as $resultSystemMessage) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoSystemMessage/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultSystemMessage['sms_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoSystemMessage::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoSystemMessage::setContextId($resultSystemMessage['sms_id'], false);
						$tmpContextId = $resultSystemMessage['sms_id'];
					}
				}
				if (isset($tmpContextId) && $resultSystemMessage['sms_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : "" ?>" 
				class="<?php echo (P('form_only') == "4" ? "data_table_chessboard" : ($index % 2 == 0 ? "data_table_even" : "data_table_odd")) ?> <?php echo $contextClass ?>
 <? echo $displayClass ?> 
<?php
				if (class_exists('portal\virgoLogLevel') && P('show_view_log_level', "1") == "1") {
?>
 log_level_<?php echo isset($resultSystemMessage['sms_llv_id']) ? $resultSystemMessage['sms_llv_id'] : "" ?>
<?php
				}
?>
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultSystemMessage['sms_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultSystemMessage['sms_id'] ?>">
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
	if (class_exists('portal\virgoExecution') && P('show_table_execution', "1") != "0"  && !isset($parentsInContext["portal\\virgoExecution"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_execution', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="execution">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_execution', "1") == "1") {
		if (isset($resultSystemMessage['execution'])) {
			echo $resultSystemMessage['execution'];
		}
	} else {
//		echo $resultSystemMessage['sms_exc_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetExecution';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_Execution_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupExecution as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_exc_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
PROFILE('timestamp');
	if (P('show_table_timestamp', "1") == "1") {
PROFILE('render_data_table_timestamp');
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
			<li class="timestamp">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_timestamp'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_timestamp');
	}
PROFILE('timestamp');
?>
<?php
PROFILE('message');
	if (P('show_table_message', "1") == "1") {
PROFILE('render_data_table_message');
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
			<li class="message">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_message'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_message');
	}
PROFILE('message');
?>
<?php
PROFILE('details');
	if (P('show_table_details', "0") == "1") {
PROFILE('render_data_table_details');
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
			<li class="details">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
			$len = strlen($resultSystemMessage['sms_details']);
			$shortTextSize = P('short_text_size_details', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultSystemMessage['sms_details'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultSystemMessage['sms_details'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultSystemMessage['sms_details'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_details');
	}
PROFILE('details');
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") {
PROFILE('render_data_table_ip');
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
			<li class="ip">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_ip'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_ip');
	}
PROFILE('ip');
?>
<?php
PROFILE('deleted user name');
	if (P('show_table_deleted_user_name', "0") == "1") {
PROFILE('render_data_table_deleted_user_name');
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
			<li class="deleted_user_name">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_deleted_user_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_deleted_user_name');
	}
PROFILE('deleted user name');
?>
<?php
PROFILE('url');
	if (P('show_table_url', "0") == "1") {
PROFILE('render_data_table_url');
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
			<li class="url">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_url'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_url');
	}
PROFILE('url');
?>
<?php
PROFILE('stack trace');
	if (P('show_table_stack_trace', "0") == "1") {
PROFILE('render_data_table_stack_trace');
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
			<li class="stack_trace">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
			$len = strlen($resultSystemMessage['sms_stack_trace']);
			$shortTextSize = P('short_text_size_stack_trace', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultSystemMessage['sms_stack_trace'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultSystemMessage['sms_stack_trace'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultSystemMessage['sms_stack_trace'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_stack_trace');
	}
PROFILE('stack trace');
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_table_user', "1") != "0"  && !isset($parentsInContext["portal\\virgoUser"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_user', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="user">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_user', "1") == "1") {
		if (isset($resultSystemMessage['user'])) {
			echo $resultSystemMessage['user'];
		}
	} else {
//		echo $resultSystemMessage['sms_usr_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetUser';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_User_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupUser as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_usr_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoLogLevel') && P('show_table_log_level', "1") != "0"  && !isset($parentsInContext["portal\\virgoLogLevel"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_log_level', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="log_level">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_log_level', "1") == "1") {
		if (isset($resultSystemMessage['log_level'])) {
			echo $resultSystemMessage['log_level'];
		}
	} else {
//		echo $resultSystemMessage['sms_llv_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetLogLevel';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_LogLevel_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupLogLevel as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_llv_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (isset($resultSystemMessage)) {
		$tmpId = is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId();
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("SYSTEM_MESSAGE"), "\\'".rawurlencode($resultSystemMessage['sms_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultSystemMessage['sms_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultSystemMessage['sms_id'] ?>">
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
	if (class_exists('portal\virgoExecution') && P('show_table_execution', "1") != "0"  && !isset($parentsInContext["portal\\virgoExecution"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_execution', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="execution">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_execution', "1") == "1") {
		if (isset($resultSystemMessage['execution'])) {
			echo $resultSystemMessage['execution'];
		}
	} else {
//		echo $resultSystemMessage['sms_exc_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetExecution';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_Execution_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupExecution as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_exc_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
PROFILE('timestamp');
	if (P('show_table_timestamp', "1") == "1") {
PROFILE('render_data_table_timestamp');
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
			<li class="timestamp">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_timestamp'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_timestamp');
	}
PROFILE('timestamp');
?>
<?php
PROFILE('message');
	if (P('show_table_message', "1") == "1") {
PROFILE('render_data_table_message');
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
			<li class="message">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_message'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_message');
	}
PROFILE('message');
?>
<?php
PROFILE('details');
	if (P('show_table_details', "0") == "1") {
PROFILE('render_data_table_details');
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
			<li class="details">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
			$len = strlen($resultSystemMessage['sms_details']);
			$shortTextSize = P('short_text_size_details', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultSystemMessage['sms_details'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultSystemMessage['sms_details'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultSystemMessage['sms_details'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_details');
	}
PROFILE('details');
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") {
PROFILE('render_data_table_ip');
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
			<li class="ip">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_ip'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_ip');
	}
PROFILE('ip');
?>
<?php
PROFILE('deleted user name');
	if (P('show_table_deleted_user_name', "0") == "1") {
PROFILE('render_data_table_deleted_user_name');
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
			<li class="deleted_user_name">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_deleted_user_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_deleted_user_name');
	}
PROFILE('deleted user name');
?>
<?php
PROFILE('url');
	if (P('show_table_url', "0") == "1") {
PROFILE('render_data_table_url');
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
			<li class="url">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultSystemMessage['sms_url'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('render_data_table_url');
	}
PROFILE('url');
?>
<?php
PROFILE('stack trace');
	if (P('show_table_stack_trace', "0") == "1") {
PROFILE('render_data_table_stack_trace');
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
			<li class="stack_trace">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
			$len = strlen($resultSystemMessage['sms_stack_trace']);
			$shortTextSize = P('short_text_size_stack_trace', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultSystemMessage['sms_stack_trace'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultSystemMessage['sms_stack_trace'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultSystemMessage['sms_stack_trace'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_stack_trace');
	}
PROFILE('stack trace');
?>
<?php
	if (class_exists('portal\virgoUser') && P('show_table_user', "1") != "0"  && !isset($parentsInContext["portal\\virgoUser"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_user', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="user">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_user', "1") == "1") {
		if (isset($resultSystemMessage['user'])) {
			echo $resultSystemMessage['user'];
		}
	} else {
//		echo $resultSystemMessage['sms_usr_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetUser';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_User_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupUser as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_usr_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (class_exists('portal\virgoLogLevel') && P('show_table_log_level', "1") != "0"  && !isset($parentsInContext["portal\\virgoLogLevel"])  ) {
?>
<?php
			if (P('form_only') != "4") {
?>
				<td 
					align="left" 
					class="<?php echo ($index % 2 == 0 ? 'data_table_even' : 'data_table_odd') ?> <?php echo P('show_table_log_level', "1") == "1" ? " selectable " : " " ?> "
				>    
<?php
			} else {
?>
				<li class="log_level">
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
					form.sms_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultSystemMessage['sms_id']) ? $resultSystemMessage['sms_id'] : '' ?>'; 
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
	if (P('show_table_log_level', "1") == "1") {
		if (isset($resultSystemMessage['log_level'])) {
			echo $resultSystemMessage['log_level'];
		}
	} else {
//		echo $resultSystemMessage['sms_llv_id'];
?>
		<select class="inline" onchange="
this.form.portlet_action.value='VirgoSetLogLevel';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo $resultSystemMessage['sms_id'] ?>');
	_pSF(form, 'sms_LogLevel_id_<?php echo $this->getId() ?>', this.options[this.selectedIndex].value);
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
		foreach ($tmpLookupLogLevel as $value => $label) {
?>
			<option value="<?php echo $value ?>" <?php echo $value == $resultSystemMessage['sms_llv_id'] ? " selected " : "" ?>><?php echo $label ?></option>
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
	if (isset($resultSystemMessage)) {
		$tmpId = is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId();
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("SYSTEM_MESSAGE"), "\\'".rawurlencode($resultSystemMessage['sms_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
			virgoSystemMessage::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultSystemMessage);
				unset($resultsSystemMessage);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpSystemMessage = new virgoSystemMessage();
						$tmpCount = $tmpSystemMessage->getAllRecordCount(' sms_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoSystemMessage::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&sms_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.sms_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.sms_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'sms_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'sms_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'sms_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'sms_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'sms_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'sms_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	$buttonRendered = false;
	if ($this->canExecute('Statistics')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_statistics inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Statistics';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('Statistics') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('ClearLog')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_clearlog inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('CAŁY log zostanie wyczyszczony!'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='ClearLog';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('Clear') ?>"
						/><div class="button_right"></div></div><?php
	}
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
					$sessionSeparator = virgoSystemMessage::getImportFieldSeparator();
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
						$sessionSeparator = virgoSystemMessage::getImportFieldSeparator();
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('SYSTEM_MESSAGES'), "") ?>'))) return false;
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	} elseif ($systemMessageDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_system_message") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var systemMessageChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == systemMessageChildrenDivOpen) {
					div.style.display = 'none';
					systemMessageChildrenDivOpen = '';
				} else {
					if (systemMessageChildrenDivOpen != '') {
						document.getElementById(systemMessageChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					systemMessageChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_system_message" name="virgo_form_system_message" enctype="multipart/form-data">
						<input type="text" name="sms_id_<?php echo $this->getId() ?>" id="sms_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

		<table class="data_table" cellpadding="0" cellspacing="0">
			<tr class="data_table_header">
<?php
//		$acl = &JFactory::getACL();
//		$dataChangeRole = virgoSystemParameter::getValueByName("DATA_CHANGE_ROLE", "Author");
?>
<?php
	if (P('show_table_timestamp', "1") == "1") {
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
	if (P('show_table_message', "1") == "1") {
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
	if (P('show_table_details', "0") == "1") {
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
	if (P('show_table_ip', "0") == "1") {
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
	if (P('show_table_deleted_user_name', "0") == "1") {
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
	if (P('show_table_url', "0") == "1") {
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
	if (P('show_table_stack_trace', "0") == "1") {
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
	if (P('show_table_user', "1") == "1" /* && ($masterComponentName != "user" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>User </td>
<?php
	}
?>
<?php
	if (P('show_table_log_level', "1") == "1" /* && ($masterComponentName != "log_level" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Log level </td>
<?php
	}
?>
<?php
	if (P('show_table_execution', "1") == "1" /* && ($masterComponentName != "execution" || is_null($contextId)) */) {
?>
				<td align="center" nowrap>Execution </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsSystemMessage = $resultSystemMessage->getRecordsToEdit();
				$idsToCorrect = $resultSystemMessage->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsSystemMessage as $resultSystemMessage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultSystemMessage->sms_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultSystemMessage->sms_id == 0 && R('virgo_validate_new', "N") == "N") {
?>
		style="display: none;"
<?php
	}
?>
			>
<?php
PROFILE('timestamp');
	if (P('show_table_timestamp', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 0;
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
PROFILE('timestamp');
	} else {
?> 
						<input
							type="hidden"
							id="timestamp_<?php echo $resultSystemMessage->sms_id ?>" 
							name="timestamp_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_timestamp, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('message');
	if (P('show_table_message', "1") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 1;
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
PROFILE('message');
	} else {
?> 
						<input
							type="hidden"
							id="message_<?php echo $resultSystemMessage->sms_id ?>" 
							name="message_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_message, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('details');
	if (P('show_table_details', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 2;
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
PROFILE('details');
	} else {
?> 
						<input
							type="hidden"
							id="details_<?php echo $resultSystemMessage->sms_id ?>" 
							name="details_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_details, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('ip');
	if (P('show_table_ip', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 3;
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
PROFILE('ip');
	} else {
?> 
						<input
							type="hidden"
							id="ip_<?php echo $resultSystemMessage->sms_id ?>" 
							name="ip_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_ip, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('deleted user name');
	if (P('show_table_deleted_user_name', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 4;
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
PROFILE('deleted user name');
	} else {
?> 
						<input
							type="hidden"
							id="deletedUserName_<?php echo $resultSystemMessage->sms_id ?>" 
							name="deletedUserName_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_deleted_user_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('url');
	if (P('show_table_url', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 5;
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
PROFILE('url');
	} else {
?> 
						<input
							type="hidden"
							id="url_<?php echo $resultSystemMessage->sms_id ?>" 
							name="url_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('stack trace');
	if (P('show_table_stack_trace', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 6;
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
PROFILE('stack trace');
	} else {
?> 
						<input
							type="hidden"
							id="stackTrace_<?php echo $resultSystemMessage->sms_id ?>" 
							name="stackTrace_<?php echo $resultSystemMessage->sms_id ?>"
							value="<?php echo htmlentities($resultSystemMessage->sms_stack_trace, ENT_QUOTES, "UTF-8") ?>"
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
	if (P('show_table_user', "1") == "1"/* && ($masterComponentName != "user" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 7;
?>
<?php
//		$limit_user = $componentParams->get('limit_to_user');
		$limit_user = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoUser");
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
$('#sms_user_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["usr"])) {
		$parentValue = $context["usr"];
	} else {
		$parentValue = $resultSystemMessage->sms_usr_id;
	}
	
?>
				<input type="hidden" id="sms_user_<?php echo $resultSystemMessage->sms_id ?>" name="sms_user_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_log_level', "1") == "1"/* && ($masterComponentName != "log_level" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 8;
?>
<?php
//		$limit_log_level = $componentParams->get('limit_to_log_level');
		$limit_log_level = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoLogLevel");
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
$('#sms_log_level_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["llv"])) {
		$parentValue = $context["llv"];
	} else {
		$parentValue = $resultSystemMessage->sms_llv_id;
	}
	
?>
				<input type="hidden" id="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" name="sms_logLevel_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
<?php
	if (P('show_table_execution', "1") == "1"/* && ($masterComponentName != "execution" || is_null($contextId)) */) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsSystemMessage) * 9;
?>
<?php
//		$limit_execution = $componentParams->get('limit_to_execution');
		$limit_execution = null;
		$tmpId = portal\virgoSystemMessage::getParentInContext("portal\\virgoExecution");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_execution', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultSystemMessage->sms_exc__id = $tmpId;
//			}
			if (!is_null($resultSystemMessage->getExcId())) {
				$parentId = $resultSystemMessage->getExcId();
				$parentValue = portal\virgoExecution::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_SYSTEM_MESSAGE_EXECUTION');
?>
<?php
	$whereList = "";
	if (!is_null($limit_execution) && trim($limit_execution) != "") {
		$whereList = $whereList . " exc_id ";
		if (trim($limit_execution) == "page_title") {
			$limit_execution = "SELECT exc_id FROM prt_executions WHERE exc_" . $limit_execution . " = '" . $mainframe->getPageTitle() . "'";
		}
		eval("\$limit_execution = \"$limit_execution\";");
		$whereList = $whereList . " IN (" . $limit_execution . ") ";
	}						
	$parentCount = portal\virgoExecution::getVirgoListSize($whereList);
	$showAjaxsms = P('show_form_execution', "1") == "3" || $parentCount > 100;
	if (!$showAjaxsms) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_execution_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
							name="sms_execution_<?php echo !is_null($resultSystemMessage->getId()) ? $resultSystemMessage->getId() : '' ?>" 
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
			if (is_null($limit_execution) || trim($limit_execution) == "") {
?>
    							<option value=""></option>
<?php
			}
?>
<?php
			$resultsExecution = portal\virgoExecution::getVirgoList($whereList);
			while(list($id, $label)=each($resultsExecution)) {
?>	
							<option value="<?php echo $id ?>" 
<?php 
				echo (!is_null($resultSystemMessage->getExcId()) && $id == $resultSystemMessage->getExcId() ? "selected='selected'" : "");
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
				$parentId = $resultSystemMessage->getExcId();
				$parentExecution = new portal\virgoExecution();
				$parentValue = $parentExecution->lookup($parentId);
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
	<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->getId() ?>" name="sms_execution_<?php echo $resultSystemMessage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" 
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
        $( "#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>" ).autocomplete({
            delay: 0,
            source: function( request, response ) {
                $.ajax({
                    url: "?",
                    dataType: "json",
                    data: {
			virgo_matching_labels_entity: "Execution",
			virgo_field_name: "execution",
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
					$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.value);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				  	$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#sms_execution_<?php echo $resultSystemMessage->getId() ?>').val('');
				$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').removeClass("locked");		
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
$('#sms_execution_dropdown_<?php echo $resultSystemMessage->getId() ?>').qtip({position: {
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
	if (isset($context["exc"])) {
		$parentValue = $context["exc"];
	} else {
		$parentValue = $resultSystemMessage->sms_exc_id;
	}
	
?>
				<input type="hidden" id="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" name="sms_execution_<?php echo $resultSystemMessage->sms_id ?>" value="<?php echo $parentValue ?>">
<?php
	} 
?>
				<td>
<?php
	if (isset($idsToCorrect[$resultSystemMessage->sms_id])) {
		$errorMessage = $idsToCorrect[$resultSystemMessage->sms_id];
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');
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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
		<div class="<?php echo $systemMessageDisplayMode ?>">
<?php
		if ($systemMessageDisplayMode == "STATISTICS") {
			$query = virgoSystemMessage::getStatisticSelect();
			$rows = QR($query);
?>
<table>
	<tr>
		<th></th>
		<th>Month</th>
		<th>Count</th>
	</tr>
<?php			
			foreach ($rows as $row) {
?>
	<tr>
		<td><input type="checkbox" name="virgo_month_to_delete[]" value="<?php echo $row['month'] ?>"/></td>
		<td><?php echo $row['month'] ?>
		<td align="right"><?php echo $row['cnt'] ?>
	</tr>
<?php			
			}
?>
</table>
 
<?php
	$buttonRendered = false;
	if ($this->canExecute('DeleteMonths')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_deletemonths inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
									if (!confirm(decodeURIComponent('Are you sure you want to delete log entries from those months?'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='DeleteMonths';
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T('Delete selected months') ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php			
		}

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
	_pSF(form, 'sms_id_<?php echo $this->getId() ?>', '<?php echo isset($resultSystemMessage) ? (is_array($resultSystemMessage) ? $resultSystemMessage['sms_id'] : $resultSystemMessage->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_system_message" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_system_message').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
	<tr>
		<td align="right">
			customDisplayModes/system_message.php
		</td>
		<td align="left">
			<b>2013-04-14</b> <span style='font-size: 0.78em;'>12:38:52</span>
		</td>
	</tr>
	<tr>
		<td align="right">
			extraEntityActions/system_message.php
		</td>
		<td align="left">
			<b>2013-04-14</b> <span style='font-size: 0.78em;'>12:25:08</span>
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
	$infos = virgoSystemMessage::getExtraFilesInfo();
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

