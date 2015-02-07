<?php
	if (isset($_POST['pgeId'])) {
		$pgeId = $_POST['pgeId'];
	} elseif (isset($_GET['pgeId'])) {
		$pgeId = $_GET['pgeId'];
	} else {
		echo "No page to configure.";
		exit();
	}
	if (isset($_POST['section'])) {
		$section = $_POST['section'];
	} elseif (isset($_GET['section'])) {
		$section = $_GET['section'];
	}
	
//	require_once(dirname(__FILE__).'/../../classes/DatabaseHandler/DatabaseHandler.php');
	$databaseHandler = new DatabaseHandler();
	
	$action = $_POST['action'];
	if (isset($action)) {
		$types = "";
		$values = array();
		switch ($action) {
			case 'newLocation': 
				if (isset($_POST["subAction"]) && $_POST["subAction"] == "Clone") {
					$query = "INSERT INTO prt_portlet_objects (pob_show_title, pob_custom_title, pob_left, pob_top, pob_width, pob_height, pob_inline, pob_ajax, pob_render_condition, pob_autorefresh, pob_pdf_id) SELECT pob_show_title, CONCAT(pob_custom_title, ?), pob_left, pob_top, pob_width, pob_height, pob_inline, pob_ajax, pob_render_condition, pob_autorefresh, pob_pdf_id FROM prt_portlet_objects WHERE pob_id = {$_POST['pobId']} ";
					$databaseHandler->queryPrepared($query, false, "s", array(" (copy)"));
					echo $databaseHandler->error();
					$nowyPobId = $databaseHandler->lastId();
					$query = " INSERT INTO prt_permissions (prm_view, prm_edit, prm_rle_id, prm_configure, prm_action, prm_execute, prm_pob_id) SELECT prm_view, prm_edit, prm_rle_id, prm_configure, prm_action, prm_execute, {$nowyPobId} FROM prt_permissions WHERE prm_pob_id = {$_POST['pobId']}";
					$databaseHandler->query($query);
					echo $databaseHandler->error();
					$query = " INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) SELECT ppr_name, ppr_value, {$nowyPobId} FROM prt_portlet_parameters WHERE ppr_pob_id = {$_POST['pobId']}";
					$databaseHandler->query($query);
					echo $databaseHandler->error();
					$query = " INSERT INTO prt_portlet_locations (plc_pge_id, plc_pob_id, plc_section, plc_order, plc_date_created, plc_usr_created_id) SELECT {$pgeId}, {$nowyPobId}, ?, IFNULL(MAX(plc_order), 0) + 1, CURDATE(), 0 FROM prt_portlet_locations WHERE plc_pge_id = {$pgeId} AND plc_section = ?";					
					$types = "ss";
					$values = array($section, $section);
				} else {
					$query = " INSERT INTO prt_portlet_locations (plc_pge_id, plc_pob_id, plc_section, plc_order, plc_date_created, plc_usr_created_id) SELECT {$pgeId}, {$_POST['pobId']}, ?, IFNULL(MAX(plc_order), 0) + 1, CURDATE(), 0 FROM prt_portlet_locations WHERE plc_pge_id = {$pgeId} AND plc_section = ?";
					$types = "ss";
					$values = array($section, $section);
				}
				break;
			case 'newObject': 
				$showTitleString = $_POST['showTitle'] == "on" ? '1' : 'NULL'; 
				$customTitleString = (isset($_POST['customTitle']) && trim($_POST['customTitle']) != "") ? $_POST['customTitle'] : null;  
				$ajaxString = $_POST['ajax'] == "on" ? '1' : 'NULL'; 
				$query = " INSERT INTO prt_portlet_objects (pob_virgo_title, pob_pdf_id, pob_show_title, pob_custom_title, pob_ajax, pob_date_created, pob_usr_created_id) SELECT pdf_virgo_title, {$_POST['pdfId']}, {$showTitleString}, ?, {$ajaxString}, CURDATE(), 0 FROM prt_portlet_definitions WHERE pdf_id = {$_POST['pdfId']} ";
				$databaseHandler->queryPrepared($query, false, "s", array($customTitleString));
				echo $databaseHandler->error();			
				$pobId = $databaseHandler->lastId();
				$query = " INSERT INTO prt_permissions (prm_pob_id, prm_rle_id, prm_view, prm_edit, prm_configure) SELECT {$pobId}, rle_id, 1, 1, 1 FROM prt_roles WHERE rle_name = ? ";
				$databaseHandler->queryPrepared($query, false, "s", array('METAadministrator'));
				echo $databaseHandler->error();
				$query = " INSERT INTO prt_portlet_locations (plc_virgo_title, plc_pge_id, plc_pob_id, plc_section, plc_order, plc_date_created, plc_usr_created_id) SELECT pob_virgo_title, {$pgeId}, {$pobId}, ?, IFNULL(MAX(plc_order), 0) + 1, CURDATE(), 0 FROM prt_portlet_locations LEFT OUTER JOIN prt_portlet_objects ON pob_id = {$pobId} WHERE plc_pge_id = {$pgeId} AND plc_section = ?";
				$types = "ss";
				$values = array($section, $section);
				break;
		}
		$databaseHandler->queryPrepared($query, false, $types, $values);
		echo $databaseHandler->error();
		if ($action == 'newObject') {
			$plcId = $databaseHandler->lastId();
			$query = " SELECT pdf_namespace, pdf_alias FROM prt_portlet_definitions WHERE pdf_id = {$_POST['pdfId']} ";
			$result = $databaseHandler->query($query);
			if ($result) {
				while($row = mysqli_fetch_row($result)) {
					$alias = $row[1];
					$namespace = $row[0];
					if (file_exists(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$alias.DIRECTORY_SEPARATOR.'controller.php')) {
						require_once(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$alias.DIRECTORY_SEPARATOR.'controller.php');
						$className = $namespace."\\".$alias;
						if (method_exists($class, "createTable")) {
							call_user_func(array($className, 'createTable'));
						}
						if (method_exists($class, "onInstall")) {
							// ta metoda jesli istnieje moze np. ustawic juz niektore parametry, np. domyslny sort, ilosc rekordow na stronie itp...
							call_user_func_array(array($className, 'onTitle'), array($pobId, $_POST['customTitle']));
						}
					}
				}
				mysqli_free_result($result);
			} else {
				$res = NULL;
			}
			$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
			$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
			$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
			$url = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . "/index.php";
			header('Location: ' . $url . "?virgo_show_config=portlet&plcId={$plcId}&pobId={$pobId}&section={$section}") ;			
		}
	}
	
	$query = "
