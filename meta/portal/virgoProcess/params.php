<?php
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>virgo parameters</title>
	</head>
	<body>
<style type="text/css">
table, input, textarea {
	font-size: 10px;
}
table, input {
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
.checkbox {
	margin: 0px;
}
table.perm, div.perm {
	font-size: 6px;
	display: inline;
}
table.perm input, table.perm tr, table.perm td {
	padding: 0px;
	margin: 0px;
}
table.perm td.neutral {
	background-color: LightGrey;
}
table.perm td.allowed {
	background-color: LightGreen;
}
table.perm td.blocked {
	background-color: Red;
}
div.action {
  font-size: 8px;
  padding: 0px 1px;
}
div.quick_links a {
	font-size: 9px;
}
</style>
<div class="quick_links">
<a href="#action_permissions">Permissions</a>
<a href="#table_columns">Table columns</a>
<a href="#create_columns">Create columns</a>
<a href="#form_columns">Form columns</a>
<a href="#view_columns">View columns</a>
</div>
<form method="post">
<?php
//	require_once(dirname(__FILE__).'/../../../classes/DatabaseHandler/DatabaseHandler.php');
	$databaseHandler = new DatabaseHandler();
	
	function isa($roleId, $prtId, $action) {
		global $databaseHandler;
		$query = " SELECT prm_execute FROM prt_permissions WHERE prm_rle_id = {$roleId} AND prm_pob_id = {$prtId} AND prm_action = ?";
		$result = $databaseHandler->queryPrepared($query, false, "s", array($action));
		echo $databaseHandler->error() == "" ? "" : $databaseHandler->error() . " " . $query;
		if ($result !== false) {
			foreach ($result as $res) {
				return $res;
			}
		} else {
			return null;
		}
	}

	function actionPermissions($action, $id, $name, $pobId) {
				if (isset($_POST['pobId'])) {
					zapiszPozwolenieRole($pobId, $action, $id, $name);
				}
?>				
				<td class="action">
					<div class="action"><?php echo $action ?></div>
					<table class="action">
						<tr>
							<td class="<?php echo perm($id, $pobId, $action, NULL) ? 'neutral' : '' ?>"><input type="radio" name="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>" id="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>_" value="NULL" <?php echo perm($id, $pobId, $action, NULL) ? " checked='checked' " : "" ?>/></td>
							<td class="<?php echo perm($id, $pobId, $action, 1) ? 'allowed' : '' ?>"><input type="radio" name="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>" id="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>_1" value="1" <?php echo perm($id, $pobId, $action, 1) ? " checked='checked' " : "" ?>/></td>
							<td class="<?php echo perm($id, $pobId, $action, 0) ? 'blocked' : '' ?>"><input type="radio" name="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>" id="<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>_0" value="0" <?php echo perm($id, $pobId, $action, 0) ? " checked='checked' " : "" ?>/></td>
							<td width="100%"></td>				
						</tr>
					</table>
				</td>
<?php
	}

	function setPermissions($action, $id, $pobId) {
?>		
var e = document.getElementById('<?php echo $action ?>_<?php echo $id ?>_<?php echo $pobId ?>_' + this.value); e.checked = true;		
<?php
	}
		
	function zapiszPozwolenieRole($id, $action, $roleId, $name) {
		global $databaseHandler;
		$query = " SELECT prm_execute FROM prt_permissions WHERE prm_rle_id = {$roleId} AND prm_pob_id = {$id} AND prm_action = ?";
		$result = $databaseHandler->queryPrepared($query, false, "s", array($action));
		echo $databaseHandler->error() == "" ? "" : $databaseHandler->error() . " " . $query;
		$row = null;
		foreach ($result as $row) {
			break;
		}
		$query = null;
		if ($_POST["{$action}_{$roleId}_{$id}"] == "NULL") {
			if (isset($row)) {	
				if (isset($row['prm_execute'])) {
					$query = " UPDATE prt_permissions SET prm_execute = NULL WHERE prm_rle_id = {$roleId} AND prm_pob_id = {$id} AND prm_action = ? ";
					$checkNull = true;
				}
			}
		} else {
			$val = $_POST["{$action}_{$roleId}_{$id}"];
			if (is_null($row)) {
				$query = " INSERT INTO prt_permissions (prm_execute, prm_rle_id, prm_pob_id, prm_action) VALUES ({$val}, {$roleId}, {$id}, ?) ";
			} else {
				if ($row['prm_execute'] != $val) {
					$query = " UPDATE prt_permissions SET prm_execute = {$val} WHERE prm_rle_id = {$roleId} AND prm_pob_id = {$id} AND prm_action = ? ";
				}
			}
		}
		if (isset($query)) {
			$databaseHandler->queryPrepared($query, false, "s", array($action));
			echo $databaseHandler->error() == "" ? "" : $databaseHandler->error() . " " . $query;
		}
	}

	function perm($roleId, $prtId, $action, $value) {
		$row = isa($roleId, $prtId, $action);
		if ($row) {
			if (is_null($row['prm_execute'])) {
				return !isset($value);
			} else {
				if (!isset($value)) {
					return false;
				} else {
					return $row['prm_execute'] == $value;
				}
			}
			
		} else {
			return !isset($value);
		}
	}	
	$newAction = $_POST['newAction'];
	if (isset($newAction) && trim($newAction) != "") {
		$query = " INSERT INTO prt_permissions (prm_rle_id, prm_pob_id, prm_action, prm_execute) SELECT rle_id, pob_id, '{$newAction}', NULL FROM prt_roles, prt_portlet_objects WHERE pob_id = {$pobId} ";
		$databaseHandler->query($query);
	}
	$codeActions = array();	
	$types = "";
	$codeActions[] = "Add";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Delete";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "DeleteSelected";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "EditSelected";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "ExecuteNow";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Export";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Form";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Offline";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Report";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "SearchForm";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "StoreAndExecuteNow";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "StoreSelected";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "UpdateTitle";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "Upload";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "View";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "VirgoDown";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActions[] = "VirgoUp";
	$codeActionStrings[] = "?";
	$types .= "s";
	$codeActionsString = implode(", ", $codeActionStrings);
	$query = "
SELECT 
	DISTINCT prm_action 
FROM 
	prt_permissions 
WHERE 
	prm_pob_id = {$pobId} 
	AND prm_action IS NOT NULL 
	AND prm_action NOT IN ({$codeActionsString})
";
	
	$result = $databaseHandler->queryPrepared($query, false, $types, $codeActions);
	$extraActions = array();
	foreach ($result as $row) {
		$extraActions[] = $row[0];
	}
	$query = "
SELECT 
	pdf_alias,
	pdf_id 
FROM 
	prt_portlet_definitions
	LEFT OUTER JOIN prt_portlet_objects ON pob_pdf_id = pdf_id
WHERE pob_id = {$pobId} ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
	$alias = $row['pdf_alias'];
	$pdfId = $row['pdf_id']
?>
	<input type="hidden" name="pobId" value="<?php echo $pobId ?>">
	<table class="params">
		<tr>
			<th>Parameter name</th>
			<th>Portlet definition value</th>
			<th>Portlet object value</th>
			<th></th>
		</tr>
<?php
	switch ($alias) {
		case 'virgoProcess':
?>
<tr class="spacer"><td colspan="4" id="component_mode">Component mode</td></tr>
<?php
			$options = array();
			$options["0"] = "CRUD Table";
			$options["1"] = "Only creation form";
			$options["7"] = "Only view data (record selection must be programmed)";
			$options["2"] = "Search by default";
			$options["5"] = "Only edition form (1 record/user)";
			$options["6"] = "Edit user data";
?>
<?php
			$types = "s";
			$values = array('form_only');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_form_only = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_form_only = $res;
			$postValue = $_POST['pdf_form_only'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_form_only != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(form_only);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_form_only)) {
						$values = array($postValue, form_only);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(form_only, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('form_only');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_form_only = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_form_only = $res;
			}
			$postValue = $_POST['pob_form_only'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_form_only != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(form_only);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_form_only)) {
						$values = array($postValue, form_only);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(form_only, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('form_only');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_form_only = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_form_only = $res;
			}
?>
		<tr>
			<td title="">
					form_only
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_form_only" >
						<option value="" <?php echo !isset($pdf_form_only) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_form_only) && strrpos(",".$pdf_form_only.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_form_only" value="<?php echo $pdf_form_only ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_form_only" >
						<option value="" <?php echo !isset($pob_form_only) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_form_only) && strrpos(",".$pob_form_only.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_form_only" value="<?php echo $pob_form_only ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No, records from all users";
			$options["1"] = "Yes, logged in user created only";
?>	
<?php
			$types = "s";
			$values = array('only_private_records');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_only_private_records = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_only_private_records = $res;
			$postValue = $_POST['pdf_only_private_records'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_only_private_records != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(only_private_records);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_only_private_records)) {
						$values = array($postValue, only_private_records);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(only_private_records, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('only_private_records');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_only_private_records = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_only_private_records = $res;
			}
			$postValue = $_POST['pob_only_private_records'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_only_private_records != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(only_private_records);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_only_private_records)) {
						$values = array($postValue, only_private_records);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(only_private_records, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('only_private_records');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_only_private_records = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_only_private_records = $res;
			}
?>
		<tr>
			<td title="">
					only_private_records
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_only_private_records" >
						<option value="" <?php echo !isset($pdf_only_private_records) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_only_private_records) && strrpos(",".$pdf_only_private_records.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_only_private_records" value="<?php echo $pdf_only_private_records ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_only_private_records" >
						<option value="" <?php echo !isset($pob_only_private_records) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_only_private_records) && strrpos(",".$pob_only_private_records.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_only_private_records" value="<?php echo $pob_only_private_records ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["1"] = "Yes, old school Oracle Forms style";
			$options["0"] = "No. Allow contextless work";
?>	
<?php
			$types = "s";
			$values = array('force_context_on_first_row');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_force_context_on_first_row = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_force_context_on_first_row = $res;
			$postValue = $_POST['pdf_force_context_on_first_row'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_force_context_on_first_row != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(force_context_on_first_row);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_force_context_on_first_row)) {
						$values = array($postValue, force_context_on_first_row);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(force_context_on_first_row, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('force_context_on_first_row');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_force_context_on_first_row = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_force_context_on_first_row = $res;
			}
			$postValue = $_POST['pob_force_context_on_first_row'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_force_context_on_first_row != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(force_context_on_first_row);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_force_context_on_first_row)) {
						$values = array($postValue, force_context_on_first_row);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(force_context_on_first_row, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('force_context_on_first_row');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_force_context_on_first_row = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_force_context_on_first_row = $res;
			}
?>
		<tr>
			<td title="">
					force_context_on_first_row
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_force_context_on_first_row" >
						<option value="" <?php echo !isset($pdf_force_context_on_first_row) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_force_context_on_first_row) && strrpos(",".$pdf_force_context_on_first_row.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_force_context_on_first_row" value="<?php echo $pdf_force_context_on_first_row ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_force_context_on_first_row" >
						<option value="" <?php echo !isset($pob_force_context_on_first_row) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_force_context_on_first_row) && strrpos(",".$pob_force_context_on_first_row.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_force_context_on_first_row" value="<?php echo $pob_force_context_on_first_row ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
?>		
<?php
			$types = "s";
			$values = array('parent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_parent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_parent_entity_pob_id = $res;
			$postValue = $_POST['pdf_parent_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_parent_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(parent_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_parent_entity_pob_id)) {
						$values = array($postValue, parent_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(parent_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('parent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_parent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_parent_entity_pob_id = $res;
			}
			$postValue = $_POST['pob_parent_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_parent_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(parent_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_parent_entity_pob_id)) {
						$values = array($postValue, parent_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(parent_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('parent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_parent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_parent_entity_pob_id = $res;
			}
?>
		<tr>
			<td title="">
					parent_entity_pob_id
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_parent_entity_pob_id[]" multiple='multiple'>
						<option value="" <?php echo !isset($pdf_parent_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_parent_entity_pob_id) && strrpos(",".$pdf_parent_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_parent_entity_pob_id" value="<?php echo $pdf_parent_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_parent_entity_pob_id[]" multiple='multiple'>
						<option value="" <?php echo !isset($pob_parent_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_parent_entity_pob_id) && strrpos(",".$pob_parent_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_parent_entity_pob_id" value="<?php echo $pob_parent_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
?>		
<?php
			$types = "s";
			$values = array('grandparent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_grandparent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_grandparent_entity_pob_id = $res;
			$postValue = $_POST['pdf_grandparent_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_grandparent_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(grandparent_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_grandparent_entity_pob_id)) {
						$values = array($postValue, grandparent_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(grandparent_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('grandparent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_grandparent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_grandparent_entity_pob_id = $res;
			}
			$postValue = $_POST['pob_grandparent_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_grandparent_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(grandparent_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_grandparent_entity_pob_id)) {
						$values = array($postValue, grandparent_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(grandparent_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('grandparent_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_grandparent_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_grandparent_entity_pob_id = $res;
			}
?>
		<tr>
			<td title="">
					grandparent_entity_pob_id
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_grandparent_entity_pob_id[]" multiple='multiple'>
						<option value="" <?php echo !isset($pdf_grandparent_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_grandparent_entity_pob_id) && strrpos(",".$pdf_grandparent_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_grandparent_entity_pob_id" value="<?php echo $pdf_grandparent_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_grandparent_entity_pob_id[]" multiple='multiple'>
						<option value="" <?php echo !isset($pob_grandparent_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_grandparent_entity_pob_id) && strrpos(",".$pob_grandparent_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_grandparent_entity_pob_id" value="<?php echo $pob_grandparent_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["E"] = "'Select parent' message";
			$options["C"] = "Chldren with empty parent";
			$options["G"] = "Filter by grandparent";
			$options["A"] = "Show all records";
			$options["H"] = "Hide content";
?>
<?php
			$types = "s";
			$values = array('when_no_parent_selected');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_when_no_parent_selected = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_when_no_parent_selected = $res;
			$postValue = $_POST['pdf_when_no_parent_selected'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_when_no_parent_selected != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(when_no_parent_selected);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_when_no_parent_selected)) {
						$values = array($postValue, when_no_parent_selected);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(when_no_parent_selected, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('when_no_parent_selected');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_when_no_parent_selected = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_when_no_parent_selected = $res;
			}
			$postValue = $_POST['pob_when_no_parent_selected'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_when_no_parent_selected != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(when_no_parent_selected);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_when_no_parent_selected)) {
						$values = array($postValue, when_no_parent_selected);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(when_no_parent_selected, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('when_no_parent_selected');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_when_no_parent_selected = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_when_no_parent_selected = $res;
			}
?>
		<tr>
			<td title="">
					when_no_parent_selected
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_when_no_parent_selected" >
						<option value="" <?php echo !isset($pdf_when_no_parent_selected) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_when_no_parent_selected) && strrpos(",".$pdf_when_no_parent_selected.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_when_no_parent_selected" value="<?php echo $pdf_when_no_parent_selected ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_when_no_parent_selected" >
						<option value="" <?php echo !isset($pob_when_no_parent_selected) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_when_no_parent_selected) && strrpos(",".$pob_when_no_parent_selected.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_when_no_parent_selected" value="<?php echo $pob_when_no_parent_selected ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('master_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_mode = $res;
			$postValue = $_POST['pdf_master_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_master_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(master_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_master_mode)) {
						$values = array($postValue, master_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(master_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('master_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_mode = $res;
			}
			$postValue = $_POST['pob_master_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_master_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(master_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_master_mode)) {
						$values = array($postValue, master_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(master_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('master_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_mode = $res;
			}
?>
		<tr>
			<td title="">
					master_mode
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_master_mode" >
						<option value="" <?php echo !isset($pdf_master_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_master_mode) && strrpos(",".$pdf_master_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_master_mode" value="<?php echo $pdf_master_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_master_mode" >
						<option value="" <?php echo !isset($pob_master_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_master_mode) && strrpos(",".$pob_master_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_master_mode" value="<?php echo $pob_master_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$query = <<<SQL
SELECT 
  pob_id,
  pdf_name,
  pob_custom_title,
  pge_title
FROM 
  prt_portlet_definitions
  LEFT OUTER JOIN prt_portlet_objects ON pob_pdf_id = pdf_id
  LEFT OUTER JOIN prt_portlet_locations ON plc_pob_id = pob_id
  LEFT OUTER JOIN prt_pages ON plc_pge_id = pge_id
WHERE 
  pdf_alias = ?
  AND pdf_namespace = ?
  AND pob_id != {$pobId}
SQL;
			$result = $databaseHandler->queryPrepared($query, false, "ss", array('virgoProcess', 'portal'));
			foreach ($result as $row) {
				$options[$row['pob_id']] = "{$row['pdf_name']} {$row['pob_custom_title']} [{$row['pge_title']}]";
			}
			$tmpOptions = $options;
?>		
<?php
			$types = "s";
			$values = array('master_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_entity_pob_id = $res;
			$postValue = $_POST['pdf_master_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_master_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(master_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_master_entity_pob_id)) {
						$values = array($postValue, master_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(master_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('master_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_entity_pob_id = $res;
			}
			$postValue = $_POST['pob_master_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_master_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(master_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_master_entity_pob_id)) {
						$values = array($postValue, master_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(master_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('master_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_master_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_master_entity_pob_id = $res;
			}
?>
		<tr>
			<td title="">
					master_entity_pob_id
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_master_entity_pob_id" >
						<option value="" <?php echo !isset($pdf_master_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_master_entity_pob_id) && strrpos(",".$pdf_master_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_master_entity_pob_id" value="<?php echo $pdf_master_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_master_entity_pob_id" >
						<option value="" <?php echo !isset($pob_master_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_master_entity_pob_id) && strrpos(",".$pob_master_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_master_entity_pob_id" value="<?php echo $pob_master_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('filter_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_mode = $res;
			$postValue = $_POST['pdf_filter_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_filter_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(filter_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_filter_mode)) {
						$values = array($postValue, filter_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(filter_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('filter_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_mode = $res;
			}
			$postValue = $_POST['pob_filter_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_filter_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(filter_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_filter_mode)) {
						$values = array($postValue, filter_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(filter_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('filter_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_mode = $res;
			}
?>
		<tr>
			<td title="Komponent pokazuje tylko formularz do szukania (ale trzeba to ustawic w searchform only)">
					filter_mode
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_filter_mode" >
						<option value="" <?php echo !isset($pdf_filter_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_filter_mode) && strrpos(",".$pdf_filter_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_filter_mode" value="<?php echo $pdf_filter_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_filter_mode" >
						<option value="" <?php echo !isset($pob_filter_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_filter_mode) && strrpos(",".$pob_filter_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_filter_mode" value="<?php echo $pob_filter_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = $tmpOptions;
?>
<?php
			$types = "s";
			$values = array('filter_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_entity_pob_id = $res;
			$postValue = $_POST['pdf_filter_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_filter_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(filter_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_filter_entity_pob_id)) {
						$values = array($postValue, filter_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(filter_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('filter_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_entity_pob_id = $res;
			}
			$postValue = $_POST['pob_filter_entity_pob_id'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_filter_entity_pob_id != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(filter_entity_pob_id);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_filter_entity_pob_id)) {
						$values = array($postValue, filter_entity_pob_id);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(filter_entity_pob_id, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('filter_entity_pob_id');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_filter_entity_pob_id = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_filter_entity_pob_id = $res;
			}
?>
		<tr>
			<td title="Czytaj kryteria nie swoje tylko z podanego komponentu">
					filter_entity_pob_id
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_filter_entity_pob_id" >
						<option value="" <?php echo !isset($pdf_filter_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_filter_entity_pob_id) && strrpos(",".$pdf_filter_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_filter_entity_pob_id" value="<?php echo $pdf_filter_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_filter_entity_pob_id" >
						<option value="" <?php echo !isset($pob_filter_entity_pob_id) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_filter_entity_pob_id) && strrpos(",".$pob_filter_entity_pob_id.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_filter_entity_pob_id" value="<?php echo $pob_filter_entity_pob_id ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["virgo"] = "Virgo generated";
			$options["template"] = "Inherit from template";
?>			
<?php
			$types = "s";
			$values = array('css_usage');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_css_usage = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_css_usage = $res;
			$postValue = $_POST['pdf_css_usage'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_css_usage != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(css_usage);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_css_usage)) {
						$values = array($postValue, css_usage);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(css_usage, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('css_usage');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_css_usage = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_css_usage = $res;
			}
			$postValue = $_POST['pob_css_usage'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_css_usage != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(css_usage);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_css_usage)) {
						$values = array($postValue, css_usage);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(css_usage, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('css_usage');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_css_usage = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_css_usage = $res;
			}
?>
		<tr>
			<td title="">
					css_usage
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_css_usage" >
						<option value="" <?php echo !isset($pdf_css_usage) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_css_usage) && strrpos(",".$pdf_css_usage.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_css_usage" value="<?php echo $pdf_css_usage ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_css_usage" >
						<option value="" <?php echo !isset($pob_css_usage) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_css_usage) && strrpos(",".$pob_css_usage.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_css_usage" value="<?php echo $pob_css_usage ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Details button";
			$options["1"] = "Each field is a link";
?>			
<?php
			$types = "s";
			$values = array('show_details_method');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_details_method = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_details_method = $res;
			$postValue = $_POST['pdf_show_details_method'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_details_method != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_details_method);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_details_method)) {
						$values = array($postValue, show_details_method);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_details_method, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_details_method');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_details_method = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_details_method = $res;
			}
			$postValue = $_POST['pob_show_details_method'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_details_method != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_details_method);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_details_method)) {
						$values = array($postValue, show_details_method);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_details_method, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_details_method');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_details_method = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_details_method = $res;
			}
?>
		<tr>
			<td title="">
					show_details_method
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_details_method" >
						<option value="" <?php echo !isset($pdf_show_details_method) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_details_method) && strrpos(",".$pdf_show_details_method.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_details_method" value="<?php echo $pdf_show_details_method ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_details_method" >
						<option value="" <?php echo !isset($pob_show_details_method) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_details_method) && strrpos(",".$pob_show_details_method.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_details_method" value="<?php echo $pob_show_details_method ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('available_page_sizes');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_available_page_sizes = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_available_page_sizes = $res;
			$postValue = $_POST['pdf_available_page_sizes'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_available_page_sizes != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(available_page_sizes);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_available_page_sizes)) {
						$values = array($postValue, available_page_sizes);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(available_page_sizes, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('available_page_sizes');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_available_page_sizes = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_available_page_sizes = $res;
			}
			$postValue = $_POST['pob_available_page_sizes'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_available_page_sizes != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(available_page_sizes);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_available_page_sizes)) {
						$values = array($postValue, available_page_sizes);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(available_page_sizes, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('available_page_sizes');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_available_page_sizes = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_available_page_sizes = $res;
			}
?>
		<tr>
			<td>available_page_sizes</td>
			<td>
<input type="text" name="pdf_available_page_sizes" value="<?php echo $pdf_available_page_sizes ?>"/>
			</td>
			<td>
<input type="text" name="pob_available_page_sizes" value="<?php echo $pob_available_page_sizes ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('default_page_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_page_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_page_size = $res;
			$postValue = $_POST['pdf_default_page_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_default_page_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_page_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_page_size)) {
						$values = array($postValue, default_page_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(default_page_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_page_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_page_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_page_size = $res;
			}
			$postValue = $_POST['pob_default_page_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_default_page_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_page_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_page_size)) {
						$values = array($postValue, default_page_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(default_page_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_page_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_page_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_page_size = $res;
			}
?>
		<tr>
			<td>default_page_size</td>
			<td>
<input type="text" name="pdf_default_page_size" value="<?php echo $pdf_default_page_size ?>"/>
			</td>
			<td>
<input type="text" name="pob_default_page_size" value="<?php echo $pob_default_page_size ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["prc_id"] = "id";
			$options["prc_name"] = "Name";

			$options["prc_execution_time"] = "Execution time";

			$options["prc_description"] = "Description";

			$options["prc_initiation_code"] = "Initiation code";

			$options["prc_execution_code"] = "Execution code";

			$options["prc_closing_code"] = "Closing code";

			$options["prc_portion_size"] = "Portion size";

			$options["prc_active"] = "Active";

			$options["prc_order"] = "Order";

			$options["prc_last_session"] = "Last session";

			$options["prc_subprocess_count"] = "Subprocess count";

			$options["prc_clear"] = "Clear";

?>
<?php
			$types = "s";
			$values = array('default_sort_column');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_column = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_column = $res;
			$postValue = $_POST['pdf_default_sort_column'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_default_sort_column != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_sort_column);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_sort_column)) {
						$values = array($postValue, default_sort_column);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(default_sort_column, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_sort_column');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_column = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_column = $res;
			}
			$postValue = $_POST['pob_default_sort_column'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_default_sort_column != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_sort_column);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_sort_column)) {
						$values = array($postValue, default_sort_column);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(default_sort_column, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_sort_column');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_column = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_column = $res;
			}
?>
		<tr>
			<td title="">
					default_sort_column
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_default_sort_column" >
						<option value="" <?php echo !isset($pdf_default_sort_column) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_default_sort_column) && strrpos(",".$pdf_default_sort_column.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_default_sort_column" value="<?php echo $pdf_default_sort_column ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_default_sort_column" >
						<option value="" <?php echo !isset($pob_default_sort_column) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_default_sort_column) && strrpos(",".$pob_default_sort_column.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_default_sort_column" value="<?php echo $pob_default_sort_column ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["asc"] = "Ascending";
			$options["desc"] = "Descending";
?>
<?php
			$types = "s";
			$values = array('default_sort_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_mode = $res;
			$postValue = $_POST['pdf_default_sort_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_default_sort_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_sort_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_default_sort_mode)) {
						$values = array($postValue, default_sort_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(default_sort_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_sort_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_mode = $res;
			}
			$postValue = $_POST['pob_default_sort_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_default_sort_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(default_sort_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_default_sort_mode)) {
						$values = array($postValue, default_sort_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(default_sort_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('default_sort_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_default_sort_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_default_sort_mode = $res;
			}
?>
		<tr>
			<td title="">
					default_sort_mode
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_default_sort_mode" >
						<option value="" <?php echo !isset($pdf_default_sort_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_default_sort_mode) && strrpos(",".$pdf_default_sort_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_default_sort_mode" value="<?php echo $pdf_default_sort_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_default_sort_mode" >
						<option value="" <?php echo !isset($pob_default_sort_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_default_sort_mode) && strrpos(",".$pob_default_sort_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_default_sort_mode" value="<?php echo $pob_default_sort_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('enable_record_duplication');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_enable_record_duplication = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_enable_record_duplication = $res;
			$postValue = $_POST['pdf_enable_record_duplication'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_enable_record_duplication != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(enable_record_duplication);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_enable_record_duplication)) {
						$values = array($postValue, enable_record_duplication);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(enable_record_duplication, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('enable_record_duplication');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_enable_record_duplication = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_enable_record_duplication = $res;
			}
			$postValue = $_POST['pob_enable_record_duplication'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_enable_record_duplication != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(enable_record_duplication);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_enable_record_duplication)) {
						$values = array($postValue, enable_record_duplication);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(enable_record_duplication, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('enable_record_duplication');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_enable_record_duplication = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_enable_record_duplication = $res;
			}
?>
		<tr>
			<td title="">
					enable_record_duplication
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_enable_record_duplication" >
						<option value="" <?php echo !isset($pdf_enable_record_duplication) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_enable_record_duplication) && strrpos(",".$pdf_enable_record_duplication.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_enable_record_duplication" value="<?php echo $pdf_enable_record_duplication ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_enable_record_duplication" >
						<option value="" <?php echo !isset($pob_enable_record_duplication) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_enable_record_duplication) && strrpos(",".$pob_enable_record_duplication.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_enable_record_duplication" value="<?php echo $pob_enable_record_duplication ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_filter');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_filter = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_filter = $res;
			$postValue = $_POST['pdf_show_table_filter'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_filter != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_filter);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_filter)) {
						$values = array($postValue, show_table_filter);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_filter, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_filter');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_filter = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_filter = $res;
			}
			$postValue = $_POST['pob_show_table_filter'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_filter != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_filter);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_filter)) {
						$values = array($postValue, show_table_filter);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_filter, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_filter');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_filter = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_filter = $res;
			}
?>
		<tr>
			<td title="">
					show_table_filter
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_filter" >
						<option value="" <?php echo !isset($pdf_show_table_filter) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_filter) && strrpos(",".$pdf_show_table_filter.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_filter" value="<?php echo $pdf_show_table_filter ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_filter" >
						<option value="" <?php echo !isset($pob_show_table_filter) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_filter) && strrpos(",".$pob_show_table_filter.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_filter" value="<?php echo $pob_show_table_filter ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('empty_values_search');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_empty_values_search = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_empty_values_search = $res;
			$postValue = $_POST['pdf_empty_values_search'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_empty_values_search != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(empty_values_search);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_empty_values_search)) {
						$values = array($postValue, empty_values_search);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(empty_values_search, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('empty_values_search');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_empty_values_search = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_empty_values_search = $res;
			}
			$postValue = $_POST['pob_empty_values_search'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_empty_values_search != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(empty_values_search);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_empty_values_search)) {
						$values = array($postValue, empty_values_search);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(empty_values_search, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('empty_values_search');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_empty_values_search = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_empty_values_search = $res;
			}
?>
		<tr>
			<td title="">
					empty_values_search
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_empty_values_search" >
						<option value="" <?php echo !isset($pdf_empty_values_search) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_empty_values_search) && strrpos(",".$pdf_empty_values_search.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_empty_values_search" value="<?php echo $pdf_empty_values_search ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_empty_values_search" >
						<option value="" <?php echo !isset($pob_empty_values_search) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_empty_values_search) && strrpos(",".$pob_empty_values_search.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_empty_values_search" value="<?php echo $pob_empty_values_search ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('title_value');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_title_value = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_title_value = $res;
			$postValue = $_POST['pdf_title_value'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_title_value != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(title_value);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_title_value)) {
						$values = array($postValue, title_value);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(title_value, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('title_value');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_title_value = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_title_value = $res;
			}
?>
		<tr>
			<td title="What you put here will be added to '$ret = ' line, so end it with colon. Eg: $this->getNazwa() . ' (' . $this->getBank()->getVirgoTitle() . ')';">title_value</td>
			<td>
<textarea name="pdf_title_value"><?php echo $pdf_title_value ?></textarea>
			</td>
			<td>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr><td>log_level</td><td>TODO</td><td>TODO</td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('under_construction');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction = $res;
			$postValue = $_POST['pdf_under_construction'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_under_construction != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(under_construction);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_under_construction)) {
						$values = array($postValue, under_construction);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(under_construction, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('under_construction');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction = $res;
			}
			$postValue = $_POST['pob_under_construction'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_under_construction != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(under_construction);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_under_construction)) {
						$values = array($postValue, under_construction);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(under_construction, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('under_construction');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction = $res;
			}
?>
		<tr>
			<td title="">
					under_construction
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_under_construction" >
						<option value="" <?php echo !isset($pdf_under_construction) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_under_construction) && strrpos(",".$pdf_under_construction.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_under_construction" value="<?php echo $pdf_under_construction ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_under_construction" >
						<option value="" <?php echo !isset($pob_under_construction) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_under_construction) && strrpos(",".$pob_under_construction.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_under_construction" value="<?php echo $pob_under_construction ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('ajax_max_label_list_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_ajax_max_label_list_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_ajax_max_label_list_size = $res;
			$postValue = $_POST['pdf_ajax_max_label_list_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_ajax_max_label_list_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(ajax_max_label_list_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_ajax_max_label_list_size)) {
						$values = array($postValue, ajax_max_label_list_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(ajax_max_label_list_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('ajax_max_label_list_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_ajax_max_label_list_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_ajax_max_label_list_size = $res;
			}
?>
		<tr>
			<td>ajax_max_label_list_size</td>
			<td>
<input type="text" name="pdf_ajax_max_label_list_size" value="<?php echo $pdf_ajax_max_label_list_size ?>"/>
			</td>
			<td>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('extra_ajax_filter');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_extra_ajax_filter = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_extra_ajax_filter = $res;
			$postValue = $_POST['pdf_extra_ajax_filter'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_extra_ajax_filter != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(extra_ajax_filter);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_extra_ajax_filter)) {
						$values = array($postValue, extra_ajax_filter);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(extra_ajax_filter, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('extra_ajax_filter');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_extra_ajax_filter = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_extra_ajax_filter = $res;
			}
?>
		<tr>
			<td title="eg. prc_abc_id in (select abc_id from...)) ">extra_ajax_filter</td>
			<td>
<textarea name="pdf_extra_ajax_filter"><?php echo $pdf_extra_ajax_filter ?></textarea>
			</td>
			<td>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr><td>check_token</td><td>TODO</td><td>TODO</td><td></td></tr>
<?php
			$types = "s";
			$values = array('under_construction_allowed_user');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction_allowed_user = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction_allowed_user = $res;
			$postValue = $_POST['pdf_under_construction_allowed_user'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_under_construction_allowed_user != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(under_construction_allowed_user);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_under_construction_allowed_user)) {
						$values = array($postValue, under_construction_allowed_user);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(under_construction_allowed_user, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('under_construction_allowed_user');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction_allowed_user = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction_allowed_user = $res;
			}
			$postValue = $_POST['pob_under_construction_allowed_user'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_under_construction_allowed_user != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(under_construction_allowed_user);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_under_construction_allowed_user)) {
						$values = array($postValue, under_construction_allowed_user);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(under_construction_allowed_user, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('under_construction_allowed_user');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_under_construction_allowed_user = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_under_construction_allowed_user = $res;
			}
?>
		<tr>
			<td>under_construction_allowed_user</td>
			<td>
<input type="text" name="pdf_under_construction_allowed_user" value="<?php echo $pdf_under_construction_allowed_user ?>"/>
			</td>
			<td>
<input type="text" name="pob_under_construction_allowed_user" value="<?php echo $pob_under_construction_allowed_user ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_project_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_project_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_project_name = $res;
			$postValue = $_POST['pdf_show_project_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_project_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_project_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_project_name)) {
						$values = array($postValue, show_project_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_project_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_project_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_project_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_project_name = $res;
			}
			$postValue = $_POST['pob_show_project_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_project_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_project_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_project_name)) {
						$values = array($postValue, show_project_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_project_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_project_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_project_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_project_name = $res;
			}
?>
		<tr>
			<td title="">
					show_project_name
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_project_name" >
						<option value="" <?php echo !isset($pdf_show_project_name) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_project_name) && strrpos(",".$pdf_show_project_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_project_name" value="<?php echo $pdf_show_project_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_project_name" >
						<option value="" <?php echo !isset($pob_show_project_name) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_project_name) && strrpos(",".$pob_show_project_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_project_name" value="<?php echo $pob_show_project_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('short_text_size_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_description = $res;
			$postValue = $_POST['pdf_short_text_size_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_short_text_size_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_short_text_size_description)) {
						$values = array($postValue, short_text_size_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_description = $res;
			}
			$postValue = $_POST['pob_short_text_size_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_short_text_size_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_short_text_size_description)) {
						$values = array($postValue, short_text_size_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_description = $res;
			}
?>
		<tr>
			<td>short_text_size_description</td>
			<td>
<input type="text" name="pdf_short_text_size_description" value="<?php echo $pdf_short_text_size_description ?>"/>
			</td>
			<td>
<input type="text" name="pob_short_text_size_description" value="<?php echo $pob_short_text_size_description ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('short_text_size_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_initiation_code = $res;
			$postValue = $_POST['pdf_short_text_size_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_short_text_size_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_short_text_size_initiation_code)) {
						$values = array($postValue, short_text_size_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_initiation_code = $res;
			}
			$postValue = $_POST['pob_short_text_size_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_short_text_size_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_short_text_size_initiation_code)) {
						$values = array($postValue, short_text_size_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_initiation_code = $res;
			}
?>
		<tr>
			<td>short_text_size_initiation_code</td>
			<td>
<input type="text" name="pdf_short_text_size_initiation_code" value="<?php echo $pdf_short_text_size_initiation_code ?>"/>
			</td>
			<td>
<input type="text" name="pob_short_text_size_initiation_code" value="<?php echo $pob_short_text_size_initiation_code ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('short_text_size_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_execution_code = $res;
			$postValue = $_POST['pdf_short_text_size_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_short_text_size_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_short_text_size_execution_code)) {
						$values = array($postValue, short_text_size_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_execution_code = $res;
			}
			$postValue = $_POST['pob_short_text_size_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_short_text_size_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_short_text_size_execution_code)) {
						$values = array($postValue, short_text_size_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_execution_code = $res;
			}
?>
		<tr>
			<td>short_text_size_execution_code</td>
			<td>
<input type="text" name="pdf_short_text_size_execution_code" value="<?php echo $pdf_short_text_size_execution_code ?>"/>
			</td>
			<td>
<input type="text" name="pob_short_text_size_execution_code" value="<?php echo $pob_short_text_size_execution_code ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('short_text_size_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_closing_code = $res;
			$postValue = $_POST['pdf_short_text_size_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_short_text_size_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_short_text_size_closing_code)) {
						$values = array($postValue, short_text_size_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_closing_code = $res;
			}
			$postValue = $_POST['pob_short_text_size_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_short_text_size_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(short_text_size_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_short_text_size_closing_code)) {
						$values = array($postValue, short_text_size_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(short_text_size_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('short_text_size_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_short_text_size_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_short_text_size_closing_code = $res;
			}
?>
		<tr>
			<td>short_text_size_closing_code</td>
			<td>
<input type="text" name="pdf_short_text_size_closing_code" value="<?php echo $pdf_short_text_size_closing_code ?>"/>
			</td>
			<td>
<input type="text" name="pob_short_text_size_closing_code" value="<?php echo $pob_short_text_size_closing_code ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["freeserif"] = "Serif";
			$options["freesans"] = "Sans serif";
?>
<?php
			$types = "s";
			$values = array('pdf_font_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_name = $res;
			$postValue = $_POST['pdf_pdf_font_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_pdf_font_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_font_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_font_name)) {
						$values = array($postValue, pdf_font_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_font_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_font_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_name = $res;
			}
			$postValue = $_POST['pob_pdf_font_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_pdf_font_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_font_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_font_name)) {
						$values = array($postValue, pdf_font_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_font_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_font_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_name = $res;
			}
?>
		<tr>
			<td title="">
					pdf_font_name
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_pdf_font_name" >
						<option value="" <?php echo !isset($pdf_pdf_font_name) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_pdf_font_name) && strrpos(",".$pdf_pdf_font_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_pdf_font_name" value="<?php echo $pdf_pdf_font_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_pdf_font_name" >
						<option value="" <?php echo !isset($pob_pdf_font_name) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_pdf_font_name) && strrpos(",".$pob_pdf_font_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_pdf_font_name" value="<?php echo $pob_pdf_font_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('pdf_include_bold_font');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_include_bold_font = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_include_bold_font = $res;
			$postValue = $_POST['pdf_pdf_include_bold_font'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_pdf_include_bold_font != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_include_bold_font);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_include_bold_font)) {
						$values = array($postValue, pdf_include_bold_font);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_include_bold_font, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_include_bold_font');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_include_bold_font = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_include_bold_font = $res;
			}
			$postValue = $_POST['pob_pdf_include_bold_font'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_pdf_include_bold_font != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_include_bold_font);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_include_bold_font)) {
						$values = array($postValue, pdf_include_bold_font);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_include_bold_font, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_include_bold_font');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_include_bold_font = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_include_bold_font = $res;
			}
?>
		<tr>
			<td title="">
					pdf_include_bold_font
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_pdf_include_bold_font" >
						<option value="" <?php echo !isset($pdf_pdf_include_bold_font) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_pdf_include_bold_font) && strrpos(",".$pdf_pdf_include_bold_font.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_pdf_include_bold_font" value="<?php echo $pdf_pdf_include_bold_font ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_pdf_include_bold_font" >
						<option value="" <?php echo !isset($pob_pdf_include_bold_font) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_pdf_include_bold_font) && strrpos(",".$pob_pdf_include_bold_font.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_pdf_include_bold_font" value="<?php echo $pob_pdf_include_bold_font ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('pdf_font_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_size = $res;
			$postValue = $_POST['pdf_pdf_font_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_pdf_font_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_font_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_font_size)) {
						$values = array($postValue, pdf_font_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_font_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_font_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_size = $res;
			}
			$postValue = $_POST['pob_pdf_font_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_pdf_font_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_font_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_font_size)) {
						$values = array($postValue, pdf_font_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_font_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_font_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_font_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_font_size = $res;
			}
?>
		<tr>
			<td>pdf_font_size</td>
			<td>
<input type="text" name="pdf_pdf_font_size" value="<?php echo $pdf_pdf_font_size ?>"/>
			</td>
			<td>
<input type="text" name="pob_pdf_font_size" value="<?php echo $pob_pdf_font_size ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('pdf_max_column_width');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_max_column_width = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_max_column_width = $res;
			$postValue = $_POST['pdf_pdf_max_column_width'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_pdf_max_column_width != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_max_column_width);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_max_column_width)) {
						$values = array($postValue, pdf_max_column_width);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_max_column_width, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_max_column_width');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_max_column_width = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_max_column_width = $res;
			}
			$postValue = $_POST['pob_pdf_max_column_width'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_pdf_max_column_width != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_max_column_width);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_max_column_width)) {
						$values = array($postValue, pdf_max_column_width);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_max_column_width, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_max_column_width');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_max_column_width = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_max_column_width = $res;
			}
?>
		<tr>
			<td>pdf_max_column_width</td>
			<td>
<input type="text" name="pdf_pdf_max_column_width" value="<?php echo $pdf_pdf_max_column_width ?>"/>
			</td>
			<td>
<input type="text" name="pob_pdf_max_column_width" value="<?php echo $pob_pdf_max_column_width ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["P"] = "Portrait";
			$options["L"] = "Landscape";
?>
<?php
			$types = "s";
			$values = array('pdf_page_orientation');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_page_orientation = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_page_orientation = $res;
			$postValue = $_POST['pdf_pdf_page_orientation'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_pdf_page_orientation != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_page_orientation);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_pdf_page_orientation)) {
						$values = array($postValue, pdf_page_orientation);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_page_orientation, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_page_orientation');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_page_orientation = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_page_orientation = $res;
			}
			$postValue = $_POST['pob_pdf_page_orientation'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_pdf_page_orientation != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(pdf_page_orientation);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_pdf_page_orientation)) {
						$values = array($postValue, pdf_page_orientation);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(pdf_page_orientation, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('pdf_page_orientation');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_pdf_page_orientation = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_pdf_page_orientation = $res;
			}
?>
		<tr>
			<td title="">
					pdf_page_orientation
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_pdf_page_orientation" >
						<option value="" <?php echo !isset($pdf_pdf_page_orientation) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_pdf_page_orientation) && strrpos(",".$pdf_pdf_page_orientation.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_pdf_page_orientation" value="<?php echo $pdf_pdf_page_orientation ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_pdf_page_orientation" >
						<option value="" <?php echo !isset($pob_pdf_page_orientation) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_pdf_page_orientation) && strrpos(",".$pob_pdf_page_orientation.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_pdf_page_orientation" value="<?php echo $pob_pdf_page_orientation ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["false"] = "Forms in list";
			$options["true"] = "Forms in table";
			$options["float"] = "Floating fields";
			$options["float-grid"] = "Floating fields in grid";
?>
<?php
			$types = "s";
			$values = array('forms_rendering');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_forms_rendering = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_forms_rendering = $res;
			$postValue = $_POST['pdf_forms_rendering'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_forms_rendering != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(forms_rendering);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_forms_rendering)) {
						$values = array($postValue, forms_rendering);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(forms_rendering, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('forms_rendering');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_forms_rendering = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_forms_rendering = $res;
			}
			$postValue = $_POST['pob_forms_rendering'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_forms_rendering != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(forms_rendering);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_forms_rendering)) {
						$values = array($postValue, forms_rendering);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(forms_rendering, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('forms_rendering');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_forms_rendering = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_forms_rendering = $res;
			}
?>
		<tr>
			<td title="">
					forms_rendering
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_forms_rendering" >
						<option value="" <?php echo !isset($pdf_forms_rendering) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_forms_rendering) && strrpos(",".$pdf_forms_rendering.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_forms_rendering" value="<?php echo $pdf_forms_rendering ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_forms_rendering" >
						<option value="" <?php echo !isset($pob_forms_rendering) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_forms_rendering) && strrpos(",".$pob_forms_rendering.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_forms_rendering" value="<?php echo $pob_forms_rendering ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["Select"] = "Select";
			$options["View"] = "View";
			$options["Form"] = "Edit";
// bo nie pyta!!!			$options["Delete"] = "Delete (seriously?)";
			$options["Custom"] = "Custom (fill field below)";
?>
<?php
			$types = "s";
			$values = array('action_on_row_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click = $res;
			$postValue = $_POST['pdf_action_on_row_click'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_action_on_row_click != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_click);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_click)) {
						$values = array($postValue, action_on_row_click);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_click, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click = $res;
			}
			$postValue = $_POST['pob_action_on_row_click'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_action_on_row_click != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_click);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_click)) {
						$values = array($postValue, action_on_row_click);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_click, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click = $res;
			}
?>
		<tr>
			<td title="">
					action_on_row_click
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_action_on_row_click" >
						<option value="" <?php echo !isset($pdf_action_on_row_click) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_action_on_row_click) && strrpos(",".$pdf_action_on_row_click.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_action_on_row_click" value="<?php echo $pdf_action_on_row_click ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_action_on_row_click" >
						<option value="" <?php echo !isset($pob_action_on_row_click) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_action_on_row_click) && strrpos(",".$pob_action_on_row_click.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_action_on_row_click" value="<?php echo $pob_action_on_row_click ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('action_on_row_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click_custom = $res;
			$postValue = $_POST['pdf_action_on_row_click_custom'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_action_on_row_click_custom != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_click_custom);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_click_custom)) {
						$values = array($postValue, action_on_row_click_custom);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_click_custom, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click_custom = $res;
			}
			$postValue = $_POST['pob_action_on_row_click_custom'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_action_on_row_click_custom != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_click_custom);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_click_custom)) {
						$values = array($postValue, action_on_row_click_custom);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_click_custom, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_click_custom = $res;
			}
?>
		<tr>
			<td>action_on_row_click_custom</td>
			<td>
<input type="text" name="pdf_action_on_row_click_custom" value="<?php echo $pdf_action_on_row_click_custom ?>"/>
			</td>
			<td>
<input type="text" name="pob_action_on_row_click_custom" value="<?php echo $pob_action_on_row_click_custom ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('action_on_row_double_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click = $res;
			$postValue = $_POST['pdf_action_on_row_double_click'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_action_on_row_double_click != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_double_click);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_double_click)) {
						$values = array($postValue, action_on_row_double_click);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_double_click, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_double_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click = $res;
			}
			$postValue = $_POST['pob_action_on_row_double_click'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_action_on_row_double_click != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_double_click);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_double_click)) {
						$values = array($postValue, action_on_row_double_click);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_double_click, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_double_click');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click = $res;
			}
?>
		<tr>
			<td title="">
					action_on_row_double_click
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_action_on_row_double_click" >
						<option value="" <?php echo !isset($pdf_action_on_row_double_click) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_action_on_row_double_click) && strrpos(",".$pdf_action_on_row_double_click.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_action_on_row_double_click" value="<?php echo $pdf_action_on_row_double_click ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_action_on_row_double_click" >
						<option value="" <?php echo !isset($pob_action_on_row_double_click) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_action_on_row_double_click) && strrpos(",".$pob_action_on_row_double_click.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_action_on_row_double_click" value="<?php echo $pob_action_on_row_double_click ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('action_on_row_double_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click_custom = $res;
			$postValue = $_POST['pdf_action_on_row_double_click_custom'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_action_on_row_double_click_custom != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_double_click_custom);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_action_on_row_double_click_custom)) {
						$values = array($postValue, action_on_row_double_click_custom);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_double_click_custom, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_double_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click_custom = $res;
			}
			$postValue = $_POST['pob_action_on_row_double_click_custom'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_action_on_row_double_click_custom != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(action_on_row_double_click_custom);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_action_on_row_double_click_custom)) {
						$values = array($postValue, action_on_row_double_click_custom);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(action_on_row_double_click_custom, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('action_on_row_double_click_custom');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_action_on_row_double_click_custom = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_action_on_row_double_click_custom = $res;
			}
?>
		<tr>
			<td>action_on_row_double_click_custom</td>
			<td>
<input type="text" name="pdf_action_on_row_double_click_custom" value="<?php echo $pdf_action_on_row_double_click_custom ?>"/>
			</td>
			<td>
<input type="text" name="pob_action_on_row_double_click_custom" value="<?php echo $pob_action_on_row_double_click_custom ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No, show it";
			$options["1"] = "Yes, hide this useless stuff";
?>
<?php
			$types = "s";
			$values = array('hide_audit');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_hide_audit = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_hide_audit = $res;
			$postValue = $_POST['pdf_hide_audit'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_hide_audit != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(hide_audit);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_hide_audit)) {
						$values = array($postValue, hide_audit);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(hide_audit, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('hide_audit');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_hide_audit = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_hide_audit = $res;
			}
			$postValue = $_POST['pob_hide_audit'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_hide_audit != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(hide_audit);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_hide_audit)) {
						$values = array($postValue, hide_audit);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(hide_audit, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('hide_audit');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_hide_audit = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_hide_audit = $res;
			}
?>
		<tr>
			<td title="">
					hide_audit
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_hide_audit" >
						<option value="" <?php echo !isset($pdf_hide_audit) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_hide_audit) && strrpos(",".$pdf_hide_audit.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_hide_audit" value="<?php echo $pdf_hide_audit ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_hide_audit" >
						<option value="" <?php echo !isset($pob_hide_audit) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_hide_audit) && strrpos(",".$pob_hide_audit.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_hide_audit" value="<?php echo $pob_hide_audit ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="action_permissions">Action permissions</td></tr>
</table>
<table class="params">
<?php
				$roles = array();
				$result = $databaseHandler->query(" SELECT rle_id, rle_name FROM prt_roles WHERE IFNULL(rle_virgo_deleted, 0) = 0 ");
				echo $databaseHandler->error();
				while($row = mysqli_fetch_row($result)) {
					$roles[$row[0]] = $row[1];
				}	
				mysqli_fetch_row($result);
				foreach ($roles as $id => $name) {
?>
<tr>
	<td>
						<?php echo $name ?>
	</td>
	<td colspan="4">
		<table class="perm" cellpadding="0" cellspacing="0">
			<tr>
<?php
	actionPermissions("Add", $id, $name, $pobId);
	actionPermissions("Delete", $id, $name, $pobId);
	actionPermissions("DeleteSelected", $id, $name, $pobId);
	actionPermissions("EditSelected", $id, $name, $pobId);
	actionPermissions("ExecuteNow", $id, $name, $pobId);
	actionPermissions("Export", $id, $name, $pobId);
	actionPermissions("Form", $id, $name, $pobId);
	actionPermissions("Offline", $id, $name, $pobId);
	actionPermissions("Report", $id, $name, $pobId);
	actionPermissions("SearchForm", $id, $name, $pobId);
	actionPermissions("StoreAndExecuteNow", $id, $name, $pobId);
	actionPermissions("StoreSelected", $id, $name, $pobId);
	actionPermissions("UpdateTitle", $id, $name, $pobId);
	actionPermissions("Upload", $id, $name, $pobId);
	actionPermissions("View", $id, $name, $pobId);
	actionPermissions("VirgoDown", $id, $name, $pobId);
	actionPermissions("VirgoUp", $id, $name, $pobId);
	foreach ($extraActions as $extraAction) {
		actionPermissions($extraAction, $id, $name, $pobId);
	}
?>
				<td>
					<select onclick="
<?php					
	setPermissions("Add", $id, $pobId);
	setPermissions("Delete", $id, $pobId);
	setPermissions("DeleteSelected", $id, $pobId);
	setPermissions("EditSelected", $id, $pobId);
	setPermissions("ExecuteNow", $id, $pobId);
	setPermissions("Export", $id, $pobId);
	setPermissions("Form", $id, $pobId);
	setPermissions("Offline", $id, $pobId);
	setPermissions("Report", $id, $pobId);
	setPermissions("SearchForm", $id, $pobId);
	setPermissions("StoreAndExecuteNow", $id, $pobId);
	setPermissions("StoreSelected", $id, $pobId);
	setPermissions("UpdateTitle", $id, $pobId);
	setPermissions("Upload", $id, $pobId);
	setPermissions("View", $id, $pobId);
	setPermissions("VirgoDown", $id, $pobId);
	setPermissions("VirgoUp", $id, $pobId);
?>	
">
						<option value="">Set all to:</option>
						<option value="1">allowed</option>
						<option value="0">blocked</option>
					</select>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?php
				}
?>				
</table>
<table><tr><td title="_ECA - extra create action... _EFA, _EVA, _ETA, _ERA, _ICA - instead create action... _IFA, _IVA, _ITA, _IRA">Dodaj akcję: <input type="text" name="newAction"></td></tr></table>
<table class="params">
<tr class="spacer"><td colspan="4" id="custom_forms">Custom forms</td></tr>
<?php
			$options = array();
			$options["virgo_default"] = "virgo default";
			$options["virgo_entity"] = "entity default";
?>
<?php
			$types = "s";
			$values = array('table_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_table_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_table_form = $res;
			$postValue = $_POST['pdf_table_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_table_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(table_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_table_form)) {
						$values = array($postValue, table_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(table_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('table_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_table_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_table_form = $res;
			}
			$postValue = $_POST['pob_table_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_table_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(table_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_table_form)) {
						$values = array($postValue, table_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(table_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('table_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_table_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_table_form = $res;
			}
?>
		<tr>
			<td title="">
					table_form
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_table_form" >
						<option value="" <?php echo !isset($pdf_table_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_table_form) && strrpos(",".$pdf_table_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_table_form" value="<?php echo $pdf_table_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_table_form" >
						<option value="" <?php echo !isset($pob_table_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_table_form) && strrpos(",".$pob_table_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_table_form" value="<?php echo $pob_table_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["virgo_default"] = "virgo default";
			$options["virgo_entity"] = "entity default";
?>
<?php
			$types = "s";
			$values = array('create_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_form = $res;
			$postValue = $_POST['pdf_create_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_create_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(create_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_create_form)) {
						$values = array($postValue, create_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(create_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('create_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_form = $res;
			}
			$postValue = $_POST['pob_create_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_create_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(create_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_create_form)) {
						$values = array($postValue, create_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(create_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('create_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_create_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_create_form = $res;
			}
?>
		<tr>
			<td title="">
					create_form
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_create_form" >
						<option value="" <?php echo !isset($pdf_create_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_create_form) && strrpos(",".$pdf_create_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_create_form" value="<?php echo $pdf_create_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_create_form" >
						<option value="" <?php echo !isset($pob_create_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_create_form) && strrpos(",".$pob_create_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_create_form" value="<?php echo $pob_create_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["virgo_default"] = "virgo default";
			$options["virgo_entity"] = "entity default";
?>
<?php
			$types = "s";
			$values = array('edit_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_edit_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_edit_form = $res;
			$postValue = $_POST['pdf_edit_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_edit_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(edit_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_edit_form)) {
						$values = array($postValue, edit_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(edit_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('edit_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_edit_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_edit_form = $res;
			}
			$postValue = $_POST['pob_edit_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_edit_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(edit_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_edit_form)) {
						$values = array($postValue, edit_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(edit_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('edit_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_edit_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_edit_form = $res;
			}
?>
		<tr>
			<td title="">
					edit_form
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_edit_form" >
						<option value="" <?php echo !isset($pdf_edit_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_edit_form) && strrpos(",".$pdf_edit_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_edit_form" value="<?php echo $pdf_edit_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_edit_form" >
						<option value="" <?php echo !isset($pob_edit_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_edit_form) && strrpos(",".$pob_edit_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_edit_form" value="<?php echo $pob_edit_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["virgo_default"] = "virgo default";
			$options["virgo_entity"] = "entity default";
?>
<?php
			$types = "s";
			$values = array('view_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_view_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_view_form = $res;
			$postValue = $_POST['pdf_view_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_view_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(view_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_view_form)) {
						$values = array($postValue, view_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(view_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('view_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_view_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_view_form = $res;
			}
			$postValue = $_POST['pob_view_form'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_view_form != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(view_form);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_view_form)) {
						$values = array($postValue, view_form);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(view_form, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('view_form');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_view_form = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_view_form = $res;
			}
?>
		<tr>
			<td title="">
					view_form
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_view_form" >
						<option value="" <?php echo !isset($pdf_view_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_view_form) && strrpos(",".$pdf_view_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_view_form" value="<?php echo $pdf_view_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_view_form" >
						<option value="" <?php echo !isset($pob_view_form) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_view_form) && strrpos(",".$pob_view_form.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_view_form" value="<?php echo $pob_view_form ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="table_columns">Table columns</td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_name = $res;
			$postValue = $_POST['pdf_show_table_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_name)) {
						$values = array($postValue, show_table_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_name = $res;
			}
			$postValue = $_POST['pob_show_table_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_name)) {
						$values = array($postValue, show_table_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_table_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_name" >
						<option value="" <?php echo !isset($pdf_show_table_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_name) && strrpos(",".$pdf_show_table_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_name" value="<?php echo $pdf_show_table_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_name" >
						<option value="" <?php echo !isset($pob_show_table_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_name) && strrpos(",".$pob_show_table_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_name" value="<?php echo $pob_show_table_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_time = $res;
			$postValue = $_POST['pdf_show_table_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_execution_time)) {
						$values = array($postValue, show_table_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_time = $res;
			}
			$postValue = $_POST['pob_show_table_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_execution_time)) {
						$values = array($postValue, show_table_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_time = $res;
			}
?>
		<tr>
			<td title="">
					show_table_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_execution_time" >
						<option value="" <?php echo !isset($pdf_show_table_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_execution_time) && strrpos(",".$pdf_show_table_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_execution_time" value="<?php echo $pdf_show_table_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_execution_time" >
						<option value="" <?php echo !isset($pob_show_table_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_execution_time) && strrpos(",".$pob_show_table_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_execution_time" value="<?php echo $pob_show_table_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_description = $res;
			$postValue = $_POST['pdf_show_table_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_description)) {
						$values = array($postValue, show_table_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_description = $res;
			}
			$postValue = $_POST['pob_show_table_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_description)) {
						$values = array($postValue, show_table_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_description = $res;
			}
?>
		<tr>
			<td title="">
					show_table_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_description" >
						<option value="" <?php echo !isset($pdf_show_table_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_description) && strrpos(",".$pdf_show_table_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_description" value="<?php echo $pdf_show_table_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_description" >
						<option value="" <?php echo !isset($pob_show_table_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_description) && strrpos(",".$pob_show_table_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_description" value="<?php echo $pob_show_table_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_initiation_code = $res;
			$postValue = $_POST['pdf_show_table_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_initiation_code)) {
						$values = array($postValue, show_table_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_initiation_code = $res;
			}
			$postValue = $_POST['pob_show_table_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_initiation_code)) {
						$values = array($postValue, show_table_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_initiation_code = $res;
			}
?>
		<tr>
			<td title="">
					show_table_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_table_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_initiation_code) && strrpos(",".$pdf_show_table_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_initiation_code" value="<?php echo $pdf_show_table_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_initiation_code" >
						<option value="" <?php echo !isset($pob_show_table_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_initiation_code) && strrpos(",".$pob_show_table_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_initiation_code" value="<?php echo $pob_show_table_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_code = $res;
			$postValue = $_POST['pdf_show_table_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_execution_code)) {
						$values = array($postValue, show_table_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_code = $res;
			}
			$postValue = $_POST['pob_show_table_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_execution_code)) {
						$values = array($postValue, show_table_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_execution_code = $res;
			}
?>
		<tr>
			<td title="">
					show_table_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_execution_code" >
						<option value="" <?php echo !isset($pdf_show_table_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_execution_code) && strrpos(",".$pdf_show_table_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_execution_code" value="<?php echo $pdf_show_table_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_execution_code" >
						<option value="" <?php echo !isset($pob_show_table_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_execution_code) && strrpos(",".$pob_show_table_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_execution_code" value="<?php echo $pob_show_table_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_closing_code = $res;
			$postValue = $_POST['pdf_show_table_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_closing_code)) {
						$values = array($postValue, show_table_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_closing_code = $res;
			}
			$postValue = $_POST['pob_show_table_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_closing_code)) {
						$values = array($postValue, show_table_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_closing_code = $res;
			}
?>
		<tr>
			<td title="">
					show_table_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_closing_code" >
						<option value="" <?php echo !isset($pdf_show_table_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_closing_code) && strrpos(",".$pdf_show_table_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_closing_code" value="<?php echo $pdf_show_table_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_closing_code" >
						<option value="" <?php echo !isset($pob_show_table_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_closing_code) && strrpos(",".$pob_show_table_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_closing_code" value="<?php echo $pob_show_table_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_portion_size = $res;
			$postValue = $_POST['pdf_show_table_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_portion_size)) {
						$values = array($postValue, show_table_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_portion_size = $res;
			}
			$postValue = $_POST['pob_show_table_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_portion_size)) {
						$values = array($postValue, show_table_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_portion_size = $res;
			}
?>
		<tr>
			<td title="">
					show_table_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_portion_size" >
						<option value="" <?php echo !isset($pdf_show_table_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_portion_size) && strrpos(",".$pdf_show_table_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_portion_size" value="<?php echo $pdf_show_table_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_portion_size" >
						<option value="" <?php echo !isset($pob_show_table_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_portion_size) && strrpos(",".$pob_show_table_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_portion_size" value="<?php echo $pob_show_table_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_active = $res;
			$postValue = $_POST['pdf_show_table_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_active)) {
						$values = array($postValue, show_table_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_active = $res;
			}
			$postValue = $_POST['pob_show_table_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_active)) {
						$values = array($postValue, show_table_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_active = $res;
			}
?>
		<tr>
			<td title="">
					show_table_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_active" >
						<option value="" <?php echo !isset($pdf_show_table_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_active) && strrpos(",".$pdf_show_table_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_active" value="<?php echo $pdf_show_table_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_active" >
						<option value="" <?php echo !isset($pob_show_table_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_active) && strrpos(",".$pob_show_table_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_active" value="<?php echo $pob_show_table_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_order = $res;
			$postValue = $_POST['pdf_show_table_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_order)) {
						$values = array($postValue, show_table_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_order = $res;
			}
			$postValue = $_POST['pob_show_table_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_order)) {
						$values = array($postValue, show_table_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_order = $res;
			}
?>
		<tr>
			<td title="">
					show_table_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_order" >
						<option value="" <?php echo !isset($pdf_show_table_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_order) && strrpos(",".$pdf_show_table_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_order" value="<?php echo $pdf_show_table_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_order" >
						<option value="" <?php echo !isset($pob_show_table_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_order) && strrpos(",".$pob_show_table_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_order" value="<?php echo $pob_show_table_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_last_session = $res;
			$postValue = $_POST['pdf_show_table_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_last_session)) {
						$values = array($postValue, show_table_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_last_session = $res;
			}
			$postValue = $_POST['pob_show_table_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_last_session)) {
						$values = array($postValue, show_table_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_last_session = $res;
			}
?>
		<tr>
			<td title="">
					show_table_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_last_session" >
						<option value="" <?php echo !isset($pdf_show_table_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_last_session) && strrpos(",".$pdf_show_table_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_last_session" value="<?php echo $pdf_show_table_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_last_session" >
						<option value="" <?php echo !isset($pob_show_table_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_last_session) && strrpos(",".$pob_show_table_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_last_session" value="<?php echo $pob_show_table_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_subprocess_count = $res;
			$postValue = $_POST['pdf_show_table_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_subprocess_count)) {
						$values = array($postValue, show_table_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_subprocess_count = $res;
			}
			$postValue = $_POST['pob_show_table_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_subprocess_count)) {
						$values = array($postValue, show_table_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_subprocess_count = $res;
			}
?>
		<tr>
			<td title="">
					show_table_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_table_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_subprocess_count) && strrpos(",".$pdf_show_table_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_subprocess_count" value="<?php echo $pdf_show_table_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_table_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_subprocess_count) && strrpos(",".$pob_show_table_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_subprocess_count" value="<?php echo $pob_show_table_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_clear = $res;
			$postValue = $_POST['pdf_show_table_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_clear)) {
						$values = array($postValue, show_table_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_clear = $res;
			}
			$postValue = $_POST['pob_show_table_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_clear)) {
						$values = array($postValue, show_table_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_clear = $res;
			}
?>
		<tr>
			<td title="">
					show_table_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_clear" >
						<option value="" <?php echo !isset($pdf_show_table_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_clear) && strrpos(",".$pdf_show_table_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_clear" value="<?php echo $pdf_show_table_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_clear" >
						<option value="" <?php echo !isset($pob_show_table_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_clear) && strrpos(",".$pob_show_table_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_clear" value="<?php echo $pob_show_table_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_table_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_executions = $res;
			$postValue = $_POST['pdf_show_table_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_table_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_table_executions)) {
						$values = array($postValue, show_table_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_executions = $res;
			}
			$postValue = $_POST['pob_show_table_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_table_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_table_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_table_executions)) {
						$values = array($postValue, show_table_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_table_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_table_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_table_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_table_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_table_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_table_executions" >
						<option value="" <?php echo !isset($pdf_show_table_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_table_executions) && strrpos(",".$pdf_show_table_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_table_executions" value="<?php echo $pdf_show_table_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_table_executions" >
						<option value="" <?php echo !isset($pob_show_table_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_table_executions) && strrpos(",".$pob_show_table_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_table_executions" value="<?php echo $pob_show_table_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="create_columns">Create columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_name = $res;
			$postValue = $_POST['pdf_show_create_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_name)) {
						$values = array($postValue, show_create_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_name = $res;
			}
			$postValue = $_POST['pob_show_create_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_name)) {
						$values = array($postValue, show_create_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_create_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_name" >
						<option value="" <?php echo !isset($pdf_show_create_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_name) && strrpos(",".$pdf_show_create_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_name" value="<?php echo $pdf_show_create_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_name" >
						<option value="" <?php echo !isset($pob_show_create_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_name) && strrpos(",".$pob_show_create_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_name" value="<?php echo $pob_show_create_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time = $res;
			$values = array("show_create_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time_obligatory = $res;
			$postValue = $_POST['pdf_show_create_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_execution_time)) {
						$values = array($postValue, show_create_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time = $res;
			$values = array("show_create_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_execution_time)) {
						$values = array($postValue, show_create_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time = $res;
			$values = array("show_create_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_execution_time_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_execution_time_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_time_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_execution_time_obligatory)) {
						$values = array($postValue, show_create_execution_time_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_time_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_time_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_time_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time_obligatory = $res;
			$values = array("show_create_execution_time_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_time_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_execution_time" >
						<option value="" <?php echo !isset($pdf_show_create_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_execution_time) && strrpos(",".$pdf_show_create_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_execution_time" value="<?php echo $pdf_show_create_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_execution_time_obligatory" value="1" <?php echo $pob_show_create_execution_time_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_execution_time" >
						<option value="" <?php echo !isset($pob_show_create_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_execution_time) && strrpos(",".$pob_show_create_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_execution_time" value="<?php echo $pob_show_create_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description = $res;
			$values = array("show_create_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description_obligatory = $res;
			$postValue = $_POST['pdf_show_create_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_description)) {
						$values = array($postValue, show_create_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description = $res;
			$values = array("show_create_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_description)) {
						$values = array($postValue, show_create_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description = $res;
			$values = array("show_create_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_description_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_description_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_description_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_description_obligatory)) {
						$values = array($postValue, show_create_description_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_description_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_description_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_description_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description_obligatory = $res;
			$values = array("show_create_description_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_description_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_description" >
						<option value="" <?php echo !isset($pdf_show_create_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_description) && strrpos(",".$pdf_show_create_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_description" value="<?php echo $pdf_show_create_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_description_obligatory" value="1" <?php echo $pob_show_create_description_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_description" >
						<option value="" <?php echo !isset($pob_show_create_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_description) && strrpos(",".$pob_show_create_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_description" value="<?php echo $pob_show_create_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code = $res;
			$values = array("show_create_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code_obligatory = $res;
			$postValue = $_POST['pdf_show_create_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_initiation_code)) {
						$values = array($postValue, show_create_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code = $res;
			$values = array("show_create_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_initiation_code)) {
						$values = array($postValue, show_create_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code = $res;
			$values = array("show_create_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_initiation_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_initiation_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_initiation_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_initiation_code_obligatory)) {
						$values = array($postValue, show_create_initiation_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_initiation_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_initiation_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_initiation_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code_obligatory = $res;
			$values = array("show_create_initiation_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_initiation_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_create_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_initiation_code) && strrpos(",".$pdf_show_create_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_initiation_code" value="<?php echo $pdf_show_create_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_initiation_code_obligatory" value="1" <?php echo $pob_show_create_initiation_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_initiation_code" >
						<option value="" <?php echo !isset($pob_show_create_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_initiation_code) && strrpos(",".$pob_show_create_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_initiation_code" value="<?php echo $pob_show_create_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code = $res;
			$values = array("show_create_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code_obligatory = $res;
			$postValue = $_POST['pdf_show_create_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_execution_code)) {
						$values = array($postValue, show_create_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code = $res;
			$values = array("show_create_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_execution_code)) {
						$values = array($postValue, show_create_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code = $res;
			$values = array("show_create_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_execution_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_execution_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_execution_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_execution_code_obligatory)) {
						$values = array($postValue, show_create_execution_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_execution_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_execution_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_execution_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code_obligatory = $res;
			$values = array("show_create_execution_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_execution_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_execution_code" >
						<option value="" <?php echo !isset($pdf_show_create_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_execution_code) && strrpos(",".$pdf_show_create_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_execution_code" value="<?php echo $pdf_show_create_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_execution_code_obligatory" value="1" <?php echo $pob_show_create_execution_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_execution_code" >
						<option value="" <?php echo !isset($pob_show_create_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_execution_code) && strrpos(",".$pob_show_create_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_execution_code" value="<?php echo $pob_show_create_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code = $res;
			$values = array("show_create_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code_obligatory = $res;
			$postValue = $_POST['pdf_show_create_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_closing_code)) {
						$values = array($postValue, show_create_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code = $res;
			$values = array("show_create_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_closing_code)) {
						$values = array($postValue, show_create_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code = $res;
			$values = array("show_create_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_closing_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_closing_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_closing_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_closing_code_obligatory)) {
						$values = array($postValue, show_create_closing_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_closing_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_closing_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_closing_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code_obligatory = $res;
			$values = array("show_create_closing_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_closing_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_closing_code" >
						<option value="" <?php echo !isset($pdf_show_create_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_closing_code) && strrpos(",".$pdf_show_create_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_closing_code" value="<?php echo $pdf_show_create_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_closing_code_obligatory" value="1" <?php echo $pob_show_create_closing_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_closing_code" >
						<option value="" <?php echo !isset($pob_show_create_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_closing_code) && strrpos(",".$pob_show_create_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_closing_code" value="<?php echo $pob_show_create_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size = $res;
			$values = array("show_create_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size_obligatory = $res;
			$postValue = $_POST['pdf_show_create_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_portion_size)) {
						$values = array($postValue, show_create_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size = $res;
			$values = array("show_create_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_portion_size)) {
						$values = array($postValue, show_create_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size = $res;
			$values = array("show_create_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_portion_size_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_portion_size_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_portion_size_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_portion_size_obligatory)) {
						$values = array($postValue, show_create_portion_size_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_portion_size_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_portion_size_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_portion_size_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size_obligatory = $res;
			$values = array("show_create_portion_size_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_portion_size_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_portion_size" >
						<option value="" <?php echo !isset($pdf_show_create_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_portion_size) && strrpos(",".$pdf_show_create_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_portion_size" value="<?php echo $pdf_show_create_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_portion_size_obligatory" value="1" <?php echo $pob_show_create_portion_size_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_portion_size" >
						<option value="" <?php echo !isset($pob_show_create_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_portion_size) && strrpos(",".$pob_show_create_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_portion_size" value="<?php echo $pob_show_create_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active = $res;
			$values = array("show_create_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active_obligatory = $res;
			$postValue = $_POST['pdf_show_create_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_active)) {
						$values = array($postValue, show_create_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active = $res;
			$values = array("show_create_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_active)) {
						$values = array($postValue, show_create_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active = $res;
			$values = array("show_create_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_active_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_active_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_active_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_active_obligatory)) {
						$values = array($postValue, show_create_active_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_active_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_active_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_active_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active_obligatory = $res;
			$values = array("show_create_active_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_active_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_active" >
						<option value="" <?php echo !isset($pdf_show_create_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_active) && strrpos(",".$pdf_show_create_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_active" value="<?php echo $pdf_show_create_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_active_obligatory" value="1" <?php echo $pob_show_create_active_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_active" >
						<option value="" <?php echo !isset($pob_show_create_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_active) && strrpos(",".$pob_show_create_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_active" value="<?php echo $pob_show_create_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order = $res;
			$values = array("show_create_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order_obligatory = $res;
			$postValue = $_POST['pdf_show_create_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_order)) {
						$values = array($postValue, show_create_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order = $res;
			$values = array("show_create_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_order)) {
						$values = array($postValue, show_create_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order = $res;
			$values = array("show_create_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_order_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_order_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_order_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_order_obligatory)) {
						$values = array($postValue, show_create_order_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_order_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_order_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_order_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order_obligatory = $res;
			$values = array("show_create_order_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_order_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_order" >
						<option value="" <?php echo !isset($pdf_show_create_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_order) && strrpos(",".$pdf_show_create_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_order" value="<?php echo $pdf_show_create_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_order_obligatory" value="1" <?php echo $pob_show_create_order_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_order" >
						<option value="" <?php echo !isset($pob_show_create_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_order) && strrpos(",".$pob_show_create_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_order" value="<?php echo $pob_show_create_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session = $res;
			$values = array("show_create_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session_obligatory = $res;
			$postValue = $_POST['pdf_show_create_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_last_session)) {
						$values = array($postValue, show_create_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session = $res;
			$values = array("show_create_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_last_session)) {
						$values = array($postValue, show_create_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session = $res;
			$values = array("show_create_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_last_session_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_last_session_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_last_session_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_last_session_obligatory)) {
						$values = array($postValue, show_create_last_session_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_last_session_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_last_session_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_last_session_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session_obligatory = $res;
			$values = array("show_create_last_session_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_last_session_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_last_session" >
						<option value="" <?php echo !isset($pdf_show_create_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_last_session) && strrpos(",".$pdf_show_create_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_last_session" value="<?php echo $pdf_show_create_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_last_session_obligatory" value="1" <?php echo $pob_show_create_last_session_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_last_session" >
						<option value="" <?php echo !isset($pob_show_create_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_last_session) && strrpos(",".$pob_show_create_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_last_session" value="<?php echo $pob_show_create_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count = $res;
			$values = array("show_create_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count_obligatory = $res;
			$postValue = $_POST['pdf_show_create_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_subprocess_count)) {
						$values = array($postValue, show_create_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count = $res;
			$values = array("show_create_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_subprocess_count)) {
						$values = array($postValue, show_create_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count = $res;
			$values = array("show_create_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_subprocess_count_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_subprocess_count_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_subprocess_count_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_subprocess_count_obligatory)) {
						$values = array($postValue, show_create_subprocess_count_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_subprocess_count_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_subprocess_count_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_subprocess_count_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count_obligatory = $res;
			$values = array("show_create_subprocess_count_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_subprocess_count_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_create_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_subprocess_count) && strrpos(",".$pdf_show_create_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_subprocess_count" value="<?php echo $pdf_show_create_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_subprocess_count_obligatory" value="1" <?php echo $pob_show_create_subprocess_count_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_create_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_subprocess_count) && strrpos(",".$pob_show_create_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_subprocess_count" value="<?php echo $pob_show_create_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_create_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear = $res;
			$values = array("show_create_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear_obligatory = $res;
			$postValue = $_POST['pdf_show_create_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_clear)) {
						$values = array($postValue, show_create_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear = $res;
			$values = array("show_create_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_clear)) {
						$values = array($postValue, show_create_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear = $res;
			$values = array("show_create_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear_obligatory = $res;
			}
			$postValue = $_POST['pob_show_create_clear_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_clear_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_clear_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_clear_obligatory)) {
						$values = array($postValue, show_create_clear_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_clear_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_clear_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_clear_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear_obligatory = $res;
			$values = array("show_create_clear_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_clear_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_create_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_clear" >
						<option value="" <?php echo !isset($pdf_show_create_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_clear) && strrpos(",".$pdf_show_create_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_clear" value="<?php echo $pdf_show_create_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_create_clear_obligatory" value="1" <?php echo $pob_show_create_clear_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_clear" >
						<option value="" <?php echo !isset($pob_show_create_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_clear) && strrpos(",".$pob_show_create_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_clear" value="<?php echo $pob_show_create_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_create_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_executions = $res;
			$postValue = $_POST['pdf_show_create_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_create_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_create_executions)) {
						$values = array($postValue, show_create_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_executions = $res;
			}
			$postValue = $_POST['pob_show_create_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_create_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_create_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_create_executions)) {
						$values = array($postValue, show_create_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_create_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_create_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_create_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_create_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_create_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_create_executions" >
						<option value="" <?php echo !isset($pdf_show_create_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_create_executions) && strrpos(",".$pdf_show_create_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_create_executions" value="<?php echo $pdf_show_create_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_create_executions" >
						<option value="" <?php echo !isset($pob_show_create_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_create_executions) && strrpos(",".$pob_show_create_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_create_executions" value="<?php echo $pob_show_create_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="form_columns">Form columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
?>
<?php
			$types = "s";
			$values = array('show_form_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_name = $res;
			$postValue = $_POST['pdf_show_form_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_name)) {
						$values = array($postValue, show_form_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_name = $res;
			}
			$postValue = $_POST['pob_show_form_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_name)) {
						$values = array($postValue, show_form_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_form_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_name" >
						<option value="" <?php echo !isset($pdf_show_form_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_name) && strrpos(",".$pdf_show_form_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_name" value="<?php echo $pdf_show_form_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_name" >
						<option value="" <?php echo !isset($pob_show_form_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_name) && strrpos(",".$pob_show_form_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_name" value="<?php echo $pob_show_form_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time = $res;
			$values = array("show_form_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time_obligatory = $res;
			$postValue = $_POST['pdf_show_form_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_execution_time)) {
						$values = array($postValue, show_form_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time = $res;
			$values = array("show_form_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_execution_time)) {
						$values = array($postValue, show_form_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time = $res;
			$values = array("show_form_execution_time_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_execution_time_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_execution_time_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_time_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_execution_time_obligatory)) {
						$values = array($postValue, show_form_execution_time_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_time_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_time_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_time_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time_obligatory = $res;
			$values = array("show_form_execution_time_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_time_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_execution_time" >
						<option value="" <?php echo !isset($pdf_show_form_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_execution_time) && strrpos(",".$pdf_show_form_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_execution_time" value="<?php echo $pdf_show_form_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_execution_time_obligatory" value="1" <?php echo $pob_show_form_execution_time_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_execution_time" >
						<option value="" <?php echo !isset($pob_show_form_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_execution_time) && strrpos(",".$pob_show_form_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_execution_time" value="<?php echo $pob_show_form_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description = $res;
			$values = array("show_form_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description_obligatory = $res;
			$postValue = $_POST['pdf_show_form_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_description)) {
						$values = array($postValue, show_form_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description = $res;
			$values = array("show_form_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_description)) {
						$values = array($postValue, show_form_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description = $res;
			$values = array("show_form_description_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_description_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_description_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_description_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_description_obligatory)) {
						$values = array($postValue, show_form_description_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_description_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_description_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_description_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description_obligatory = $res;
			$values = array("show_form_description_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_description_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_description" >
						<option value="" <?php echo !isset($pdf_show_form_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_description) && strrpos(",".$pdf_show_form_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_description" value="<?php echo $pdf_show_form_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_description_obligatory" value="1" <?php echo $pob_show_form_description_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_description" >
						<option value="" <?php echo !isset($pob_show_form_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_description) && strrpos(",".$pob_show_form_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_description" value="<?php echo $pob_show_form_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code = $res;
			$values = array("show_form_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code_obligatory = $res;
			$postValue = $_POST['pdf_show_form_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_initiation_code)) {
						$values = array($postValue, show_form_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code = $res;
			$values = array("show_form_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_initiation_code)) {
						$values = array($postValue, show_form_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code = $res;
			$values = array("show_form_initiation_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_initiation_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_initiation_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_initiation_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_initiation_code_obligatory)) {
						$values = array($postValue, show_form_initiation_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_initiation_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_initiation_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_initiation_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code_obligatory = $res;
			$values = array("show_form_initiation_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_initiation_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_form_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_initiation_code) && strrpos(",".$pdf_show_form_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_initiation_code" value="<?php echo $pdf_show_form_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_initiation_code_obligatory" value="1" <?php echo $pob_show_form_initiation_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_initiation_code" >
						<option value="" <?php echo !isset($pob_show_form_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_initiation_code) && strrpos(",".$pob_show_form_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_initiation_code" value="<?php echo $pob_show_form_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code = $res;
			$values = array("show_form_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code_obligatory = $res;
			$postValue = $_POST['pdf_show_form_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_execution_code)) {
						$values = array($postValue, show_form_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code = $res;
			$values = array("show_form_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_execution_code)) {
						$values = array($postValue, show_form_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code = $res;
			$values = array("show_form_execution_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_execution_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_execution_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_execution_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_execution_code_obligatory)) {
						$values = array($postValue, show_form_execution_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_execution_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_execution_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_execution_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code_obligatory = $res;
			$values = array("show_form_execution_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_execution_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_execution_code" >
						<option value="" <?php echo !isset($pdf_show_form_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_execution_code) && strrpos(",".$pdf_show_form_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_execution_code" value="<?php echo $pdf_show_form_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_execution_code_obligatory" value="1" <?php echo $pob_show_form_execution_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_execution_code" >
						<option value="" <?php echo !isset($pob_show_form_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_execution_code) && strrpos(",".$pob_show_form_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_execution_code" value="<?php echo $pob_show_form_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code = $res;
			$values = array("show_form_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code_obligatory = $res;
			$postValue = $_POST['pdf_show_form_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_closing_code)) {
						$values = array($postValue, show_form_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code = $res;
			$values = array("show_form_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_closing_code)) {
						$values = array($postValue, show_form_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code = $res;
			$values = array("show_form_closing_code_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_closing_code_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_closing_code_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_closing_code_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_closing_code_obligatory)) {
						$values = array($postValue, show_form_closing_code_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_closing_code_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_closing_code_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_closing_code_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code_obligatory = $res;
			$values = array("show_form_closing_code_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_closing_code_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_closing_code" >
						<option value="" <?php echo !isset($pdf_show_form_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_closing_code) && strrpos(",".$pdf_show_form_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_closing_code" value="<?php echo $pdf_show_form_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_closing_code_obligatory" value="1" <?php echo $pob_show_form_closing_code_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_closing_code" >
						<option value="" <?php echo !isset($pob_show_form_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_closing_code) && strrpos(",".$pob_show_form_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_closing_code" value="<?php echo $pob_show_form_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size = $res;
			$values = array("show_form_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size_obligatory = $res;
			$postValue = $_POST['pdf_show_form_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_portion_size)) {
						$values = array($postValue, show_form_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size = $res;
			$values = array("show_form_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_portion_size)) {
						$values = array($postValue, show_form_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size = $res;
			$values = array("show_form_portion_size_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_portion_size_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_portion_size_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_portion_size_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_portion_size_obligatory)) {
						$values = array($postValue, show_form_portion_size_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_portion_size_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_portion_size_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_portion_size_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size_obligatory = $res;
			$values = array("show_form_portion_size_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_portion_size_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_portion_size" >
						<option value="" <?php echo !isset($pdf_show_form_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_portion_size) && strrpos(",".$pdf_show_form_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_portion_size" value="<?php echo $pdf_show_form_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_portion_size_obligatory" value="1" <?php echo $pob_show_form_portion_size_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_portion_size" >
						<option value="" <?php echo !isset($pob_show_form_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_portion_size) && strrpos(",".$pob_show_form_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_portion_size" value="<?php echo $pob_show_form_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active = $res;
			$values = array("show_form_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active_obligatory = $res;
			$postValue = $_POST['pdf_show_form_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_active)) {
						$values = array($postValue, show_form_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active = $res;
			$values = array("show_form_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_active)) {
						$values = array($postValue, show_form_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active = $res;
			$values = array("show_form_active_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_active_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_active_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_active_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_active_obligatory)) {
						$values = array($postValue, show_form_active_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_active_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_active_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_active_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active_obligatory = $res;
			$values = array("show_form_active_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_active_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_active" >
						<option value="" <?php echo !isset($pdf_show_form_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_active) && strrpos(",".$pdf_show_form_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_active" value="<?php echo $pdf_show_form_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_active_obligatory" value="1" <?php echo $pob_show_form_active_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_active" >
						<option value="" <?php echo !isset($pob_show_form_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_active) && strrpos(",".$pob_show_form_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_active" value="<?php echo $pob_show_form_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order = $res;
			$values = array("show_form_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order_obligatory = $res;
			$postValue = $_POST['pdf_show_form_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_order)) {
						$values = array($postValue, show_form_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order = $res;
			$values = array("show_form_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_order)) {
						$values = array($postValue, show_form_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order = $res;
			$values = array("show_form_order_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_order_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_order_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_order_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_order_obligatory)) {
						$values = array($postValue, show_form_order_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_order_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_order_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_order_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order_obligatory = $res;
			$values = array("show_form_order_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_order_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_order" >
						<option value="" <?php echo !isset($pdf_show_form_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_order) && strrpos(",".$pdf_show_form_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_order" value="<?php echo $pdf_show_form_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_order_obligatory" value="1" <?php echo $pob_show_form_order_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_order" >
						<option value="" <?php echo !isset($pob_show_form_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_order) && strrpos(",".$pob_show_form_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_order" value="<?php echo $pob_show_form_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session = $res;
			$values = array("show_form_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session_obligatory = $res;
			$postValue = $_POST['pdf_show_form_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_last_session)) {
						$values = array($postValue, show_form_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session = $res;
			$values = array("show_form_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_last_session)) {
						$values = array($postValue, show_form_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session = $res;
			$values = array("show_form_last_session_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_last_session_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_last_session_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_last_session_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_last_session_obligatory)) {
						$values = array($postValue, show_form_last_session_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_last_session_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_last_session_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_last_session_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session_obligatory = $res;
			$values = array("show_form_last_session_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_last_session_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_last_session" >
						<option value="" <?php echo !isset($pdf_show_form_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_last_session) && strrpos(",".$pdf_show_form_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_last_session" value="<?php echo $pdf_show_form_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_last_session_obligatory" value="1" <?php echo $pob_show_form_last_session_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_last_session" >
						<option value="" <?php echo !isset($pob_show_form_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_last_session) && strrpos(",".$pob_show_form_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_last_session" value="<?php echo $pob_show_form_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count = $res;
			$values = array("show_form_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count_obligatory = $res;
			$postValue = $_POST['pdf_show_form_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_subprocess_count)) {
						$values = array($postValue, show_form_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count = $res;
			$values = array("show_form_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_subprocess_count)) {
						$values = array($postValue, show_form_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count = $res;
			$values = array("show_form_subprocess_count_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_subprocess_count_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_subprocess_count_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_subprocess_count_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_subprocess_count_obligatory)) {
						$values = array($postValue, show_form_subprocess_count_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_subprocess_count_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_subprocess_count_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_subprocess_count_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count_obligatory = $res;
			$values = array("show_form_subprocess_count_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_subprocess_count_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_form_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_subprocess_count) && strrpos(",".$pdf_show_form_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_subprocess_count" value="<?php echo $pdf_show_form_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_subprocess_count_obligatory" value="1" <?php echo $pob_show_form_subprocess_count_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_form_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_subprocess_count) && strrpos(",".$pob_show_form_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_subprocess_count" value="<?php echo $pob_show_form_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_form_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear = $res;
			$values = array("show_form_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear_obligatory = $res;
			$postValue = $_POST['pdf_show_form_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_clear)) {
						$values = array($postValue, show_form_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear = $res;
			$values = array("show_form_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_clear)) {
						$values = array($postValue, show_form_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear = $res;
			$values = array("show_form_clear_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear_obligatory = $res;
			}
			$postValue = $_POST['pob_show_form_clear_obligatory'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_clear_obligatory != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_clear_obligatory);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_clear_obligatory)) {
						$values = array($postValue, show_form_clear_obligatory);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_clear_obligatory, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_clear_obligatory');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_clear_obligatory = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear_obligatory = $res;
			$values = array("show_form_clear_obligatory_obligatory");
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_clear_obligatory_obligatory = $res;
			}
?>
		<tr>
			<td title="">
					show_form_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_clear" >
						<option value="" <?php echo !isset($pdf_show_form_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_clear) && strrpos(",".$pdf_show_form_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_clear" value="<?php echo $pdf_show_form_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
					Obl:<input type="checkbox" name="pob_show_form_clear_obligatory" value="1" <?php echo $pob_show_form_clear_obligatory == "1" ? " checked='checked' " : "" ?>/>
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_clear" >
						<option value="" <?php echo !isset($pob_show_form_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_clear) && strrpos(",".$pob_show_form_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_clear" value="<?php echo $pob_show_form_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["2"] = "Read";
			$options["1"] = "Change";
			$options["3"] = "Change Ajax";
?>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_form_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_executions = $res;
			$postValue = $_POST['pdf_show_form_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_form_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_form_executions)) {
						$values = array($postValue, show_form_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_executions = $res;
			}
			$postValue = $_POST['pob_show_form_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_form_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_form_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_form_executions)) {
						$values = array($postValue, show_form_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_form_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_form_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_form_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_form_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_form_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_form_executions" >
						<option value="" <?php echo !isset($pdf_show_form_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_form_executions) && strrpos(",".$pdf_show_form_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_form_executions" value="<?php echo $pdf_show_form_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_form_executions" >
						<option value="" <?php echo !isset($pob_show_form_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_form_executions) && strrpos(",".$pob_show_form_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_form_executions" value="<?php echo $pob_show_form_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="view_columns">View columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<?php
			$types = "s";
			$values = array('show_view_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_name = $res;
			$postValue = $_POST['pdf_show_view_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_name)) {
						$values = array($postValue, show_view_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_name = $res;
			}
			$postValue = $_POST['pob_show_view_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_name)) {
						$values = array($postValue, show_view_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_view_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_name" >
						<option value="" <?php echo !isset($pdf_show_view_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_name) && strrpos(",".$pdf_show_view_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_name" value="<?php echo $pdf_show_view_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_name" >
						<option value="" <?php echo !isset($pob_show_view_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_name) && strrpos(",".$pob_show_view_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_name" value="<?php echo $pob_show_view_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_time = $res;
			$postValue = $_POST['pdf_show_view_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_execution_time)) {
						$values = array($postValue, show_view_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_time = $res;
			}
			$postValue = $_POST['pob_show_view_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_execution_time)) {
						$values = array($postValue, show_view_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_time = $res;
			}
?>
		<tr>
			<td title="">
					show_view_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_execution_time" >
						<option value="" <?php echo !isset($pdf_show_view_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_execution_time) && strrpos(",".$pdf_show_view_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_execution_time" value="<?php echo $pdf_show_view_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_execution_time" >
						<option value="" <?php echo !isset($pob_show_view_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_execution_time) && strrpos(",".$pob_show_view_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_execution_time" value="<?php echo $pob_show_view_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_description = $res;
			$postValue = $_POST['pdf_show_view_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_description)) {
						$values = array($postValue, show_view_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_description = $res;
			}
			$postValue = $_POST['pob_show_view_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_description)) {
						$values = array($postValue, show_view_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_description = $res;
			}
?>
		<tr>
			<td title="">
					show_view_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_description" >
						<option value="" <?php echo !isset($pdf_show_view_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_description) && strrpos(",".$pdf_show_view_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_description" value="<?php echo $pdf_show_view_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_description" >
						<option value="" <?php echo !isset($pob_show_view_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_description) && strrpos(",".$pob_show_view_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_description" value="<?php echo $pob_show_view_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_initiation_code = $res;
			$postValue = $_POST['pdf_show_view_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_initiation_code)) {
						$values = array($postValue, show_view_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_initiation_code = $res;
			}
			$postValue = $_POST['pob_show_view_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_initiation_code)) {
						$values = array($postValue, show_view_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_initiation_code = $res;
			}
?>
		<tr>
			<td title="">
					show_view_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_view_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_initiation_code) && strrpos(",".$pdf_show_view_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_initiation_code" value="<?php echo $pdf_show_view_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_initiation_code" >
						<option value="" <?php echo !isset($pob_show_view_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_initiation_code) && strrpos(",".$pob_show_view_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_initiation_code" value="<?php echo $pob_show_view_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_code = $res;
			$postValue = $_POST['pdf_show_view_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_execution_code)) {
						$values = array($postValue, show_view_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_code = $res;
			}
			$postValue = $_POST['pob_show_view_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_execution_code)) {
						$values = array($postValue, show_view_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_execution_code = $res;
			}
?>
		<tr>
			<td title="">
					show_view_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_execution_code" >
						<option value="" <?php echo !isset($pdf_show_view_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_execution_code) && strrpos(",".$pdf_show_view_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_execution_code" value="<?php echo $pdf_show_view_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_execution_code" >
						<option value="" <?php echo !isset($pob_show_view_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_execution_code) && strrpos(",".$pob_show_view_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_execution_code" value="<?php echo $pob_show_view_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_closing_code = $res;
			$postValue = $_POST['pdf_show_view_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_closing_code)) {
						$values = array($postValue, show_view_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_closing_code = $res;
			}
			$postValue = $_POST['pob_show_view_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_closing_code)) {
						$values = array($postValue, show_view_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_closing_code = $res;
			}
?>
		<tr>
			<td title="">
					show_view_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_closing_code" >
						<option value="" <?php echo !isset($pdf_show_view_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_closing_code) && strrpos(",".$pdf_show_view_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_closing_code" value="<?php echo $pdf_show_view_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_closing_code" >
						<option value="" <?php echo !isset($pob_show_view_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_closing_code) && strrpos(",".$pob_show_view_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_closing_code" value="<?php echo $pob_show_view_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_portion_size = $res;
			$postValue = $_POST['pdf_show_view_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_portion_size)) {
						$values = array($postValue, show_view_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_portion_size = $res;
			}
			$postValue = $_POST['pob_show_view_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_portion_size)) {
						$values = array($postValue, show_view_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_portion_size = $res;
			}
?>
		<tr>
			<td title="">
					show_view_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_portion_size" >
						<option value="" <?php echo !isset($pdf_show_view_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_portion_size) && strrpos(",".$pdf_show_view_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_portion_size" value="<?php echo $pdf_show_view_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_portion_size" >
						<option value="" <?php echo !isset($pob_show_view_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_portion_size) && strrpos(",".$pob_show_view_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_portion_size" value="<?php echo $pob_show_view_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_active = $res;
			$postValue = $_POST['pdf_show_view_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_active)) {
						$values = array($postValue, show_view_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_active = $res;
			}
			$postValue = $_POST['pob_show_view_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_active)) {
						$values = array($postValue, show_view_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_active = $res;
			}
?>
		<tr>
			<td title="">
					show_view_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_active" >
						<option value="" <?php echo !isset($pdf_show_view_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_active) && strrpos(",".$pdf_show_view_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_active" value="<?php echo $pdf_show_view_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_active" >
						<option value="" <?php echo !isset($pob_show_view_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_active) && strrpos(",".$pob_show_view_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_active" value="<?php echo $pob_show_view_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_order = $res;
			$postValue = $_POST['pdf_show_view_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_order)) {
						$values = array($postValue, show_view_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_order = $res;
			}
			$postValue = $_POST['pob_show_view_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_order)) {
						$values = array($postValue, show_view_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_order = $res;
			}
?>
		<tr>
			<td title="">
					show_view_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_order" >
						<option value="" <?php echo !isset($pdf_show_view_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_order) && strrpos(",".$pdf_show_view_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_order" value="<?php echo $pdf_show_view_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_order" >
						<option value="" <?php echo !isset($pob_show_view_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_order) && strrpos(",".$pob_show_view_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_order" value="<?php echo $pob_show_view_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_last_session = $res;
			$postValue = $_POST['pdf_show_view_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_last_session)) {
						$values = array($postValue, show_view_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_last_session = $res;
			}
			$postValue = $_POST['pob_show_view_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_last_session)) {
						$values = array($postValue, show_view_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_last_session = $res;
			}
?>
		<tr>
			<td title="">
					show_view_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_last_session" >
						<option value="" <?php echo !isset($pdf_show_view_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_last_session) && strrpos(",".$pdf_show_view_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_last_session" value="<?php echo $pdf_show_view_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_last_session" >
						<option value="" <?php echo !isset($pob_show_view_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_last_session) && strrpos(",".$pob_show_view_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_last_session" value="<?php echo $pob_show_view_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_subprocess_count = $res;
			$postValue = $_POST['pdf_show_view_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_subprocess_count)) {
						$values = array($postValue, show_view_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_subprocess_count = $res;
			}
			$postValue = $_POST['pob_show_view_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_subprocess_count)) {
						$values = array($postValue, show_view_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_subprocess_count = $res;
			}
?>
		<tr>
			<td title="">
					show_view_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_view_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_subprocess_count) && strrpos(",".$pdf_show_view_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_subprocess_count" value="<?php echo $pdf_show_view_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_view_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_subprocess_count) && strrpos(",".$pob_show_view_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_subprocess_count" value="<?php echo $pob_show_view_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_view_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_clear = $res;
			$postValue = $_POST['pdf_show_view_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_clear)) {
						$values = array($postValue, show_view_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_clear = $res;
			}
			$postValue = $_POST['pob_show_view_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_clear)) {
						$values = array($postValue, show_view_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_clear = $res;
			}
?>
		<tr>
			<td title="">
					show_view_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_clear" >
						<option value="" <?php echo !isset($pdf_show_view_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_clear) && strrpos(",".$pdf_show_view_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_clear" value="<?php echo $pdf_show_view_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_clear" >
						<option value="" <?php echo !isset($pob_show_view_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_clear) && strrpos(",".$pob_show_view_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_clear" value="<?php echo $pob_show_view_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_view_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_executions = $res;
			$postValue = $_POST['pdf_show_view_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_view_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_view_executions)) {
						$values = array($postValue, show_view_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_executions = $res;
			}
			$postValue = $_POST['pob_show_view_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_view_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_view_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_view_executions)) {
						$values = array($postValue, show_view_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_view_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_view_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_view_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_view_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_view_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_view_executions" >
						<option value="" <?php echo !isset($pdf_show_view_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_view_executions) && strrpos(",".$pdf_show_view_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_view_executions" value="<?php echo $pdf_show_view_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_view_executions" >
						<option value="" <?php echo !isset($pob_show_view_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_view_executions) && strrpos(",".$pob_show_view_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_view_executions" value="<?php echo $pob_show_view_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="search_columns">Search columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<?php
			$types = "s";
			$values = array('show_search_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_name = $res;
			$postValue = $_POST['pdf_show_search_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_name)) {
						$values = array($postValue, show_search_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_name = $res;
			}
			$postValue = $_POST['pob_show_search_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_name)) {
						$values = array($postValue, show_search_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_search_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_name" >
						<option value="" <?php echo !isset($pdf_show_search_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_name) && strrpos(",".$pdf_show_search_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_name" value="<?php echo $pdf_show_search_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_name" >
						<option value="" <?php echo !isset($pob_show_search_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_name) && strrpos(",".$pob_show_search_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_name" value="<?php echo $pob_show_search_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_time = $res;
			$postValue = $_POST['pdf_show_search_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_execution_time)) {
						$values = array($postValue, show_search_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_time = $res;
			}
			$postValue = $_POST['pob_show_search_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_execution_time)) {
						$values = array($postValue, show_search_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_time = $res;
			}
?>
		<tr>
			<td title="">
					show_search_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_execution_time" >
						<option value="" <?php echo !isset($pdf_show_search_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_execution_time) && strrpos(",".$pdf_show_search_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_execution_time" value="<?php echo $pdf_show_search_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_execution_time" >
						<option value="" <?php echo !isset($pob_show_search_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_execution_time) && strrpos(",".$pob_show_search_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_execution_time" value="<?php echo $pob_show_search_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_description = $res;
			$postValue = $_POST['pdf_show_search_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_description)) {
						$values = array($postValue, show_search_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_description = $res;
			}
			$postValue = $_POST['pob_show_search_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_description)) {
						$values = array($postValue, show_search_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_description = $res;
			}
?>
		<tr>
			<td title="">
					show_search_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_description" >
						<option value="" <?php echo !isset($pdf_show_search_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_description) && strrpos(",".$pdf_show_search_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_description" value="<?php echo $pdf_show_search_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_description" >
						<option value="" <?php echo !isset($pob_show_search_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_description) && strrpos(",".$pob_show_search_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_description" value="<?php echo $pob_show_search_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_initiation_code = $res;
			$postValue = $_POST['pdf_show_search_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_initiation_code)) {
						$values = array($postValue, show_search_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_initiation_code = $res;
			}
			$postValue = $_POST['pob_show_search_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_initiation_code)) {
						$values = array($postValue, show_search_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_initiation_code = $res;
			}
?>
		<tr>
			<td title="">
					show_search_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_search_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_initiation_code) && strrpos(",".$pdf_show_search_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_initiation_code" value="<?php echo $pdf_show_search_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_initiation_code" >
						<option value="" <?php echo !isset($pob_show_search_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_initiation_code) && strrpos(",".$pob_show_search_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_initiation_code" value="<?php echo $pob_show_search_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_code = $res;
			$postValue = $_POST['pdf_show_search_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_execution_code)) {
						$values = array($postValue, show_search_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_code = $res;
			}
			$postValue = $_POST['pob_show_search_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_execution_code)) {
						$values = array($postValue, show_search_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_execution_code = $res;
			}
?>
		<tr>
			<td title="">
					show_search_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_execution_code" >
						<option value="" <?php echo !isset($pdf_show_search_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_execution_code) && strrpos(",".$pdf_show_search_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_execution_code" value="<?php echo $pdf_show_search_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_execution_code" >
						<option value="" <?php echo !isset($pob_show_search_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_execution_code) && strrpos(",".$pob_show_search_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_execution_code" value="<?php echo $pob_show_search_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_closing_code = $res;
			$postValue = $_POST['pdf_show_search_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_closing_code)) {
						$values = array($postValue, show_search_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_closing_code = $res;
			}
			$postValue = $_POST['pob_show_search_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_closing_code)) {
						$values = array($postValue, show_search_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_closing_code = $res;
			}
?>
		<tr>
			<td title="">
					show_search_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_closing_code" >
						<option value="" <?php echo !isset($pdf_show_search_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_closing_code) && strrpos(",".$pdf_show_search_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_closing_code" value="<?php echo $pdf_show_search_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_closing_code" >
						<option value="" <?php echo !isset($pob_show_search_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_closing_code) && strrpos(",".$pob_show_search_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_closing_code" value="<?php echo $pob_show_search_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_portion_size = $res;
			$postValue = $_POST['pdf_show_search_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_portion_size)) {
						$values = array($postValue, show_search_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_portion_size = $res;
			}
			$postValue = $_POST['pob_show_search_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_portion_size)) {
						$values = array($postValue, show_search_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_portion_size = $res;
			}
?>
		<tr>
			<td title="">
					show_search_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_portion_size" >
						<option value="" <?php echo !isset($pdf_show_search_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_portion_size) && strrpos(",".$pdf_show_search_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_portion_size" value="<?php echo $pdf_show_search_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_portion_size" >
						<option value="" <?php echo !isset($pob_show_search_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_portion_size) && strrpos(",".$pob_show_search_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_portion_size" value="<?php echo $pob_show_search_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_active = $res;
			$postValue = $_POST['pdf_show_search_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_active)) {
						$values = array($postValue, show_search_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_active = $res;
			}
			$postValue = $_POST['pob_show_search_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_active)) {
						$values = array($postValue, show_search_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_active = $res;
			}
?>
		<tr>
			<td title="">
					show_search_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_active" >
						<option value="" <?php echo !isset($pdf_show_search_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_active) && strrpos(",".$pdf_show_search_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_active" value="<?php echo $pdf_show_search_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_active" >
						<option value="" <?php echo !isset($pob_show_search_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_active) && strrpos(",".$pob_show_search_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_active" value="<?php echo $pob_show_search_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_order = $res;
			$postValue = $_POST['pdf_show_search_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_order)) {
						$values = array($postValue, show_search_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_order = $res;
			}
			$postValue = $_POST['pob_show_search_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_order)) {
						$values = array($postValue, show_search_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_order = $res;
			}
?>
		<tr>
			<td title="">
					show_search_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_order" >
						<option value="" <?php echo !isset($pdf_show_search_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_order) && strrpos(",".$pdf_show_search_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_order" value="<?php echo $pdf_show_search_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_order" >
						<option value="" <?php echo !isset($pob_show_search_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_order) && strrpos(",".$pob_show_search_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_order" value="<?php echo $pob_show_search_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_last_session = $res;
			$postValue = $_POST['pdf_show_search_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_last_session)) {
						$values = array($postValue, show_search_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_last_session = $res;
			}
			$postValue = $_POST['pob_show_search_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_last_session)) {
						$values = array($postValue, show_search_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_last_session = $res;
			}
?>
		<tr>
			<td title="">
					show_search_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_last_session" >
						<option value="" <?php echo !isset($pdf_show_search_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_last_session) && strrpos(",".$pdf_show_search_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_last_session" value="<?php echo $pdf_show_search_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_last_session" >
						<option value="" <?php echo !isset($pob_show_search_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_last_session) && strrpos(",".$pob_show_search_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_last_session" value="<?php echo $pob_show_search_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_subprocess_count = $res;
			$postValue = $_POST['pdf_show_search_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_subprocess_count)) {
						$values = array($postValue, show_search_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_subprocess_count = $res;
			}
			$postValue = $_POST['pob_show_search_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_subprocess_count)) {
						$values = array($postValue, show_search_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_subprocess_count = $res;
			}
?>
		<tr>
			<td title="">
					show_search_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_search_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_subprocess_count) && strrpos(",".$pdf_show_search_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_subprocess_count" value="<?php echo $pdf_show_search_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_search_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_subprocess_count) && strrpos(",".$pob_show_search_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_subprocess_count" value="<?php echo $pob_show_search_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_search_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_clear = $res;
			$postValue = $_POST['pdf_show_search_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_clear)) {
						$values = array($postValue, show_search_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_clear = $res;
			}
			$postValue = $_POST['pob_show_search_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_clear)) {
						$values = array($postValue, show_search_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_clear = $res;
			}
?>
		<tr>
			<td title="">
					show_search_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_clear" >
						<option value="" <?php echo !isset($pdf_show_search_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_clear) && strrpos(",".$pdf_show_search_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_clear" value="<?php echo $pdf_show_search_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_clear" >
						<option value="" <?php echo !isset($pob_show_search_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_clear) && strrpos(",".$pob_show_search_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_clear" value="<?php echo $pob_show_search_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_search_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_executions = $res;
			$postValue = $_POST['pdf_show_search_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_search_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_search_executions)) {
						$values = array($postValue, show_search_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_executions = $res;
			}
			$postValue = $_POST['pob_show_search_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_search_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_search_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_search_executions)) {
						$values = array($postValue, show_search_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_search_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_search_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_search_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_search_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_search_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_search_executions" >
						<option value="" <?php echo !isset($pdf_show_search_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_search_executions) && strrpos(",".$pdf_show_search_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_search_executions" value="<?php echo $pdf_show_search_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_search_executions" >
						<option value="" <?php echo !isset($pob_show_search_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_search_executions) && strrpos(",".$pob_show_search_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_search_executions" value="<?php echo $pob_show_search_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="pdf_columns">PDF columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
			$options["2"] = "Count()";
			$options["3"] = "Sum()";
			$options["4"] = "Avg()";
?>
<?php
			$types = "s";
			$values = array('show_pdf_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_name = $res;
			$postValue = $_POST['pdf_show_pdf_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_name)) {
						$values = array($postValue, show_pdf_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_name = $res;
			}
			$postValue = $_POST['pob_show_pdf_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_name)) {
						$values = array($postValue, show_pdf_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_pdf_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_name" >
						<option value="" <?php echo !isset($pdf_show_pdf_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_name) && strrpos(",".$pdf_show_pdf_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_name" value="<?php echo $pdf_show_pdf_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_name" >
						<option value="" <?php echo !isset($pob_show_pdf_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_name) && strrpos(",".$pob_show_pdf_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_name" value="<?php echo $pob_show_pdf_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_time = $res;
			$postValue = $_POST['pdf_show_pdf_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_execution_time)) {
						$values = array($postValue, show_pdf_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_time = $res;
			}
			$postValue = $_POST['pob_show_pdf_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_execution_time)) {
						$values = array($postValue, show_pdf_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_time = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_execution_time" >
						<option value="" <?php echo !isset($pdf_show_pdf_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_execution_time) && strrpos(",".$pdf_show_pdf_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_execution_time" value="<?php echo $pdf_show_pdf_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_execution_time" >
						<option value="" <?php echo !isset($pob_show_pdf_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_execution_time) && strrpos(",".$pob_show_pdf_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_execution_time" value="<?php echo $pob_show_pdf_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_description = $res;
			$postValue = $_POST['pdf_show_pdf_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_description)) {
						$values = array($postValue, show_pdf_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_description = $res;
			}
			$postValue = $_POST['pob_show_pdf_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_description)) {
						$values = array($postValue, show_pdf_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_description = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_description" >
						<option value="" <?php echo !isset($pdf_show_pdf_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_description) && strrpos(",".$pdf_show_pdf_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_description" value="<?php echo $pdf_show_pdf_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_description" >
						<option value="" <?php echo !isset($pob_show_pdf_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_description) && strrpos(",".$pob_show_pdf_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_description" value="<?php echo $pob_show_pdf_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_initiation_code = $res;
			$postValue = $_POST['pdf_show_pdf_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_initiation_code)) {
						$values = array($postValue, show_pdf_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_initiation_code = $res;
			}
			$postValue = $_POST['pob_show_pdf_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_initiation_code)) {
						$values = array($postValue, show_pdf_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_initiation_code = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_pdf_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_initiation_code) && strrpos(",".$pdf_show_pdf_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_initiation_code" value="<?php echo $pdf_show_pdf_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_initiation_code" >
						<option value="" <?php echo !isset($pob_show_pdf_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_initiation_code) && strrpos(",".$pob_show_pdf_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_initiation_code" value="<?php echo $pob_show_pdf_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_code = $res;
			$postValue = $_POST['pdf_show_pdf_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_execution_code)) {
						$values = array($postValue, show_pdf_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_code = $res;
			}
			$postValue = $_POST['pob_show_pdf_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_execution_code)) {
						$values = array($postValue, show_pdf_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_execution_code = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_execution_code" >
						<option value="" <?php echo !isset($pdf_show_pdf_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_execution_code) && strrpos(",".$pdf_show_pdf_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_execution_code" value="<?php echo $pdf_show_pdf_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_execution_code" >
						<option value="" <?php echo !isset($pob_show_pdf_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_execution_code) && strrpos(",".$pob_show_pdf_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_execution_code" value="<?php echo $pob_show_pdf_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_closing_code = $res;
			$postValue = $_POST['pdf_show_pdf_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_closing_code)) {
						$values = array($postValue, show_pdf_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_closing_code = $res;
			}
			$postValue = $_POST['pob_show_pdf_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_closing_code)) {
						$values = array($postValue, show_pdf_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_closing_code = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_closing_code" >
						<option value="" <?php echo !isset($pdf_show_pdf_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_closing_code) && strrpos(",".$pdf_show_pdf_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_closing_code" value="<?php echo $pdf_show_pdf_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_closing_code" >
						<option value="" <?php echo !isset($pob_show_pdf_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_closing_code) && strrpos(",".$pob_show_pdf_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_closing_code" value="<?php echo $pob_show_pdf_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_portion_size = $res;
			$postValue = $_POST['pdf_show_pdf_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_portion_size)) {
						$values = array($postValue, show_pdf_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_portion_size = $res;
			}
			$postValue = $_POST['pob_show_pdf_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_portion_size)) {
						$values = array($postValue, show_pdf_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_portion_size = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_portion_size" >
						<option value="" <?php echo !isset($pdf_show_pdf_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_portion_size) && strrpos(",".$pdf_show_pdf_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_portion_size" value="<?php echo $pdf_show_pdf_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_portion_size" >
						<option value="" <?php echo !isset($pob_show_pdf_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_portion_size) && strrpos(",".$pob_show_pdf_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_portion_size" value="<?php echo $pob_show_pdf_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_active = $res;
			$postValue = $_POST['pdf_show_pdf_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_active)) {
						$values = array($postValue, show_pdf_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_active = $res;
			}
			$postValue = $_POST['pob_show_pdf_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_active)) {
						$values = array($postValue, show_pdf_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_active = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_active" >
						<option value="" <?php echo !isset($pdf_show_pdf_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_active) && strrpos(",".$pdf_show_pdf_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_active" value="<?php echo $pdf_show_pdf_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_active" >
						<option value="" <?php echo !isset($pob_show_pdf_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_active) && strrpos(",".$pob_show_pdf_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_active" value="<?php echo $pob_show_pdf_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_order = $res;
			$postValue = $_POST['pdf_show_pdf_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_order)) {
						$values = array($postValue, show_pdf_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_order = $res;
			}
			$postValue = $_POST['pob_show_pdf_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_order)) {
						$values = array($postValue, show_pdf_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_order = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_order" >
						<option value="" <?php echo !isset($pdf_show_pdf_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_order) && strrpos(",".$pdf_show_pdf_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_order" value="<?php echo $pdf_show_pdf_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_order" >
						<option value="" <?php echo !isset($pob_show_pdf_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_order) && strrpos(",".$pob_show_pdf_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_order" value="<?php echo $pob_show_pdf_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_last_session = $res;
			$postValue = $_POST['pdf_show_pdf_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_last_session)) {
						$values = array($postValue, show_pdf_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_last_session = $res;
			}
			$postValue = $_POST['pob_show_pdf_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_last_session)) {
						$values = array($postValue, show_pdf_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_last_session = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_last_session" >
						<option value="" <?php echo !isset($pdf_show_pdf_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_last_session) && strrpos(",".$pdf_show_pdf_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_last_session" value="<?php echo $pdf_show_pdf_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_last_session" >
						<option value="" <?php echo !isset($pob_show_pdf_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_last_session) && strrpos(",".$pob_show_pdf_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_last_session" value="<?php echo $pob_show_pdf_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_subprocess_count = $res;
			$postValue = $_POST['pdf_show_pdf_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_subprocess_count)) {
						$values = array($postValue, show_pdf_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_subprocess_count = $res;
			}
			$postValue = $_POST['pob_show_pdf_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_subprocess_count)) {
						$values = array($postValue, show_pdf_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_subprocess_count = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_pdf_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_subprocess_count) && strrpos(",".$pdf_show_pdf_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_subprocess_count" value="<?php echo $pdf_show_pdf_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_pdf_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_subprocess_count) && strrpos(",".$pob_show_pdf_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_subprocess_count" value="<?php echo $pob_show_pdf_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_pdf_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_clear = $res;
			$postValue = $_POST['pdf_show_pdf_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_clear)) {
						$values = array($postValue, show_pdf_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_clear = $res;
			}
			$postValue = $_POST['pob_show_pdf_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_clear)) {
						$values = array($postValue, show_pdf_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_clear = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_clear" >
						<option value="" <?php echo !isset($pdf_show_pdf_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_clear) && strrpos(",".$pdf_show_pdf_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_clear" value="<?php echo $pdf_show_pdf_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_clear" >
						<option value="" <?php echo !isset($pob_show_pdf_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_clear) && strrpos(",".$pob_show_pdf_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_clear" value="<?php echo $pob_show_pdf_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_pdf_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_executions = $res;
			$postValue = $_POST['pdf_show_pdf_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_pdf_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_pdf_executions)) {
						$values = array($postValue, show_pdf_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_executions = $res;
			}
			$postValue = $_POST['pob_show_pdf_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_pdf_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_pdf_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_pdf_executions)) {
						$values = array($postValue, show_pdf_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_pdf_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_pdf_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_pdf_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_pdf_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_pdf_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_pdf_executions" >
						<option value="" <?php echo !isset($pdf_show_pdf_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_pdf_executions) && strrpos(",".$pdf_show_pdf_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_pdf_executions" value="<?php echo $pdf_show_pdf_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_pdf_executions" >
						<option value="" <?php echo !isset($pob_show_pdf_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_pdf_executions) && strrpos(",".$pob_show_pdf_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_pdf_executions" value="<?php echo $pob_show_pdf_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="export_columns">Export columns</td></tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<?php
			$types = "s";
			$values = array('show_export_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_name = $res;
			$postValue = $_POST['pdf_show_export_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_name)) {
						$values = array($postValue, show_export_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_name = $res;
			}
			$postValue = $_POST['pob_show_export_name'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_name != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_name);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_name)) {
						$values = array($postValue, show_export_name);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_name, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_name');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_name = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_name = $res;
			}
?>
		<tr>
			<td title="">
				<strong>
					show_export_name
				</strong>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_name" >
						<option value="" <?php echo !isset($pdf_show_export_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_name) && strrpos(",".$pdf_show_export_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_name" value="<?php echo $pdf_show_export_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_name" >
						<option value="" <?php echo !isset($pob_show_export_name) ? "selected " : "" ?>>!!!OBLIGATORY!!!</option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_name) && strrpos(",".$pob_show_export_name.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_name" value="<?php echo $pob_show_export_name ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_time = $res;
			$postValue = $_POST['pdf_show_export_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_execution_time)) {
						$values = array($postValue, show_export_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_time = $res;
			}
			$postValue = $_POST['pob_show_export_execution_time'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_execution_time != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_execution_time);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_execution_time)) {
						$values = array($postValue, show_export_execution_time);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_execution_time, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_execution_time');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_time = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_time = $res;
			}
?>
		<tr>
			<td title="">
					show_export_execution_time
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_execution_time" >
						<option value="" <?php echo !isset($pdf_show_export_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_execution_time) && strrpos(",".$pdf_show_export_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_execution_time" value="<?php echo $pdf_show_export_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_execution_time" >
						<option value="" <?php echo !isset($pob_show_export_execution_time) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_execution_time) && strrpos(",".$pob_show_export_execution_time.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_execution_time" value="<?php echo $pob_show_export_execution_time ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_description = $res;
			$postValue = $_POST['pdf_show_export_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_description)) {
						$values = array($postValue, show_export_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_description = $res;
			}
			$postValue = $_POST['pob_show_export_description'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_description != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_description);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_description)) {
						$values = array($postValue, show_export_description);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_description, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_description');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_description = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_description = $res;
			}
?>
		<tr>
			<td title="">
					show_export_description
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_description" >
						<option value="" <?php echo !isset($pdf_show_export_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_description) && strrpos(",".$pdf_show_export_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_description" value="<?php echo $pdf_show_export_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_description" >
						<option value="" <?php echo !isset($pob_show_export_description) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_description) && strrpos(",".$pob_show_export_description.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_description" value="<?php echo $pob_show_export_description ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_initiation_code = $res;
			$postValue = $_POST['pdf_show_export_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_initiation_code)) {
						$values = array($postValue, show_export_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_initiation_code = $res;
			}
			$postValue = $_POST['pob_show_export_initiation_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_initiation_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_initiation_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_initiation_code)) {
						$values = array($postValue, show_export_initiation_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_initiation_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_initiation_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_initiation_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_initiation_code = $res;
			}
?>
		<tr>
			<td title="">
					show_export_initiation_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_initiation_code" >
						<option value="" <?php echo !isset($pdf_show_export_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_initiation_code) && strrpos(",".$pdf_show_export_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_initiation_code" value="<?php echo $pdf_show_export_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_initiation_code" >
						<option value="" <?php echo !isset($pob_show_export_initiation_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_initiation_code) && strrpos(",".$pob_show_export_initiation_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_initiation_code" value="<?php echo $pob_show_export_initiation_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_code = $res;
			$postValue = $_POST['pdf_show_export_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_execution_code)) {
						$values = array($postValue, show_export_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_code = $res;
			}
			$postValue = $_POST['pob_show_export_execution_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_execution_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_execution_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_execution_code)) {
						$values = array($postValue, show_export_execution_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_execution_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_execution_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_execution_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_execution_code = $res;
			}
?>
		<tr>
			<td title="">
					show_export_execution_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_execution_code" >
						<option value="" <?php echo !isset($pdf_show_export_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_execution_code) && strrpos(",".$pdf_show_export_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_execution_code" value="<?php echo $pdf_show_export_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_execution_code" >
						<option value="" <?php echo !isset($pob_show_export_execution_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_execution_code) && strrpos(",".$pob_show_export_execution_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_execution_code" value="<?php echo $pob_show_export_execution_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_closing_code = $res;
			$postValue = $_POST['pdf_show_export_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_closing_code)) {
						$values = array($postValue, show_export_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_closing_code = $res;
			}
			$postValue = $_POST['pob_show_export_closing_code'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_closing_code != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_closing_code);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_closing_code)) {
						$values = array($postValue, show_export_closing_code);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_closing_code, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_closing_code');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_closing_code = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_closing_code = $res;
			}
?>
		<tr>
			<td title="">
					show_export_closing_code
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_closing_code" >
						<option value="" <?php echo !isset($pdf_show_export_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_closing_code) && strrpos(",".$pdf_show_export_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_closing_code" value="<?php echo $pdf_show_export_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_closing_code" >
						<option value="" <?php echo !isset($pob_show_export_closing_code) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_closing_code) && strrpos(",".$pob_show_export_closing_code.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_closing_code" value="<?php echo $pob_show_export_closing_code ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_portion_size = $res;
			$postValue = $_POST['pdf_show_export_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_portion_size)) {
						$values = array($postValue, show_export_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_portion_size = $res;
			}
			$postValue = $_POST['pob_show_export_portion_size'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_portion_size != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_portion_size);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_portion_size)) {
						$values = array($postValue, show_export_portion_size);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_portion_size, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_portion_size');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_portion_size = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_portion_size = $res;
			}
?>
		<tr>
			<td title="">
					show_export_portion_size
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_portion_size" >
						<option value="" <?php echo !isset($pdf_show_export_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_portion_size) && strrpos(",".$pdf_show_export_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_portion_size" value="<?php echo $pdf_show_export_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_portion_size" >
						<option value="" <?php echo !isset($pob_show_export_portion_size) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_portion_size) && strrpos(",".$pob_show_export_portion_size.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_portion_size" value="<?php echo $pob_show_export_portion_size ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_active = $res;
			$postValue = $_POST['pdf_show_export_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_active)) {
						$values = array($postValue, show_export_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_active = $res;
			}
			$postValue = $_POST['pob_show_export_active'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_active != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_active);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_active)) {
						$values = array($postValue, show_export_active);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_active, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_active');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_active = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_active = $res;
			}
?>
		<tr>
			<td title="">
					show_export_active
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_active" >
						<option value="" <?php echo !isset($pdf_show_export_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_active) && strrpos(",".$pdf_show_export_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_active" value="<?php echo $pdf_show_export_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_active" >
						<option value="" <?php echo !isset($pob_show_export_active) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_active) && strrpos(",".$pob_show_export_active.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_active" value="<?php echo $pob_show_export_active ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_order = $res;
			$postValue = $_POST['pdf_show_export_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_order)) {
						$values = array($postValue, show_export_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_order = $res;
			}
			$postValue = $_POST['pob_show_export_order'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_order != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_order);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_order)) {
						$values = array($postValue, show_export_order);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_order, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_order');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_order = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_order = $res;
			}
?>
		<tr>
			<td title="">
					show_export_order
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_order" >
						<option value="" <?php echo !isset($pdf_show_export_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_order) && strrpos(",".$pdf_show_export_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_order" value="<?php echo $pdf_show_export_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_order" >
						<option value="" <?php echo !isset($pob_show_export_order) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_order) && strrpos(",".$pob_show_export_order.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_order" value="<?php echo $pob_show_export_order ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_last_session = $res;
			$postValue = $_POST['pdf_show_export_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_last_session)) {
						$values = array($postValue, show_export_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_last_session = $res;
			}
			$postValue = $_POST['pob_show_export_last_session'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_last_session != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_last_session);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_last_session)) {
						$values = array($postValue, show_export_last_session);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_last_session, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_last_session');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_last_session = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_last_session = $res;
			}
?>
		<tr>
			<td title="">
					show_export_last_session
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_last_session" >
						<option value="" <?php echo !isset($pdf_show_export_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_last_session) && strrpos(",".$pdf_show_export_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_last_session" value="<?php echo $pdf_show_export_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_last_session" >
						<option value="" <?php echo !isset($pob_show_export_last_session) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_last_session) && strrpos(",".$pob_show_export_last_session.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_last_session" value="<?php echo $pob_show_export_last_session ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_subprocess_count = $res;
			$postValue = $_POST['pdf_show_export_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_subprocess_count)) {
						$values = array($postValue, show_export_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_subprocess_count = $res;
			}
			$postValue = $_POST['pob_show_export_subprocess_count'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_subprocess_count != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_subprocess_count);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_subprocess_count)) {
						$values = array($postValue, show_export_subprocess_count);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_subprocess_count, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_subprocess_count');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_subprocess_count = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_subprocess_count = $res;
			}
?>
		<tr>
			<td title="">
					show_export_subprocess_count
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_subprocess_count" >
						<option value="" <?php echo !isset($pdf_show_export_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_subprocess_count) && strrpos(",".$pdf_show_export_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_subprocess_count" value="<?php echo $pdf_show_export_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_subprocess_count" >
						<option value="" <?php echo !isset($pob_show_export_subprocess_count) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_subprocess_count) && strrpos(",".$pob_show_export_subprocess_count.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_subprocess_count" value="<?php echo $pob_show_export_subprocess_count ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('show_export_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_clear = $res;
			$postValue = $_POST['pdf_show_export_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_clear)) {
						$values = array($postValue, show_export_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_clear = $res;
			}
			$postValue = $_POST['pob_show_export_clear'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_clear != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_clear);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_clear)) {
						$values = array($postValue, show_export_clear);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_clear, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_clear');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_clear = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_clear = $res;
			}
?>
		<tr>
			<td title="">
					show_export_clear
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_clear" >
						<option value="" <?php echo !isset($pdf_show_export_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_clear) && strrpos(",".$pdf_show_export_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_clear" value="<?php echo $pdf_show_export_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_clear" >
						<option value="" <?php echo !isset($pob_show_export_clear) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_clear) && strrpos(",".$pob_show_export_clear.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_clear" value="<?php echo $pob_show_export_clear ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$options = array();
			$options["0"] = "Hide";
			$options["1"] = "Show";
?>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$options = array();
			$options["0"] = "No";
			$options["1"] = "Yes";
?>
<?php
			$types = "s";
			$values = array('show_export_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_executions = $res;
			$postValue = $_POST['pdf_show_export_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_show_export_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_show_export_executions)) {
						$values = array($postValue, show_export_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_executions = $res;
			}
			$postValue = $_POST['pob_show_export_executions'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_show_export_executions != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(show_export_executions);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_show_export_executions)) {
						$values = array($postValue, show_export_executions);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(show_export_executions, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('show_export_executions');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_show_export_executions = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_show_export_executions = $res;
			}
?>
		<tr>
			<td title="">
					show_export_executions
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_show_export_executions" >
						<option value="" <?php echo !isset($pdf_show_export_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_show_export_executions) && strrpos(",".$pdf_show_export_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_show_export_executions" value="<?php echo $pdf_show_export_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_show_export_executions" >
						<option value="" <?php echo !isset($pob_show_export_executions) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_show_export_executions) && strrpos(",".$pob_show_export_executions.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_show_export_executions" value="<?php echo $pob_show_export_executions ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('custom_sql_condition');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_sql_condition = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_sql_condition = $res;
			$postValue = $_POST['pdf_custom_sql_condition'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_custom_sql_condition != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(custom_sql_condition);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_custom_sql_condition)) {
						$values = array($postValue, custom_sql_condition);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(custom_sql_condition, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('custom_sql_condition');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_sql_condition = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_sql_condition = $res;
			}
			$postValue = $_POST['pob_custom_sql_condition'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_custom_sql_condition != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(custom_sql_condition);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_custom_sql_condition)) {
						$values = array($postValue, custom_sql_condition);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(custom_sql_condition, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('custom_sql_condition');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_sql_condition = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_sql_condition = $res;
			}
?>
		<tr>
			<td title="Custom SQL condition (eg. prc_abc_id in (select abc_id from...)) You can use classes $currentUser and $currentPage (eg. prc_usr_created_id = {$user->getId()})">custom_sql_condition</td>
			<td>
<textarea name="pdf_custom_sql_condition"><?php echo $pdf_custom_sql_condition ?></textarea>
			</td>
			<td>
<textarea name="pob_custom_sql_condition"><?php echo $pob_custom_sql_condition ?></textarea>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('custom_parent_query');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_parent_query = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_parent_query = $res;
			$postValue = $_POST['pdf_custom_parent_query'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_custom_parent_query != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(custom_parent_query);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_custom_parent_query)) {
						$values = array($postValue, custom_parent_query);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(custom_parent_query, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('custom_parent_query');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_parent_query = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_parent_query = $res;
			}
			$postValue = $_POST['pob_custom_parent_query'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_custom_parent_query != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(custom_parent_query);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_custom_parent_query)) {
						$values = array($postValue, custom_parent_query);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(custom_parent_query, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('custom_parent_query');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_custom_parent_query = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_custom_parent_query = $res;
			}
?>
		<tr>
			<td title="For more complex and flexible parent filtering than usual master/detail. The ? sign will be replaced with the value of the virgo_parent_id parameter set by some other portlet">custom_parent_query</td>
			<td>
<textarea name="pdf_custom_parent_query"><?php echo $pdf_custom_parent_query ?></textarea>
			</td>
			<td>
<textarea name="pob_custom_parent_query"><?php echo $pob_custom_parent_query ?></textarea>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<tr class="spacer"><td colspan="4" id="import_setting">Import setting</td></tr>
<?php
			$options = array();
			$options["T"] = "All or nothing (break on first error)";
			$options["V"] = "Import valid records, ignore rest";
?>
<?php
			$types = "s";
			$values = array('import_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_mode = $res;
			$postValue = $_POST['pdf_import_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_import_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(import_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_import_mode)) {
						$values = array($postValue, import_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(import_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('import_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_mode = $res;
			}
			$postValue = $_POST['pob_import_mode'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_import_mode != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(import_mode);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_import_mode)) {
						$values = array($postValue, import_mode);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(import_mode, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('import_mode');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_import_mode = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_import_mode = $res;
			}
?>
		<tr>
			<td title="">
					import_mode
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pdf_import_mode" >
						<option value="" <?php echo !isset($pdf_import_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pdf_import_mode) && strrpos(",".$pdf_import_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pdf_import_mode" value="<?php echo $pdf_import_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<div style="max-width: 200px; overflow: auto;">
<?php
	if (count($options) <= 100) {
?>				
					<select name="pob_import_mode" >
						<option value="" <?php echo !isset($pob_import_mode) ? "selected " : "" ?>></option>
<?php
			foreach ($options as $key => $val) {
?>				
						<option value="<?php echo $key ?>" <?php echo isset($pob_import_mode) && strrpos(",".$pob_import_mode.",", ",".$key.",") !== false ? "selected " : "" ?>><?php echo $val ?></option>
<?php
			}
?>				
					</select>
<?php
	} else {
		/* podawanie z palca. na razie bez multi */
?>
	Za duzo rekordów, podaj ID: <input type="text" name="pob_import_mode" value="<?php echo $pob_import_mode ?>">
<?php
	}
?>				
				</div>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			$types = "s";
			$values = array('field_separator');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_field_separator = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_field_separator = $res;
			$postValue = $_POST['pdf_field_separator'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_field_separator != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(field_separator);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_field_separator)) {
						$values = array($postValue, field_separator);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(field_separator, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('field_separator');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_field_separator = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_field_separator = $res;
			}
			$postValue = $_POST['pob_field_separator'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_field_separator != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(field_separator);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_field_separator)) {
						$values = array($postValue, field_separator);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(field_separator, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('field_separator');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_field_separator = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_field_separator = $res;
			}
?>
		<tr>
			<td>field_separator</td>
			<td>
<input type="text" name="pdf_field_separator" value="<?php echo $pdf_field_separator ?>"/>
			</td>
			<td>
<input type="text" name="pob_field_separator" value="<?php echo $pob_field_separator ?>"/>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
	$where = " lng_default = 1 ";
	if (isset($_SESSION['portal_current_lang_id'])) {
		$where = " lng_id = " . $_SESSION['portal_current_lang_id'];
	}
	$query = <<<SQL
SELECT
	lng_id, lng_name
FROM
	prt_languages
WHERE 
	{$where}
SQL;
	$result = $databaseHandler->query($query);
	while ($row = mysqli_fetch_row($result)) {
		$lngId = $row[0];
		$lngName = $row[1];
	}
	mysqli_free_result($result);			
?>
<tr class="spacer"><td colspan="4" id="hints_php_echo_lngname_">Hints (<?php echo $lngName ?>)</td></tr>
<?php 
	if (isset($_POST['HINT_process'])) {
		$newHint = $_POST['HINT_process'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_name'])) {
		$newHint = $_POST['HINT_process_name'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_name'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_name', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_name'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_name'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_name</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_name"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_execution_time'])) {
		$newHint = $_POST['HINT_process_execution_time'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_time'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_execution_time', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_time'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_time'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_execution_time</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_execution_time"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_description'])) {
		$newHint = $_POST['HINT_process_description'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_description'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_description', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_description'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_description'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_description</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_description"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_initiation_code'])) {
		$newHint = $_POST['HINT_process_initiation_code'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_initiation_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_initiation_code', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_initiation_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_initiation_code'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_initiation_code</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_initiation_code"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_execution_code'])) {
		$newHint = $_POST['HINT_process_execution_code'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_execution_code', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_execution_code'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_execution_code</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_execution_code"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_closing_code'])) {
		$newHint = $_POST['HINT_process_closing_code'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_closing_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_closing_code', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_closing_code'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_closing_code'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_closing_code</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_closing_code"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_portion_size'])) {
		$newHint = $_POST['HINT_process_portion_size'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_portion_size'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_portion_size', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_portion_size'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_portion_size'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_portion_size</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_portion_size"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_active'])) {
		$newHint = $_POST['HINT_process_active'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_active'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_active', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_active'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_active'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_active</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_active"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_order'])) {
		$newHint = $_POST['HINT_process_order'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_order'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_order', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_order'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_order'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_order</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_order"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_last_session'])) {
		$newHint = $_POST['HINT_process_last_session'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_last_session'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_last_session', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_last_session'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_last_session'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_last_session</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_last_session"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_subprocess_count'])) {
		$newHint = $_POST['HINT_process_subprocess_count'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_subprocess_count'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_subprocess_count', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_subprocess_count'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_subprocess_count'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_subprocess_count</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_subprocess_count"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<?php 
	if (isset($_POST['HINT_process_clear'])) {
		$newHint = $_POST['HINT_process_clear'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_clear'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_clear', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_clear'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_clear'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_clear</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_clear"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php 
	if (isset($_POST['HINT_process_executions'])) {
		$newHint = $_POST['HINT_process_executions'];
		$newHint = trim($newHint);
		if ($newHint == "") {
			$newHint = null;
		}
		$query = "";
		if (isset($newHint)) {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_executions'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				if ($newHint != $hintText) {
					$query = " UPDATE prt_translations SET trn_text = '" . $newHint . "' WHERE trn_id = " . $hintId;
				}
			} else {
					$query = " INSERT INTO prt_translations (trn_lng_id, trn_token, trn_text) VALUES (" . $lngId . ", 'HINT_process_executions', '" . $newHint . "')";
			}
		} else {
	$hintId = null;
	$hintText = null;
	$query = " SELECT trn_id, trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_executions'));
	foreach ($result as $res) {
		$hintId = $row[trn_id];
		$hintText = $row[trn_text];
	}
			if (isset($hintId)) {
				$query = " DELETE FROM  prt_translations WHERE trn_id = " . $hintId;			
			}		
		}
		if ($query != "") {
			$databaseHandler->query($query);
		}
	}
	$query = " SELECT trn_text FROM prt_translations WHERE trn_token = ? AND trn_lng_id = " . $lngId;
	$result = $databaseHandler->queryPrepared($query, false, "s", array('HINT_process_executions'));
	$text = null;
	foreach ($result as $row) {
		$text = $row[trn_text];
	}
?>
	<tr>
		<td>HINT_process_executions</td>
		<td colspan="2"><textarea cols="60" rows="4" name="HINT_process_executions"><?php echo $text ?></textarea></td>
		<td>
			<input type="submit" value="Store"/>
		</td>			
	</tr>
<tr><td></td><td></td><td></td><td></td></tr>
<?php
			$types = "s";
			$values = array('portlet_css');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_portlet_css = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_portlet_css = $res;
			$postValue = $_POST['pdf_portlet_css'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pdf_portlet_css != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(portlet_css);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pdf_portlet_css)) {
						$values = array($postValue, portlet_css);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
					} else {
						$values = array(portlet_css, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pdf_id) VALUES (?, ?, {$pdfId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('portlet_css');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_portlet_css = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_portlet_css = $res;
			}
			$postValue = $_POST['pob_portlet_css'];
			if (isset($postValue) && is_array($postValue)) {
				$postValue = implode(',', $postValue);
			}
			if (isset($_POST['pobId']) && $pob_portlet_css != $postValue) {
				if (!isset($postValue) || $postValue == "") {
					$types = "s";
					$values = array(portlet_css);
					$query = "DELETE FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
				} else {
					$types = "ss";
					if (isset($pob_portlet_css)) {
						$values = array($postValue, portlet_css);
						$query = "UPDATE prt_portlet_parameters SET ppr_value = ? WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
					} else {
						$values = array(portlet_css, $postValue);
						$query = "INSERT INTO prt_portlet_parameters (ppr_name, ppr_value, ppr_pob_id) VALUES (?, ?, {$pobId})";
					}
				}
				$databaseHandler->queryPrepared($query, false, $types, $values);
			$types = "s";
			$values = array('portlet_css');
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pdf_id = {$pdfId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pdf_portlet_css = $res;
			$query = "SELECT ppr_value FROM prt_portlet_parameters WHERE ppr_pob_id = {$pobId} AND ppr_name = ? ";
	$result = $databaseHandler->queryPrepared($query, false, $types, $values);
	if ($result !== false) {
		$res = null;
		foreach ($result as $row) {
			$res = $row['ppr_value'];
		}
	} else {
		$res = null;
	}
			$pob_portlet_css = $res;
			}
?>
		<tr>
			<td title="Style definitions limited to current portlet, eg: legend.my_form {display: none;} ">portlet_css</td>
			<td>
<textarea name="pdf_portlet_css"><?php echo $pdf_portlet_css ?></textarea>
			</td>
			<td>
<textarea name="pob_portlet_css"><?php echo $pob_portlet_css ?></textarea>
			</td>
			<td>
				<input type="submit" value="Store"/>
			</td>			
		</tr>
<?php
			break;
	}
?>
	</table>
	<input type="submit" value="Store"/>
</form>
	</body>
</html>


