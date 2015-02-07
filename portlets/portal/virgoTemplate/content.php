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
	use portal\virgoTemplate;

//	setlocale(LC_ALL, '$messages.LOCALE');
	$componentParams = null; //&JComponentHelper::getParams('com_prt_template');
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
<link rel="stylesheet" href="<?php echo $live_site ?>/components/com_prt_template/portal.css" type="text/css" /> 
<?php
	}
?>
<?php
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'prt_tmp.css')) {
?>
<link rel="stylesheet" href="<?php echo $_SESSION['portal_url'] ?>/portlets/portal/virgoTemplate/prt_tmp.css" type="text/css" /> 
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
<div class="virgo_container_portal virgo_container_entity_template" style="border: none;">
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
			$resultTemplate = virgoTemplate::createGuiAware();
			$contextId = $resultTemplate->getContextId();
			if (isset($contextId)) {
				if (virgoTemplate::getDisplayMode() != "CREATE" || R('portlet_action') == "Duplicate") {
					$resultTemplate->load($contextId);
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
		if ($className == "virgoTemplate") {
			$masterObject = new $className();
			$tmpId = $masterObject->getRemoteContextId($masterPobId);
			if (isset($tmpId)) {
				$resultTemplate = new virgoTemplate($tmpId);
				virgoTemplate::setDisplayMode("FORM");
			} else {
				$resultTemplate = new virgoTemplate();
				virgoTemplate::setDisplayMode("CREATE");
			}
		}
	} else {
		if (P('form_only', "0") == "5") {
			if (is_null($resultTemplate->getId())) { 
				if (P('only_private_records', "0") == "1") {
					$allPrivateRecords = $resultTemplate->selectAll();
					if (sizeof($allPrivateRecords) > 0) {
						$resultTemplate = new virgoTemplate($allPrivateRecords[0]['tmp_id']);
						$resultTemplate->putInContext(false);
					} else {
						$resultTemplate = new virgoTemplate();
					}
				} else {
					$customSQL = P('custom_sql_condition');
					if (isset($customSQL) && trim($customSQL) != '') {
						$currentUser = virgoUser::getUser();
						$currentPage = virgoPage::getCurrentPage();
						eval("\$customSQL = \"$customSQL\";");
						$records = $resultTemplate->selectAll($customSQL);
						if (sizeof($records) > 0) {
							$resultTemplate = new virgoTemplate($records[0]['tmp_id']);
							$resultTemplate->putInContext(false);
						} else {
							$resultTemplate = new virgoTemplate();
						}
					} else {
						$resultTemplate = new virgoTemplate();
					}
				}
			}
		} elseif (P('form_only', "0") == "6") {
			$resultTemplate = new virgoTemplate(virgoUser::getUserId());
			$resultTemplate->putInContext(false);
		}
	}
?>
<?php
		if (isset($includeError) && $includeError == 1) {
			$resultTemplate = new virgoTemplate();
		}
?>
<?php
	$templateDisplayMode = virgoTemplate::getDisplayMode();
//	if ($templateDisplayMode == "" || $templateDisplayMode == "TABLE") {
//		$resultTemplate = $resultTemplate->portletActionForm();
//	}
?>
		<div class="form">
<?php
		$parentContextInfos = $resultTemplate->getParentsInContext();
		foreach ($parentContextInfos as $parentContextInfo) {
//			$whereClauseTemplate = $whereClauseTemplate . ' AND ' . $parentContextInfo['condition'];
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
		$criteriaTemplate = $resultTemplate->getCriteria();
		$countTmp = 0;
		if (isset($criteriaTemplate["name"])) {
			$fieldCriteriaName = $criteriaTemplate["name"];
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
		if (isset($criteriaTemplate["code"])) {
			$fieldCriteriaCode = $criteriaTemplate["code"];
			if ($fieldCriteriaCode["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaCode["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (isset($criteriaTemplate["css"])) {
			$fieldCriteriaCss = $criteriaTemplate["css"];
			if ($fieldCriteriaCss["is_null"] != 0) {
				$countTmp = $countTmp + 1;
			} else {
				$dataTypeCriteria = $fieldCriteriaCss["value"];
				$renderCriteria = "";
				if ($renderCriteria != "") {
					$countTmp = $countTmp + 1;
				}
			}
		}
		if (is_null($criteriaTemplate) || sizeof($criteriaTemplate) == 0 || $countTmp == 0) {
		} else {
?>
			<input type="hidden" name="virgo_filter_column"/>
			<table class="db_criteria_record">
				<tr>
					<td colspan="3" class="db_criteria_message"><?php echo T('SEARCH_CRITERIA') ?></td>
				</tr>
<?php
			if (isset($criteriaTemplate["name"])) {
				$fieldCriteriaName = $criteriaTemplate["name"];
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
			if (isset($criteriaTemplate["code"])) {
				$fieldCriteriaCode = $criteriaTemplate["code"];
				if ($fieldCriteriaCode["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaCode["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaCode["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='code';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaCode["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Code') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='code';
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
			if (isset($criteriaTemplate["css"])) {
				$fieldCriteriaCss = $criteriaTemplate["css"];
				if ($fieldCriteriaCss["is_null"] != 0) {
?>			
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Css') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
<?php
					if ($fieldCriteriaCss["is_null"] == 1) {
?>
					<?php echo T('NOT_EMPTY_VALUE') ?><?php
					} elseif ($fieldCriteriaCss["is_null"] == 2) {
?>
					<?php echo T('EMPTY_VALUE') ?><?php
					}
?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='css';
						this.form.portlet_action.value='RemoveCriterium';
						<?php echo JSFS() ?>
					">
<?php echo T('REMOVE_CRITERIA') ?>					</button>
				</td>
			</tr>
<?php				
				} else {
					$dataTypeCriteria = $fieldCriteriaCss["value"];
					$renderCriteria = "";
					if ($renderCriteria != "") {
?>
			<tr>
				<td class="db_criteria_label" nowrap="nowrap">
					<?php echo T('Css') ?> <?php echo T(' ') ?>				</td>
				<td class="db_criteria_value">
					<?php echo $renderCriteria ?>
				</td>
				<td class="db_criteria_value">
					<button class="button btn btn-mini" onclick="
						this.form.virgo_filter_column.value='css';
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
	if (isset($resultTemplate)) {
		$tmpId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId();
		if (isset($tmpId)) {
?>
<input type="hidden" name="<?php echo getTokenName($tmpId) ?>" value="<?php echo getTokenValue($tmpId) ?>"/>
<?php
		}
	}
PROFILE('token');
?>
<?php
	if ($templateDisplayMode != "TABLE") {
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
			$pob = $resultTemplate->getMyPortletObject();
			$reloadFromRequest = $pob->getPortletSessionValue('reload_from_request', '0');
			if (isset($invokedPortletId) && $invokedPortletId == $_SESSION['current_portlet_object_id'] && isset($reloadFromRequest) && $reloadFromRequest == "1") { 
				$pob->setPortletSessionValue('reload_from_request', '0');
				$resultTemplate->loadFromRequest();
			} else {
				if (P('form_only', "0") == "1" && isset($contextId)) {
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'create_store_message.php')) {
						require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'create_store_message.php');
						$templateDisplayMode = "-empty-";
					}
				}
			}
		}
	}
if (!$resultTemplate->hideContentDueToNoParentSelected()) {
	$formsInTable = (P('forms_rendering', "false") == "true");
	if (!$formsInTable) {
		$floatingFields = (P('forms_rendering', "false") == "float" || P('forms_rendering', "false") == "float-grid");
		$floatingGridFields = (P('forms_rendering', "false") == "float-grid");
	}
/* MILESTONE 1.1 Form */
	$tabIndex = 1;
	$parentAjaxRendered = "0";
	if ($templateDisplayMode == "FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_template") {
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
<?php echo T('TEMPLATE') ?>:</legend>
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
						for="tmp_name_<?php echo $resultTemplate->getId() ?>"
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
							<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="tmp_name_<?php echo $resultTemplate->getId() ?>" value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="tmp_name_<?php echo $resultTemplate->getId() ?>" 
							name="tmp_name_<?php echo $resultTemplate->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_NAME');
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
$('#tmp_name_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_form_code', "1") == "1" || P('show_form_code', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_code_obligatory', "0") == "1" ? " obligatory " : "" ?>   code code" 
						for="tmp_code_<?php echo $resultTemplate->getId() ?>"
					> <?php echo P('show_form_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CODE') ?>
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
	if (P('show_form_code', "1") == "2") {
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
	id="tmp_code_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_code_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_code_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox code" 
	id="tmp_code_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_code_<?php echo $resultTemplate->getId() ?>"
	rows="40"
	cols="130"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_code_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_form_css', "1") == "1" || P('show_form_css', "1") == "2") {
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
						class="fieldlabel  <?php echo P('show_form_css_obligatory', "0") == "1" ? " obligatory " : "" ?>   css code" 
						for="tmp_css_<?php echo $resultTemplate->getId() ?>"
					> <?php echo P('show_form_css_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CSS') ?>
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
	if (P('show_form_css', "1") == "2") {
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
	id="tmp_css_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_css_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_css, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_css_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox css" 
	id="tmp_css_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_css_<?php echo $resultTemplate->getId() ?>"
	rows="40_Type:css"
	cols="80"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CSS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCss(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_css_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoPage') && P('show_form_pages', '1') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_form_portals', '1') == "1") {
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
	if (false) { //$componentParams->get('show_form_pages') == "1") {
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
//	$componentParamsPage = &JComponentHelper::getParams('com_prt_page');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_page/prt_page_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_portal/prt_portal_class.php");
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
	if (false) { //$componentParamsPage->get('show_table_title') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Title
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Alias
*
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Default
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") {
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
	if (false) { //$componentParamsPage->get('show_table_path') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Path
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td align="center" nowrap>Page </td>
<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portal </td>
<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPage = new portal\virgoPage();
				$resultsPage = $tmpPage->selectAll(' pge_tmp_id = ' . $resultTemplate->tmp_id);
				$idsToCorrect = $tmpPage->getInvalidRecords();
				$index = 0;
				foreach ($resultsPage as $resultPage) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPage->pge_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPage->pge_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPage->pge_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPage->pge_id) ? 0 : $resultPage->pge_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPage->pge_id;
		$resultPage = new virgoPage;
		$resultPage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPage->get('show_table_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="title_<?php echo $resultTemplate->tmp_id ?>" 
							name="title_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="alias_<?php echo $resultTemplate->tmp_id ?>" 
							name="alias_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_alias, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 2;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="default_<?php echo $resultTemplate->tmp_id ?>" 
							name="default_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_default, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 3;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="order_<?php echo $resultTemplate->tmp_id ?>" 
							name="order_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 4;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultTemplate->tmp_id ?>" 
							name="path_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#tmp_page_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
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
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
$('#tmp_portal_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
				$resultPage = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPage->pge_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPage->pge_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPage->pge_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPage->pge_id) ? 0 : $resultPage->pge_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPage->pge_id;
		$resultPage = new virgoPage;
		$resultPage->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPage->get('show_table_title') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_title_<?php echo $resultPage->getId() ?>" 
							name="pge_title_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getTitle(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_TITLE');
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
$('#pge_title_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="title_<?php echo $resultTemplate->tmp_id ?>" 
							name="title_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_title, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_alias') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="pge_alias_<?php echo $resultPage->getId() ?>" 
							name="pge_alias_<?php echo $resultPage->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPage->getAlias(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ALIAS');
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
$('#pge_alias_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="alias_<?php echo $resultTemplate->tmp_id ?>" 
							name="alias_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_alias, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_default') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 2;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
<select class="inputbox" id="pge_default_<?php echo $resultPage->getId() ?>" name="pge_default_<?php echo $resultPage->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_DEFAULT');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPage->getDefault() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPage->getDefault() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPage->getDefault()) || $resultPage->getDefault() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#pge_default_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="default_<?php echo $resultTemplate->tmp_id ?>" 
							name="default_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_default, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_order') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 3;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_order_obligatory', "0") == "1" ? " obligatory " : "" ?>   short  " 
							type="text"
							id="pge_order_<?php echo $resultPage->getId() ?>" 
							name="pge_order_<?php echo $resultPage->getId() ?>"
							style="border: yellow 1 solid; text-align: right;" 
							size="15"
							value="<?php echo htmlentities($resultPage->getOrder(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_ORDER');
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
$('#pge_order_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="order_<?php echo $resultTemplate->tmp_id ?>" 
							name="order_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_order, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 4;
?>
<?php
	if (!isset($resultPage)) {
		$resultPage = new portal\virgoPage();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   long  " 
							type="text"
							id="pge_path_<?php echo $resultPage->getId() ?>" 
							name="pge_path_<?php echo $resultPage->getId() ?>"
							maxlength="2000"
							size="50" 
							value="<?php echo htmlentities($resultPage->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PAGE_PATH');
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
$('#pge_path_<?php echo $resultPage->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultTemplate->tmp_id ?>" 
							name="path_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPage->get('show_table_page') == "1" && ($masterComponentName != "page" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 5;
?>
<?php
//		$limit_page = $componentParams->get('limit_to_page');
		$limit_page = null;
		$readOnly = "";
		if (isset($tmpId) || P('show_form_page', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_pge__id = $tmpId;
//			}
			if (!is_null($resultPage->getPgeId())) {
				$parentId = $resultPage->getPgeId();
				$parentValue = portal\virgoPage::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PAGE');
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
	$showAjaxpge = P('show_form_page', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_page_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_page_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPgeId()) && $id == $resultPage->getPgeId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPgeId();
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
	<input type="hidden" id="pge_page_<?php echo $resultPage->getId() ?>" name="pge_page_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="pge_page_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_page_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_page_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_page_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_page_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
$('#tmp_page_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPage->get('show_table_portal') == "1" && ($masterComponentName != "portal" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPage) * 6;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortal");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portal', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPage->pge_prt__id = $tmpId;
//			}
			if (!is_null($resultPage->getPrtId())) {
				$parentId = $resultPage->getPrtId();
				$parentValue = portal\virgoPortal::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PAGE_PORTAL');
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
	$showAjaxpge = P('show_form_portal', "1") == "3" || $parentCount > 100;
	if (!$showAjaxpge) {
?>
    						<select 
							class="inputbox  obligatory " 
							id="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
							name="pge_portal_<?php echo !is_null($resultPage->getId()) ? $resultPage->getId() : '' ?>" 
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
				echo (!is_null($resultPage->getPrtId()) && $id == $resultPage->getPrtId() ? "selected='selected'" : "");
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
				$parentId = $resultPage->getPrtId();
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
	<input type="hidden" id="pge_portal_<?php echo $resultPage->getId() ?>" name="pge_portal_<?php echo $resultPage->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?>  obligatory " 
		id="pge_portal_dropdown_<?php echo $resultPage->getId() ?>" 
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
        $( "#pge_portal_dropdown_<?php echo $resultPage->getId() ?>" ).autocomplete({
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
					$('#pge_portal_<?php echo $resultPage->getId() ?>').val(ui.item.value);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				  	$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#pge_portal_<?php echo $resultPage->getId() ?>').val('');
				$('#pge_portal_dropdown_<?php echo $resultPage->getId() ?>').removeClass("locked");		
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
	if ($this->canExecute('AddPortal')) { 		$buttonRendered = true;
		$anythingRendered = true;
?>
<div class="button_wrapper button_wrapper_addportal inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='AddPortal';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
$('#tmp_portal_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
				$tmpPage->setInvalidRecords(null);
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
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td align="center" nowrap>Portlet object </td>
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
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPortletParameter = new portal\virgoPortletParameter();
				$resultsPortletParameter = $tmpPortletParameter->selectAll(' ppr_tmp_id = ' . $resultTemplate->tmp_id);
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
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
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
							id="name_<?php echo $resultTemplate->tmp_id ?>" 
							name="name_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
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
							id="value_<?php echo $resultTemplate->tmp_id ?>" 
							name="value_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_value, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 2;
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortletObject");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPobId())) {
				$parentId = $resultPortletParameter->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTLET_OBJECT');
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
	$showAjaxppr = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portletObject_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portletObject_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
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
				echo (!is_null($resultPortletParameter->getPobId()) && $id == $resultPortletParameter->getPobId() ? "selected='selected'" : "");
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
				$parentId = $resultPortletParameter->getPobId();
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
	<input type="hidden" id="ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
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
        $( "#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
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
					$('#ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
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
$('#tmp_portlet_object_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 3;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortletDefinition");
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
$('#tmp_portlet_definition_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	$tabIndex = $index + sizeof($resultsPortletParameter) * 4;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortal");
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
$('#tmp_portal_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
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
							id="name_<?php echo $resultTemplate->tmp_id ?>" 
							name="name_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_value') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
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
							id="value_<?php echo $resultTemplate->tmp_id ?>" 
							name="value_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_value, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_object') == "1" && ($masterComponentName != "portlet_object" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 2;
?>
<?php
//		$limit_portlet_object = $componentParams->get('limit_to_portlet_object');
		$limit_portlet_object = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortletObject");
		$readOnly = "";
		if (isset($tmpId) || P('show_form_portlet_object', "1") == "2") {
// to powinno bylo juz byc zrobione w createGuiAware()			
//			if (!is_null($tmpId)) {
//				$resultPortletParameter->ppr_pob__id = $tmpId;
//			}
			if (!is_null($resultPortletParameter->getPobId())) {
				$parentId = $resultPortletParameter->getPobId();
				$parentValue = portal\virgoPortletObject::lookup($parentId);
			} else {
				$parentId = null;
				$parentValue = null;
			}
?>
						<input type="hidden" id="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>">
						<span class="inputbox readonly"><?php echo isset($parentValue) ? $parentValue : '' ?></span>
<?php
		} else {
?>
<?php
	$hint = TE('HINT_PORTLET_PARAMETER_PORTLET_OBJECT');
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
	$showAjaxppr = P('show_form_portlet_object', "1") == "3" || $parentCount > 100;
	if (!$showAjaxppr) {
?>
    						<select 
							class="inputbox  <?php echo P('show_form_portlet_object_obligatory') == "1" ? " obligatory " : "" ?> " 
							id="ppr_portletObject_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
							name="ppr_portletObject_<?php echo !is_null($resultPortletParameter->getId()) ? $resultPortletParameter->getId() : '' ?>" 
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
				echo (!is_null($resultPortletParameter->getPobId()) && $id == $resultPortletParameter->getPobId() ? "selected='selected'" : "");
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
				$parentId = $resultPortletParameter->getPobId();
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
	<input type="hidden" id="ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>" name="ppr_portletObject_<?php echo $resultPortletParameter->getId() ?>" value="<?php echo $parentId ?>"/> 
	<input 
		type="text"
		class="inputbox dropdown <?php echo !is_null($parentId) && trim($parentId) != '' && $parentId != '0' ? 'locked' : '' ?> " 
		id="ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>" 
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
        $( "#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>" ).autocomplete({
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
					$('#ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.value);
				  	$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				  	$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').addClass("locked");
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            focus: function( event, ui ) {
				if (ui.item.value != '') {
					$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').val(ui.item.label);
				}
				event.stopImmediatePropagation();
				event.preventDefault();
            },
            open: function() {
				$('#ppr_portlet_object_<?php echo $resultPortletParameter->getId() ?>').val('');
				$('#ppr_portlet_object_dropdown_<?php echo $resultPortletParameter->getId() ?>').removeClass("locked");		
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
$('#tmp_portlet_object_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (false) { //$componentParamsPortletParameter->get('show_table_portlet_definition') == "1" && ($masterComponentName != "portlet_definition" || is_null($contextId))) {
?>
				<td nowrap align="left" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>">    
<?php
	$tabIndex = $index + sizeof($resultsPortletParameter) * 3;
?>
<?php
//		$limit_portlet_definition = $componentParams->get('limit_to_portlet_definition');
		$limit_portlet_definition = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortletDefinition");
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
$('#tmp_portlet_definition_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	$tabIndex = $index + sizeof($resultsPortletParameter) * 4;
?>
<?php
//		$limit_portal = $componentParams->get('limit_to_portal');
		$limit_portal = null;
		$tmpId = portal\virgoTemplate::getParentInContext("portal\\virgoPortal");
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
$('#tmp_portal_dropdown_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (false) { //$componentParams->get('show_form_portals') == "1") {
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
//	$componentParamsPortal = &JComponentHelper::getParams('com_prt_portal');
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
	include_once(/*$_SERVER[ "DOCUMENT_ROOT"]*/ PORTAL_PATH . "/components/com_prt_template/prt_template_class.php");
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
	if (false) { //$componentParamsPortal->get('show_table_name') == "1") {
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
	if (false) { //$componentParamsPortal->get('show_table_url') == "1") {
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
	if (false) { //$componentParamsPortal->get('show_table_identifier') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Identifier
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_path') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Path
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_tolerant_access_policy') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Tolerant access policy
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_namespace') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							User class namespace
						</span>
				</td>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_name') == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							User class name
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$tmpPortal = new portal\virgoPortal();
				$resultsPortal = $tmpPortal->selectAll(' prt_tmp_id = ' . $resultTemplate->tmp_id);
				$idsToCorrect = $tmpPortal->getInvalidRecords();
				$index = 0;
				foreach ($resultsPortal as $resultPortal) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultPortal->prt_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortal->prt_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortal->prt_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortal->prt_id) ? 0 : $resultPortal->prt_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortal->prt_id;
		$resultPortal = new virgoPortal;
		$resultPortal->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortal->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prt_name_<?php echo $resultPortal->getId() ?>" 
							name="prt_name_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_NAME');
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
$('#prt_name_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="name_<?php echo $resultTemplate->tmp_id ?>" 
							name="name_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_url_<?php echo $resultPortal->getId() ?>" 
							name="prt_url_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_URL');
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
$('#prt_url_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="url_<?php echo $resultTemplate->tmp_id ?>" 
							name="url_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_identifier') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 2;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_identifier_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_identifier_<?php echo $resultPortal->getId() ?>" 
							name="prt_identifier_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getIdentifier(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_IDENTIFIER');
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
$('#prt_identifier_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="identifier_<?php echo $resultTemplate->tmp_id ?>" 
							name="identifier_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_identifier, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 3;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_path_<?php echo $resultPortal->getId() ?>" 
							name="prt_path_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_PATH');
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
$('#prt_path_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultTemplate->tmp_id ?>" 
							name="path_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_tolerant_access_policy') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 4;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
<select class="inputbox" id="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>" name="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_TOLERANT_ACCESS_POLICY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortal->getTolerantAccessPolicy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortal->getTolerantAccessPolicy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortal->getTolerantAccessPolicy()) || $resultPortal->getTolerantAccessPolicy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="tolerantAccessPolicy_<?php echo $resultTemplate->tmp_id ?>" 
							name="tolerantAccessPolicy_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_tolerant_access_policy, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_namespace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 5;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_namespace_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassNamespace(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAMESPACE');
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
$('#prt_userClassNamespace_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="userClassNamespace_<?php echo $resultTemplate->tmp_id ?>" 
							name="userClassNamespace_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_user_class_namespace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 6;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassName_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassName_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAME');
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
$('#prt_userClassName_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="userClassName_<?php echo $resultTemplate->tmp_id ?>" 
							name="userClassName_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_user_class_name, ENT_QUOTES, "UTF-8") ?>"
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
				$resultPortal = array();
?>		
			<tr id="virgo_tr_id_<?php echo $resultPortal->prt_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
			>
				<td>
<?php
	if (!is_null($resultPortal->prt_id)) {
?>
					<input type="checkbox" class="checkbox" name="DELETE[]" value="<?php echo $resultPortal->prt_id ?>">
					<?php echo JText::_('DELETE') ?>
<?php
	} else {
?>
					<input type="checkbox" class="checkbox" name="virgo_validate_new" <?php echo  strtoupper(R('virgo_validate_new')) == "ON" ? "checked" :"" ?>>
					<?php echo JText::_('ADD') ?>
<?php
	}
	$errorMessage = $idsToCorrect[is_null($resultPortal->prt_id) ? 0 : $resultPortal->prt_id];
	if (!is_null($errorMessage)) {
		$tmpId = $resultPortal->prt_id;
		$resultPortal = new virgoPortal;
		$resultPortal->loadRecordFromRequest($tmpId);
	}
?>
				</td>
<?php
	if (false) { //$componentParamsPortal->get('show_table_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="prt_name_<?php echo $resultPortal->getId() ?>" 
							name="prt_name_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_NAME');
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
$('#prt_name_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="name_<?php echo $resultTemplate->tmp_id ?>" 
							name="name_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_url') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_url_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_url_<?php echo $resultPortal->getId() ?>" 
							name="prt_url_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUrl(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_URL');
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
$('#prt_url_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="url_<?php echo $resultTemplate->tmp_id ?>" 
							name="url_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_url, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_identifier') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 2;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_identifier_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_identifier_<?php echo $resultPortal->getId() ?>" 
							name="prt_identifier_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getIdentifier(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_IDENTIFIER');
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
$('#prt_identifier_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="identifier_<?php echo $resultTemplate->tmp_id ?>" 
							name="identifier_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_identifier, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_path') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 3;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_path_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_path_<?php echo $resultPortal->getId() ?>" 
							name="prt_path_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getPath(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_PATH');
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
$('#prt_path_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="path_<?php echo $resultTemplate->tmp_id ?>" 
							name="path_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_path, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_tolerant_access_policy') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 4;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
<select class="inputbox" id="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>" name="prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_TOLERANT_ACCESS_POLICY');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
>
	<option value="1" <?php echo ($resultPortal->getTolerantAccessPolicy() == 1 ? "selected='selected'" : "") ?>><?php echo T('YES') ?></option>
	<option value="0" <?php echo ($resultPortal->getTolerantAccessPolicy() === "0" ? "selected='selected'" : "") ?>><?php echo T('NO') ?></option>
	<option value="2" <?php echo (is_null($resultPortal->getTolerantAccessPolicy()) || $resultPortal->getTolerantAccessPolicy() == 2 ? "selected='selected'" : "") ?>><?php echo T('NO_DATA') ?></option>
</select>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#prt_tolerantAccessPolicy_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="tolerantAccessPolicy_<?php echo $resultTemplate->tmp_id ?>" 
							name="tolerantAccessPolicy_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_tolerant_access_policy, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_namespace') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 5;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_namespace_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassNamespace_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassNamespace(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAMESPACE');
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
$('#prt_userClassNamespace_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="userClassNamespace_<?php echo $resultTemplate->tmp_id ?>" 
							name="userClassNamespace_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_user_class_namespace, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
	if (false) { //$componentParamsPortal->get('show_table_user_class_name') == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 6;
?>
<?php
	if (!isset($resultPortal)) {
		$resultPortal = new portal\virgoPortal();
	}
?>
						<input 
							class="inputbox  <?php echo P('show_form_user_class_name_obligatory', "0") == "1" ? " obligatory " : "" ?>   medium  " 
							type="text"
							id="prt_userClassName_<?php echo $resultPortal->getId() ?>" 
							name="prt_userClassName_<?php echo $resultPortal->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultPortal->getUserClassName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_PORTAL_USER_CLASS_NAME');
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
$('#prt_userClassName_<?php echo $resultPortal->getId() ?>').qtip({position: {
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
							id="userClassName_<?php echo $resultTemplate->tmp_id ?>" 
							name="userClassName_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_user_class_name, ENT_QUOTES, "UTF-8") ?>"
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
				$tmpPortal->setInvalidRecords(null);
?>
<?php
	}
?>
			</fieldset>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultTemplate->getDateCreated()) {
		if ($resultTemplate->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultTemplate->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultTemplate->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultTemplate->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultTemplate->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultTemplate->getDateModified()) {
		if ($resultTemplate->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultTemplate->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultTemplate->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultTemplate->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultTemplate->getDateModified() ?>"	>
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
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("TEMPLATE"), "\\'".rawurlencode($resultTemplate->getVirgoTitle())."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
this.form.virgo_changed.value = 'N';
 								form.target = '';
							" 
							value="<?php echo T('CLOSE') ?>"
						/><div class="button_right"></div></div><?php						
	}
?>
				</div>
<script type="text/javascript" language="JavaScript">
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['tmp_name_<?php echo $resultTemplate->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.2 Create */
	} elseif ($templateDisplayMode == "CREATE") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_template") {
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
<?php echo T('TEMPLATE') ?>:</legend>
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
		if (isset($resultTemplate->tmp_id)) {
			$resultTemplate->tmp_id = null;
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
					<label nowrap class="fieldlabel  obligatory " for="tmp_name_<?php echo $resultTemplate->getId() ?>">
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
				$resultTemplate->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="tmp_name_<?php echo $resultTemplate->getId() ?>" value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="tmp_name_<?php echo $resultTemplate->getId() ?>" 
							name="tmp_name_<?php echo $resultTemplate->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_NAME');
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
$('#tmp_name_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_create_code', "1") == "1" || P('show_create_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="tmp_code_<?php echo $resultTemplate->getId() ?>">
 <?php echo P('show_create_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CODE') ?>
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
			if (P('event_column') == "code") {
				$resultTemplate->setCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_code', "1") == "2") {
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
	id="tmp_code_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_code_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_code_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox code" 
	id="tmp_code_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_code_<?php echo $resultTemplate->getId() ?>"
	rows="40"
	cols="130"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_code_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_create_css', "1") == "1" || P('show_create_css', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_css_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="tmp_css_<?php echo $resultTemplate->getId() ?>">
 <?php echo P('show_create_css_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CSS') ?>
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
			if (P('event_column') == "css") {
				$resultTemplate->setCss($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_css', "1") == "2") {
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
	id="tmp_css_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_css_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_css, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_css_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox css" 
	id="tmp_css_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_css_<?php echo $resultTemplate->getId() ?>"
	rows="40_Type:css"
	cols="80"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CSS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCss(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_css_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoPage') && P('show_create_pages', '1') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_create_portals', '1') == "1") {
?>
<?php
	} else {
	}
?>


<?php
	} elseif ($createForm == "virgo_entity") {
?>
<?php
		if (isset($resultTemplate->tmp_id)) {
			$resultTemplate->tmp_id = null;
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
					<label nowrap class="fieldlabel  obligatory " for="tmp_name_<?php echo $resultTemplate->getId() ?>">
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
				$resultTemplate->setName($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_name', "1") == "2") {
?>
						<span class="inputbox readonly uneditable-input">
							<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="tmp_name_<?php echo $resultTemplate->getId() ?>" value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>"> 

<?php
	} else {
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="tmp_name_<?php echo $resultTemplate->getId() ?>" 
							name="tmp_name_<?php echo $resultTemplate->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_NAME');
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
$('#tmp_name_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_create_code', "1") == "1" || P('show_create_code', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_code_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="tmp_code_<?php echo $resultTemplate->getId() ?>">
 <?php echo P('show_create_code_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CODE') ?>
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
			if (P('event_column') == "code") {
				$resultTemplate->setCode($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_code', "1") == "2") {
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
	id="tmp_code_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_code_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_code_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox code" 
	id="tmp_code_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_code_<?php echo $resultTemplate->getId() ?>"
	rows="40"
	cols="130"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_code_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (P('show_create_css', "1") == "1" || P('show_create_css', "1") == "2") {
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
					<label nowrap class="fieldlabel  <?php echo P('show_create_css_obligatory', "0") == "1" ? " obligatory " : "" ?> " for="tmp_css_<?php echo $resultTemplate->getId() ?>">
 <?php echo P('show_create_css_obligatory', "0") == "1" ? "* " : "" ?><?php echo T('CSS') ?>
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
			if (P('event_column') == "css") {
				$resultTemplate->setCss($virgoSelectedDay);
			}
		}
	}
	if (P('show_create_css', "1") == "2") {
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
	id="tmp_css_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_css_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_css, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_css_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox css" 
	id="tmp_css_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_css_<?php echo $resultTemplate->getId() ?>"
	rows="40_Type:css"
	cols="80"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CSS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCss(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_css_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
	if (class_exists('portal\virgoPage') && P('show_create_pages', '1') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_create_portals', '1') == "1") {
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
	if ($resultTemplate->getDateCreated()) {
		if ($resultTemplate->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultTemplate->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultTemplate->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultTemplate->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultTemplate->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultTemplate->getDateModified()) {
		if ($resultTemplate->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultTemplate->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultTemplate->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultTemplate->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultTemplate->getDateModified() ?>"	>
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
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
// document.forms['portlet_form_<?php echo $this->getId() ?>'].elements['tmp_name_<?php echo $resultTemplate->getId() ?>'].focus();
</script>
	</div>
<?php
/* MILESTONE 1.3 Search */
	} elseif ($templateDisplayMode == "SEARCH") {
?>
	<div class="form_edit form_search">
			<fieldset class="form">
				<legend>
<?php echo T('TEMPLATE') ?>:</legend>
				<ul>
<?php
	$criteriaTemplate = $resultTemplate->getCriteria();
?>
<?php
	if (P('show_search_name', "1") == "1") {

		if (isset($criteriaTemplate["name"])) {
			$fieldCriteriaName = $criteriaTemplate["name"];
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
	if (P('show_search_code', "1") == "1") {

		if (isset($criteriaTemplate["code"])) {
			$fieldCriteriaCode = $criteriaTemplate["code"];
			$dataTypeCriteria = $fieldCriteriaCode["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CODE') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_code_is_null" 
				name="virgo_search_code_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaCode) && $fieldCriteriaCode["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaCode) && $fieldCriteriaCode["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaCode) && $fieldCriteriaCode["is_null"] == 2) {
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
	if (P('show_search_css', "1") == "1") {

		if (isset($criteriaTemplate["css"])) {
			$fieldCriteriaCss = $criteriaTemplate["css"];
			$dataTypeCriteria = $fieldCriteriaCss["value"];
		}
?>
	<li
		<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
	>
		<label align="right" nowrap class="fieldlabel"
			<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
		>
<?php echo T('CSS') ?>
		</label>
		<span align="left" nowrap>
		</span>
<?php
	if (P('empty_values_search', "0") == "1") {
?>
		
		<span class="virgo_search_empty_values" align="left" nowrap style="font-size: 0.7em;">
			<?php echo T('VALUE') ?>			<select 
				id="virgo_search_css_is_null" 
				name="virgo_search_css_is_null"
			>
				<option value=""
<?php
		if (isset($fieldCriteriaCss) && $fieldCriteriaCss["is_null"] == 0) {
?>
				selected="selected"
<?php
		}
?>
				></option>
				<option value="not_null"
<?php
		if (isset($fieldCriteriaCss) && $fieldCriteriaCss["is_null"] == 1) {
?>
				selected="selected"
<?php
		}
?>
				><?php echo T('NOT_EMPTY_VALUE') ?></option>
				<option value="null"
<?php
		if (isset($fieldCriteriaCss) && $fieldCriteriaCss["is_null"] == 2) {
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
	if (P('show_search_pages') == "1") {
?>
<?php
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
	$record->load($recordId);
	$subrecordsPages = $record->getPages();
	$sizePages = count($subrecordsPages);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Pages
					</label>
<?php
	if ($sizePages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePages) {
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
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
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
	if (P('show_search_portals') == "1") {
?>
<?php
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
	$record->load($recordId);
	$subrecordsPortals = $record->getPortals();
	$sizePortals = count($subrecordsPortals);
?>
				<li
					<?php echo (!$formsInTable && $floatingFields) ? "style='display: inline-block; float: left;'" : '' ?>
				>
					<label align="right" valign="top" nowrap class="fieldlabel"
						<?php echo (!$formsInTable && $floatingFields) ? "style='width: inherit;'" : '' ?>
					>
						Portals
					</label>
<?php
	if ($sizePortals == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortals as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortals) {
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
	unset($criteriaTemplate);
?>
				</ul>
			</fieldset>
				<div class="buttons form-actions">
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
						<input type="hidden" name="virgo_order_column" id="virgo_order_column"/>
						<input type="hidden" name="virgo_order_mode" id="virgo_order_mode"/>						

 <div class="button_wrapper button_wrapper_search inlineBlock"><input 							name="submit_button" 
							class="button btn  " 
							type="submit" 
							onclick="
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Search';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	} elseif ($templateDisplayMode == "VIEW") {
?>
	<div class="form_view">
<?php
	$editForm = P('view_form', "virgo_default");
	if (is_null($editForm) || trim($editForm) == "" || $editForm == "virgo_default") {
?>
			<fieldset class="form">
				<legend>
<?php echo T('TEMPLATE') ?>:</legend>
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
							<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?> 
						&nbsp;</span>
						<input type="hidden" id="name" name="tmp_name_<?php echo $resultTemplate->getId() ?>" value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>"> 

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
	if (P('show_view_code', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="code"
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
<?php echo T('CODE') ?>
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
	id="tmp_code_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_code_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_code, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_code_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (P('show_view_css', '1') == "1") {
?>
<?php
	if (!$formsInTable) {
?>
	<li
		class="css"
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
<?php echo T('CSS') ?>
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
	id="tmp_css_<?php echo $resultTemplate->tmp_id ?>" 
	name="tmp_css_<?php echo $resultTemplate->tmp_id ?>"
	cols="75" 
	rows="20" 
	onchange="this.form.virgo_changed.value='T'"	
><?php echo htmlentities($resultTemplate->tmp_css, ENT_QUOTES, "UTF-8") ?></textarea>
<script type="text/javascript">
var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("tmp_css_<?php echo $resultTemplate->tmp_id ?>"), {
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
	if (class_exists('portal\virgoPage') && P('show_view_pages', '0') == "1") {
?>
<?php
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
	$record->load($recordId);
	$subrecordsPages = $record->getPages();
	$sizePages = count($subrecordsPages);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="template"
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
						Pages 
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
	if ($sizePages == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPages as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePages) {
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
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
	$record->load($recordId);
	$subrecordsPortletParameters = $record->getPortletParameters();
	$sizePortletParameters = count($subrecordsPortletParameters);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="template"
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
	if (class_exists('portal\virgoPortal') && P('show_view_portals', '0') == "1") {
?>
<?php
	$record = new portal\virgoTemplate();
	$recordId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->tmp_id;
	$record->load($recordId);
	$subrecordsPortals = $record->getPortals();
	$sizePortals = count($subrecordsPortals);
?>
<?php
	if (!$formsInTable) {
?>
	<li	class="template"
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
						Portals 
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
	if ($sizePortals == 0) {
?>
<?php
	} else {
		$subrecordIndex = 0;
		foreach ($subrecordsPortals as $subrecord) {
			$subrecordIndex++;
			echo htmlentities($subrecord->getVirgoTitle(), ENT_QUOTES, "UTF-8");
			if ($subrecordIndex < $sizePortals) {
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
<?php echo T('TEMPLATE') ?>:</legend>
				<ul>
				</ul>
			</fieldset>
<?php
	}
?>
<?php
if (P('hide_audit', '0') == '0') {
	$showFieldset = 0;
	if ($resultTemplate->getDateCreated()) {
		if ($resultTemplate->getUsrCreatedId() == 0) {
			$username = "anonymous";
		} else {
			$createdByUser = new virgoUser((int)$resultTemplate->getUsrCreatedId());
			$username = $createdByUser->getUsername();
		}
		$createdOn = $resultTemplate->getDateCreated();
		$showFieldset = 1;
?>
	 <fieldset class="audit">
		<legend><?php echo T('AUDIT_DATA') ?>:</legend>
			<ul>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_created_id" name="usr_created_id" value="<?php echo $resultTemplate->getUsrCreatedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('CREATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $createdOn ?></i></span>
					<input type="hidden" id="date_created" name="date_created" value="<?php echo $resultTemplate->getDateCreated() ?>"	>
				</li>
<?php
	}
?>
<?php
	if ($resultTemplate->getDateModified()) {
		if ($resultTemplate->getUsrModifiedId() == 0) {
			$username = "anonymous";
		} else {
			$modifiedByUser = new virgoUser((int)$resultTemplate->getUsrModifiedId());
			$username = $modifiedByUser->getUsername();
		}
		$modifiedOn = $resultTemplate->getDateModified();
?>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFIED_BY') ?></span>
					<span class="readonly"><b><?php echo $username ?></b></span>
					<input type="hidden" id="usr_modified_id" name="usr_modified_id" value="<?php echo $resultTemplate->getUsrModifiedId() ?>"	>
				</li>
				<li>
					<span align="right" nowrap class="fieldlabel"><?php echo T('MODIFICATION_DATE') ?></span>
					<span class="readonly"><i><?php echo $modifiedOn ?></i></span>
					<input type="hidden" id="date_modified" name="date_modified" value="<?php echo $resultTemplate->getDateModified() ?>"	>
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
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("TEMPLATE"), "\\'".$resultTemplate->getVirgoTitle()."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	} elseif ($templateDisplayMode == "TABLE") {
PROFILE('TABLE');
		if (P('form_only') == "3") {
?>
<?php
	$selectedMonth = $this->getPortletSessionValue('selected_month', date("m"));
	$selectedYear = $this->getPortletSessionValue('selected_year', date("Y"));

	$tmpDay = getdate(mktime(0, 0, 0, $selectedMonth, 1, $selectedYear));
	$firstDay = $tmpDay;
	$lastDay = getdate(strtotime($tmpDay["year"] . "-" .  (((int)$tmpDay["mon"])+1) . "-" . (((int)$tmpDay["mday"])-1)));
	$eventColumn = "tmp_" . P('event_column');

	$resultCount = -1;
	$filterApplied = false;
	$resultTemplate->setShowPage(1); 
	$resultTemplate->setShowRows('all'); 	
	$resultsTemplate = $resultTemplate->getTableData($resultCount, $filterApplied);
	$events = array();
	foreach ($resultsTemplate as $resultTemplate) {
		if (isset($resultTemplate[$eventColumn]) && isset($events[substr($resultTemplate[$eventColumn], 0, 10)])) {
			$eventsInDay = $events[substr($resultTemplate[$eventColumn], 0, 10)];
		} else {
			$eventsInDay = array();
		}
		$eventObject = new virgoTemplate($resultTemplate['tmp_id']);
		$eventsInDay[] = $eventObject;
		$events[substr($resultTemplate[$eventColumn], 0, 10)] = $eventsInDay;
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
				<input type='hidden' name='tmp_id_<?php echo $this->getId() ?>' value=''/>
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
			foreach ($eventsInDay as $resultTemplate) {
?>
<?php
PROFILE('token');
	if (isset($resultTemplate)) {
		$tmpId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId();
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

 								form.target = '';
							" 
							value="<?php echo T($resultTemplate->getVirgoTitle()) ?>"
						/><div class="button_right"></div></div><?php
	}
?>
<?php				
//				echo "<span class='virgo_calendar_event' onclick='var form=document.getElementById(\"portlet_form_".$this->getId()."\");form.portlet_action.value=\"View\";form.tmp_id_".$this->getId().".value=\"".$eventInDay->getId()."\";form.submit();'>" . $eventInDay->getVirgoTitle() . "</span>";
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
			var templateChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == templateChildrenDivOpen) {
					div.style.display = 'none';
					templateChildrenDivOpen = '';
				} else {
					if (templateChildrenDivOpen != '') {
						document.getElementById(templateChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					templateChildrenDivOpen = clickedDivId;
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
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPage'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletObject'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortletDefinition'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoPortal'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
	if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php')) require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoTemplate'.DIRECTORY_SEPARATOR.'controller.php');
			$showPage = $resultTemplate->getShowPage(); 
			$showRows = $resultTemplate->getShowRows(); 
?>
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
				<tr><td colspan="99" class="nav-header"><?php echo T('Templates') ?></td></tr>
<?php
			}
?>			
<?php
PROFILE('table_02');
PROFILE('main select');
			$virgoOrderColumn = $resultTemplate->getOrderColumn();
			$virgoOrderMode = $resultTemplate->getOrderMode();
			$resultCount = -1;
			$filterApplied = false;
			$resultsTemplate = $resultTemplate->getTableData($resultCount, $filterApplied);
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
	$oc = $resultTemplate->getOrderColumn(); 
	$om = $resultTemplate->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'tmp_name');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('NAME') ?>							<?php echo ($oc == "tmp_name" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoTemplate::getLocalSessionValue('VirgoFilterName', null);
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
	if (P('show_table_code', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultTemplate->getOrderColumn(); 
	$om = $resultTemplate->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'tmp_code');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CODE') ?>							<?php echo ($oc == "tmp_code" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoTemplate::getLocalSessionValue('VirgoFilterCode', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (P('show_table_css', "0") == "1") {
?>
				<th align="left" valign="middle" rowspan="2" style="text-align: left;">
<?php
	$oc = $resultTemplate->getOrderColumn(); 
	$om = $resultTemplate->getOrderMode();
	$pagingAscHTML = '<div style="display: inline;" class="button_paging">&#x21E7;</div>';
	$pagingDescHTML = '<div style="display: inline;" class="button_paging">&#x21E9;</div>';
?>
						<span onclick="var form = document.getElementById('portlet_form_<?php echo $this->getId() ?>');
							form.portlet_action.value='ChangeOrder'; 
	_pSF(form, 'virgo_order_column', 'tmp_css');
	_pSF(form, 'virgo_order_mode', '<?php echo ($om == 'asc' ? 'desc' : 'asc') ?>');
							<?php echo JSFS() ?>
							 " style="white-space: normal; cursor: pointer;" class="data_table_header">
<?php echo T('CSS') ?>							<?php echo ($oc == "tmp_css" ? ($om == "" ? $pagingDescHTML : ($om == "asc") ? $pagingDescHTML : $pagingAscHTML) : "") ?> 
						</span>
<?php
	if (P('show_table_filter', '0') == '1') {
		$tableFilter = virgoTemplate::getLocalSessionValue('VirgoFilterCss', null);
?>
<?php		
	}
?>
				</th>

<?php
	}
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_table_portals', '0') == "1") {
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
					$resultTemplate->setShowPage($showPage);
				}
				$index = 0;
PROFILE('table_04');
PROFILE('rows rendering');
				$contextRowIdInTable = null;
				$firstRowId = null;
				foreach ($resultsTemplate as $resultTemplate) {
					$index = $index + 1;
?>
<?php
$fileNameToInclude = PORTAL_PATH . "/portlets/portal/virgoTemplate/modules/renderTableRow_{$_SESSION['current_portlet_object_id']}.php";
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
	$fileNameToInclude = PORTAL_PATH . "/portlets/portal/modules/renderTableRow.php";
} 
if (!file_exists($fileNameToInclude) || !is_readable($fileNameToInclude)) {
?>
<?php
			if (P('form_only') != "4" || (P('chessboard_width') != 0 && $index % P('chessboard_width') == 1)) {
				if (is_null($firstRowId)) {
					$firstRowId = $resultTemplate['tmp_id'];
				}
				$displayClass = ' displayClass ';
				$tmpContextId = virgoTemplate::getContextId();
				if (is_null($tmpContextId)) {
					$forceContextOnFirstRow = P('force_context_on_first_row', "1");
					if ($forceContextOnFirstRow == "1") {
						virgoTemplate::setContextId($resultTemplate['tmp_id'], false);
						$tmpContextId = $resultTemplate['tmp_id'];
					}
				}
				if (isset($tmpContextId) && $resultTemplate['tmp_id'] == $tmpContextId) {
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
				id="<?php echo $this->getId() ?>_<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : "" ?>" 
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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultTemplate['tmp_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultTemplate['tmp_id'] ?>">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultTemplate['tmp_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('code');
	if (P('show_table_code', "0") == "1") {
PROFILE('render_data_table_code');
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
			<li class="code">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
			$len = strlen($resultTemplate['tmp_code']);
			$shortTextSize = P('short_text_size_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultTemplate['tmp_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultTemplate['tmp_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultTemplate['tmp_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_code');
	}
PROFILE('code');
?>
<?php
PROFILE('css');
	if (P('show_table_css', "0") == "1") {
PROFILE('render_data_table_css');
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
			<li class="css">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
			$len = strlen($resultTemplate['tmp_css']);
			$shortTextSize = P('short_text_size_css', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultTemplate['tmp_css'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultTemplate['tmp_css'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultTemplate['tmp_css'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_css');
	}
PROFILE('css');
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_table_portals', '0') == "1") {
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
	if (isset($resultTemplate)) {
		$tmpId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId();
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("TEMPLATE"), "\\'".rawurlencode($resultTemplate['tmp_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
				<input type="checkbox" class="checkbox" style="float: right;" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultTemplate['tmp_id'] ?>">
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
				<input type="checkbox" class="checkbox" name="DELETE_<?php echo $this->getId() ?>_<?php echo $resultTemplate['tmp_id'] ?>">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
				<?php echo htmlentities($resultTemplate['tmp_name'], ENT_QUOTES, "UTF-8") ?>
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
PROFILE('code');
	if (P('show_table_code', "0") == "1") {
PROFILE('render_data_table_code');
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
			<li class="code">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
			$len = strlen($resultTemplate['tmp_code']);
			$shortTextSize = P('short_text_size_code', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultTemplate['tmp_code'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultTemplate['tmp_code'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultTemplate['tmp_code'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_code');
	}
PROFILE('code');
?>
<?php
PROFILE('css');
	if (P('show_table_css', "0") == "1") {
PROFILE('render_data_table_css');
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
			<li class="css">
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
					form.tmp_id_<?php echo $this->getId() ?>.value='<?php echo isset($resultTemplate['tmp_id']) ? $resultTemplate['tmp_id'] : '' ?>'; 
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
			$len = strlen($resultTemplate['tmp_css']);
			$shortTextSize = P('short_text_size_css', 30);
		?>
		<span 
			class="<?php echo 'displayClass' ?>" <?php print ($len > $shortTextSize ? 'title="' . htmlentities($resultTemplate['tmp_css'], ENT_QUOTES, "UTF-8") . '"' : '') ?>>
			<?php
				if ($shortTextSize > 0 && $len > $shortTextSize) {
					echo htmlentities(substr($resultTemplate['tmp_css'], 0, $shortTextSize), ENT_QUOTES, "UTF-8") . "...";
				} else {
					if ($shortTextSize == 0) {
						echo "<pre style='white-space: pre-line;'>";
					}
					echo htmlentities($resultTemplate['tmp_css'], ENT_QUOTES, "UTF-8");
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
PROFILE('render_data_table_css');
	}
PROFILE('css');
?>
<?php
	if (class_exists('portal\virgoPage') && P('show_table_pages', '0') == "1") {
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
	if (class_exists('portal\virgoPortal') && P('show_table_portals', '0') == "1") {
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
	if (isset($resultTemplate)) {
		$tmpId = is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId();
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
									if (!confirm(decodeURIComponent('<?php echo T("ARE_YOU_SURE_YOU_WANT_REMOVE", T("TEMPLATE"), "\\'".rawurlencode($resultTemplate['tmp_virgo_title'])."\\'") ?>'))) return false;
								var form = this.form;
								form.action = '';
								form.portlet_action.value='Delete';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
			virgoTemplate::setContextId($firstRowId, false);
			if (P('form_only') != "4") {
?>
<script type="text/javascript">
		$('form#portlet_form_<?php echo $this->getId() ?> table.data_table tr#<?php echo $this->getId() ?>_<?php echo $firstRowId ?>').addClass("contextClass");
</script>
<?php
			}
		}
	}				
				unset($resultTemplate);
				unset($resultsTemplate);
				if (isset($contextIdOwn) && trim($contextIdOwn) != "") {
					if ($contextIdConfirmed == false) {
						$tmpTemplate = new virgoTemplate();
						$tmpCount = $tmpTemplate->getAllRecordCount(' tmp_id = ' . $contextIdOwn);
						if ($tmpCount == 0) {
							virgoTemplate::clearRemoteContextId($tabModeEditMenu);
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
		$.getJSON('<?php echo $page->getUrl() ?>?portlet_action=SelectJson&tmp_id_<?php echo $this->getId() ?>=' + virgoId + '&invoked_portlet_object_id=<?php echo $this->getId() ?>&virgo_action_mode_json=T&_virgo_ajax=1', function(data) {
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
		form.tmp_id_<?php echo $this->getId() ?>.value=virgoId; 
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
		form.tmp_id_<?php echo $this->getId() ?>.value=virgoId; 
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'tmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'tmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Report';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'tmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'tmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Export';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
								  if (children[i].getAttribute('name') == 'tmp_id_<?php echo $this->getId() ?>') {
									found = 1;
								  }
								}
								if (found == 0) {
								  var input = document.createElement('input');
								  input.setAttribute('type', 'hidden');
								  input.setAttribute('name', 'tmp_id_<?php echo $this->getId() ?>');
								  input.setAttribute('value', '');
								  form.appendChild(input);
								} else {
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '');
								}
								form.action = '';
								form.portlet_action.value='Offline';
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
					$sessionSeparator = virgoTemplate::getImportFieldSeparator();
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
						$sessionSeparator = virgoTemplate::getImportFieldSeparator();
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
									if (!confirm(decodeURIComponent('<?php echo T('ARE_YOU_SURE_YOU_WANT_REMOVE', T('TEMPLATES'), "") ?>'))) return false;
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	} elseif ($templateDisplayMode == "TABLE_FORM") {
?>
<script language="JavaScript">
  window.onbeforeunload = confirmExit;
  function confirmExit() {
	  var checks = document.getElementsByName("virgo_changed");
	  for (var i=0; i < checks.length; i++) {
		  var check = checks.item(i);
		  if (check.form.name == "virgo_form_template") {
			  if (check.value == 'T') {
				  return "<?php echo T('ARE_YOU_SURE_YOU_WANT_DISCARD') ?>";
			  }
		  }
        }
  }
</script>
		<script type="text/javascript">
			var templateChildrenDivOpen = '';
			
			function childrenButtonClicked(clickedDivId) {
				var div = document.getElementById(clickedDivId);
				if (clickedDivId == templateChildrenDivOpen) {
					div.style.display = 'none';
					templateChildrenDivOpen = '';
				} else {
					if (templateChildrenDivOpen != '') {
						document.getElementById(templateChildrenDivOpen).style.display = 'none';
					}
					div.style.display = 'block';
					templateChildrenDivOpen = clickedDivId;
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

	<form method="post" style="display: inline;" action="" id="virgo_form_template" name="virgo_form_template" enctype="multipart/form-data">
						<input type="text" name="tmp_id_<?php echo $this->getId() ?>" id="tmp_id_<?php echo $this->getId() ?>" value="" style="display: none;"/>
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
	if (P('show_table_code', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Code
						</span>
				</td>

<?php
	}
?>
<?php
	if (P('show_table_css', "0") == "1") {
?>
				<td align="center" valign="middle"><!-- bylo: nowrap -->
						<span style="white-space: normal;" class="data_table_header">
							Css
						</span>
				</td>

<?php
	}
?>
				<td></td>
				<td></td>
			</tr>

<?php			
				$resultsTemplate = $resultTemplate->getRecordsToEdit();
				$idsToCorrect = $resultTemplate->getInvalidRecords();
				$index = 0;
PROFILE('rows rendering');
				foreach ($resultsTemplate as $resultTemplate) {
					$index = $index + 1;
?>
			<tr id="virgo_tr_id_<?php echo $resultTemplate->tmp_id ?>" class="<?php echo ($index % 2 == 0 ? "data_table_even" : "data_table_odd") ?>"
<?php
	if ($resultTemplate->tmp_id == 0 && R('virgo_validate_new', "N") == "N") {
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
	$tabIndex = $index + sizeof($resultsTemplate) * 0;
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>
						<input 
							class="inputbox  obligatory   medium  " 
							type="text"
							id="tmp_name_<?php echo $resultTemplate->getId() ?>" 
							name="tmp_name_<?php echo $resultTemplate->getId() ?>"
							maxlength="255"
							size="50" 
							value="<?php echo htmlentities($resultTemplate->getName(), ENT_QUOTES, "UTF-8") ?>" 
							onchange="this.form.virgo_changed.value='T'"
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_NAME');
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
$('#tmp_name_<?php echo $resultTemplate->getId() ?>').qtip({position: {
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
							id="name_<?php echo $resultTemplate->tmp_id ?>" 
							name="name_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_name, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('code');
	if (P('show_table_code', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 1;
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox code" 
	id="tmp_code_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_code_<?php echo $resultTemplate->getId() ?>"
	rows="40"
	cols="130"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CODE');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCode(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_code_<?php echo $resultTemplate->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('code');
	} else {
?> 
						<input
							type="hidden"
							id="code_<?php echo $resultTemplate->tmp_id ?>" 
							name="code_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_code, ENT_QUOTES, "UTF-8") ?>"
						>

<?php
	}
?>
<?php
PROFILE('css');
	if (P('show_table_css', "0") == "1") { 
?>
<td>
<?php
	$tabIndex = $index + sizeof($resultsTemplate) * 2;
?>
<?php
	if (!isset($resultTemplate)) {
		$resultTemplate = new portal\virgoTemplate();
	}
?>

<textarea 
	class="inputbox css" 
	id="tmp_css_<?php echo $resultTemplate->getId() ?>" 
	name="tmp_css_<?php echo $resultTemplate->getId() ?>"
	rows="40_Type:css"
	cols="80"
	onchange="this.form.virgo_changed.value='T'"	
<?php
	if (isset($tabIndex) && $tabIndex > 0) {
?>
							tabindex="<?php echo $tabIndex ?>"
<?php
	}
	$hint = TE('HINT_TEMPLATE_CSS');
	if (isset($hint)) {
?>
							title="<?php echo $hint ?>"
<?php
	}
?>
><?php echo htmlentities($resultTemplate->getCss(), ENT_QUOTES, "UTF-8") ?></textarea>
<?php
	if (isset($hint)) {
?>						
<script type="text/javascript">
$('#tmp_css_<?php echo $resultTemplate->getId() ?>').qtip({position: {
		my: 'left center',
		at: 'right center'
	}});
</script>						
<?php
	}
?>						




</td>
<?php
PROFILE('css');
	} else {
?> 
						<input
							type="hidden"
							id="css_<?php echo $resultTemplate->tmp_id ?>" 
							name="css_<?php echo $resultTemplate->tmp_id ?>"
							value="<?php echo htmlentities($resultTemplate->tmp_css, ENT_QUOTES, "UTF-8") ?>"
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
	if (isset($idsToCorrect[$resultTemplate->tmp_id])) {
		$errorMessage = $idsToCorrect[$resultTemplate->tmp_id];
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
		<div class="<?php echo $templateDisplayMode ?>">
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
	_pSF(form, 'tmp_id_<?php echo $this->getId() ?>', '<?php echo isset($resultTemplate) ? (is_array($resultTemplate) ? $resultTemplate['tmp_id'] : $resultTemplate->getId()) : '' ?>');

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
<div style="display: none; background-color:#FFFFFF; border:1px solid #000000; font-size:10px; margin:10px 0; padding:10px;"; id="extraFilesInfo_prt_template" style="font-size: 12px; " onclick="document.getElementById('extraFilesInfo_prt_template').style.display='none';">
<table><tr><td valign="top">
<table collspacing="2" collpadding="1">
	<tr>
		<td colspan="2">
			<b>Web:</b>
		</td>
	</tr>
	<tr>
		<td align="right">
			extraPublicActions/template.php
		</td>
		<td align="left">
			<b>2013-02-04</b> <span style='font-size: 0.78em;'>13:51:50</span>
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
	$infos = virgoTemplate::getExtraFilesInfo();
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