SELECT 
  pob_id AS a0, pdf_namespace AS a1, CONCAT(pdf_name, ?, IFNULL(pob_custom_title, ?)) AS a2, pge_title AS a3
FROM 
  prt_portlet_objects
  JOIN prt_portlet_definitions ON (pdf_id = pob_pdf_id)
  LEFT OUTER JOIN prt_portlet_locations ON (pob_id = plc_pob_id)
  LEFT OUTER JOIN prt_pages ON (pge_id = plc_pge_id)
ORDER BY
  pdf_namespace, CONCAT(pdf_name, ?, IFNULL(pob_custom_title, ?))
";
	$result = $databaseHandler->queryPrepared($query, false, "ssss", array(" ", "", " ", ""));
	if ($result) {
		foreach ($result as $row) {
			$res[] = $row;
		}
	} else {
		$res = NULL;
	}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>portlets</title>
	</head>
	<body>
<style type="text/css">
table, input, textarea, fieldset {
	font-size: 10px;
}
table, input, fieldset {
	font-family: Verdana;
}
textarea {
	font-family: Courier;
}
form {
	background-color: LightGoldenRodYellow;
	color: Black;
	padding: 10px;
	margin: 5px;
	border: 2px outset BurlyWood;
}
tr.spacer {
    background-color: Wheat;
    font-weight: bold;
}
th {
	background-color: White;
}
ul {
	list-style: none;
	margin: 0px;
	padding: 0px;
}
</style>
		<fieldset>
			<legend>Add a new location to a existing portlet object</legend>
			<form method="post">
				Choose portlet
				<select name="pobId">
					<option value=""></option>
