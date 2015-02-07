<?php
	function renderTitle($paramName, $title = null) {
		echo "<td" . (isset($title) ? " title='{$title}'" : "") . ">$paramName</td>";
	}
	function renderListMultiple1($paramName, $options, $pArray, $pName) {
		echo "	<td>";
		echo "		<select name='{$pName}_{$paramName}[]' multiple='multiple'>";
		echo "			<option value='' " . (!isset($pArray[$paramName]) ? "selected " : "") . "></option>";
		foreach ($options as $key => $val) {
			echo "			<option value='$key' " . (isset($pArray[$paramName]) && strrpos(",".$pArray[$paramName].",", ",".$key.",") !== false ? "selected " : "") . ">$val</option>";
		}
		echo "		</select>";
		echo "	</td>";
	}
	function renderListMultiple($paramName, $options, $pdf, $pob, $title = null) {

		echo "<tr>";
		renderTitle($paramName, $title);
		renderListMultiple1($paramName, $options, $pdf, 'pdf');
		renderListMultiple1($paramName, $options, $pob, 'pob');
		echo "<td><input type='submit' value='Store'/></td>";			
		echo "</tr>";
	}
	function renderList1($paramName, $options, $pArray, $pName) {
		echo "	<td>";
		echo "		<select name='{$pName}_{$paramName}'>";
		echo "			<option value='' " . (!isset($pArray[$paramName]) ? "selected " : "") . "></option>";
		foreach ($options as $key => $val) {
			echo "			<option value='$key' " . (isset($pArray[$paramName]) && $pArray[$paramName] == $key ? "selected " : "") . ">$val</option>";
		}
		echo "		</select>";
		echo "	</td>";
	}
	function renderList($paramName, $options, $pdf, $pob, $title = null) {

		echo "<tr>";
		renderTitle($paramName, $title);
		renderList1($paramName, $options, $pdf, 'pdf');
		renderList1($paramName, $options, $pob, 'pob');
		echo "<td><input type='submit' value='Store'/></td>";			
		echo "</tr>";
	}
	function renderText1($paramName, $pArray, $pName) {
		echo "	<td>";
		echo "		<input type='text' name='{$pName}_{$paramName}' value='{$pArray[$paramName]}'>";
		echo "	</td>";
	}
	function renderText($paramName, $pdf, $pob, $title = null) {

		echo "<tr>";
		renderTitle($paramName, $title);
		renderText1($paramName, $pdf, 'pdf');
		renderText1($paramName, $pob, 'pob');
		echo "<td><input type='submit' value='Store'/></td>";			
		echo "</tr>";
	}
	function renderTextarea1($paramName, $pArray, $pName) {
		echo "	<td>";
		echo "		<textarea rows='3' cols='80' name='{$pName}_{$paramName}'>{$pArray[$paramName]}</textarea>";
		echo "	</td>";
	}
	function renderTextarea($paramName, $pdf, $pob, $title = null) {

		echo "<tr>";
		renderTitle($paramName, $title);
		renderTextarea1($paramName, $pdf, 'pdf');
		renderTextarea1($paramName, $pob, 'pob');
		echo "<td><input type='submit' value='Store'/></td>";			
		echo "</tr>";
	}
	function renderBool1($paramName, $pArray, $pName, $title = null) {
		echo "	<td>";
		$checked = "";
		if ($pArray[$paramName] == "on") {
			$checked = " checked ";
		}
		echo "		<input type='checkbox' name='{$pName}_{$paramName}' value='{$pName}_{$paramName}' {$checked}>";
		echo "	</td>";
	}
	function renderBool($paramName, $pdf, $pob) {

		echo "<tr>";
		renderTitle($paramName, $title);
		renderBool1($paramName, $pdf, 'pdf');
		renderBool1($paramName, $pob, 'pob');
		echo "<td><input type='submit' value='Store'/></td>";			
		echo "</tr>";
	}
	function readValueFromDB($id, $type, $paramName) {
		global $databaseHandler;
		$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_{$type}_id = {$id} AND ppr_name = ? ";
		$rows = $databaseHandler->queryPrepared($query, false, "s", array($paramName));
		if ($rows && count($rows)>0) {
			$res = $rows[0]['ppr_value'];
		} else {
			$res = NULL;
		}
		return $res;
	}
	function storeInDB($id, $type, $paramName, $paramValue) {
		global $databaseHandler;
		if (isset($_POST["{$type}_{$paramName}"]) && is_array($_POST["{$type}_{$paramName}"])) {
			$_POST["{$type}_{$paramName}"] = implode(',', $_POST["{$type}_{$paramName}"]);
		}
		if (isset($_POST["{$type}Id"]) && $paramValue != $_POST["{$type}_{$paramName}"]) {
			if (!isset($_POST["{$type}_{$paramName}"]) || $_POST["{$type}_{$paramName}"] == "") {
				$query = "DELETE FROM prt_portlet_parameters WHERE ppr_{$type}_id = {$id} AND ppr_name = ?";
				$databaseHandler->queryPrepared($query, false, "s", array($paramName));			
			} else {
				if (isset($paramValue)) {
					$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_{$type}_id = {$id} AND ppr_name = ?";
				} else {
					$query = "INSERT INTO prt_portlet_parameters (ppr_value, ppr_name, ppr_{$type}_id) VALUES (?, ?, {$id})";
				}
				$databaseHandler->queryPrepared($query, false, "ss", array($_POST["{$type}_{$paramName}"], $paramName));			
			}
			return $_POST["{$type}_{$paramName}"];
		}
		return $paramValue;
	}
	function readAndStore($id, $type, $paramName) {
		$value = readValueFromDB($id, $type, $paramName);
		return storeInDB($id, $type, $paramName, $value);
	}
	function readAndStoreAll($pdfId, $pobId, &$pdf, &$pob, $paramName) {
			$pdf[$paramName] = readAndStore($pdfId, 'pdf', $paramName);
			$pob[$paramName] = readAndStore($pobId, 'pob', $paramName);
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
fieldset {
	border-top: 1px solid LightGrey;
	border-bottom: none;
	border-left: none;
	border-right: none;
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
	padding: 0px;
}
</style>
<?php
	if (isset($_POST['plcId'])) {
		$plcId = $_POST['plcId'];
	} elseif (isset($_GET['plcId'])) {
		$plcId = $_GET['plcId'];
	} else {
		echo "No portlet location to configure.";
		exit();
	}
	if (isset($_POST['pobId'])) {
		$pobId = $_POST['pobId'];
	} elseif (isset($_GET['pobId'])) {
		$pobId = $_GET['pobId'];
	} else {
		echo "No portlet object to configure.";
		exit();
	}

//	require_once(dirname(__FILE__).'/../../classes/DatabaseHandler/DatabaseHandler.php');
	$databaseHandler = new DatabaseHandler();
	
	function applyPermission($pobId, $rleId, $action, $allow, $block) {
		global $databaseHandler;
		if ($allow == "on") {
			if ($block == "on") { 
				echo "Make up your mind: allowed or blocked?";
				return;
			} else {
				$permission = 1;
			}
		} else {
			if ($block == "on") { 
				$permission = 0;
			} else {
				$permission = NULL;
			}
		}
		$query = " SELECT prm_{$action} perm FROM prt_permissions WHERE prm_pob_id = {$pobId} AND prm_rle_id = {$rleId} AND prm_action IS NULL ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		$row = mysqli_fetch_row($result);
		mysqli_free_result($result);
		$check = false;
		if ($row) { 
			$perm = $row[0];
			if (!isset($permission)) {
				if (!isset($perm)) {
					return; // nothing to do here
				} else {
					$query = " UPDATE prt_permissions SET prm_{$action} = NULL WHERE prm_pob_id = {$pobId} AND prm_rle_id = {$rleId} ";				
					$check = true;
				}
			} else {
				if ($permission !== $perm) {
					$query = " UPDATE prt_permissions SET prm_{$action} = {$permission} WHERE prm_pob_id = {$pobId} AND prm_rle_id = {$rleId} ";
				} else {
					return;
				}
			}
		} else {
			if (!isset($permission)) {
				return; // nothing to do here
			} else {
				$query = " INSERT INTO prt_permissions (prm_pob_id, prm_rle_id, prm_{$action}) VALUES ({$pobId}, {$rleId}, {$permission}) ";
			}
		}
		$databaseHandler->query($query);
		echo $databaseHandler->error();
		if ($check) {
			$query = " DELETE FROM prt_permissions WHERE prm_view IS NULL AND prm_edit IS NULL and prm_configure IS NULL AND prm_pob_id = {$pobId} AND prm_rle_id = {$rleId} ";
			$databaseHandler->query($query);
			echo $databaseHandler->error();
		}
	}


	$query = " SELECT pdf_namespace, pdf_alias, pob_custom_title, plc_section, pob_show_title, pob_left, pob_top, pob_width, pob_height, pob_inline, pob_ajax, pob_render_condition, pob_autorefresh, plc_position, plc_pge_id, pob_pob_id FROM prt_portlet_definitions, prt_portlet_objects, prt_portlet_locations WHERE plc_pob_id = pob_id AND pob_pdf_id = pdf_id AND plc_id = {$plcId}";
	$result = $databaseHandler->query($query);
	$error = $databaseHandler->error();
	if (isset($error) && trim($error) != "" ) {
		$databaseHandler->query("ALTER TABLE `prt_portlet_objects` ADD COLUMN `pob_pob_id` int(11) default NULL AFTER pob_pdf_id");
		echo $databaseHandler->error();
		$databaseHandler->query($query);
		$error = $databaseHandler->error();
		if (is_null($error) || trim($error) == "") {
?>
<script type="text/javascript">location.reload();</script>
<?php	
			exit();		
		} else {
			echo $error;
		}
	}
	echo $databaseHandler->error();
	$row = mysqli_fetch_row($result);
	mysqli_free_result($result);
	$namespace = $row[0];
	$portletName = $row[1];
	$title = $row[2];
	$section = $row[3];
	$showTitle = $row[4];
	$left = $row[5];
	$top = $row[6]; 
	$width = $row[7];
	$height = $row[8]; 
	$inline = $row[9];
	$ajax = $row[10]; 
	$renderCondition = $row[11]; 
	$autoRefresh = $row[12]; 
	$position = $row[13]; 
	$plcPgeId = $row[14]; 
	$syncPobId = $row[15];
	
	$action = $_POST['action'];
	if (isset($action)) {
		switch ($action) {
			case 'delete': 
				$query = " DELETE FROM prt_portlet_locations WHERE plc_id = {$plcId} ";
				break;
			case 'hardDelete': 
				$query = " DELETE FROM prt_portlet_locations WHERE plc_pob_id = {$pobId} ";
				$databaseHandler->query($query);
				$query = " DELETE FROM prt_portlet_objects WHERE pob_id = {$pobId} ";
				echo $databaseHandler->error();
				break;
			case 'script_gen':
				$title = $_POST['title'];
				if (trim($title) == "") {
					$title = null;
				}
				$query = <<<SQL
SELECT 
	CONCAT("('", ppr_name, "', '", ppr_value, "', {\$pobId})") 
FROM 
	prt_portlet_parameters 
WHERE 
	ppr_pob_id = {$pobId}
SQL;
				$result = $databaseHandler->query($query);
				echo $databaseHandler->error();
				echo "<textarea id='script_gen' style='font-family: Courier; margin: 10px 0px; width: 100%; height: 100px; border: 1px dotted grey; color: darkblue; background-color: lightgrey; font-weight: bold;'>";				
				if (isset($title)) {
					echo "if (isset(\$title) && trim(\$title) == \"$title\") {\r\n";
				}
				echo "\t\$query = <<<SQL\r\nINSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES \r\n";
				$first = true;
				while ($row = mysqli_fetch_row($result)) {
					if ($first) {
						$first = false;
					} else {
						echo ",\r\n";
					}
					echo $row[0];
				}
				echo "\r\nSQL;\r\n\tQ(\$query);\r\n";
				if (isset($title)) {
					echo "}";
				}
				echo "</textarea><script type='text/javascript'>document.getElementById('script_gen').focus();document.getElementById('script_gen').select();</script>";
				mysqli_free_result($result);
				break;
			case 'less': 
				$query = <<<SQL
SELECT
	orig.plc_order old_order, 
	IFNULL(MAX(lower.plc_order), orig.plc_order - 1) new_order,
	orig.plc_pge_id, 
	orig.plc_section
FROM 
	prt_portlet_locations orig,  
	prt_portlet_locations lower  
WHERE 
	orig.plc_id = {$plcId}
	AND lower.plc_order < orig.plc_order
	AND (lower.plc_pge_id  = orig.plc_pge_id 
		OR ((lower.plc_pge_id IS NULL OR orig.plc_pge_id IS NULL) AND lower.plc_prt_id = orig.plc_prt_id)
		)
	AND lower.plc_section  = orig.plc_section
SQL;
				$result = $databaseHandler->query($query);
				echo $databaseHandler->error();
				$row = mysqli_fetch_row($result);
				mysqli_free_result($result);
				$oldOrder = $row[0];
				$newOrder = $row[1];
				$pgeId = $row[2];
				$section = $row[3];
				$query = " UPDATE prt_portlet_locations SET plc_order = {$oldOrder} WHERE plc_pge_id = {$pgeId} AND plc_section = ? AND plc_order = {$newOrder}; ";
				$databaseHandler->queryPrepared($query, false, "s", array($section));
				echo $databaseHandler->error();
				$query = " UPDATE prt_portlet_locations SET plc_order = {$newOrder} WHERE plc_id = {$plcId};  ";
				break;
			case 'more': 
				$query = <<<SQL
SELECT
	orig.plc_order old_order, 
	IFNULL(MIN(higher.plc_order), orig.plc_order + 1) new_order,
	orig.plc_pge_id, 
	orig.plc_section
FROM 
	prt_portlet_locations orig,  
	prt_portlet_locations higher  
WHERE 
	orig.plc_id = {$plcId}
	AND higher.plc_order > orig.plc_order
	AND (higher.plc_pge_id  = orig.plc_pge_id 
		OR ((higher.plc_pge_id IS NULL OR orig.plc_pge_id IS NULL) AND higher.plc_prt_id = orig.plc_prt_id)
		)
	AND higher.plc_section  = orig.plc_section
SQL;
				$result = $databaseHandler->query($query);
				echo $databaseHandler->error();
				$row = mysqli_fetch_row($result);
				mysqli_free_result($result);
				$oldOrder = $row[0];
				$newOrder = $row[1];
				$pgeId = $row[2];
				$section = $row[3];
				$query = " UPDATE prt_portlet_locations SET plc_order = {$oldOrder} WHERE plc_pge_id = {$pgeId} AND plc_section = ? AND plc_order = {$newOrder} ";
				$databaseHandler->queryPrepared($query, false, "s", array($section));
				echo $databaseHandler->error();
				$query = " UPDATE prt_portlet_locations SET plc_order = {$newOrder} WHERE plc_id = {$plcId} ";
				break;
			case 'permissions':
				$query = " SELECT rle_id FROM prt_roles WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
				$result = $databaseHandler->query($query);
				echo $databaseHandler->error();
				while ($row = mysqli_fetch_row($result)) {
					applyPermission($pobId, $row[0], 'view', $_POST["view_allow_{$row[0]}"], $_POST["view_block_{$row[0]}"]);
					applyPermission($pobId, $row[0], 'edit', $_POST["edit_allow_{$row[0]}"], $_POST["edit_block_{$row[0]}"]);
					applyPermission($pobId, $row[0], 'configure', $_POST["configure_allow_{$row[0]}"], $_POST["configure_block_{$row[0]}"]);
				}
				mysqli_free_result($result);
				break;
			case 'portlet':
				if (isset($_POST['title']) && trim($_POST['title']) != "" && trim($_POST['title']) != $title) {
					$title = trim($_POST['title']);					
					$query = " UPDATE prt_portlet_objects SET pob_custom_title = ? WHERE pob_id = {$pobId} ";
					$databaseHandler->queryPrepared($query, false, "s", array($title));
					echo $databaseHandler->error();
				} else {
					if (isset($title) && (!isset($_POST['title']) || trim($_POST['title']) == "")) {
						$query = " UPDATE prt_portlet_objects SET pob_custom_title = NULL WHERE pob_id = {$pobId} AND pob_custom_title IS NOT NULL";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
						$title = NULL;
					}
				}
				if (isset($_POST['section']) && trim($_POST['section']) != "" && trim($_POST['section']) != $section) {
					$section = trim($_POST['section']);
					$query = " UPDATE prt_portlet_locations SET plc_section = ? WHERE plc_id = {$plcId} ";
					$databaseHandler->queryPrepared($query, false, "s", array($section));
					echo $databaseHandler->error();
				}
				if ($showTitle == 1) {
					if ($_POST['showTitle'] != "on") {
						$showTitle = 0;
						$query = " UPDATE prt_portlet_objects SET pob_show_title = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				} else {
					if ($_POST['showTitle'] == "on") {
						$showTitle = 1;
						$query = " UPDATE prt_portlet_objects SET pob_show_title = 1 WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($left)) {
					if (isset($_POST['left']) && trim($_POST['left']) != "") {
						if ($left != trim($_POST['left'])) {
							$left = trim($_POST['left']); 
							$query = " UPDATE prt_portlet_objects SET pob_left = {$left} WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$left = "";
						$query = " UPDATE prt_portlet_objects SET pob_left = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
				} else {
					if (isset($_POST['left']) && trim($_POST['left']) != "") {
						$left = trim($_POST['left']); 
						$query = " UPDATE prt_portlet_objects SET pob_left = {$left} WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($top)) {
					if (isset($_POST['top']) && trim($_POST['top']) != "") {
						if ($top != trim($_POST['top'])) {
							$top = trim($_POST['top']); 
							$query = " UPDATE prt_portlet_objects SET pob_top = {$top} WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$top = "";
						$query = " UPDATE prt_portlet_objects SET pob_top = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
				} else {
					if (isset($_POST['top']) && trim($_POST['top']) != "") {
						$top = trim($_POST['top']); 
						$query = " UPDATE prt_portlet_objects SET pob_top = {$top} WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($width)) {
					if (isset($_POST['width']) && trim($_POST['width']) != "") {
						if ($width != trim($_POST['width'])) {
							$width = trim($_POST['width']); 
							$query = " UPDATE prt_portlet_objects SET pob_width = {$width} WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$width = "";
						$query = " UPDATE prt_portlet_objects SET pob_width = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
				} else {
					if (isset($_POST['width']) && trim($_POST['width']) != "") {
						$width = trim($_POST['width']); 
						$query = " UPDATE prt_portlet_objects SET pob_width = {$width} WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($height)) {
					if (isset($_POST['height']) && trim($_POST['height']) != "") {
						if ($height != trim($_POST['height'])) {
							$height = trim($_POST['height']); 
							$query = " UPDATE prt_portlet_objects SET pob_height = {$height} WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$height = "";
						$query = " UPDATE prt_portlet_objects SET pob_height = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
					
				} else {
					if (isset($_POST['height']) && trim($_POST['height']) != "") {
						$height = trim($_POST['height']); 
						$query = " UPDATE prt_portlet_objects SET pob_height = {$height} WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($_POST['inline']) && $_POST['inline'] == "on") {
					if ($inline) {
					} else {
						$inline = true;
						$query = " UPDATE prt_portlet_objects SET pob_inline = 1 WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				} else if (!isset($_POST['inline']) || (isset($_POST['inline']) && $_POST['inline'] != "on")) {
					if ($inline) {
						$inline = false;
						$query = " UPDATE prt_portlet_objects SET pob_inline = 0 WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					} else {
					}
				}
				if (isset($_POST['ajax']) && $_POST['ajax'] == "on") {
					if ($ajax) {
					} else {
						$ajax = true;
						$query = " UPDATE prt_portlet_objects SET pob_ajax = 1 WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				} else if (!isset($_POST['ajax']) || (isset($_POST['ajax']) && $_POST['ajax'] != "on")) {
					if ($ajax) {
						$ajax = false;
						$query = " UPDATE prt_portlet_objects SET pob_ajax = 0 WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					} else {
					}
				}
				if (isset($renderCondition)) {
					if (isset($_POST['renderCondition']) && trim($_POST['renderCondition']) != "") {
						if ($renderCondition != trim($_POST['renderCondition'])) {
							$renderCondition = trim($_POST['renderCondition']); 
							$query = " UPDATE prt_portlet_objects SET pob_render_condition = '{$renderCondition}' WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$renderCondition = "";
						$query = " UPDATE prt_portlet_objects SET pob_render_condition = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
				} else {
					if (isset($_POST['renderCondition']) && trim($_POST['renderCondition']) != "") {
						$renderCondition = trim($_POST['renderCondition']); 
						$query = " UPDATE prt_portlet_objects SET pob_render_condition = '{$renderCondition}' WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($autoRefresh)) {
					if (isset($_POST['autoRefresh']) && trim($_POST['autoRefresh']) != "") {
						if ($autoRefresh != trim($_POST['autoRefresh'])) {
							$autoRefresh = trim($_POST['autoRefresh']); 
							$query = " UPDATE prt_portlet_objects SET pob_autorefresh = '{$autoRefresh}' WHERE pob_id = {$pobId} ";
							$databaseHandler->query($query);
							echo $databaseHandler->error();
						}
					} else {
						$autoRefresh = "";
						$query = " UPDATE prt_portlet_objects SET pob_autorefresh = NULL WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error(); 
					}
				} else {
					if (isset($_POST['autoRefresh']) && trim($_POST['autoRefresh']) != "") {
						$autoRefresh = trim($_POST['autoRefresh']); 
						$query = " UPDATE prt_portlet_objects SET pob_autorefresh = '{$autoRefresh}' WHERE pob_id = {$pobId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				}
				if (isset($plcPgeId)) {
					if (isset($_POST['allPages']) && $_POST['allPages'] == "1") {
						$query = " UPDATE prt_portlet_locations SET plc_pge_id = NULL WHERE plc_id = {$plcId} ";
						$databaseHandler->query($query);
						echo $databaseHandler->error();
					}
				} else {
					if (!isset($_POST['allPages']) || $_POST['allPages'] != "1") {
						echo "jeszcze nie ma zmiany w druga strone (bez page na z pagem) bo nie przekazujemy pgeId ";
//						$query = " UPDATE prt_portlet_locations SET plc_pge_id = tutaj WHERE plc_id = {$plcId} ";
//						$databaseHandler->query($query);
//						echo $databaseHandler->error();
					}
				}
				if (isset($_POST['position'])) {
					$position = trim($_POST['position']);
					$query = " UPDATE prt_portlet_locations SET plc_position = {$position} WHERE plc_id = {$plcId} ";
					$databaseHandler->query($query);
					echo $databaseHandler->error();
				}
				if (isset($syncPobId)) {
					if (isset($_POST['sync_pob_id'])) {
						if ($syncPobId != $_POST['sync_pob_id']) {
							$query = " UPDATE prt_portlet_objects SET pob_pob_id = {$_POST['sync_pob_id']} WHERE pob_id = {$pobId} ";
						} else {
							$query = "";
						}
					} else {
						$query = " UPDATE prt_portlet_objects SET pob_pob_id = NULL WHERE pob_id = {$pobId} ";
					}
				} else {
					if (isset($_POST['sync_pob_id'])) {
						$query = " UPDATE prt_portlet_objects SET pob_pob_id = {$_POST['sync_pob_id']} WHERE pob_id = {$pobId} ";
					} else {
						$query = "";
					}
				}
				$databaseHandler->query($query);
				echo $databaseHandler->error();
				break;
		}
		$databaseHandler->query($query);
		echo $databaseHandler->error();
		echo "<div onclick='this.style.display=\"none\";' style='border: 2px solid red; color: red; font-weight: bold; background-color: yellow; padding: 5px; margin: 0px 0px 5px 0px;'>Action executed - " . date("Y-m-d H:i:s") . "</div>";
	}
?>
		<form method="post">
			<input type="hidden" name="action" value="portlet"/>
			<table class="params">
				<tr>
					<th>Namespace</th>
					<th>Portlet name</th>
					<th>Show title</th>
					<th>Portlet object title</th>
					<th style="width: 80px;">Position</th>
					<th style="width: 80px;">Size</th>
					<th>Section</th>
					<th>Inline</th>
					<th>Ajax</th>
					<td></td>
				</tr>
				<tr>
					<td><?php echo $namespace ?></td>
					<td><?php echo $portletName ?></td>
					<td><input type="checkbox" name="showTitle" <?php echo $showTitle == 1 ? " checked='checked' " : "" ?>/></td>
					<td><input type="text" name="title" value="<?php echo $title ?>"/></td>
					<td>
						<input id="left" type="text" size="4" name="left" value="<?php echo $left ?>"/> <!--<input type="button" onclick="document.getElementById('width').value='<?php echo $_GET['actualWidth'] ?>'" value="<?php echo $_GET['actualWidth'] ?>"> -->
						<input id="top" type="text" size="4" name="top" value="<?php echo $top ?>"/>
					</td>
					<td>
						<input id="width" type="text" size="4" name="width" value="<?php echo $width ?>"/> <!--<input type="button" onclick="document.getElementById('height').value='<?php echo $_GET['actualHeight'] ?>'" value="<?php echo $_GET['actualHeight'] ?>"> -->
						<input id="height" type="text" size="4" name="height" value="<?php echo $height ?>"/>
					</td>
					<td><input type="text" name="section" value="<?php echo $section ?>"/></td>
					<td><input type="checkbox" name="inline" <?php echo $inline ? "checked" : "" ?>/></td>
					<td><input type="checkbox" name="ajax" <?php echo $ajax ? "checked" : "" ?>/></td>
					<td><input type="submit" value="Store"/></td>
				</tr>
				<tr>
					<td>Render condition</td>
					<td colspan="8">
						<textarea name="renderCondition" rows="3" cols="76"><?php echo $renderCondition ?></textarea>AuRefr:<input type="text" name="autoRefresh" size="2" value="<?php echo $autoRefresh ?>"/>AllPages:<input type="checkbox" name="allPages" value="1" <?php echo isset($plcPgeId) ? "" : " checked='checked' " ?>> 
						Sync to:
						<select name="sync_pob_id">
							<option></option>
<?php
				$query = <<<SQL
SELECT
  pob_id,
  pdf_name,
  pob_custom_title
FROM 
  prt_portlet_locations,
  prt_portlet_objects,
  prt_portlet_definitions
WHERE 
  pob_id = plc_pob_id
  AND plc_id != {$plcId}
  AND plc_pge_id = (SELECT plc_pge_id FROM prt_portlet_locations WHERE plc_id = {$plcId})
  AND  pdf_id = pob_pdf_id
SQL;
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[0] == $syncPobId) {
				$selected = " selected='selected' ";
			} else {
				$selected = "";
			}
?>
			<option value="<?php echo $row[0] ?>" <?php echo $selected ?>><?php echo $row[1] ?>: "<?php echo $row[2] ?>"</option>
<?php
		}
		mysqli_free_result($result);
?>							
						</select>
					</td>
					<td>
						Position:<br>
						<select name="position">
							<option style="text-align: left;" value="-1" <?php echo $position == -1 ? " selected='selected' " : "" ?>>left</option>
							<option style="text-align: center;" value="0" <?php echo $position == 0 ? " selected='selected' " : "" ?>>center</option>
							<option style="text-align: right;" value="1" <?php echo $position == 1 ? " selected='selected' " : "" ?>>right</option>
						</select>
					</td>
				</tr>
			</table>
		</form>
		<fieldset>
			<legend>Portlet location operations</legend>
			<form method="post">
				<input type="hidden" name="action"/>
				<input type="hidden" name="plcId" value="<?php echo $plcId ?>"/>
				<input type="submit" value="Delete" onclick="this.form.action.value='delete'; this.form.submit;"/>
				<input type="submit" value="Move Up/Left" onclick="this.form.action.value='less'; this.form.submit;"/>
				<input type="submit" value="Move Down/Right" onclick="this.form.action.value='more'; this.form.submit;"/>
				<input type="submit" value="HARD Delete" onclick="this.form.action.value='hardDelete'; this.form.submit;"/>
			</form>
		</fieldset>
		<fieldset>
			<legend>Permissions</legend>
			<form method="post">
				<input type="hidden" name="action" value="permissions">
				<input type="hidden" name="plcId" value="<?php echo $plcId ?>"/>
				<table>
					<tr>
						<td colspan="3">
							Allowed to
						</td>
					</tr>
					<tr>
						<td>View</td>
						<td>Edit</td>
						<td>Configure</td>
					</tr>
					<tr>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_view, 0) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "1") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="view_allow_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_edit, 0) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "1") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="edit_allow_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_configure, 0) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "1") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="configure_allow_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							Blocked to
						</td>
					</tr>
					<tr>
						<td>View</td>
						<td>Edit</td>
						<td>Configure</td>
					</tr>
					<tr>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_view, 1) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "0") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="view_block_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_edit, 1) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "0") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="edit_block_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
						<td>
							<ul>
<?php
		$query = " SELECT rle_id, rle_name, IFNULL(prm_configure, 1) FROM prt_roles LEFT OUTER JOIN prt_permissions ON prm_rle_id = rle_id AND prm_pob_id = {$pobId} AND prm_action IS NULL WHERE IFNULL(rle_virgo_deleted, 0) = 0 ";
		$result = $databaseHandler->query($query);
		echo $databaseHandler->error();
		while ($row = mysqli_fetch_row($result)) {
			if ($row[2] == "0") {
				$checked = "checked='checked'";
			} else {
				$checked = "";
			}
?>
			<li><input type="checkbox" name="configure_block_<?php echo $row[0] ?>" <?php echo $checked ?>><?php echo $row[1] ?></li>
<?php
		}
		mysqli_free_result($result);
?>						
							</ul>
						</td>
					</tr>
				</table>
				<input type="submit" value="Store"/>
			</form>
		</fieldset>
<?php
	$pdf = array();
	$pob = array();
	if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$portletName.DIRECTORY_SEPARATOR.'params.php')) {
		require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$portletName.DIRECTORY_SEPARATOR.'params.php');
	} else {
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.'params.php')) {
			require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.'params.php');
		}
	}
?>		
		<form method="post">
			<input type="hidden" name="plcId" value="<?php echo $plcId ?>"/>
			<input type="hidden" name="title" value="<?php echo $title ?>"/>
			<input type="hidden" name="action" value="script_gen"/>
			<input type="submit" value="Generate configuration script"/>
		</form>
	</body>
</html>


