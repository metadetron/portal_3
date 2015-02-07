<?php

//
//									Wersje
//

/*
	Versioning:
	Major.Minor.Release.Build

	Major: new conception
	Minor: portal interface (functions calls to portal.virgo classes) changed
	Release: interface (some function called by index.php) changed
	Biuld: changes, but not in interface
*/

	define("PORTAL_VERSION", "4.0.0.0"); // optimized, sceured, refactored
/*	define("PORTAL_VERSION", "2.0.0.1"); // version ignores "_" portlets now
	define("PORTAL_VERSION", "2.0.0.0"); // first two numbers are common for virgo generator, famework (index.php and functions.php) and portal project
	define("PORTAL_VERSION", "1.28"); // Generates transparent png
	define("PORTAL_VERSION", "1.27"); // Portlet name height removed
	define("PORTAL_VERSION", "1.26"); // FOUC on jQuery UI tabs prevented, yay!
	define("PORTAL_VERSION", "1.25"); // Portal name rendered
	define("PORTAL_VERSION", "1.24"); // API mode
	define("PORTAL_VERSION", "1.23"); // Unassigned portlets (finally!)
	define("PORTAL_VERSION", "1.22"); // Google fonts
	define("PORTAL_VERSION", "1.21"); // pdf->alias as css class
	define("PORTAL_VERSION", "1.20"); // autologout can be switched on (AUTO_LOGOUT == 0)
	define("PORTAL_VERSION", "1.19"); // overflow: visible
	define("PORTAL_VERSION", "1.18"); // Noscript alert
	define("PORTAL_VERSION", "1.17"); // HTML -> PDF link
	define("PORTAL_VERSION", "1.16"); // SESSION[portal_url] before first action call
	define("PORTAL_VERSION", "1.15"); // tabs = no inline-block
	define("PORTAL_VERSION", "1.14"); // Microportlets bug fixed
	define("PORTAL_VERSION", "1.13"); // jQuery Tabs!
	define("PORTAL_VERSION", "1.12"); // Gridless layout prevention
	define("PORTAL_VERSION", "1.11"); // Autorefresh, yay! 	
	define("PORTAL_VERSION", "1.10"); // Main functions moved to library, for SOAP and other modules to use it
	define("PORTAL_VERSION", "1.9"); // P() changed for portlet def parameters
	define("PORTAL_VERSION", "1.8"); // HREF changed
	define("PORTAL_VERSION", "1.7"); // cache'owanie css
	define("PORTAL_VERSION", "1.6"); // portal has default template again
	define("PORTAL_VERSION", "1.5"); // portlet geometry
	define("PORTAL_VERSION", "1.4"); // ajaxForm without portlet refresh
	define("PORTAL_VERSION", "1.3"); // grid in sections added
	define("PORTAL_VERSION", "1.2"); // portlet dimensions and layout
	define("PORTAL_VERSION", "1.1"); // version controll
*/
	define( '_INDEX_PORTAL', 1 );
   	if (!isset($_SERVER["REQUEST_TIME_FLOAT"])) {
		$_SESSION['VIRGO_REQUEST_TIME'] = microtime(true);
	}
	date_default_timezone_set('Europe/Berlin');
	// only for portlet classes, so let's assume they are always referred with pattern: namespace\classname
	function virgoAutoloader($classWithNamespace) {
		$elements = explode("\\", $classWithNamespace);
		if (count($elements) == 2) {
			$namespace = $elements[0];
			$class = $elements[1];
			if (!file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$class.DIRECTORY_SEPARATOR.'controller.php')) {
				ST();
	    	}
    		include PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$class.DIRECTORY_SEPARATOR.'controller.php';
    	}
	}
	spl_autoload_register('virgoAutoloader');	
	include PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'functions.php';
	include PORTAL_PATH.DIRECTORY_SEPARATOR.'libraries'.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'core.php';
	$underConstructionWarning = underConstruction();
	modRewriteDebug();
	$databaseHandler = new DatabaseHandler();
	showConfig();
	$time_start = microtime(true);
	security();
	phpSettings();
	// let's avoid this: Notice: session_start(): ps_files_cleanup_dir: opendir(/var/lib/php5) failed: Permission denied (13)
	@session_start();
	localeSettings();
	errorMessages();
	$_REQUEST['profiler'] = (R('profiler') == "T" ? array() : null);
	$_SESSION['cache'] = array();
	sessionExpiration();
	cron();
	labelMatching();
	$page = selectPage();
	$portal = $page->getPortal();
	$portletActionReturnValue = null;
	portletActionCallAjax($databaseHandler);
	renderMedia();
	upload();
	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoSystemMessage'.DIRECTORY_SEPARATOR.'controller.php');
	$portletActionReturnValue = null;
	portletActionCall($page, $databaseHandler);

	require_once(PORTAL_PATH .DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.'portal'.DIRECTORY_SEPARATOR.'virgoRole'.DIRECTORY_SEPARATOR.'controller.php');
	if ($page->canView()) {
		$template = $page->getPageTemplate();
		if (!is_null($template->getId())) {
			$portletNameHeight = 20;
			setTemplateSessionParams($template);
			$preout = "";
			$preout = $preout . str_replace('__VIRGO_PORTAL_NAME__', PP('PORTAL_NAME'), $template->getCode());
			$canEditPage = $page->canEdit();	
			$user = portal\virgoUser::getUser();			
			$sessionExpiredText = T('SESSION_EXPIRED');
			$portalIdentifier = getPortalIdentifier($portal);
			$out = getHTMLTemplate($page, $template, $user, $preout, $underConstructionWarning);

//
//									wstaw portlety
//	

//			$pattern = '/<section name="(.*?)"\/>/';
			$autorefreshCode = "";
			$sectionsInTemplate = array();
			$pattern = '/<section\s+name="(\S+?)"(\s+cw="(\d+?)"\s+ch="(\d+?)"\s+gw="(\d+?)"\s+gh="(\d+?)")?(\s+(tabs="true"))?\s*\/>/';
			if (preg_match_all($pattern, $out, $matches, PREG_SET_ORDER) > 0) {
				foreach ($matches as $val) {
					$sectionName = $val[1];
					$sectionsInTemplate[] = $sectionName;
					$portletsContent = "";
					$gridEnabled = isGridEnabled($cellWidth, $cellHeight, $gutterWidth, $gutterHeight, $cellRealWidth, $cellRealHeight, $maxWidth, $maxHeight, $val);
					$tabsEnabled = areTabsEnabled($val, $tabsBegin, $tabsEnd);
					$sectionPortletsContent = "";
					$portletsLocations = $page->getPortletsInSection($sectionName, $canEditPage);
					if ($canEditPage) {
						$sectionPortletsContent .= getSectionPortletContent($page, $sectionName);
					}
					foreach ($portletsLocations as $portletLocation) {
						$positionCss = "";
						$portletObject = $portletLocation->getPortletObject();
						if (is_null($portletObject->getId())) {
							continue;
						}
						if (!renderPortlet($portletObject, $canEditPage)) {
							continue;							
						}
						if (!$canEditPage) {
							$renderCondition = $portletObject->getRenderCondition();
							if (!is_null($renderCondition) && trim($renderCondition) != "") {
								$render = true;
								eval($renderCondition);
								if (!$render) {
									continue;
								}
							}
						}
						if ($tabsEnabled) {
							$portletTitle = $portletObject->getTitle();							
							$tabsBegin .= '<li><a href="#tab_'.$portletObject->getId().'">'.T($portletTitle).'</a></li>';
						}
						$positionCss = getPortletCssPosition($portletLocation, $gridEnabled);
						$autorefreshCode = getAutorefreshCode($portletObject);
						$sectionPortletsContent =  $sectionPortletsContent . getJavascriptTriggersCode($portletObject);
						if (!$gridEnabled) {
							if (!is_null($portletObject->getWidth()) && $portletObject->getWidth() > 0) {
								if (is_null($portletObject->getLeft()) && is_null($portletObject->getTop())) {
									if (!$tabsEnabled) {
										$positionCss .= " width: " . $portletObject->getWidth() . "px; ";
									}
								}
							}
						} else {
							if (!is_null($portletObject->getWidth()) && $portletObject->getWidth() > 0) {
								$width = $portletObject->getWidth();
							} else {
								$width = 1;
							}
						}
						if (!$gridEnabled) {
							if (!is_null($portletObject->getHeight()) && $portletObject->getHeight() > 0) {
								if (is_null($portletObject->getLeft()) && is_null($portletObject->getTop())) {
									if (!$tabsEnabled) {
										$positionCss .= " height: " . $portletObject->getHeight() . "px; ";
									}
								}
							}
						} else {
							if (!is_null($portletObject->getHeight()) && $portletObject->getHeight() > 0) {
								$height = $portletObject->getHeight();
							} else {
								$height = 1;
							}
						}
						if (!$gridEnabled) {
							if ($portletObject->getInline()) {
								$positionCss .= " display: inline-block;"; // JUZ NIE WIEM CO Z TYM... . ($portletObject->getShowTitle() == 1 || $canEditPage ? "-block" : "") . ";"; // float: left; "; // czemu tu bylo "float left"? Przez to sie nie dalo loginu na prawo ustawic... // a czemu bylo inline-block? Przez to menu gorne mialo "szpare" na dole
							} else {
								$positionCss .= " display: block; ";
							}
						}
						if ($gridEnabled) {
							$liBodyStyle = /* position: absolute;  */ "bottom: 0px; left: 0px; right: 0px; top: {$portletNameHeight}px;";
							if (!is_null($portletObject->getLeft()) && $portletObject->getLeft() >= 0) {
								$left = $portletObject->getLeft();
							} else {
								$left = 0;
							}
							if (!is_null($portletObject->getTop()) && $portletObject->getTop() >= 0) {
								$top = $portletObject->getTop();
							} else {
								$top = 0;
							}
							$positionCss .= "width: " . ($cellWidth + ($width - 1) * $cellRealWidth) . "px; height: " . ($cellHeight + ($height - 1) * $cellRealHeight) . "px; margin: " . ($gutterWidth/2) . "px " . ($gutterHeight/2) . "px; left: " . ($left * $cellRealWidth) . "px; top: " . ($top * $cellRealHeight) . "px;";
							$tmpWidth = $left + $width;
							$tmpHeight = $top + $height;
							$maxWidth = max($maxWidth, $tmpWidth);
							$maxHeight = max($maxHeight, $tmpHeight);
						} else {
							$liBodyStyle = "";
						}
						$positionCssUl = null;
						$positionCssDiv = null;
						$positionCssMask = null;
						if ($tabsEnabled) {
							$sectionPortletsContent = $sectionPortletsContent . "<div id='tab_".$portletObject->getId()."'>";
						}
						// jak jest relative, to zamiast obok siebie, portlety sa po przekatnej (drugi jest na prawo pod pierwszym)
						$sectionPortletsContent = $sectionPortletsContent . "<div id='section_{$sectionName}' style='vertical-align: top; position: " . ($gridEnabled ? "absolute" : "static") . "; {$positionCss}'>";
						
						$ajax = $portletObject->getAjax();
						if (($portletObject->getShowTitle() == 1 && !$tabsEnabled)|| $canEditPage) {
//							if ($portletObject->getShowTitle() == 1) {
								$positionCss .= ' overflow: visible;'; // czemu tu bylo auto? przez to sie menu nie pokazuje cale 
//							}
							$positionCssUl = "position: static; " . $positionCss;
							if ($canEditPage || $portletObject->canConfigure()) {
								if (file_exists(PORTAL_PATH .DIRECTORY_SEPARATOR.'meta'.DIRECTORY_SEPARATOR.'_portlet'.DIRECTORY_SEPARATOR.'params.php')) {
									$configurable = getTitleConfigurable($portletObject, $portletLocation, $sectionName);
									$portletGeometry = getPortletGeometry($portletObject);
									$nameScroll = "overflow-y: scroll; overflow-x: hidden;";
								} else {
									$configurable = "";
									$portletGeometry = "";
									$nameScroll = "";
								}
							} else {
								$configurable = "";
								$portletGeometry = "";
								$nameScroll = "";
							}						
							$titleStart = getPortletTitleStart($portletObject, $positionCssUl, $nameScroll, $configurable, $portletGeometry, $liBodyStyle);
							$titleEnd = "</li></ul>";
							$dimensions = "";
						} else {
							if ($ajax) {
								// zakomentowane, bo sie maska loadingu zle pokazywala (nie trafiala w portlet) przy gridzie wlaczonym
								// $positionCssMask = $positionCss;
								if ($tabsEnabled) {
									$titleStart = "<div>";
								} else {
									$titleStart = "<div style='display: block;'>"; // zmienilem na 'block' zeby mozna bylo centrowac portlety na srodku strony // dodalem -block, zeby Prolongate nie bylo w nowej linii
								}
							} else {
								$positionCssDl = $positionCss;
								$titleStart = "<div style='{$positionCssDl}'>";
							}
							$titleEnd = "</div>";
						}
						$_SESSION['current_portlet_object_id'] = $portletObject->getId();
						$sectionPortletsContent =  $sectionPortletsContent . $titleStart;
						if ($ajax) {
							/* bylo: position: absolute; top: 0px; */							
							$sectionPortletsContent =  $sectionPortletsContent . getSystemMessagesAjaxCode($portletObject);
						} else {
							$sectionPortletsContent =  $sectionPortletsContent . getSystemMessagesCode($portletObject);
						}
						if ($ajax && isset($_REQUEST['profiler'])) {
							$profiler = "<input type='hidden' name='profiler' value='T'>";
						} else {
							$profiler = "";
						}						
						$sectionPortletsContent = $sectionPortletsContent . getPortletBeginCode($portletObject, $positionCssMask, $profiler);
						$profiler = 'rendering ' . $portletObject->getPortletDefinition()->getAlias() . " (" . $portletObject->getCustomTitle() . ")";
						PROFILE($profiler);
						$sectionPortletsContent = $sectionPortletsContent . $portletObject->getContent();
						PROFILE($profiler);
						$sectionPortletsContent = $sectionPortletsContent . <<<HTML
	</div>
HTML;
						$sectionPortletsContent = $sectionPortletsContent . <<<HTML
</form></div>{$titleEnd}
HTML;
						$sectionPortletsContent = $sectionPortletsContent . getAjaxFormSubmitCode($portletObject, $ajax); 
						$sectionPortletsContent = $sectionPortletsContent . renderTriggerCall($portletObject);
						$sectionPortletsContent = $sectionPortletsContent . "</div>";
						if ($tabsEnabled) {
							$sectionPortletsContent = $sectionPortletsContent . "</div>";
						}
						unset($_SESSION['current_portlet_object_id']);
					}
					if ($tabsEnabled) {
						$tabsBegin .= '</ul>';
					}
					if ($canEditPage) {
						$sectionPortletsContent = $sectionPortletsContent . "</li></ul>";
					}
					if ($gridEnabled) {
						$portletsContent = "<div style='position: relative; width: " . ($cellWidth + ($maxWidth - 1) * $cellRealWidth) . "px; height: " . ($cellHeight + ($maxHeight - 1) * $cellRealHeight) . "px;'>" . $sectionPortletsContent . "</div>";
					} else {						
						$portletsContent = $tabsBegin . $sectionPortletsContent . $tabsEnd;
					}
					$out = str_replace($val[0], $portletsContent, $out);
				}
			}
			/* a teraz te przypisane do sekcji, ktorych nie ma w templacie */
			$out = $out . renderNotAssignedPortlets($page, $sectionsInTemplate);
			$messages = getSystemMessagesContent();
			$out = str_replace("<system-messages/>", $messages, $out); 			
			$out = str_replace("<portal-name/>", $page->getPortal()->getName(), $out); 			
			$out = $out . getOnloadCode($autorefreshCode); 
			$out = $out . <<<HTML
	</body>
</html>
HTML;
			// thanks Tobias Goldkamp
//		    $search = array(
//		        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
//        		'/[^\S ]+\</s', //strip whitespaces before tags, except space
//		        '/(\s)+/s'  // shorten multiple whitespace sequences
//        	);
//		    $replace = array('>', '<', '\\1');
// wszystko dobrze, ale pola formatowane (template html i css) i komentarze w javascripcie sie kaszania...
// moze powinien pomijac pola <textarea> i od // do konca linii kasowac w js?		    
//			$out = preg_replace($search, $replace, $out);
			echo $out;
		} else {
			echo "No template defined.";
		}
	} else {
		L('Access denied.', '', 'ERROR');
		portal\virgoPage::redirectDefault();
?>
<script type="text/javascript">
	window.location = '<?php echo $portal->getPortalUrl() ?>/?session_expired=true';
</script>
<?php
	}
?>
<?php
	profiler($time_start);
	showVersionCode();
?>