<?php
	foreach ($res as $r) {
?>					
					<option value="<?php echo $r['a0'] ?>"><?php echo $r['a1'] ?> - <?php echo $r['a2'] ?> [<?php echo $r['a3'] ?>]</option>
<?php
	}
?>					
				</select>
				<input type="hidden" name="section" value="<?php echo $section ?>"/>
				<input type="hidden" name="pgeId" value="<?php echo $pgeId ?>"/>
				<input type="hidden" name="action" value="newLocation"/>
				<input type="submit" value="Store"/>
				<input type="submit" name="subAction" value="Clone"/>
			</form>
		</fieldset>
		<fieldset>
			<legend>Add new portlet object</legend>
			<form method="post">
				<input type="hidden" name="action" value="newObject"/>
				<input type="hidden" name="section" value="<?php echo $section ?>"/>
				<input type="hidden" name="pgeId" value="<?php echo $pgeId ?>"/>
				<ul>
					<li>
				Choose portlet 
						<select name="pdfId" onchange="document.getElementById('ajax').checked = virgos[this.selectedIndex];">
							<option value=""></option>
<?php					
// szukamy skopiowanych ale nie wklepanych do bazy:
	$namespaces = scandir(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets');	
	foreach ($namespaces as $namespace) {
		if ($namespace == ".") continue;
		if ($namespace == "..") continue;
		if (substr($namespace, 0, 1) == "_") continue;
		$portlets = scandir(PORTAL_PATH.DIRECTORY_SEPARATOR.'portlets'.DIRECTORY_SEPARATOR.$namespace);
		foreach ($portlets as $portlet) {
			if ($portlet == ".") continue;
			if ($portlet == "..") continue;
			$query = "SELECT pdf_id FROM prt_portlet_definitions WHERE pdf_namespace = ? AND pdf_alias = ?";
			$rows = QPR($query, "ss", array($namespace, $portlet));
			if (count($rows) == 0) {
				I('PortletDefinition');
				$pdf = new portal\virgoPortletDefinition();
				$pdf->setNamespace($namespace);
				$pdf->setAlias($portlet);
				$className = $portlet;
				if (substr($portlet, 0, 5) == 'virgo') {
					$portlet = substr($portlet, 5);
				}
				$pdf->setName(ucfirst(strtolower(str_replace("_", " ", $portlet))));
				$pdf->setAuthor(' - ');
				$pdf->setVersion(' - ');
				LE($pdf->store());
			}
		}
	}
	$query = "
SELECT 
  pdf_id AS a0, pdf_namespace AS a1, pdf_name AS a2, pdf_alias AS a3
FROM 
  prt_portlet_definitions
ORDER BY
  pdf_namespace, pdf_name
";
	$result = $databaseHandler->queryPrepared($query, false, "", array());
	if ($result) {
?>
<script	type="text/javascript">
  var index = 0;
  var virgos = new Array();
</script>
<?php
		foreach ($result as $row) {
?>					
					<option value="<?php echo $row['a0'] ?>"><?php echo $row['a1'] ?> - <?php echo $row['a2'] ?></option>
<script	type="text/javascript">
	virgos[index] = <?php echo substr($row[3], 0, 5) == 'virgo' ? 'true' : 'false' ?>;
	index = index + 1;
</script>
<?php
		}
	}
?>
					
						</select>
					</li>
					<li>
						Show title
						<input type="checkbox" name="showTitle"/>
					</li>
					<li>
						Custom title
						<input type="text" name="customTitle"/>
					</li>
					<li>
						Ajax
						<input type="checkbox" name="ajax" id="ajax"/>
					</li>
				</ul>
				<input type="submit" value="Store"/>
			</form>
		</fieldset>
	</body>
</html>


